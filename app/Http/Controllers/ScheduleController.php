<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\TravelPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    /**
     * Tambah jadwal baru ke travel plan.
     */
    public function store(Request $request, TravelPlan $travelPlan)
    {
        if ($travelPlan->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'judul'        => 'required|string|max:255',
            'tanggal'      => 'required|date',
            'deskripsi'    => 'nullable|string',
            'jam_mulai'    => 'nullable',
            'jam_selesai'  => 'nullable',
            'destinasi_id' => 'nullable|exists:destinasi,id',
        ]);

        $travelPlan->schedules()->create([
            'destinasi_id' => $request->destinasi_id,
            'judul'        => $request->judul,
            'deskripsi'    => $request->deskripsi,
            'tanggal'      => $request->tanggal,
            'jam_mulai'    => $request->jam_mulai,
            'jam_selesai'  => $request->jam_selesai,
        ]);

        return redirect()->back()->with('success', 'Jadwal berhasil ditambahkan!');
    }

    /**
     * Hapus jadwal.
     */
    public function destroy(Schedule $schedule)
    {
        if ($schedule->travelPlan->user_id !== Auth::id()) {
            abort(403);
        }

        $schedule->delete();

        return redirect()->back()->with('success', 'Jadwal berhasil dihapus.');
    }
}
