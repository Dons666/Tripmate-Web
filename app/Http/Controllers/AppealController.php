<?php

namespace App\Http\Controllers;

use App\Models\Appeal;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AppealController extends Controller
{
    /**
     * Store a new account deactivation appeal from a user.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'reason' => ['required', 'string', 'min:10', 'max:1000'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'reason.required' => 'Penjelasan banding wajib diisi.',
            'reason.min' => 'Penjelasan banding minimal 10 karakter.',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Akun dengan email tersebut tidak ditemukan.']);
        }

        if ($user->is_active) {
            return back()->with('info', 'Akun Anda saat ini aktif dan tidak sedang dinonaktifkan.');
        }

        // Check if there is already a pending appeal
        $existingAppeal = Appeal::where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();

        if ($existingAppeal) {
            return back()->with('info', 'Anda sudah mengajukan banding yang sedang dalam proses peninjauan Admin. Mohon tunggu informasi selanjutnya.');
        }

        Appeal::create([
            'user_id' => $user->id,
            'email' => $user->email,
            'reason' => $request->reason,
            'status' => 'pending',
            'is_read' => false,
        ]);

        return back()->with('appeal_success', 'Pengajuan banding Anda telah berhasil dikirim ke Admin. Silakan tunggu peninjauan ulang oleh tim Admin.');
    }
}
