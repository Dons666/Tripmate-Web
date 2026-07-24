<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('penyedia-travel.index') }}" class="w-10 h-10 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-600 flex items-center justify-center transition">
                &larr;
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Paket Perjalanan
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-200">
                <!-- Cover Image -->
                <div class="w-full h-72 sm:h-96 bg-slate-900 relative">
                    @if($travel->gambar)
                        <img src="{{ str_starts_with($travel->gambar, 'http') ? $travel->gambar : asset('storage/' . $travel->gambar) }}" alt="{{ $travel->nama_travel }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-slate-900 via-sky-950 to-slate-900 flex flex-col items-center justify-center text-slate-400 gap-2">
                            <span class="text-6xl">🎒</span>
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent"></div>
                    
                    <div class="absolute bottom-6 left-6 right-6">
                        <span class="px-3 py-1 bg-sky-500/90 backdrop-blur-sm text-white rounded-full text-xs font-black uppercase tracking-wider mb-3 inline-block">
                            📍 {{ $travel->kota ?? 'Destinasi' }}
                        </span>
                        <h1 class="text-3xl sm:text-5xl font-black text-white leading-tight">
                            {{ $travel->nama_travel }}
                        </h1>
                        <p class="text-sky-200 text-sm mt-2 font-medium flex items-center gap-2">
                            By {{ $travel->user->name ?? 'Mitra TripMate' }}
                            @if($travel->rating)
                                <span class="text-amber-400">★ {{ number_format($travel->rating, 1) }}</span>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 p-6 sm:p-8">
                    <!-- Left: Description & Details -->
                    <div class="md:col-span-2 space-y-8">
                        <div>
                            <h3 class="text-lg font-extrabold text-slate-900 mb-3 border-b border-slate-100 pb-2">Deskripsi Paket</h3>
                            <p class="text-slate-600 text-sm leading-relaxed whitespace-pre-line">{{ $travel->deskripsi }}</p>
                        </div>

                        <div>
                            <h3 class="text-lg font-extrabold text-slate-900 mb-3 border-b border-slate-100 pb-2">Layanan & Fasilitas</h3>
                            <div class="flex items-start gap-3 bg-slate-50 p-4 rounded-2xl border border-slate-100">
                                <span class="text-2xl">🚐</span>
                                <p class="text-slate-700 text-sm font-semibold mt-1">{{ $travel->layanan }}</p>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-extrabold text-slate-900 mb-3 border-b border-slate-100 pb-2">Rute Wisata & Aktivitas</h3>
                            
                            @php
                                $wisatas = $travel->destinasis->where('tipe', 'wisata')->values();
                                $kuliners = $travel->destinasis->where('tipe', 'kuliner')->values();
                                $penginapans = $travel->destinasis->where('tipe', 'penginapan')->values();
                                $stepCount = 1;
                            @endphp

                            @if($travel->destinasis->count() == 0)
                                <p class="text-sm text-slate-500 italic ml-6">Belum ada rute destinasi yang ditentukan.</p>
                            @else
                                <div class="space-y-8">
                                    @foreach([
                                        ['title' => '🏞️ Destinasi Wisata', 'color' => 'text-sky-700', 'items' => $wisatas],
                                        ['title' => '🍽️ Destinasi Kuliner', 'color' => 'text-amber-600', 'items' => $kuliners],
                                        ['title' => '🏨 Penginapan (Hotel/Villa)', 'color' => 'text-indigo-600', 'items' => $penginapans]
                                    ] as $group)
                                        @if($group['items']->count() > 0)
                                            <div>
                                                <h4 class="font-bold {{ $group['color'] }} text-sm mb-3 uppercase tracking-widest">{{ $group['title'] }}</h4>
                                                <div class="space-y-3 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-slate-200 before:to-transparent">
                                                    @foreach($group['items'] as $destinasi)
                                                        <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                                                            <!-- Icon -->
                                                            <div class="flex items-center justify-center w-10 h-10 rounded-full border border-white bg-slate-100 text-slate-500 shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 z-10">
                                                                <span class="text-sm font-bold">{{ $stepCount++ }}</span>
                                                            </div>
                                                            <!-- Card -->
                                                            <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-4 rounded-2xl border border-slate-200 bg-white shadow-sm flex items-center gap-3 hover:border-sky-300 transition">
                                                                @if($destinasi->gambar)
                                                                    <img src="{{ str_starts_with($destinasi->gambar, 'http') ? $destinasi->gambar : asset('storage/' . $destinasi->gambar) }}" class="w-12 h-12 rounded-xl object-cover">
                                                                @else
                                                                    <div class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center text-xl">📍</div>
                                                                @endif
                                                                <div>
                                                                    <h4 class="font-bold text-slate-800 text-sm">{{ $destinasi->nama_destinasi }}</h4>
                                                                    <p class="text-xs text-slate-500 truncate w-32 md:w-48">{{ $destinasi->kategori_wisata ?? 'Destinasi Wisata' }}</p>
                                                                </div>
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
                    </div>

                    <!-- Right: Booking Card -->
                    <div class="md:col-span-1">
                        <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-xl sticky top-24">
                            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">Harga Paket</p>
                            <h2 class="text-3xl font-black text-sky-600 mb-6">
                                Rp {{ number_format($travel->harga_paket, 0, ',', '.') }}
                            </h2>

                            <form action="{{ route('travel.packages.book', $travel->id) }}" method="POST" id="bookingForm" class="space-y-4">
                                @csrf
                                
                                <div class="bg-sky-50 border border-sky-100 rounded-xl p-3 mb-2">
                                    <label class="block text-xs font-bold text-sky-800 mb-0.5">Tanggal Keberangkatan</label>
                                    <div class="text-sm font-black text-sky-900">
                                        {{ $travel->tanggal_keberangkatan ? $travel->tanggal_keberangkatan->format('d F Y') : 'Belum Ditentukan' }}
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Jumlah Peserta / Kursi</label>
                                    <input type="number" name="jumlah_peserta" id="jumlah_peserta" required min="1" value="1" class="w-full rounded-xl border-slate-300 focus:border-sky-500 text-sm">
                                </div>

                                <div id="availability-check" class="text-sm font-semibold p-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-600 hidden">
                                    Mengecek ketersediaan kursi...
                                </div>

                                <button type="submit" id="btnSubmit" class="w-full py-4 bg-sky-600 hover:bg-sky-700 text-white rounded-2xl font-extrabold text-lg shadow-lg shadow-sky-500/30 transition transform hover:-translate-y-1">
                                    Pesan Sekarang
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
                                    alertBox.className = 'text-sm font-semibold p-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-600';
                                    btnSubmit.disabled = true;
                                    btnSubmit.classList.add('opacity-50', 'cursor-not-allowed');

                                    try {
                                        const response = await fetch(`/api/travel/{{ $travel->id }}/availability`);
                                        const data = await response.json();

                                        if (data.available_seats >= peserta) {
                                            alertBox.innerHTML = `✅ Tersedia ${data.available_seats} kursi. (Armada: ${data.armada_name})`;
                                            alertBox.className = 'text-sm font-semibold p-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700';
                                            btnSubmit.disabled = false;
                                            btnSubmit.classList.remove('opacity-50', 'cursor-not-allowed');
                                        } else if (data.available_seats > 0) {
                                            alertBox.innerHTML = `⚠️ Sisa kursi hanya ${data.available_seats}. Kurangi jumlah peserta.`;
                                            alertBox.className = 'text-sm font-semibold p-3 rounded-xl bg-rose-50 border border-rose-200 text-rose-700';
                                        } else {
                                            alertBox.innerHTML = `❌ Kursi habis / Armada Penuh untuk tanggal ini.`;
                                            alertBox.className = 'text-sm font-semibold p-3 rounded-xl bg-rose-50 border border-rose-200 text-rose-700';
                                        }
                                    } catch (err) {
                                        alertBox.innerHTML = 'Gagal mengecek ketersediaan.';
                                    }
                                }
                            </script>

                            <div class="mt-6 pt-6 border-t border-slate-100 text-center">
                                <p class="text-[10px] text-slate-400 font-medium mb-3">Butuh bantuan atau mau tanya-tanya?</p>
                                
                                @php
                                    $cleanPhone = preg_replace('/[^0-9]/', '', $travel->kontak);
                                    if (str_starts_with($cleanPhone, '0')) {
                                        $cleanPhone = '62' . substr($cleanPhone, 1);
                                    }
                                    $waMessage = rawurlencode("Halo {$travel->nama_travel}, saya tertarik dengan paket ini.");
                                @endphp
                                
                                <a href="https://wa.me/{{ $cleanPhone }}?text={{ $waMessage }}" target="_blank" class="w-full py-2.5 bg-emerald-50 text-emerald-600 hover:bg-emerald-100 border border-emerald-200 rounded-xl text-xs font-bold transition flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                                    Tanya Via WhatsApp
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
