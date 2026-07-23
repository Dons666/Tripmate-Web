<?php

namespace App\Http\Controllers;

use App\Models\TravelPlan;
use App\Models\Destinasi;
use App\Models\Travel;
use App\Models\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TravelPlanController extends Controller
{
    public function index()
    {
        return view('travel-plans.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_perjalanan' => 'required|string|max:255',
            'tujuan'          => 'required|string|max:255',
            'catatan'         => 'nullable|string',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'budget'          => 'nullable|numeric|min:0',
            'status'          => 'nullable|string|in:Perencanaan Aktif,Sedang Berjalan,Selesai,Dibatalkan',
            'foto_sampul'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'travel_id'       => 'nullable|exists:travels,id',
        ]);

        $data = $request->except('_token');

        if ($request->hasFile('foto_sampul')) {
            $data['foto_sampul'] = $request->file('foto_sampul')->store('travel-covers', 'public');
        }

        if (empty($data['status'])) {
            $data['status'] = 'Perencanaan Aktif';
        }

        Auth::user()->travelPlans()->create($data);

        return back()->with('success', 'Rencana perjalanan berhasil dibuat!');
    }

    public function show(TravelPlan $travelPlan)
    {
        if ($travelPlan->user_id !== Auth::id()) {
            abort(403);
        }

        $travelPlan->load('destinasis', 'expenses', 'schedules.destinasi', 'travel');
        $travels = Travel::all();
        return view('travel-plans.show', compact('travelPlan', 'travels'));
    }

    public function attachTravel(Request $request, TravelPlan $travelPlan)
    {
        if ($travelPlan->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'travel_id' => 'nullable|exists:travels,id',
        ]);

        $travelPlan->update([
            'travel_id' => $request->travel_id ?: null,
        ]);

        $msg = $request->travel_id ? 'Mitra Agen Travel berhasil dipasang pada rencana perjalanan!' : 'Agen Travel dilepas. Perencanaan diubah ke Mandiri.';

        return back()->with('success', $msg);
    }

    public function checkout(TravelPlan $travelPlan)
    {
        if ($travelPlan->user_id !== Auth::id()) {
            abort(403);
        }

        if (!$travelPlan->travel_id) {
            return redirect()->route('travel-plans.show', $travelPlan)
                ->with('error', 'Checkout hanya tersedia jika Rencana Perjalanan menggunakan Agen Travel.');
        }

        $travelPlan->load('destinasis', 'expenses', 'schedules.destinasi', 'travel');

        return view('travel-plans.checkout', compact('travelPlan'));
    }

    public function processCheckout(Request $request, TravelPlan $travelPlan)
    {
        if ($travelPlan->user_id !== Auth::id()) {
            abort(403);
        }

        if (!$travelPlan->travel_id) {
            return redirect()->route('travel-plans.show', $travelPlan)
                ->with('error', 'Checkout tidak dapat diproses tanpa Agen Travel.');
        }

        $request->validate([
            'metode_pembayaran' => 'required|string',
            'payment_proof'     => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $proofPath = $request->file('payment_proof')->store('payment_proofs', 'public');

        $travelPlan->load('travel');

        // Tambahkan pengeluaran paket travel
        if ($travelPlan->travel) {
            $travelPlan->expenses()->firstOrCreate([
                'nama_pengeluaran' => 'Paket Travel: ' . $travelPlan->travel->nama_travel,
            ], [
                'user_id'  => Auth::id(),
                'jumlah'   => $travelPlan->travel->harga_paket,
                'tanggal'  => now()->format('Y-m-d'),
                'kategori' => 'Paket Travel',
            ]);
        }

        $refCode = 'PAY-' . strtoupper(Str::random(8));

        $travelPlan->update([
            'is_checkout'     => true,
            'payment_status'  => 'pending_admin', // Menunggu verifikasi admin
            'trip_status'     => 'planning',       // Belum ready karena belum lunas
            'payment_method'  => $request->metode_pembayaran,
            'payment_ref'     => $refCode,
            'payment_proof'   => $proofPath,
            'status'          => 'Menunggu Verifikasi Pembayaran',
        ]);

        // 1. Notifikasi ke User Pemesan
        UserNotification::sendNotification(
            $travelPlan->user_id,
            '⏳ Pembayaran Sedang Diverifikasi',
            'Bukti pembayaran paket travel "' . ($travelPlan->travel->nama_travel ?? 'Travel') . '" telah diterima dan sedang menunggu verifikasi oleh Admin.',
            'info'
        );

        // Notifikasi ke Agen Travel DITUNDA sampai Admin menyetujui (verifyPayment)
        // Jadi kita tidak kirim notifikasi ke Travel Agen di sini.

        return redirect()->route('travel-plans.receipt', $travelPlan)
            ->with('success', 'Bukti Pembayaran berhasil diunggah! Sedang menunggu verifikasi oleh Admin.');
    }

    public function receipt(TravelPlan $travelPlan)
    {
        if ($travelPlan->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $travelPlan->load('travel', 'destinasis', 'expenses');

        $expensesByCategory = $travelPlan->expenses->groupBy('kategori');

        return view('travel-plans.receipt', compact('travelPlan', 'expensesByCategory'));
    }

    public function addDestinasi(Request $request, TravelPlan $travelPlan)
    {
        $request->validate(['destinasi_id' => 'required|exists:destinasi,id']);

        if ($travelPlan->user_id !== Auth::id()) {
            abort(403);
        }

        if ($travelPlan->destinasis()->where('destinasi_id', $request->destinasi_id)->exists()) {
            return redirect()->route('destinasi.show', $request->destinasi_id)
                ->with('error', 'Destinasi sudah ada di rencana "' . $travelPlan->nama_perjalanan . '".');
        }

        $travelPlan->destinasis()->attach($request->destinasi_id);

        return redirect()->route('destinasi.show', $request->destinasi_id)
            ->with('success', 'Destinasi ditambahkan ke rencana "' . $travelPlan->nama_perjalanan . '"!');
    }

    public function quickAdd(Request $request)
    {
        $request->validate([
            'nama_perjalanan' => 'required|string|max:255',
            'destinasi_id'    => 'required|exists:destinasi,id',
            'tanggal_mulai'   => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'budget'          => 'nullable|numeric|min:0',
        ]);

        $destinasi = Destinasi::find($request->destinasi_id);

        $plan = Auth::user()->travelPlans()->create([
            'nama_perjalanan' => $request->nama_perjalanan,
            'tujuan'          => $destinasi->kota ?? null,
            'tanggal_mulai'   => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'budget'          => $request->budget,
            'status'          => 'Perencanaan Aktif',
        ]);

        $plan->destinasis()->attach($request->destinasi_id);

        return redirect()->route('destinasi.show', $request->destinasi_id)
            ->with('success', 'Rencana "' . $plan->nama_perjalanan . '" dibuat dan destinasi ditambahkan!');
    }

    public function removeDestinasi(TravelPlan $travelPlan, Destinasi $destinasi)
    {
        if ($travelPlan->user_id !== Auth::id()) {
            abort(403);
        }

        $travelPlan->destinasis()->detach($destinasi->id);
        return back()->with('success', 'Destinasi dihapus dari rencana.');
    }

    public function destroy(TravelPlan $travelPlan)
    {
        if ($travelPlan->user_id !== Auth::id()) {
            abort(403);
        }

        if ($travelPlan->foto_sampul && Storage::disk('public')->exists($travelPlan->foto_sampul)) {
            Storage::disk('public')->delete($travelPlan->foto_sampul);
        }

        $travelPlan->delete();
        return redirect()->route('travel-plans.index')->with('success', 'Rencana dihapus.');
    }

    public function complete(TravelPlan $travelPlan)
    {
    if ($travelPlan->user_id !== Auth::id()) {
        abort(403);
    }

    $travelPlan->update(['status' => 'Selesai']);

    return redirect()->route('travel-plans.show', $travelPlan)
        ->with('success', 'Perjalanan ditandai sebagai selesai! Cek di Riwayat Perjalanan.');
    }


}