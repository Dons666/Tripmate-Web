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

        $email = strtolower(trim($request->email));
        $user = User::where('email', $email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Akun dengan email tersebut tidak ditemukan.']);
        }

        if ($user->is_active) {
            return back()->with('info', 'Akun Anda saat ini aktif dan tidak sedang dinonaktifkan.');
        }

        // Cek apakah ada pengajuan banding yang sedang PENDING
        $existingPending = Appeal::where(function ($q) use ($user, $email) {
                $q->where('user_id', $user->id)
                  ->orWhere('email', $email);
            })
            ->where('status', 'pending')
            ->first();

        if ($existingPending) {
            return back()->with('info', 'Anda sudah memiliki pengajuan banding yang saat ini sedang dalam proses peninjauan Admin. Mohon tunggu keputusan Admin.');
        }

        // Jika pernah diajukan sebelumnya (misal status rejected), perbarui menjadi PENDING kembali dengan alasan baru
        $existingAppeal = Appeal::where(function ($q) use ($user, $email) {
                $q->where('user_id', $user->id)
                  ->orWhere('email', $email);
            })
            ->latest()
            ->first();

        if ($existingAppeal) {
            $existingAppeal->update([
                'reason' => $request->reason,
                'status' => 'pending',
                'is_read' => false,
                'created_at' => now(),
            ]);
        } else {
            Appeal::create([
                'user_id' => $user->id,
                'email' => $user->email,
                'reason' => $request->reason,
                'status' => 'pending',
                'is_read' => false,
            ]);
        }

        return back()->with('appeal_success', 'Pengajuan banding baru Anda telah berhasil dikirim ke Admin. Silakan tunggu peninjauan ulang.');
    }
}
