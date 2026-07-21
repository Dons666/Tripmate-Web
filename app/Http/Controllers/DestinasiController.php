<?php

namespace App\Http\Controllers;

use App\Models\Destinasi;
use App\Models\Kategori;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\RecommendationService;

class DestinasiController extends Controller
{
    protected RecommendationService $recommendationService;

    public function __construct(
    RecommendationService $recommendationService
)
{
    $this->recommendationService = $recommendationService;
}
    // Halaman Search & Filter
    public function search(Request $request)
    {
        $query = Destinasi::query();

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function($q) use ($keyword) {
                $q->where('nama_destinasi', 'like', '%' . $keyword . '%')
                  ->orWhere('deskripsi', 'like', '%' . $keyword . '%');
            });
        }

        if ($request->filled('kota')) {
            $query->where('kota', $request->kota);
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('harga_min')) {
            $query->where('harga', '>=', $request->harga_min);
        }
        if ($request->filled('harga_max')) {
            $query->where('harga', '<=', $request->harga_max);
        }

        $destinasis = $query
            ->withAvg('ratings', 'skor_rating')
            ->withCount('ratings')
            ->paginate(12);
        $kotas = Destinasi::select('kota')->distinct()->orderBy('kota')->get();
        $kategoris = Kategori::all();

        return view('destinasi.search', compact('destinasis', 'kotas', 'kategoris'));
    }



    // Halaman Detail Destinasi
    public function show($id)
    {
    // with('ratings.user') = Eager loading agar komentar ikut bawa nama user yang nulis
    $destinasi = Destinasi::with('ratings.user')->findOrFail($id);

    $isBookmarked = false;

    if (Auth::check()) {

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $isBookmarked = $user
            ->bookmarks()
            ->where('destinasi_id', $id)
            ->exists();
    }

        $similarDestinations =
    $this->recommendationService
        ->getSimilarDestinations($id);
 
    return view(
        'destinasi.show',
        compact(
            'destinasi',
            'isBookmarked',
            'similarDestinations'
        )
    );
    }



    // Simpan Rating & Komentar
    public function storeRating(Request $request, $id)
    {
        $request->validate([
            'skor_rating' => 'required|numeric|min:1|max:5',
            'komentar' => 'nullable|string|max:500',
        ]);

        // updateOrCreate memastikan 1 user hanya bisa memberi 1 rating per destinasi
        // Jika user edit rating, akan diupdate. Jika belum, dibuat baru.
        Rating::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'destinasi_id' => $id,
            ],
            [
                'skor_rating' => $request->skor_rating,
                'komentar' => $request->komentar,
            ]
        );

        return back()->with('success', 'Ulasan berhasil ditambahkan/diperbarui!');
    }
}