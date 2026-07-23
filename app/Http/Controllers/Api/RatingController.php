<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use App\Models\Destinasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    /**
     * GET /api/ratings/destinasi/{id}
     * Ambil semua rating untuk destinasi tertentu (publik).
     */
    public function index(int $id)
    {
        $destinasi = Destinasi::findOrFail($id);

        $ratings = Rating::where('destinasi_id', $id)
            ->with('user:id,name')
            ->latest()
            ->get()
            ->map(fn ($r) => [
                'id'          => $r->id,
                'user_name'   => $r->user?->name ?? 'Anonim',
                'skor_rating' => (float) $r->skor_rating,
                'komentar'    => $r->komentar,
                'created_at'  => $r->created_at?->toDateString(),
            ]);

        return response()->json([
            'destinasi_id'   => $destinasi->id,
            'nama_destinasi' => $destinasi->nama_destinasi,
            'avg_rating'     => $destinasi->rating_destinasi,
            'total_reviews'  => $ratings->count(),
            'ratings'        => $ratings,
        ]);
    }

    /**
     * POST /api/ratings/destinasi/{id}
     * Submit atau update rating user untuk destinasi ini (auth).
     */
    public function store(Request $request, int $id)
    {
        $destinasi = Destinasi::findOrFail($id);

        $validated = $request->validate([
            'skor_rating' => ['required', 'numeric', 'min:1', 'max:5'],
            'komentar'    => ['nullable', 'string', 'max:500'],
        ]);

        $rating = Rating::updateOrCreate(
            [
                'user_id'      => Auth::id(),
                'destinasi_id' => $id,
            ],
            [
                'skor_rating' => $validated['skor_rating'],
                'komentar'    => $validated['komentar'] ?? null,
            ]
        );

        // Update Bayesian average rating di tabel destinasi
        Rating::updateDestinationRating($id);

        return response()->json([
            'message'    => 'Rating berhasil disimpan.',
            'rating'     => [
                'id'          => $rating->id,
                'skor_rating' => (float) $rating->skor_rating,
                'komentar'    => $rating->komentar,
            ],
            'avg_rating' => Destinasi::find($id)?->rating_destinasi,
        ]);
    }

    /**
     * GET /api/ratings/my
     * Semua rating yang pernah diberikan user yang sedang login.
     */
    public function my()
    {
        $ratings = Rating::where('user_id', Auth::id())
            ->with('destinasi:id,nama_destinasi')
            ->latest()
            ->get()
            ->map(fn ($r) => [
                'id'             => $r->id,
                'destinasi_id'   => $r->destinasi_id,
                'nama_destinasi' => $r->destinasi?->nama_destinasi,
                'skor_rating'    => (float) $r->skor_rating,
                'komentar'       => $r->komentar,
                'created_at'     => $r->created_at?->toDateString(),
            ]);

        return response()->json(['ratings' => $ratings]);
    }
}
