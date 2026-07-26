<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('penyedia-travel.index') }}" class="w-10 h-10 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-600 flex items-center justify-center transition shadow-sm border border-slate-200">
                    &larr;
                </a>
                <div>
                    <h2 class="font-extrabold text-xl text-slate-800 leading-tight">
                        Detail Paket Perjalanan
                    </h2>
                    <p class="text-xs text-slate-500 font-medium">Informasi publik & katalog resmi paket wisata</p>
                </div>
            </div>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-full text-xs font-bold shadow-sm">
                <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                Mitra Terverifikasi Escrow
            </span>
        </div>
    </x-slot>

    <div class="py-10 bg-slate-50/60 min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <div class="bg-white rounded-3xl overflow-hidden shadow-xl border border-slate-200/80">
                <!-- Cover Image & Header Hero -->
                <div class="w-full h-80 sm:h-[420px] bg-slate-900 relative">
                    @if($travel->gambar)
                        <img src="{{ str_starts_with($travel->gambar, 'http') ? $travel->gambar : asset('storage/' . ltrim(str_replace(['public/', 'storage/'], '', $travel->gambar), '/')) }}" alt="{{ $travel->nama_travel }}" class="w-full h-full object-cover" onerror="this.style.display='none'; if(this.nextElementSibling) this.nextElementSibling.style.display='flex';">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-slate-900 via-sky-950 to-slate-900 flex flex-col items-center justify-center text-slate-400 gap-2">
                            <span class="text-6xl">🎒</span>
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-500">TripMate Package</span>
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-transparent"></div>
                    
                    <div class="absolute bottom-6 left-6 right-6 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
                        <div class="space-y-2">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="px-3 py-1 bg-sky-500/90 backdrop-blur-md text-white rounded-full text-xs font-black uppercase tracking-wider shadow border border-sky-400/30">
                                    📍 {{ $travel->kota ?? 'Destinasi Wisata' }}
                                </span>
                                <span class="px-3 py-1 bg-emerald-500/90 backdrop-blur-md text-white rounded-full text-xs font-extrabold shadow border border-emerald-400/30 flex items-center gap-1">
                                    🛡️ Garansi Escrow TripMate
                                </span>
                            </div>
                            <h1 class="text-3xl sm:text-5xl font-black text-white leading-tight tracking-tight">
                                {{ $travel->nama_travel }}
                            </h1>
                            <p class="text-sky-200 text-sm font-semibold flex items-center gap-3">
                                <span>Oleh {{ $travel->user->name ?? 'Mitra Penyedia Travel' }}</span>
                                @if($travel->rating)
                                    <span class="px-2 py-0.5 bg-amber-400/20 text-amber-300 rounded-lg text-xs font-bold border border-amber-400/30">★ {{ number_format($travel->rating, 1) }}</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Main Content Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 p-6 sm:p-10">
                    
                    <!-- Left Column: Information & Details -->
                    <div class="lg:col-span-2 space-y-8">
                        
                        <!-- Deskripsi Paket -->
                        <div>
                            <h3 class="text-lg font-extrabold text-slate-900 mb-3 flex items-center gap-2 border-b border-slate-100 pb-2">
                                <span>📝</span> Deskripsi Paket Wisata
                            </h3>
                            <p class="text-slate-600 text-sm leading-relaxed whitespace-pre-line font-normal">{{ $travel->deskripsi }}</p>
                        </div>

                        <!-- Layanan & Spesifikasi Armada (Tanpa Data Sensitif Plat Nomor) -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200/80 space-y-2">
                                <span class="text-xs font-bold text-sky-800 uppercase tracking-wider block">Layanan & Inklusi</span>
                                <div class="flex items-start gap-3">
                                    <span class="text-2xl">✨</span>
                                    <p class="text-slate-700 text-xs font-bold mt-1 leading-relaxed">{{ $travel->layanan }}</p>
                                </div>
                            </div>

                            <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200/80 space-y-2">
                                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Spesifikasi Armada</span>
                                <div class="flex items-start gap-3">
                                    <span class="text-2xl">🚐</span>
                                    <div>
                                        <p class="text-slate-800 text-xs font-extrabold">
                                            {{ $travel->armada->nama_kendaraan ?? 'Kendaraan Standard Travel' }}
                                        </p>
                                        <p class="text-slate-500 text-[11px] font-medium mt-0.5">
                                            Kapasitas Total: {{ $travel->armada->kapasitas_kursi ?? 'Multi-Seat' }} Kursi
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Rute Wisata & Aktivitas -->
                        <div>
                            <h3 class="text-lg font-extrabold text-slate-900 mb-4 flex items-center gap-2 border-b border-slate-100 pb-2">
                                <span>🗺️</span> Rute Destinasi & Kunjungan
                            </h3>
                            
                            @php
                                $wisatas = $travel->destinasis->where('tipe', 'wisata')->values();
                                $kuliners = $travel->destinasis->where('tipe', 'kuliner')->values();
                                $penginapans = $travel->destinasis->where('tipe', 'penginapan')->values();
                            @endphp

                            @if($travel->destinasis->count() == 0)
                                <div class="p-6 bg-slate-50 rounded-2xl border border-dashed border-slate-200 text-center">
                                    <p class="text-xs text-slate-500 italic">Rute destinasi fleksibel & dapat disesuaikan saat keberangkatan.</p>
                                </div>
                            @else
                                <div class="space-y-6">
                                    @foreach([
                                        ['title' => '🏞️ Destinasi Wisata Utama', 'color' => 'text-sky-700', 'items' => $wisatas],
                                        ['title' => '🍽️ Kuliner & Restoran', 'color' => 'text-amber-600', 'items' => $kuliners],
                                        ['title' => '🏨 Penginapan (Hotel / Villa)', 'color' => 'text-indigo-600', 'items' => $penginapans]
                                    ] as $group)
                                        @if($group['items']->count() > 0)
                                            <div>
                                                <h4 class="font-extrabold {{ $group['color'] }} text-xs mb-3 uppercase tracking-widest">{{ $group['title'] }}</h4>
                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                                    @foreach($group['items'] as $destinasi)
                                                        <div class="p-3.5 rounded-2xl border border-slate-200 bg-white shadow-sm flex items-center gap-3 hover:border-sky-300 transition">
                                                            @if($destinasi->gambar)
                                                                <img src="{{ str_starts_with($destinasi->gambar, 'http') ? $destinasi->gambar : asset('storage/' . ltrim(str_replace(['public/', 'storage/'], '', $destinasi->gambar), '/')) }}" class="w-12 h-12 rounded-xl object-cover shrink-0" onerror="this.style.display='none'; if(this.nextElementSibling) this.nextElementSibling.style.display='flex';">
                                                            @else
                                                                <div class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center text-xl shrink-0">📍</div>
                                                            @endif
                                                            <div class="min-w-0">
                                                                <h4 class="font-bold text-slate-800 text-xs truncate">{{ $destinasi->nama_destinasi }}</h4>
                                                                <p class="text-[11px] text-slate-500 truncate">{{ $destinasi->kategori_wisata ?? 'Destinasi Wisata' }}</p>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <!-- Card Proteksi Keamanan & Data Sensitif Internal -->
                        <div class="p-6 bg-gradient-to-r from-sky-900 to-slate-900 text-white rounded-3xl space-y-3 shadow-lg border border-sky-800/40">
                            <div class="flex items-center gap-2 text-amber-400 font-extrabold text-sm">
                                <span>🔒</span> Proteksi Keamanan & Privasi Mitra TripMate
                            </div>
                            <p class="text-xs text-sky-100 leading-relaxed font-medium">
                                Demi keamanan transaksi dan privasi mitra travel, seluruh dokumen legalitas bisnis (KTP Pemilik, SIUP/NIB) serta rekening bank mitra telah **tervalidasi & diverifikasi oleh tim Admin TripMate**.
                            </p>
                            <div class="pt-2 flex items-center gap-4 text-[11px] text-sky-300 font-semibold border-t border-sky-800/60">
                                <span class="flex items-center gap-1">✅ Pembayaran Via System Escrow</span>
                                <span class="flex items-center gap-1">🛡️ Garansi Refund Resmi</span>
                            </div>
                        </div>

                    </div>

                    <!-- Right Column: Interactive Booking Card -->
                    <div class="lg:col-span-1">
                        <div class="bg-white border border-slate-200/90 rounded-3xl p-6 shadow-xl sticky top-24 space-y-6">
                            
                            <div>
                                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">Harga Paket per Peserta</p>
                                <div class="flex items-baseline gap-1">
                                    <h2 class="text-3xl font-black text-sky-600">
                                        Rp {{ number_format($travel->harga_paket, 0, ',', '.') }}
                                    </h2>
                                    <span class="text-xs font-bold text-slate-400">/ orang</span>
                                </div>
                            </div>

                            <form action="{{ route('travel.packages.book', $travel->id) }}" method="POST" id="bookingForm" class="space-y-4">
                                @csrf
                                
                                <div class="bg-sky-50/80 border border-sky-100 rounded-2xl p-4 space-y-1">
                                    <label class="block text-[11px] font-bold text-sky-800 uppercase tracking-wider">Tanggal Keberangkatan</label>
                                    <div class="text-sm font-black text-sky-950 flex items-center gap-2">
                                        <span>📅</span>
                                        <span>{{ $travel->tanggal_keberangkatan ? $travel->tanggal_keberangkatan->format('d F Y') : 'Jadwal Fleksibel' }}</span>
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Jumlah Peserta / Kursi</label>
                                    <input type="number" name="jumlah_peserta" id="jumlah_peserta" required min="1" value="1" class="w-full rounded-2xl border-slate-300 focus:border-sky-500 focus:ring-sky-500 text-sm font-bold">
                                </div>

                                <div id="availability-check" class="text-xs font-semibold p-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-slate-600 hidden">
                                    Mengecek ketersediaan kursi...
                                </div>

                                <button type="submit" id="btnSubmit" class="w-full py-4 bg-sky-600 hover:bg-sky-500 text-white rounded-2xl font-extrabold text-base shadow-lg shadow-sky-500/30 transition transform hover:-translate-y-0.5 active:translate-y-0">
                                    Pesan Sekarang (Escrow)
                                </button>
                            </form>

                            <script>
                                document.addEventListener('DOMContentLoaded', checkAvailability);
                                document.getElementById('jumlah_peserta').addEventListener('input', checkAvailability);

                                async function checkAvailability() {
                                    const peserta = document.getElementById('jumlah_peserta').value;
                                    const alertBox = document.getElementById('availability-check');
                                    const btnSubmit = document.getElementById('btnSubmit');

                                    if (peserta < 1) return;

                                    alertBox.classList.remove('hidden');
                                    alertBox.innerHTML = 'Mengecek ketersediaan kursi...';
                                    alertBox.className = 'text-xs font-semibold p-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-slate-600';
                                    btnSubmit.disabled = true;
                                    btnSubmit.classList.add('opacity-50', 'cursor-not-allowed');

                                    try {
                                        const response = await fetch(`/api/travel/{{ $travel->id }}/availability`);
                                        const data = await response.json();

                                        if (data.available_seats >= peserta) {
                                            alertBox.innerHTML = `✅ Tersedia ${data.available_seats} kursi. (Armada: ${data.armada_name})`;
                                            alertBox.className = 'text-xs font-semibold p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700';
                                            btnSubmit.disabled = false;
                                            btnSubmit.classList.remove('opacity-50', 'cursor-not-allowed');
                                        } else if (data.available_seats > 0) {
                                            alertBox.innerHTML = `⚠️ Sisa kursi hanya ${data.available_seats}. Kurangi jumlah peserta.`;
                                            alertBox.className = 'text-xs font-semibold p-3.5 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700';
                                        } else {
                                            alertBox.innerHTML = `❌ Kursi habis / Armada Penuh untuk tanggal ini.`;
                                            alertBox.className = 'text-xs font-semibold p-3.5 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700';
                                        }
                                    } catch (err) {
                                        alertBox.innerHTML = 'Gagal mengecek ketersediaan.';
                                    }
                                }
                            </script>

                            <div class="pt-4 border-t border-slate-100 text-center space-y-3">
                                <p class="text-[11px] text-slate-400 font-medium">Butuh bantuan seputar pemesanan paket ini?</p>
                                
                                @php
                                    $cleanPhone = preg_replace('/[^0-9]/', '', $travel->kontak);
                                    if (str_starts_with($cleanPhone, '0')) {
                                        $cleanPhone = '62' . substr($cleanPhone, 1);
                                    }
                                    $waMessage = rawurlencode("Halo {$travel->nama_travel}, saya mau tanya seputar paket wisata ini.");
                                @endphp
                                
                                <a href="https://wa.me/{{ $cleanPhone }}?text={{ $waMessage }}" target="_blank" class="w-full py-3 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200 rounded-2xl text-xs font-bold transition flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                                    Tanya CS via WhatsApp
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
