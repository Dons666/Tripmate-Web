<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\TravelPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    /**
<<<<<<< HEAD
     * Tambahkan jadwal baru ke travel plan.
=======
     * Tambah jadwal baru ke travel plan.
>>>>>>> 2b8a5de4b1fb5421787a20f79da6ed6a661a6750
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
<<<<<<< HEAD
            'jam_mulai'    => 'nullable|date_format:H:i',
            'jam_selesai'  => 'nullable|date_format:H:i',
=======
            'jam_mulai'    => 'nullable',
            'jam_selesai'  => 'nullable',
>>>>>>> 2b8a5de4b1fb5421787a20f79da6ed6a661a6750
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

<<<<<<< HEAD
        return back()->with('success', 'Jadwal kegiatan berhasil ditambahkan!');
    }

    /**
     * Hapus jadwal kegiatan dari travel plan.
=======
        return redirect()->back()->with('success', 'Jadwal berhasil ditambahkan!');
    }

    /**
     * Hapus jadwal.
>>>>>>> 2b8a5de4b1fb5421787a20f79da6ed6a661a6750
     */
    public function destroy(Schedule $schedule)
    {
        if ($schedule->travelPlan->user_id !== Auth::id()) {
            abort(403);
        }

        $schedule->delete();

<<<<<<< HEAD
        return back()->with('success', 'Jadwal kegiatan berhasil dihapus.');
=======
        return redirect()->back()->with('success', 'Jadwal berhasil dihapus.');
>>>>>>> 2b8a5de4b1fb5421787a20f79da6ed6a661a6750
    }
}
