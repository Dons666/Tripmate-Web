<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\TravelPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    /**
     * Tambahkan jadwal baru ke travel plan.
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
            'jam_mulai'    => 'nullable|date_format:H:i',
            'jam_selesai'  => 'nullable|date_format:H:i',
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

        return back()->with('success', 'Jadwal kegiatan berhasil ditambahkan!');
    }

    /**
     * Hapus jadwal kegiatan dari travel plan.
     */
    public function destroy(Schedule $schedule)
    {
        if ($schedule->travelPlan->user_id !== Auth::id()) {
            abort(403);
        }

        $schedule->delete();

        return back()->with('success', 'Jadwal kegiatan berhasil dihapus.');
    }
}
