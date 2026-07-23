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
                <h2 class="text-xl font-extrabold text-slate-900">Katalog Penyedia Travel Aktif</h2>
                <p class="text-xs text-slate-500 mt-0.5">Menampilkan mitra penyedia travel yang telah resmi disetujui (ACC) Admin.</p>
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
            @forelse($penyediaTravels as $travel)
                <div class="bg-white rounded-3xl shadow-sm hover:shadow-xl border border-slate-200/80 transition-all duration-300 overflow-hidden flex flex-col justify-between group hover:-translate-y-1">
                    <!-- Photo Header -->
                    <div class="relative h-44 bg-slate-900 overflow-hidden">
                        @if($travel->foto_kendaraan)
                            <img src="{{ asset('storage/' . $travel->foto_kendaraan) }}" alt="{{ $travel->nama_travel }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-slate-900 via-sky-950 to-slate-900 flex flex-col items-center justify-center text-slate-400 gap-1">
                                <span class="text-4xl">🚐</span>
                                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Foto Kendaraan</span>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-black/20"></div>
                        <div class="absolute top-3 left-3 right-3 flex items-center justify-between gap-2">
                            <span class="px-3 py-1 bg-slate-900/80 backdrop-blur-md text-white rounded-full text-xs font-bold border border-white/20 flex items-center gap-1.5 shadow">
                                📍 {{ $travel->kota_asal_travel ?? 'Kota Asal' }}
                            </span>
                            <span class="px-2.5 py-1 bg-emerald-500/90 backdrop-blur-md text-white rounded-full text-[10px] font-black uppercase tracking-wider shadow">
                                Verified ACC
                            </span>
                        </div>
                    </div>

                    <div class="p-6">
                        <!-- Travel Name -->
                        <h3 class="text-xl font-extrabold text-slate-900 group-hover:text-sky-600 transition-colors leading-tight mb-4">
                            {{ $travel->nama_travel }}
                        </h3>

                        <!-- Info Rows -->
                        <div class="space-y-4 text-xs">
                            <!-- Armada + Harga + Foto Per Jenis -->
                            <div>
                                <span class="font-bold text-slate-400 uppercase tracking-wider text-[10px] block mb-2">Daftar Armada & Tarif Sewa</span>
                                @if(!empty($travel->jenis_kendaraan))
                                    @php
                                        $armadaList = array_values(array_filter(array_map('trim', explode(',', $travel->jenis_kendaraan))));
                                        $fotosArray = $travel->fotos_array;
                                    @endphp
                                    <div class="space-y-2">
                                        @foreach($armadaList as $index => $armada)
                                            @php
                                                $armadaPhoto = $fotosArray[$index] ?? null;
                                                $rawItem = $armada;

                                                // Extract Price (Rp ...)
                                                $extractedPrice = null;
                                                if (preg_match('/^(.*?)\s*\((?:Rp\s*)?([\d\.]+)\)$/i', $rawItem, $priceMatches)) {
                                                    $rawItem = trim($priceMatches[1]);
                                                    $cleanNum = str_replace('.', '', $priceMatches[2]);
                                                    if (is_numeric($cleanNum) && (float)$cleanNum > 0) {
                                                        $extractedPrice = 'Rp ' . number_format((float)$cleanNum, 0, ',', '.');
                                                    }
                                                }
                                                if (!$extractedPrice && ($travel->harga ?? 0) > 0) {
                                                    $extractedPrice = 'Rp ' . number_format($travel->harga, 0, ',', '.');
                                                }

                                                // Extract Seats (14 Kursi / 14 Orang)
                                                $extractedSeats = null;
                                                if (preg_match('/^(.*?)\s*\((?:(\d+)\s*(?:Kursi|Orang|Pax|Seat))\)$/i', $rawItem, $seatMatches)) {
                                                    $rawItem = trim($seatMatches[1]);
                                                    $extractedSeats = $seatMatches[2] . ' Kursi';
                                                }

                                                // Extract Qty (2 Unit)
                                                $extractedQty = null;
                                                if (preg_match('/^(\d+\s*Unit)\s+(.*)$/i', $rawItem, $qtyMatches)) {
                                                    $extractedQty = $qtyMatches[1];
                                                    $rawItem = trim($qtyMatches[2]);
                                                }
                                            @endphp
                                            <div class="flex items-center justify-between p-2.5 rounded-2xl bg-slate-900 text-white border border-slate-800 shadow-sm gap-2">
                                                <div class="flex items-center gap-2.5 min-w-0">
                                                    @if($armadaPhoto)
                                                        <img src="{{ asset('storage/' . $armadaPhoto) }}" alt="{{ $rawItem }}" class="w-10 h-10 object-cover rounded-xl border border-slate-700 shrink-0">
                                                    @else
                                                        <div class="w-10 h-10 rounded-xl bg-slate-800 flex items-center justify-center text-base shrink-0 border border-slate-700">
                                                            🚐
                                                        </div>
                                                    @endif
                                                    <div class="min-w-0">
                                                        <span class="text-xs font-bold truncate block">
                                                            @if($extractedQty)
                                                                <span class="text-sky-400 font-extrabold">{{ $extractedQty }}</span>
                                                            @endif
                                                            {{ $rawItem }}
                                                        </span>
                                                        @if($extractedSeats)
                                                            <span class="text-[10px] text-sky-300 font-semibold block">
                                                                👥 {{ $extractedSeats }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                @if($extractedPrice)
                                                    <span class="px-2 py-1 bg-emerald-500 text-white rounded-lg text-[10px] font-black shrink-0">
                                                        {{ $extractedPrice }} / hari
                                                    </span>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-slate-400 italic">Armada belum diisi</span>
                                @endif
                            </div>

                            <!-- Hari Operasional -->
                            <div class="bg-slate-50 p-3 rounded-2xl border border-slate-100 flex items-center gap-2">
                                <span class="text-base shrink-0">📅</span>
                                <div>
                                    <span class="font-bold text-slate-800 text-[11px] uppercase tracking-wider block">Hari Operasional</span>
                                    <p class="text-slate-600 font-semibold text-xs">{{ $travel->jadwal_ketersediaan ?? 'Setiap Hari' }}</p>
                                </div>
                            </div>

                            <!-- Alamat -->
                            @if($travel->alamat_travel)
                                <div class="text-slate-500 font-medium flex items-start gap-1.5">
                                    <svg class="w-4 h-4 text-slate-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                    <span class="line-clamp-2">{{ $travel->alamat_travel }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Footer Action Card -->
                    <div class="p-6 bg-slate-50/80 border-t border-slate-100 flex items-center justify-between gap-3">
                        <div>
                            <span class="text-[10px] uppercase font-bold text-slate-400 block">Hubungi Pemilik</span>
                            <span class="text-xs font-extrabold text-slate-800">{{ $travel->nomor_hp_pemilik_travel }}</span>
                        </div>

                        @php
                            $cleanPhone = preg_replace('/[^0-9]/', '', $travel->nomor_hp_pemilik_travel);
                            if (str_starts_with($cleanPhone, '0')) {
                                $cleanPhone = '62' . substr($cleanPhone, 1);
                            }
                            $waMessage = rawurlencode("Halo {$travel->nama_travel}, saya tertarik memesan layanan travel dari TripMate.");
                        @endphp
                        
                        <a href="https://wa.me/{{ $cleanPhone }}?text={{ $waMessage }}" target="_blank"
                            class="px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-extrabold transition shadow-md shadow-emerald-600/20 flex items-center gap-1.5 shrink-0">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                            <span>Chat WA</span>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-3xl p-12 text-center border border-slate-200/80 shadow-sm">
                    <div class="w-16 h-16 bg-sky-50 text-sky-600 rounded-full flex items-center justify-center font-bold text-3xl mx-auto mb-4">
                        🚌
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">Belum Ada Penyedia Travel Aktif</h3>
                    <p class="text-slate-500 text-xs mt-1 max-w-md mx-auto">
                        Belum ada mitra penyedia travel yang terdaftar atau disetujui. Apakah Anda pemilik bisnis travel?
                    </p>
                    <a href="{{ route('penyedia-travel.create') }}" class="inline-block mt-5 px-6 py-2.5 bg-sky-600 hover:bg-sky-700 text-white text-xs font-bold rounded-xl shadow transition">
                        Daftar Sebagai Penyedia Travel &rarr;
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $penyediaTravels->links() }}
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
