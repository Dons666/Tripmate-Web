<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $destinasi->nama_destinasi }} - TripMate</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans">

    <!-- Navbar -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <a href="{{ route('home') }}" class="text-2xl font-bold tracking-tight">
                    <span class="text-sky-600">TripMate</span>
                </a>
                <a href="javascript:history.back()" class="text-sm text-gray-600 hover:text-sky-500">← Kembali</a>
            </div>
        </div>
    </nav>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Header Detail -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
            
            <!-- Bagian Gambar Utama -->
            <div class="w-full h-[450px] md:h-[550px] bg-gray-200 relative overflow-hidden">
                @if($destinasi->gambar)
                    <img src="{{ $destinasi->gambar }}" alt="{{ $destinasi->nama_destinasi }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center">
                        <svg class="w-24 h-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                @endif

                @if($destinasi->hidden_gem)
                <span class="absolute top-4 left-4 bg-yellow-400 text-yellow-900 text-sm font-bold px-3 py-1 rounded-full shadow">Hidden Gem 💎</span>
                @endif
            </div>

            <!-- Info Utama -->
            <div class="p-6 md:p-8">
                <div class="flex flex-col md:flex-row md:justify-between md:items-start mb-4">
                    <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 mb-2 md:mb-0">{{ $destinasi->nama_destinasi }}</h1>
                    @if($destinasi->harga == 0)
                        <span class="text-2xl font-bold text-green-600 whitespace-nowrap">Gratis</span>
                    @else
                        <span class="text-2xl font-bold text-sky-600 whitespace-nowrap">Rp {{ number_format($destinasi->harga, 0, ',', '.') }}</span>
                    @endif
                </div>

                <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500 mb-6">
                    <span class="flex items-center gap-1">📍 {{ $destinasi->kota }}</span>
                    <span class="flex items-center gap-1">🏷️ {{ $destinasi->kategori }}</span>
                    <span class="text-gray-400 text-xs">•</span>
                    @if(($destinasi->ratings_count ?? $destinasi->ratings->count()) > 0)
                        <span class="flex items-center gap-1 text-yellow-500 font-semibold">⭐ {{ number_format($destinasi->average_rating, 1) }} / 5.0</span>
                    @endif
                </div>

                <!-- Tombol Aksi -->    
                <div class="flex gap-3">
                    @auth
                        <button type="button" id="btnTambahRencana" class="flex-1 bg-sky-600 text-white font-bold py-3 rounded-xl hover:bg-sky-700 transition flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            Tambah ke Rencana
                        </button>
                    @else
                        <a href="{{ route('login') }}" class="flex-1 bg-sky-600 text-white font-bold py-3 rounded-xl hover:bg-sky-700 transition flex items-center justify-center gap-2 text-center">
                            Login untuk Tambah ke Rencana
                        </a>
                    @endauth

                    <form action="{{ route('bookmarks.toggle') }}" method="POST" class="flex items-center">
                        @csrf
                        <input type="hidden" name="destinasi_id" value="{{ $destinasi->id }}">
                        <button type="submit" class="bg-gray-100 text-gray-600 font-bold py-3 px-6 rounded-xl hover:bg-gray-200 transition flex items-center justify-center gap-2">
                            @if($isBookmarked ?? false)
                                💖 Terbookmark
                            @else
                                🤍 Bookmark
                            @endif
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Deskripsi & Fasilitas -->
<!-- Deskripsi & Fasilitas -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6 items-start">
    <div class="md:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-3">Tentang Tempat Ini</h2>
                <p class="text-gray-600 leading-relaxed whitespace-pre-line">{{ $destinasi->deskripsi }}</p>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-3">Fasilitas</h2>
                <div class="space-y-2 text-sm text-gray-600">
                    @if($destinasi->fasilitas && $destinasi->fasilitas !== 'Tidak tersedia')
                        @foreach(explode(',', $destinasi->fasilitas) as $fasilitas)
                            <div class="flex items-center gap-2 bg-gray-50 p-2 rounded-lg">
                                <span class="text-sky-500">✓</span> {{ trim($fasilitas) }}
                            </div>
                        @endforeach
                    @else
                        <p class="text-gray-400 italic">Tidak ada info fasilitas</p>
                    @endif
                </div>
            </div>
        </div>


        

       <!-- Informasi Destinasi -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
    
    <!-- Header -->
    <div class="px-6 pt-6 pb-4">
        <h2 class="text-lg font-bold text-gray-800">📍 Informasi Destinasi</h2>
    </div>

    <div class="px-6 pb-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">

            <!-- Alamat -->
            <div class="bg-gradient-to-br from-sky-50 to-white rounded-xl p-4 border border-sky-100/50">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-sky-100 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[11px] font-semibold text-sky-500 uppercase tracking-wider mb-0.5">Alamat</p>
                        <p class="text-sm text-gray-700 leading-relaxed">{{ $destinasi->alamat ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Transportasi -->
            <div class="bg-gradient-to-br from-emerald-50 to-white rounded-xl p-4 border border-emerald-100/50">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4-4m-4 4l4 4"></path></svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[11px] font-semibold text-emerald-500 uppercase tracking-wider mb-0.5">Transportasi</p>
                        <div class="text-sm text-gray-700 leading-relaxed">
                            @php
                                $transportasi = $destinasi->transportasi ?? '-';
                                $items = explode(',', $transportasi);
                            @endphp
                            @foreach($items as $i => $item)
                                <span class="inline-flex items-center gap-1 bg-white px-2 py-0.5 rounded-md border border-emerald-100 text-xs font-medium text-gray-600 mr-1 mb-1">
                                    {{ trim($item) }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hari Operasional -->
            <div class="bg-gradient-to-br from-amber-50 to-white rounded-xl p-4 border border-amber-100/50">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[11px] font-semibold text-amber-500 uppercase tracking-wider mb-0.5">Hari Operasional</p>
                        <p class="text-sm text-gray-700 font-medium">{{ $destinasi->hari_operasional ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Jam Operasional -->
            <div class="bg-gradient-to-br from-violet-50 to-white rounded-xl p-4 border border-violet-100/50">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-violet-100 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg class="w-5 h-5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[11px] font-semibold text-violet-500 uppercase tracking-wider mb-0.5">Jam Operasional</p>
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-bold text-gray-800">{{ $destinasi->jam_buka ?? '--:--' }}</span>
                            <span class="text-xs text-gray-300">—</span>
                            <span class="text-sm font-bold text-gray-800">{{ $destinasi->jam_tutup ?? '--:--' }}</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

        <!-- Section Rating & Komentar -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-6">Ulasan Pengunjung</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                <div class="bg-amber-50 border border-amber-100 p-5 rounded-xl text-center">
                    @if(($destinasi->ratings_count ?? $destinasi->ratings->count()) > 0)
                        <p class="text-5xl font-extrabold text-amber-600 mb-1">{{ number_format($destinasi->average_rating, 1) }}</p>
                    @else
                        <p class="text-5xl font-extrabold text-amber-600 mb-1">-</p>
                    @endif
                    <div class="flex justify-center text-yellow-400 text-xl mb-2">⭐⭐⭐⭐⭐</div>
                    <p class="text-sm font-bold text-amber-800 uppercase tracking-wider">Rating Resmi</p>
                    <p class="text-xs text-amber-600 mt-1">Berdasarkan Data TripMate</p>
                </div>
                <div class="bg-sky-50 border border-sky-100 p-5 rounded-xl text-center">
                    @if($destinasi->ratings->count() > 0)
                        <p class="text-5xl font-extrabold text-sky-600 mb-1">{{ number_format($destinasi->average_rating, 1) }}</p>
                        <div class="flex justify-center text-yellow-400 text-xl mb-2">⭐⭐⭐⭐⭐</div>
                        <p class="text-sm font-bold text-sky-800 uppercase tracking-wider">Ulasan Pengunjung</p>
                        <p class="text-xs text-sky-600 mt-1">Berdasarkan {{ $destinasi->ratings->count() }} ulasan</p>
                    @else
                        <p class="text-lg font-bold text-sky-800">Belum Ada Ulasan</p>
                        <p class="text-sm text-sky-600 mt-2">Jadilah yang pertama memberikan ulasan</p>
                    @endif
                </div>
            </div>

            @auth
                @if(session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-700 p-3 rounded-xl mb-4 text-sm font-medium">✅ {{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="bg-amber-50 border border-amber-200 text-amber-700 p-3 rounded-xl mb-4 text-sm font-medium">⚠️ {{ session('error') }}</div>
                @endif

                <form action="{{ route('destinasi.rate', $destinasi->id) }}" method="POST" class="mb-8 bg-gray-50 p-5 rounded-xl border border-gray-100">
                    @csrf
                    <h3 class="font-semibold text-gray-800 mb-3 text-sm">Beri Ulasanmu</h3>
                    <div class="flex flex-col md:flex-row gap-4 mb-3">
                        <div class="flex-1">
                            <label class="block text-xs font-bold text-gray-500 mb-1">Rating (1-5)</label>
                            <select name="skor_rating" class="w-full px-4 py-2 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 bg-white" required>
                                <option value="5">⭐⭐⭐⭐⭐ (5 - Sangat Bagus)</option>
                                <option value="4">⭐⭐⭐⭐ (4 - Bagus)</option>
                                <option value="3">⭐⭐⭐ (3 - Cukup)</option>
                                <option value="2">⭐⭐ (2 - Kurang)</option>
                                <option value="1">⭐ (1 - Buruk)</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="block text-xs font-bold text-gray-500 mb-1">Komentar (Opsional)</label>
                        <textarea name="komentar" rows="3" placeholder="Bagikan pengalamanmu..." class="w-full px-4 py-2 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 bg-white"></textarea>
                    </div>
                    <button type="submit" class="bg-sky-600 text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-sky-700 transition">Kirim Ulasan</button>
                </form>
            @else
                <div class="bg-gray-50 p-4 rounded-xl text-sm text-gray-500 mb-8 border border-gray-100">
                    Silakan <a href="{{ route('login') }}" class="text-sky-600 font-medium hover:underline">Login</a> untuk memberikan ulasan.
                </div>
            @endauth

            <div class="space-y-5 max-h-[500px] overflow-y-auto pr-2">
                @forelse($destinasi->ratings->sortByDesc('created_at') as $rating)
                    <div class="border-b border-gray-100 pb-5 last:border-0">
                        <div class="flex justify-between items-start mb-2">
                            <div class="flex items-center gap-3">
                                @if($rating->user->avatar)
    <img src="{{ asset('storage/' . $rating->user->avatar) }}" alt="{{ $rating->user->name }}" class="w-10 h-10 rounded-full object-cover border-2 border-sky-100 shadow-sm">
@else
    <div class="w-10 h-10 bg-sky-100 text-sky-600 rounded-full flex items-center justify-center text-sm font-bold shadow-sm">
        {{ strtoupper(substr($rating->user->name, 0, 1)) }}
    </div>
@endif


                                <div>
                                    <span class="font-bold text-gray-800 text-sm block">{{ $rating->user->name }}</span>
                                    <span class="text-gray-400 text-xs">{{ $rating->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                            <span class="bg-amber-50 text-amber-700 text-xs font-bold px-3 py-1 rounded-full border border-amber-100">⭐ {{ $rating->skor_rating }}</span>
                        </div>
                        <p class="text-gray-600 text-sm ml-[52px] leading-relaxed">
                            @if($rating->komentar)
                                {{ $rating->komentar }}
                            @else
                                <span class="italic text-gray-400">Tidak ada komentar</span>
                            @endif
                        </p>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <p class="text-gray-400 text-sm font-medium">Belum ada ulasan. Jadilah yang pertama!</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- DESTINASI SERUPA -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mt-6">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Destinasi Serupa</h2>
                    <p class="text-sm text-gray-500">Rekomendasi tempat yang mirip dengan destinasi ini</p>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-5">
                @forelse($similarDestinations ?? [] as $item)
                    <a href="{{ route('destinasi.show', $item->id) }}" class="group bg-white border border-gray-100 rounded-2xl overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <img src="{{ $item->gambar }}" alt="{{ $item->nama_destinasi }}" class="w-full h-40 object-cover group-hover:scale-105 transition duration-300">
                        <div class="p-4">
                            <h3 class="font-bold text-gray-800 line-clamp-2">{{ $item->nama_destinasi }}</h3>
                            <p class="text-sm text-gray-500 mt-1">📍 {{ $item->kota }}</p>
                            <div class="flex justify-between items-center mt-3">
                                <span class="text-yellow-500 font-semibold">⭐ {{ number_format($item->average_rating, 1) }}</span>
                            </div>
                            @if($item->harga == 0)
                                <span class="text-green-600 font-bold text-sm">Gratis</span>
                            @else
                                <span class="text-sky-600 font-bold text-sm">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                            @endif
                        </div>
                    </a>
                @empty
                    <div class="col-span-full text-center py-10">
                        <div class="text-5xl mb-3">🧭</div>
                        <p class="text-gray-500">Destinasi serupa belum tersedia</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- GALERI DESTINASI -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mt-6">
            <h2 class="text-xl font-bold text-gray-800 mb-5">Galeri Destinasi</h2>
            @if($destinasi->gambar)
                <div class="overflow-hidden rounded-2xl">
                    <img src="{{ $destinasi->gambar }}" alt="{{ $destinasi->nama_destinasi }}" class="w-full h-[450px] object-cover hover:scale-105 transition duration-500">
                </div>
            @else
                <div class="h-64 flex items-center justify-center bg-gray-100 rounded-2xl">
                    <span class="text-gray-400">Belum ada galeri</span>
                </div>
            @endif
        </div>

    </div>

    <!-- ============================================ -->
    <!-- MODAL: TAMBAH KE RENCANA                    -->
    <!-- ============================================ -->
    <div id="modalTambahRencana" style="display:none; position:fixed; inset:0; z-index:9999;">
        <div onclick="closeModal()" style="position:absolute; inset:0; background:rgba(0,0,0,0.5); backdrop-filter:blur(4px);"></div>
        <div style="position:relative; display:flex; align-items:center; justify-content:center; min-height:100vh; padding:1rem;">
            <div style="background:white; border-radius:1rem; box-shadow:0 25px 50px -12px rgba(0,0,0,0.25); width:100%; max-width:28rem; max-height:85vh; overflow:hidden; display:flex; flex-direction:column;">
                
                <!-- Header -->
                <div style="background:#0284c7; padding:1rem 1.5rem; display:flex; align-items:center; justify-content:space-between; flex-shrink:0;">
                    <div style="display:flex; align-items:center; gap:0.75rem;">
                        <div style="width:3rem; height:3rem; border-radius:0.5rem; overflow:hidden; border:2px solid rgba(255,255,255,0.3); flex-shrink:0;">
                            @if($destinasi->gambar)
                                <img src="{{ $destinasi->gambar }}" style="width:100%; height:100%; object-fit:cover;" alt="">
                            @else
                                <div style="width:100%; height:100%; background:#38bdf8; display:flex; align-items:center; justify-content:center; font-size:1.25rem;">📍</div>
                            @endif
                        </div>
                        <div style="min-width:0;">
                            <h3 style="color:white; font-weight:700; font-size:0.875rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $destinasi->nama_destinasi }}</h3>
                            <p style="color:#bae6fd; font-size:0.75rem;">📍 {{ $destinasi->kota }} · {{ $destinasi->kategori }}</p>
                        </div>
                    </div>
                    <button onclick="closeModal()" style="color:rgba(255,255,255,0.7); background:none; border:none; cursor:pointer; padding:0.25rem;">
                        <svg style="width:1.5rem; height:1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Body -->
                <div style="flex:1; overflow-y:auto; padding:1.5rem;">
                    @auth
                        @php $userPlans = Auth::user()->travelPlans()->latest()->get(); @endphp

                        @if($userPlans->count() > 0)
                            <p style="font-size:0.875rem; font-weight:700; color:#374151; margin-bottom:0.75rem;">Pilih Rencana Perjalanan</p>
                            <div style="display:flex; flex-direction:column; gap:0.5rem; margin-bottom:1.5rem;">
                                @foreach($userPlans as $plan)
                                    <form action="{{ route('travel-plans.addDestinasi', $plan->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="destinasi_id" value="{{ $destinasi->id }}">
                                        <button type="submit" style="width:100%; text-align:left; display:flex; align-items:center; gap:1rem; padding:1rem; border-radius:0.75rem; border:2px solid #f3f4f6; background:white; cursor:pointer; transition:all 0.2s;" onmouseover="this.style.borderColor='#38bdf8'; this.style.background='#f0f9ff';" onmouseout="this.style.borderColor='#f3f4f6'; this.style.background='white';">
                                            <div style="width:3.5rem; height:3.5rem; border-radius:0.5rem; overflow:hidden; flex-shrink:0;">
                                                @if($plan->foto_sampul)
                                                    <img src="{{ Storage::url($plan->foto_sampul) }}" style="width:100%; height:100%; object-fit:cover;" alt="">
                                                @else
                                                    <div style="width:100%; height:100%; background:#e0f2fe; display:flex; align-items:center; justify-content:center; font-size:1.125rem;">🗺️</div>
                                                @endif
                                            </div>
                                            <div style="flex:1; min-width:0;">
                                                <p style="font-weight:700; color:#111827; font-size:0.875rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; margin:0;">{{ $plan->nama_perjalanan }}</p>
                                                <p style="font-size:0.75rem; color:#9ca3af; margin:0.25rem 0 0 0;">
                                                    📍 {{ $plan->tujuan ?? '-' }}
                                                    @if($plan->tanggal_mulai)
                                                        · {{ $plan->tanggal_mulai->format('d M Y') }}
                                                    @endif
                                                </p>
                                            </div>
                                            <svg style="width:1.25rem; height:1.25rem; color:#d1d5db; flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        </button>
                                    </form>
                                @endforeach
                            </div>

                            <!-- Divider -->
                            <div style="display:flex; align-items:center; gap:0.75rem; margin-bottom:1.5rem;">
                                <div style="flex:1; height:1px; background:#e5e7eb;"></div>
                                <span style="font-size:0.75rem; color:#9ca3af; font-weight:600;">ATAU BUAT BARU</span>
                                <div style="flex:1; height:1px; background:#e5e7eb;"></div>
                            </div>
                        @endif

                        <!-- Form Buat Baru -->
                        <div style="background:#f9fafb; border-radius:0.75rem; padding:1.25rem; border:1px solid #f3f4f6;">
                            <p style="font-size:0.875rem; font-weight:700; color:#374151; margin-bottom:0.75rem;">✨ Buat Rencana Baru</p>
                            <form action="{{ route('travel-plans.quick-add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="destinasi_id" value="{{ $destinasi->id }}">
                                <div style="display:flex; flex-direction:column; gap:0.75rem;">
                                    <div>
                                        <label style="display:block; font-size:0.75rem; font-weight:600; color:#6b7280; margin-bottom:0.25rem;">Nama Perjalanan *</label>
                                        <input type="text" name="nama_perjalanan" value="Trip ke {{ $destinasi->kota }}" required style="width:100%; padding:0.625rem 1rem; border-radius:0.75rem; border:1px solid #e5e7eb; font-size:0.875rem; outline:none; box-sizing:border-box;">
                                    </div>
                                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:0.75rem;">
                                        <div>
                                            <label style="display:block; font-size:0.75rem; font-weight:600; color:#6b7280; margin-bottom:0.25rem;">Tanggal Mulai</label>
                                            <input type="date" name="tanggal_mulai" style="width:100%; padding:0.625rem 0.75rem; border-radius:0.75rem; border:1px solid #e5e7eb; font-size:0.875rem; outline:none; box-sizing:border-box;">
                                        </div>
                                        <div>
                                            <label style="display:block; font-size:0.75rem; font-weight:600; color:#6b7280; margin-bottom:0.25rem;">Tanggal Selesai</label>
                                            <input type="date" name="tanggal_selesai" style="width:100%; padding:0.625rem 0.75rem; border-radius:0.75rem; border:1px solid #e5e7eb; font-size:0.875rem; outline:none; box-sizing:border-box;">
                                        </div>
                                    </div>
                                    <div>
                                        <label style="display:block; font-size:0.75rem; font-weight:600; color:#6b7280; margin-bottom:0.25rem;">Budget (Rp)</label>
                                        <input type="number" name="budget" placeholder="5000000" style="width:100%; padding:0.625rem 1rem; border-radius:0.75rem; border:1px solid #e5e7eb; font-size:0.875rem; outline:none; box-sizing:border-box;">
                                    </div>
                                </div>
                                <button type="submit" style="width:100%; margin-top:1rem; background:#0284c7; color:white; font-weight:700; padding:0.75rem; border-radius:0.75rem; border:none; cursor:pointer; font-size:0.875rem; display:flex; align-items:center; justify-content:center; gap:0.5rem;">
                                    <svg style="width:1rem; height:1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                    Buat & Tambahkan Destinasi
                                </button>
                            </form>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPT -->
    <script>
        document.getElementById('btnTambahRencana').addEventListener('click', function() {
            document.getElementById('modalTambahRencana').style.display = 'block';
            document.body.style.overflow = 'hidden';
        });

        function closeModal() {
            document.getElementById('modalTambahRencana').style.display = 'none';
            document.body.style.overflow = '';
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeModal();
        });
    </script>

</body>
</html>