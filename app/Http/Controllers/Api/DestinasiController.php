<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Destinasi;
use Illuminate\Http\Request;

class DestinasiController extends Controller
{
    /**
     * List semua destinasi, dengan filter opsional.
     */
    public function index(Request $request)
    {
        $query = Destinasi::query();

        if ($request->filled('search')) {
            $keyword = $request->search;
            $query->where(function ($q) use ($keyword) {
                $q->where('nama_destinasi', 'like', '%' . $keyword . '%')
                  ->orWhere('deskripsi', 'like', '%' . $keyword . '%')
                  ->orWhere('kota', 'like', '%' . $keyword . '%')
                  ->orWhere('alamat', 'like', '%' . $keyword . '%');
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('kota')) {
            $query->where('kota', $request->kota);
        }

        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }

        if ($request->filled('budget_max')) {
            $query->where('harga', '<=', $request->budget_max);
        }

        if ($request->filled('hidden_gem')) {
            $query->where('hidden_gem', filter_var($request->hidden_gem, FILTER_VALIDATE_BOOLEAN));
        }

        $destinasi = $query->latest()->paginate(20);

        return response()->json($destinasi);
    }

    /**
     * Tampilkan detail satu destinasi.
     */
    public function show(string $id)
    {
        $destinasi = Destinasi::findOrFail($id);

        return response()->json([
            'id'               => $destinasi->id,
            'nama_destinasi'   => $destinasi->nama_destinasi,
            'tipe'             => $destinasi->tipe,
            'kota'             => $destinasi->kota,
            'kategori'         => $destinasi->kategori,
            'harga'            => $destinasi->harga,
            'hidden_gem'       => $destinasi->hidden_gem,
            'deskripsi'        => $destinasi->deskripsi,
            'fasilitas'        => $destinasi->fasilitas,
            'alamat'           => $destinasi->place_address,
            'provinsi'         => $destinasi->province,
            'transportasi'     => $destinasi->transportasi,
            'jam_buka'         => $destinasi->jam_buka,
            'jam_tutup'        => $destinasi->jam_tutup,
            'hari_operasional' => $destinasi->hari_operasional,
            'latitude'         => $destinasi->latitude,
            'longitude'        => $destinasi->longitude,
            'gambar'           => $destinasi->image_url,
            'rating'           => $destinasi->rating_destinasi,
        ]);
    }
}
