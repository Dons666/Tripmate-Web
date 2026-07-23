<?php

namespace App\Http\Controllers;

use App\Models\PenyediaTravel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TravelDashboardController extends Controller
{
    /**
     * Tampilkan Dashboard Khusus Mitra Travel Provider.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Khusus Penyedia Travel (role = 'travel') dan Admin
        if ($user->role !== 'travel' && $user->role !== 'admin') {
            return redirect()->route('home')
                ->with('error', 'Akses ditolak. Dashboard ini khusus untuk Mitra Penyedia Travel.');
        }

        // Cari data penyedia travel khusus milik akun yang sedang login
        $penyediaTravel = PenyediaTravel::where('email', $user->email)->first();

        // Cari entity Travel yang terhubung ke user ID ini
        $travel = \App\Models\Travel::where('user_id', $user->id)->first();

        if (!$travel && $penyediaTravel) {
            $travel = \App\Models\Travel::where('nama_travel', $penyediaTravel->nama_travel)->first();
        }

        $bookings = \App\Models\TravelPlan::where('travel_id', $travel->id ?? 0)
            ->with(['user', 'destinasis', 'schedules'])
            ->orderByDesc('created_at')
            ->get();

        return view('travel.dashboard', compact('user', 'penyediaTravel', 'travel', 'bookings'));
    }

    /**
     * Tampilkan Form Edit Profil Travel.
     */
    public function edit()
    {
        $user = Auth::user();

        if ($user->role !== 'travel' && $user->role !== 'admin') {
            return redirect()->route('home')
                ->with('error', 'Akses ditolak. Halaman ini khusus Mitra Penyedia Travel.');
        }

        $penyediaTravel = PenyediaTravel::where('email', $user->email)->firstOrFail();

        return view('travel.edit', compact('user', 'penyediaTravel'));
    }

    /**
     * Update Data Usaha & Profil Travel oleh Mitra (Membutuhkan ACC Admin kembali).
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        if ($user->role !== 'travel' && $user->role !== 'admin') {
            return redirect()->route('home')
                ->with('error', 'Akses ditolak. Akses ini khusus Mitra Penyedia Travel.');
        }

        $penyediaTravel = PenyediaTravel::where('email', $user->email)->firstOrFail();

        $validated = $request->validate([
            'nama_travel' => 'required|string|max:255',
            'kota_asal_travel' => 'nullable|string|max:255',
            'alamat_travel' => 'nullable|string',
            'jenis_kendaraan' => 'nullable|string|max:255',
            'harga' => 'nullable|numeric|min:0',
            'foto_kendaraan' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'jadwal_ketersediaan' => 'nullable|string',
            'rekening' => 'nullable|string|max:255',
            'nomor_hp_pemilik_travel' => 'required|string|max:30',
        ], [
            'nama_travel.required' => 'Nama travel wajib diisi.',
            'nomor_hp_pemilik_travel.required' => 'Nomor HP pemilik wajib diisi.',
            'harga.numeric' => 'Harga harus berupa angka.',
        ]);

        // Handle File Upload for Foto Kendaraan (Per-Vehicle Photos or Global Photo)
        $fotoArmadaPaths = [];
        $existingFotos = $request->input('existing_foto_armada', []);

        if ($request->hasFile('foto_armada')) {
            $uploadedFiles = $request->file('foto_armada');
            foreach ($uploadedFiles as $index => $file) {
                if ($file && $file->isValid()) {
                    $fotoArmadaPaths[$index] = $file->store('travel_docs/foto_kendaraan', 'public');
                } elseif (isset($existingFotos[$index]) && !empty($existingFotos[$index])) {
                    $fotoArmadaPaths[$index] = $existingFotos[$index];
                }
            }
            foreach ($existingFotos as $index => $path) {
                if (!isset($fotoArmadaPaths[$index]) && !empty($path)) {
                    $fotoArmadaPaths[$index] = $path;
                }
            }
        } elseif (!empty($existingFotos)) {
            $fotoArmadaPaths = array_values(array_filter($existingFotos));
        }

        if (!empty($fotoArmadaPaths)) {
            ksort($fotoArmadaPaths);
            $validated['foto_kendaraan'] = json_encode(array_values($fotoArmadaPaths));
        } elseif ($request->hasFile('foto_kendaraan')) {
            $validated['foto_kendaraan'] = $request->file('foto_kendaraan')->store('travel_docs/foto_kendaraan', 'public');
        }

        // Handle File Upload for Surat Izin Usaha jika diunggah baru
        if ($request->hasFile('surat_izin_usaha_travel')) {
            $validated['surat_izin_usaha_travel'] = $request->file('surat_izin_usaha_travel')->store('travel_docs/surat_izin', 'public');
        }

        // Handle File Upload for KTP Pemilik jika diunggah baru
        if ($request->hasFile('ktp_pemilik')) {
            $validated['ktp_pemilik'] = $request->file('ktp_pemilik')->store('travel_docs/ktp', 'public');
        }

        // Jika status mitra sudah 'approved', pertahankan status 'approved' agar kemitraan tetap aktif
        if ($penyediaTravel->status === 'approved') {
            $validated['status'] = 'approved';
        }

        $penyediaTravel->update($validated);

        // Sync name di tabel User dan pastikan akun tetap aktif
        $user->update([
            'name' => $validated['nama_travel'],
            'is_active' => true,
        ]);

        return redirect()->route('travel.dashboard')->with('success', 'Perubahan data travel Anda berhasil diperbarui! Status kemitraan Anda tetap Aktif (ACC).');
    }
}
