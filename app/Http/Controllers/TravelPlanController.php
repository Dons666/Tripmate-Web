<?php

namespace App\Http\Controllers;

use App\Models\TravelPlan;
use App\Models\Destinasi;

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
        if ((int) $travelPlan->user_id !== (int) Auth::id() && (!Auth::check() || !Auth::user()->isAdmin())) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat Rencana Perjalanan milik pengguna lain.');
        }

        $travelPlan->load('destinasis', 'expenses', 'schedules.destinasi');
        return view('travel-plans.show', compact('travelPlan'));
    }

    public function attachTravel(Request $request, TravelPlan $travelPlan)
    {
        if ((int) $travelPlan->user_id !== (int) Auth::id()) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengubah Rencana Perjalanan ini.');
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
        if ((int) $travelPlan->user_id !== (int) Auth::id()) {
            abort(403, 'Anda tidak memiliki hak akses untuk melakukan checkout Rencana Perjalanan ini.');
        }

        if (!$travelPlan->travel_id) {
            return redirect()->route('travel-plans.show', $travelPlan)
                ->with('error', 'Checkout hanya tersedia jika Rencana Perjalanan menggunakan Agen Travel.');
        }

        $travelPlan->load('destinasis', 'expenses', 'schedules.destinasi');

        return view('travel-plans.checkout', compact('travelPlan'));
    }

    public function processCheckout(Request $request, TravelPlan $travelPlan)
    {
        if ((int) $travelPlan->user_id !== (int) Auth::id()) {
            abort(403, 'Anda tidak memiliki hak akses untuk memproses checkout Rencana Perjalanan ini.');
        }

        if (!$travelPlan->travel_id) {
            return redirect()->route('travel-plans.show', $travelPlan)
                ->with('error', 'Checkout tidak dapat diproses tanpa Agen Travel.');
        }

        $request->validate([
            'metode_pembayaran' => 'required|string',
            'payment_proof'     => 'required|image|max:2048',
        ]);

        $proofPath = null;
        if ($request->hasFile('payment_proof')) {
            $proofPath = $request->file('payment_proof')->store('payment-proofs', 'public');
        }

        $travelPlan->update([
            'is_checkout' => true,
            'payment_method' => $request->metode_pembayaran,
            'payment_proof' => $proofPath,
            'payment_status' => 'pending_admin',
            'trip_status' => 'pending',
            'status'      => 'Menunggu Konfirmasi',
        ]);

        return redirect()->route('travel-plans.receipt', $travelPlan)
            ->with('success', 'Pembayaran Checkout Paket Travel berhasil diajukan! Menunggu verifikasi dari Admin.');
    }

    public function addDestinasi(Request $request, TravelPlan $travelPlan)
    {
        $request->validate(['destinasi_id' => 'required|exists:destinasi,id']);

        if ((int) $travelPlan->user_id !== (int) Auth::id()) {
            abort(403, 'Anda tidak memiliki hak akses untuk menambah destinasi ke Rencana Perjalanan ini.');
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

    public function saveIntegratedRoute(Request $request)
    {
        $request->validate([
            'nama_perjalanan' => 'required|string|max:255',
            'budget'          => 'required|numeric|min:0',
            'destinasi_ids'   => 'required|array|min:1',
            'destinasi_ids.*' => 'exists:destinasi,id',
        ]);

        $plan = Auth::user()->travelPlans()->create([
            'nama_perjalanan' => $request->nama_perjalanan,
            'budget'          => $request->budget,
            'status'          => 'Perencanaan Aktif',
        ]);

        $plan->destinasis()->attach($request->destinasi_ids);

        return redirect()->route('travel-plans.show', $plan->id)
            ->with('success', 'Rute terpendek berhasil disimpan sebagai rencana perjalanan!');
    }

    public function removeDestinasi(TravelPlan $travelPlan, Destinasi $destinasi)
    {
        if ((int) $travelPlan->user_id !== (int) Auth::id()) {
            abort(403, 'Anda tidak memiliki hak akses untuk menghapus destinasi dari Rencana Perjalanan ini.');
        }

        $travelPlan->destinasis()->detach($destinasi->id);
        return back()->with('success', 'Destinasi dihapus dari rencana.');
    }

    public function destroy(TravelPlan $travelPlan)
    {
        if ((int) $travelPlan->user_id !== (int) Auth::id()) {
            abort(403, 'Anda tidak memiliki hak akses untuk menghapus Rencana Perjalanan ini.');
        }

        if ($travelPlan->foto_sampul && Storage::disk('public')->exists($travelPlan->foto_sampul)) {
            Storage::disk('public')->delete($travelPlan->foto_sampul);
        }

        $travelPlan->delete();
        return redirect()->route('travel-plans.index')->with('success', 'Rencana dihapus.');
    }

    public function complete(TravelPlan $travelPlan)
    {
        if ((int) $travelPlan->user_id !== (int) Auth::id()) {
            abort(403, 'Anda tidak memiliki hak akses untuk menyelesaikan Rencana Perjalanan ini.');
        }

        $travelPlan->update(['status' => 'Selesai']);

        return redirect()->route('travel-plans.receipt', $travelPlan)
            ->with('success', 'Selamat! Perjalanan Anda telah selesai. Berikut struk dan ringkasan perjalanannya.');
    }

    public function receipt(TravelPlan $travelPlan)
    {
        if ((int) $travelPlan->user_id !== (int) Auth::id() && (!Auth::check() || !Auth::user()->isAdmin())) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat Struk Rencana Perjalanan milik pengguna lain.');
        }

        $travelPlan->load('destinasis', 'expenses', 'schedules.destinasi', 'travel');

        $expensesByCategory = $travelPlan->expenses->groupBy(function ($expense) {
            return $expense->kategori ? ucfirst($expense->kategori) : 'Lain-lain';
        });

        $userRatings = \App\Models\Rating::where('user_id', Auth::id())->get();

        return view('travel-plans.receipt', compact('travelPlan', 'expensesByCategory', 'userRatings'));
    }

    public function bookPackage(Request $request, $travelId)
    {
        $request->validate([
            'jumlah_peserta' => 'required|integer|min:1',
        ]);

        $travel = \App\Models\Travel::findOrFail($travelId);

        $plan = Auth::user()->travelPlans()->create([
            'nama_perjalanan' => 'Trip ' . $travel->nama_travel,
            'tujuan'          => $travel->kota,
            'tanggal_mulai'   => $travel->tanggal_keberangkatan,
            'tanggal_selesai' => $travel->tanggal_keberangkatan,
            'budget'          => $travel->harga_paket * $request->jumlah_peserta,
            'travel_id'       => $travel->id,
            'jumlah_peserta'  => $request->jumlah_peserta,
            'status'          => 'Perencanaan Aktif',
        ]);

        return redirect()->route('travel-plans.show', $plan->id)
            ->with('success', 'Paket travel berhasil dipesan! Anda langsung diarahkan ke rencana perjalanan baru.');
    }
}