<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 - Akses Ditolak | {{ config('app.name', 'TripMate') }}</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-slate-900 text-slate-100 min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
    <!-- Background Gradient Accents -->
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-sky-500/20 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-indigo-500/20 rounded-full blur-3xl"></div>

    <div class="relative z-10 max-w-lg w-full bg-slate-800/80 backdrop-blur-xl border border-slate-700/60 rounded-3xl p-8 sm:p-10 shadow-2xl text-center">
        <!-- Badge & Icon -->
        <div class="mx-auto w-20 h-20 bg-rose-500/10 border border-rose-500/20 rounded-2xl flex items-center justify-center mb-6 shadow-inner">
            <svg class="w-10 h-10 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 002-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
            </svg>
        </div>

        <span class="inline-block px-3 py-1 bg-rose-500/10 border border-rose-500/30 text-rose-400 text-xs font-bold uppercase tracking-wider rounded-full mb-3">
            Error 403 - Forbidden
        </span>

        <h1 class="text-3xl sm:text-4xl font-extrabold text-white mb-3 tracking-tight">
            Akses Ditolak
        </h1>

        <p class="text-slate-300 text-sm sm:text-base mb-8 leading-relaxed">
            {{ $exception->getMessage() ?: 'Halaman ini hanya dapat diakses oleh akun dengan role Admin. Silakan pastikan Anda telah login menggunakan akun Admin.' }}
        </p>

        <!-- Actions -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
            <a href="{{ route('home') }}" class="w-full sm:w-auto px-6 py-3 bg-slate-700 hover:bg-slate-600 text-slate-100 text-sm font-semibold rounded-2xl transition duration-200 shadow-md flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 00-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Kembali ke Beranda
            </a>

            @auth
                <form method="POST" action="{{ route('logout') }}" class="w-full sm:w-auto">
                    @csrf
                    <button type="submit" class="w-full sm:w-auto px-6 py-3 bg-sky-600 hover:bg-sky-500 text-white text-sm font-semibold rounded-2xl transition duration-200 shadow-lg shadow-sky-600/30 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 01-3-3H6a3 3 0 01-3 3v1"></path>
                        </svg>
                        Logout & Ganti Akun
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="w-full sm:w-auto px-6 py-3 bg-sky-600 hover:bg-sky-500 text-white text-sm font-semibold rounded-2xl transition duration-200 shadow-lg shadow-sky-600/30 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 01-3-3H7a3 3 0 013 3v1"></path>
                    </svg>
                    Halaman Login
                </a>
            @endauth
        </div>
    </div>
</body>
</html>
