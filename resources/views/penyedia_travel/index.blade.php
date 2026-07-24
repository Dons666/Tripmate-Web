<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penyedia Travel Terpercaya - TripMate</title>
    <!-- Google Fonts Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 font-sans text-slate-800 antialiased min-h-screen">
    @include('layouts.navigation')

    <!-- Hero Header -->
    <section class="relative bg-gradient-to-br from-slate-900 via-sky-950 to-slate-900 text-white py-14 px-4 sm:px-6 lg:px-8 overflow-hidden shadow-xl">
        <div class="absolute -right-20 -top-20 w-96 h-96 bg-sky-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="max-w-7xl mx-auto text-center relative z-10">
            <span class="inline-block px-3.5 py-1 bg-sky-500/20 text-sky-300 rounded-full text-xs font-black uppercase tracking-wider mb-3 border border-sky-500/30">
                Partner Travel Resmi
            </span>
            <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight">
                Temukan Mitra Travel Terpercaya
            </h1>
            <p class="text-slate-300 mt-3 text-sm sm:text-base max-w-2xl mx-auto font-medium">
                Pilih armada kendaraan terbaik, cek tarif transparan, dan hubungi penyedia travel langsung melalui WhatsApp resmi.
            </p>

            <!-- Search Bar Form -->
            <form method="GET" action="{{ route('penyedia-travel.index') }}" class="mt-8 max-w-2xl mx-auto flex flex-col sm:flex-row gap-3">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 9 0 0114 0z"/></svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari berdasarkan nama travel, kota asal, atau jenis armada..."
                        class="w-full rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 pl-11 pr-4 py-3.5 text-sm text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:bg-white/20 transition shadow-inner">
                </div>
                <button type="submit" class="px-7 py-3.5 bg-sky-500 hover:bg-sky-400 text-slate-950 font-extrabold rounded-2xl text-sm transition shadow-lg shadow-sky-500/30 flex items-center justify-center gap-2">
                    <span>Cari Travel</span>
                </button>
            </form>
        </div>
    </section>

    <!-- Main Content Container -->
    <main class="max-w-7xl mx-auto px-4 py-10 sm:px-6 lg:px-8">
        
        <!-- Header Info & Search Filter Status -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h2 class="text-xl font-extrabold text-slate-900">Katalog Paket Perjalanan</h2>
                <p class="text-xs text-slate-500 mt-0.5">Menampilkan paket wisata dan perjalanan dari mitra travel terpercaya.</p>
            </div>
            
            @if(request('search'))
                <div class="flex items-center gap-2">
                    <span class="text-xs text-slate-500">Hasil pencarian untuk: <strong>"{{ request('search') }}"</strong></span>
                    <a href="{{ route('penyedia-travel.index') }}" class="text-xs text-rose-600 font-bold hover:underline">Hapus Filter</a>
                </div>
            @endif
        </div>

        <!-- Travel Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            @forelse($packages as $package)
                <div class="bg-white rounded-3xl shadow-sm hover:shadow-xl border border-slate-200/80 transition-all duration-300 overflow-hidden flex flex-col justify-between group hover:-translate-y-1">
                    <!-- Photo Header -->
                    <div class="relative h-48 bg-slate-900 overflow-hidden">
                        @if($package->gambar)
                            <img src="{{ str_starts_with($package->gambar, 'http') ? $package->gambar : asset('storage/' . $package->gambar) }}" alt="{{ $package->nama_travel }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-slate-900 via-sky-950 to-slate-900 flex flex-col items-center justify-center text-slate-400 gap-1">
                                <span class="text-4xl">🎒</span>
                                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Paket Wisata</span>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-black/20"></div>
                        <div class="absolute top-3 left-3 right-3 flex items-center justify-between gap-2">
                            <span class="px-3 py-1 bg-slate-900/80 backdrop-blur-md text-white rounded-full text-xs font-bold border border-white/20 flex items-center gap-1.5 shadow">
                                📍 {{ $package->kota ?? 'Destinasi' }}
                            </span>
                            <span class="px-2.5 py-1 bg-sky-500/90 backdrop-blur-md text-white rounded-full text-[10px] font-black uppercase tracking-wider shadow">
                                Rp {{ number_format($package->harga_paket, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <div class="p-6">
                        <!-- Travel Name -->
                        <h3 class="text-xl font-extrabold text-slate-900 group-hover:text-sky-600 transition-colors leading-tight mb-2">
                            {{ $package->nama_travel }}
                        </h3>
                        <p class="text-xs text-slate-500 line-clamp-2 mb-4">{{ $package->deskripsi }}</p>

                        <!-- Info Rows -->
                        <div class="space-y-3 text-xs border-t border-slate-100 pt-4">
                            <div class="flex items-start gap-2">
                                <span class="text-base shrink-0">🚐</span>
                                <div>
                                    <span class="font-bold text-slate-800 text-[11px] uppercase tracking-wider block">Layanan & Fasilitas</span>
                                    <p class="text-slate-600 font-semibold text-xs">{{ $package->layanan }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Action Card -->
                    <div class="p-6 bg-slate-50/80 border-t border-slate-100 flex items-center justify-between gap-3">
                        <a href="{{ route('penyedia-travel.show', $package->id) }}" class="w-full text-center px-4 py-3 bg-sky-600 hover:bg-sky-700 text-white rounded-xl text-sm font-extrabold transition shadow-md flex items-center justify-center gap-2">
                            Lihat Detail & Pesan <span>&rarr;</span>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-3xl p-12 text-center border border-slate-200/80 shadow-sm">
                    <div class="w-16 h-16 bg-sky-50 text-sky-600 rounded-full flex items-center justify-center font-bold text-3xl mx-auto mb-4">
                        🎒
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">Belum Ada Paket Perjalanan</h3>
                    <p class="text-slate-500 text-xs mt-1 max-w-md mx-auto">
                        Belum ada mitra penyedia travel yang menambahkan paket perjalanannya.
                    </p>
                    <a href="{{ route('penyedia-travel.create') }}" class="inline-block mt-5 px-6 py-2.5 bg-sky-600 hover:bg-sky-700 text-white text-xs font-bold rounded-xl shadow transition">
                        Daftar Sebagai Penyedia Travel &rarr;
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $packages->links() }}
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-400 py-10 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-xs">
            <p>&copy; {{ date('Y') }} TripMate. Seluruh Hak Cipta Dilindungi.</p>
        </div>
    </footer>
</body>
</html>
