<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TravelPlan;
use Illuminate\Http\Request;

class TravelPlanController extends Controller
{
    /**
     * List semua travel plan milik user.
     */
    public function index(Request $request)
    {
        $plans = $request->user()
            ->travelPlans()
            ->with('destinasis', 'expenses')
            ->latest()
            ->get();

        return response()->json($plans);
    }

    /**
     * Buat travel plan baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_perjalanan' => 'required|string|max:255',
            'tanggal_mulai'   => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'budget'          => 'nullable|numeric|min:0',
            'tujuan'          => 'nullable|string|max:255',
            'catatan'         => 'nullable|string',
        ]);

        $plan = $request->user()->travelPlans()->create([
            'nama_perjalanan' => $request->nama_perjalanan,
            'tanggal_mulai'   => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'budget'          => $request->budget ?? 0,
            'tujuan'          => $request->tujuan,
            'catatan'         => $request->catatan,
            'status'          => 'planning',
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Rencana perjalanan berhasil dibuat!',
            'plan'    => $plan,
        ], 201);
    }

    /**
     * Detail travel plan + destinations + expenses.
     */
    public function show(Request $request, string $id)
    {
        $plan = TravelPlan::with(['destinasis', 'expenses', 'schedules.destinasi:id,nama_destinasi,kota,gambar'])
            ->where('user_id', $request->user()->id)
            ->findOrFail($id);

        return response()->json($plan);
    }

    /**
     * Hapus travel plan.
     */
    public function destroy(Request $request, string $id)
    {
        $plan = TravelPlan::where('user_id', $request->user()->id)
            ->findOrFail($id);

        $plan->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Rencana perjalanan dihapus.',
        ]);
    }

    /**
     * Tambah destinasi ke travel plan.
     */
    public function addDestinasi(Request $request, string $planId)
    {
        $request->validate([
            'destinasi_id' => 'required|exists:destinasi,id',
        ]);

        $plan = TravelPlan::where('user_id', $request->user()->id)
            ->findOrFail($planId);

        if ($plan->destinasis()->where('destinasi_id', $request->destinasi_id)->exists()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Destinasi sudah ada di rencana ini.',
            ], 422);
        }

        $plan->destinasis()->attach($request->destinasi_id);

        return response()->json([
            'status'  => 'success',
            'message' => 'Destinasi ditambahkan ke rencana!',
        ]);
    }

    /**
     * Hapus destinasi dari travel plan.
     */
    public function removeDestinasi(Request $request, string $planId, string $destinasiId)
    {
        $plan = TravelPlan::where('user_id', $request->user()->id)
            ->findOrFail($planId);

        $plan->destinasis()->detach($destinasiId);

        return response()->json([
            'status'  => 'success',
            'message' => 'Destinasi dihapus dari rencana.',
        ]);
    }
}
