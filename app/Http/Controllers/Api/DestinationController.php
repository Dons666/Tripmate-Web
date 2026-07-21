<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    /**
     * List semua destinasi, dengan filter opsional.
     */
    public function index(Request $request)
    {
        $query = Destination::query();

        if ($request->filled('search')) {
            $keyword = $request->search;
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', '%' . $keyword . '%')
                  ->orWhere('description', 'like', '%' . $keyword . '%')
                  ->orWhere('address', 'like', '%' . $keyword . '%');
            });
        }

        if ($request->filled('kategori')) {
            $query->where('category', $request->kategori);
        }

        if ($request->filled('kota')) {
            $query->where('kota', $request->kota);
        }

        if ($request->filled('budget_max')) {
            $query->where('estimated_cost', '<=', $request->budget_max);
        }

        $destinations = $query->latest()->paginate(20);

        return response()->json($destinations);
    }

    /**
     * Tampilkan detail satu destinasi.
     */
    public function show(string $id)
    {
        $destination = Destination::findOrFail($id);

        return response()->json($destination);
    }

    /**
     * Simpan destinasi baru (admin only).
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'description'    => 'nullable|string',
            'latitude'       => 'required|numeric',
            'longitude'      => 'required|numeric',
            'address'        => 'required|string',
            'image'          => 'nullable|string',
            'estimated_cost' => 'nullable|numeric|min:0',
            'category'       => 'nullable|string',
            'kota'           => 'nullable|string',
        ]);

        $destination = Destination::create($request->only([
            'name', 'description', 'latitude', 'longitude',
            'address', 'image', 'estimated_cost', 'category', 'kota',
        ]));

        return response()->json([
            'status'      => 'success',
            'message'     => 'Destinasi berhasil ditambahkan!',
            'destination' => $destination,
        ], 201);
    }

    /**
     * Update destinasi (admin only).
     */
    public function update(Request $request, string $id)
    {
        $destination = Destination::findOrFail($id);

        $request->validate([
            'name'           => 'sometimes|string|max:255',
            'description'    => 'nullable|string',
            'latitude'       => 'sometimes|numeric',
            'longitude'      => 'sometimes|numeric',
            'address'        => 'sometimes|string',
            'image'          => 'nullable|string',
            'estimated_cost' => 'nullable|numeric|min:0',
            'category'       => 'nullable|string',
            'kota'           => 'nullable|string',
        ]);

        $destination->update($request->only([
            'name', 'description', 'latitude', 'longitude',
            'address', 'image', 'estimated_cost', 'category', 'kota',
        ]));

        return response()->json([
            'status'      => 'success',
            'message'     => 'Destinasi berhasil diperbarui!',
            'destination' => $destination,
        ]);
    }

    /**
     * Hapus destinasi (admin only).
     */
    public function destroy(string $id)
    {
        $destination = Destination::findOrFail($id);
        $destination->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Destinasi berhasil dihapus!',
        ]);
    }
}
