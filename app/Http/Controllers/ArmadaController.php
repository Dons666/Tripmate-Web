<?php

namespace App\Http\Controllers;

use App\Models\Armada;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArmadaController extends Controller
{
    public function index()
    {
        $armadas = Auth::user()->armadas()->latest()->get();
        return view('travel.armada.index', compact('armadas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kendaraan' => 'required|string|max:255',
            'nomor_polisi'   => 'nullable|string|max:50',
            'kapasitas_kursi'=> 'required|integer|min:1',
        ]);

        Auth::user()->armadas()->create($request->all());

        return back()->with('success', 'Armada berhasil ditambahkan!');
    }

    public function update(Request $request, Armada $armada)
    {
        if ($armada->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'nama_kendaraan' => 'required|string|max:255',
            'nomor_polisi'   => 'nullable|string|max:50',
            'kapasitas_kursi'=> 'required|integer|min:1',
        ]);

        $armada->update($request->all());

        return back()->with('success', 'Armada berhasil diupdate!');
    }

    public function destroy(Armada $armada)
    {
        if ($armada->user_id !== Auth::id()) {
            abort(403);
        }

        // Cek apakah armada sedang dipakai oleh paket travel
        if ($armada->travels()->count() > 0) {
            return back()->with('error', 'Armada tidak dapat dihapus karena sedang digunakan pada Paket Travel!');
        }

        $armada->delete();

        return back()->with('success', 'Armada berhasil dihapus!');
    }
}
