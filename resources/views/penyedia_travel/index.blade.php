<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penyedia Travel Terpercaya - TripMate</title>
    <!-- Google Fonts Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50/80 font-sans text-slate-800 antialiased min-h-screen">
    @include('layouts.navigation')

    <!-- Hero Header (Light Mode - High Contrast Dark Typography) -->
    <section class="relative bg-gradient-to-b from-sky-50 via-slate-50 to-white py-16 px-4 sm:px-6 lg:px-8 border-b border-slate-200/60 shadow-sm">
        <div class="max-w-4xl mx-auto text-center space-y-4">
            <span class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-sky-100 text-sky-800 border border-sky-200 rounded-full text-xs font-black uppercase tracking-wider shadow-sm">
                🛡️ Mitra Travel Terverifikasi Escrow
            </span>
            
            <h1 class="text-3xl sm:text-5xl font-black text-slate-900 tracking-tight leading-tight">
                Jelajahi Paket Travel & Rental Armada
            </h1>
            
            <p class="text-slate-600 text-sm sm:text-base max-w-2xl mx-auto font-semibold leading-relaxed">
                Pilih paket liburan impian, temukan armada kendaraan nyaman, dan transaksi aman terlindungi garansi **Escrow TripMate**.
            </p>

            <!-- Search Bar Form (Clean White Container with High Contrast Input) -->
            <form method="GET" action="{{ route('penyedia-travel.index') }}" class="mt-8 max-w-2xl mx-auto">
                <div class="bg-white rounded-3xl p-2.5 shadow-xl flex flex-col sm:flex-row items-center gap-2 border-2 border-sky-100 transition-all focus-within:border-sky-500 focus-within:ring-4 focus-within:ring-sky-500/20">
                    <div class="relative flex-1 w-full flex items-center">
                        <div class="pl-4 text-sky-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 9 0 0114 0z"/></svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama paket, kota asal, atau jenis armada..."
                            class="w-full bg-transparent border-0 focus:ring-0 text-slate-900 placeholder-slate-400 text-sm font-bold pl-3 pr-4 py-3 outline-none">
                    </div>
                    <button type="submit" class="w-full sm:w-auto px-8 py-3.5 bg-sky-600 hover:bg-sky-700 text-white font-black rounded-2xl text-sm transition-all duration-200 shadow-md shadow-sky-600/30 shrink-0 flex items-center justify-center gap-2 active:scale-95">
                        <span>Cari Travel</span>
                        <span>&rarr;</span>
                    </button>
                </div>
            </form>
        </div>
    </section>

    <!-- Main Content Container -->
    <main class="max-w-7xl mx-auto px-4 py-12 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Header Info & Search Filter Status -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200/80 pb-5">
            <div>
                <h2 class="text-2xl font-black text-slate-900 tracking-tight">Katalog Paket Perjalanan</h2>
                <p class="text-xs text-slate-500 font-medium mt-0.5">Menampilkan paket wisata dan perjalanan resmi dari mitra terverifikasi.</p>
            </div>
            
            @if(request('search'))
                <div class="flex items-center gap-3 bg-sky-50 px-4 py-2 rounded-2xl border border-sky-100">
                    <span class="text-xs text-sky-900 font-medium">Pencarian: <strong class="font-extrabold text-sky-600">"{{ request('search') }}"</strong></span>
                    <a href="{{ route('penyedia-travel.index') }}" class="text-xs text-rose-600 font-extrabold hover:underline flex items-center gap-1">
                        ✕ Hapus Filter
                    </a>
                </div>
            @endif
        </div>

        <!-- Travel Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            @forelse($packages as $package)
                <div class="bg-white rounded-3xl shadow-sm hover:shadow-2xl border border-slate-200/90 transition-all duration-300 overflow-hidden flex flex-col justify-between group hover:-translate-y-1.5">
                    
                    <!-- Cover Photo Header -->
                    <a href="{{ route('penyedia-travel.show', $package->id) }}" class="relative h-52 bg-slate-900 overflow-hidden block">
                        @if($package->gambar)
                            <img src="{{ str_starts_with($package->gambar, 'http') ? $package->gambar : asset('storage/' . $package->gambar) }}" alt="{{ $package->nama_travel }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-slate-900 via-sky-950 to-slate-900 flex flex-col items-center justify-center text-slate-400 gap-2">
                                <span class="text-5xl">🎒</span>
                                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">TripMate Travel</span>
                            </div>
                        @endif
                        
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/20 to-black/30"></div>
                        
                        <!-- Floating Badges -->
                        <div class="absolute top-3 left-3 right-3 flex items-center justify-between gap-2">
                            <span class="px-3 py-1 bg-slate-900/80 backdrop-blur-md text-white rounded-full text-xs font-bold border border-white/20 flex items-center gap-1.5 shadow-md">
                                📍 {{ $package->kota ?? 'Destinasi' }}
                            </span>
                            <span class="px-3 py-1 bg-sky-500/90 backdrop-blur-md text-white rounded-full text-xs font-black uppercase tracking-wider shadow-md">
                                Rp {{ number_format($package->harga_paket, 0, ',', '.') }} <span class="text-[10px] font-semibold lowercase">/pax</span>
                            </span>
                        </div>
                    </a>

                    <!-- Card Body Info -->
                    <div class="p-6 space-y-4">
                        <div>
                            <div class="flex items-center justify-between gap-2 mb-1">
                                <span class="text-[11px] font-bold text-sky-600 bg-sky-50 px-2.5 py-0.5 rounded-md border border-sky-100">
                                    Oleh {{ $package->user->name ?? 'Mitra Travel' }}
                                </span>
                                @if($package->rating)
                                    <span class="text-xs font-black text-amber-500 flex items-center gap-1">
                                        ★ {{ number_format($package->rating, 1) }}
                                    </span>
                                @endif
                            </div>
                            <h3 class="text-xl font-black text-slate-900 group-hover:text-sky-600 transition-colors leading-tight">
                                <a href="{{ route('penyedia-travel.show', $package->id) }}">
                                    {{ $package->nama_travel }}
                                </a>
                            </h3>
                            <p class="text-xs text-slate-500 line-clamp-2 mt-2 leading-relaxed font-medium">{{ $package->deskripsi }}</p>
                        </div>

                        <!-- Info Features -->
                        <div class="bg-slate-50 p-3.5 rounded-2xl border border-slate-100 space-y-2">
                            <div class="flex items-center gap-2 text-xs text-slate-700 font-bold">
                                <span>🚐</span>
                                <span class="truncate">{{ $package->armada->nama_kendaraan ?? 'Kendaraan Standard Travel' }}</span>
                                <span class="text-slate-300">•</span>
                                <span class="text-sky-600 font-extrabold">{{ $package->armada->kapasitas_kursi ?? '-' }} Kursi</span>
                            </div>
                            <div class="text-[11px] text-slate-500 font-medium truncate">
                                ✨ {{ Str::limit($package->layanan, 35) }}
                            </div>
                        </div>
                    </div>

                    <!-- Footer Action CTA -->
                    <div class="p-6 bg-slate-50/50 border-t border-slate-100">
                        <a href="{{ route('penyedia-travel.show', $package->id) }}" class="w-full py-3.5 bg-sky-600 hover:bg-sky-700 text-white rounded-2xl text-xs font-black transition-all duration-200 shadow-md flex items-center justify-center gap-2 active:scale-95">
                            <span>Lihat Detail & Pesan</span>
                            <span>&rarr;</span>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-3xl p-14 text-center border border-slate-200/80 shadow-sm space-y-3">
                    <div class="w-16 h-16 bg-sky-50 text-sky-600 rounded-full flex items-center justify-center font-bold text-3xl mx-auto mb-2">
                        🎒
                    </div>
                    <h3 class="text-xl font-black text-slate-900">Belum Ada Paket Perjalanan</h3>
                    <p class="text-slate-500 text-xs max-w-md mx-auto font-medium">
                        Belum ada paket perjalanan yang sesuai dengan kata kunci pencarian Anda.
                    </p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8 flex justify-center">
            {{ $packages->links() }}
        </div>
    </main>

    <!-- Bottom Partner CTA Banner (Light Mode) -->
    <section class="bg-slate-100 border-t border-slate-200/80 py-12 px-4 text-center">
        <div class="max-w-3xl mx-auto space-y-3 bg-white p-8 sm:p-10 rounded-3xl border border-slate-200 shadow-sm">
            <span class="px-3.5 py-1 bg-sky-100 text-sky-800 rounded-full text-xs font-black uppercase tracking-wider border border-sky-200 inline-block">
                Kemitraan Agent Travel
            </span>
            <h3 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Punya Usaha Travel / Rental Armada?</h3>
            <p class="text-xs sm:text-sm text-slate-600 max-w-xl mx-auto font-semibold leading-relaxed">
                Bergabunglah sebagai mitra agen travel terverifikasi di TripMate dan jangkau wisatawan di seluruh Indonesia.
            </p>
            <div class="pt-2">
                <a href="{{ route('penyedia-travel.create') }}" class="inline-flex items-center gap-2 px-8 py-3.5 bg-sky-600 hover:bg-sky-700 text-white rounded-2xl text-xs font-black shadow-lg shadow-sky-600/30 transition transform hover:-translate-y-0.5 active:scale-95">
                    <span>Daftar Sebagai Penyedia Travel</span>
                    <span>&rarr;</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-400 py-10 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-xs font-medium">
            <p>&copy; {{ date('Y') }} TripMate. Seluruh Hak Cipta Dilindungi.</p>
        </div>
    </footer>
</body>
</html>
