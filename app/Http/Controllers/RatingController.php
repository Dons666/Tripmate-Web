<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function store(Request $request, string $type, int $id): RedirectResponse
    {
        abort_unless($type === 'destination', 404);

        $request->validate([
            'rating' => ['required', 'numeric', 'min:1', 'max:5'],
            'review' => ['nullable', 'string', 'max:500'],
        ]);

        Rating::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'destinasi_id' => $id,
            ],
            [
                'skor_rating' => $request->rating,
                'komentar' => $request->review,
            ]
        );

        return back()->with('success', 'Ulasan berhasil ditambahkan/diperbarui!');
    }
}
