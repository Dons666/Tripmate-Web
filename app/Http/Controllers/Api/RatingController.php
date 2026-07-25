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

        $userId = $request->user()?->id ?? Auth::id();

        $rating = Rating::updateOrCreate(
            [
                'user_id'      => $userId,
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

    public function my(Request $request)
    {
        $userId = $request->user()?->id ?? Auth::id();
        $ratings = Rating::where('user_id', $userId)
            ->with(['destinasi:id,nama_destinasi', 'travel:id,nama_travel'])
            ->latest()
            ->get()
            ->map(fn ($r) => [
                'id'             => $r->id,
                'destinasi_id'   => $r->destinasi_id,
                'nama_destinasi' => $r->destinasi?->nama_destinasi,
                'travel_id'      => $r->travel_id,
                'nama_travel'    => $r->travel?->nama_travel,
                'skor_rating'    => (float) $r->skor_rating,
                'komentar'       => $r->komentar,
                'created_at'     => $r->created_at?->toDateString(),
            ]);

        return response()->json(['ratings' => $ratings]);
    }

    /**
     * POST /api/ratings/travel/{id}
     * Submit atau update rating user untuk agen travel ini (auth).
     */
    public function storeTravel(Request $request, int $id)
    {
        $travel = \App\Models\Travel::findOrFail($id);

        $validated = $request->validate([
            'skor_rating' => ['required', 'numeric', 'min:1', 'max:5'],
            'komentar'    => ['nullable', 'string', 'max:500'],
        ]);

        $userId = $request->user()?->id ?? Auth::id();

        $rating = Rating::updateOrCreate(
            [
                'user_id'   => $userId,
                'travel_id' => $id,
            ],
            [
                'skor_rating' => $validated['skor_rating'],
                'komentar'    => $validated['komentar'] ?? null,
            ]
        );

        $average = Rating::where('travel_id', $id)->avg('skor_rating') ?? 5.0;
        $travel->update(['rating' => $average]);

        return response()->json([
            'message'    => 'Rating travel berhasil disimpan.',
            'rating'     => [
                'id'          => $rating->id,
                'skor_rating' => (float) $rating->skor_rating,
                'komentar'    => $rating->komentar,
            ],
            'avg_rating' => (float) $travel->rating,
        ]);
    }
}
