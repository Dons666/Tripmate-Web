<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Middleware untuk memverifikasi user adalah admin
     * 
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verify user is authenticated and has admin role
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized. Admin access required.');
        }

        return $next($request);
    }
}
