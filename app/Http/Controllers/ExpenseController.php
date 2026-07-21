<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\TravelPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function store(Request $request, TravelPlan $travelPlan)
    {
        $request->validate([
            'nama_pengeluaran' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0',
            'tanggal' => 'required|date',
            'kategori' => 'nullable|string|max:255',
        ]);

        // Cek apakah travel plan milik user yang login
        if ($travelPlan->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke rencana perjalanan ini.');
        }

        Expense::create([
            'user_id' => Auth::id(),
            'travel_plan_id' => $travelPlan->id,
            'nama_pengeluaran' => $request->nama_pengeluaran,
            'jumlah' => $request->jumlah,
            'tanggal' => $request->tanggal,
            'kategori' => $request->kategori,
        ]);

        return back()->with('success', 'Pengeluaran berhasil ditambahkan!');
    }

    public function destroy(Expense $expense)
    {
        if ($expense->user_id !== Auth::id()) {
            abort(403);
        }

        $expense->delete();
        
        return back()->with('success', 'Pengeluaran dihapus.');
    }
}