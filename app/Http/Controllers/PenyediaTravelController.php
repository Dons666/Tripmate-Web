<?php

namespace App\Http\Controllers;

use App\Models\PenyediaTravel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PenyediaTravelController extends Controller
{
    /**
     * Tampilkan daftar penyedia travel yang sudah disetujui (Approved) untuk Pengguna.
     */
    public function index(Request $request)
    {
        $query = PenyediaTravel::query()->where(function($q) {
            $q->where('status', 'approved')
              ->orWhereNull('status');
        });

        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('nama_travel', 'like', "%{$search}%")
                  ->orWhere('kota_asal_travel', 'like', "%{$search}%")
                  ->orWhere('jenis_kendaraan', 'like', "%{$search}%")
                  ->orWhere('alamat_travel', 'like', "%{$search}%");
            });
        }

        $penyediaTravels = $query->latest()->paginate(9)->withQueryString();

        return view('penyedia_travel.index', compact('penyediaTravels'));
    }

    /**
     * Tampilkan form pendaftaran travel untuk Pengguna / Partner.
     */
    public function create()
    {
        return view('penyedia_travel.create');
    }

    /**
     * Simpan pendaftaran travel mandiri dari Pengguna (Status Pending nunggu ACC Admin).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_travel' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8|confirmed',
            'nomor_hp_pemilik_travel' => 'required|string|max:30',
            'surat_izin_usaha_travel' => 'required',
            'ktp_pemilik' => 'required',
        ], [
            'nama_travel.required' => 'Nama travel wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'nomor_hp_pemilik_travel.required' => 'Nomor HP pemilik travel wajib diisi.',
            'surat_izin_usaha_travel.required' => 'Surat izin usaha travel wajib diisi atau diunggah.',
            'ktp_pemilik.required' => 'KTP pemilik wajib diisi atau diunggah.',
        ]);

        $validated['status'] = 'pending';
        $validated['alamat_travel'] = $request->input('alamat_travel', null);
        $validated['kota_asal_travel'] = $request->input('kota_asal_travel', null);
        $validated['jenis_kendaraan'] = $request->input('jenis_kendaraan', null);
        $validated['harga'] = $request->input('harga', 0);
        $validated['jadwal_ketersediaan'] = $request->input('jadwal_ketersediaan', null);
        $validated['rekening'] = $request->input('rekening', null);

        // Handle File Upload for Foto Kendaraan
        if ($request->hasFile('foto_kendaraan')) {
            $validated['foto_kendaraan'] = $request->file('foto_kendaraan')->store('travel_docs/foto_kendaraan', 'public');
        }

        // Handle File Upload or String Input for Surat Izin Usaha
        if ($request->hasFile('surat_izin_usaha_travel')) {
            $pathSurat = $request->file('surat_izin_usaha_travel')->store('travel_docs/surat_izin', 'public');
            $validated['surat_izin_usaha_travel'] = $pathSurat;
        } elseif (is_string($request->input('surat_izin_usaha_travel'))) {
            $validated['surat_izin_usaha_travel'] = $request->input('surat_izin_usaha_travel');
        }

        // Handle File Upload or String Input for KTP Pemilik
        if ($request->hasFile('ktp_pemilik')) {
            $pathKtp = $request->file('ktp_pemilik')->store('travel_docs/ktp', 'public');
            $validated['ktp_pemilik'] = $pathKtp;
        } elseif (is_string($request->input('ktp_pemilik'))) {
            $validated['ktp_pemilik'] = $request->input('ktp_pemilik');
        }

        PenyediaTravel::create($validated);

        // Buat Akun User untuk sistem Login (status is_active false sampai disetujui Admin)
        User::firstOrCreate(
            ['email' => $validated['email']],
            [
                'name' => $validated['nama_travel'],
                'password' => Hash::make($validated['password']),
                'role' => 'travel',
                'is_active' => false,
            ]
        );

        return redirect()->route('penyedia-travel.success')->with('success', 'Pendaftaran travel berhasil! Akun Anda berstatus PENDING dan menunggu peninjauan & persetujuan (ACC) dari Admin.');
    }

    /**
     * Halaman konfirmasi sukses pendaftaran pengguna.
     */
    public function success()
    {
        return view('penyedia_travel.success');
    }
}
