<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Middleware untuk memverifikasi user adalah admin
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Jika belum login sama sekali, redirect ke halaman Login
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk mengakses Admin Panel.');
        }

        // 2. Jika sudah login tetapi role bukan admin, tampilkan akses ditolak 403 dengan detail akun
        if (!auth()->user()->isAdmin()) {
            $email = auth()->user()->email ?? '-';
            $role = auth()->user()->role ?? 'kosong';
            abort(403, "Akses ditolak. Halaman ini hanya dapat diakses oleh Admin. (Terlogin sebagai: {$email}, Role: '{$role}')");
        }

        return $next($request);
    }
}
