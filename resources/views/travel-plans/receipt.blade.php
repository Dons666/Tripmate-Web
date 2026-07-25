<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🧾 Struk & Ringkasan Perjalanan
        </h2>
    </x-slot>

    <!-- CSS PRINT STYLES -->
    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            #printableReceipt, #printableReceipt * {
                visibility: visible;
            }
            #printableReceipt {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                box-shadow: none !important;
                border: none !important;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>

    <div class="py-10 bg-slate-100 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- ACTION BUTTONS TOP -->
            <div class="flex items-center justify-between no-print">
                <a href="{{ route('travel-plans.show', $travelPlan) }}" class="text-sm font-semibold text-slate-600 hover:text-sky-600 flex items-center gap-1">
                    ← Kembali ke Detail Rencana
                </a>

                <div class="flex items-center gap-3">
                    <button onclick="window.print()" class="px-5 py-2.5 bg-sky-600 hover:bg-sky-700 text-white text-xs font-bold rounded-xl shadow-md transition flex items-center gap-2">
                        🖨️ Cetak / Download Struk (PDF)
                    </button>
                </div>
            </div>

            <!-- RECEIPT CARD -->
            <div id="printableReceipt" class="bg-white rounded-3xl border border-slate-200 p-8 sm:p-12 shadow-xl relative overflow-hidden space-y-8">
                <!-- RECEIPT HEADER -->
                <div class="border-b-2 border-dashed border-slate-200 pb-8 flex flex-wrap justify-between items-start gap-4">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="text-3xl font-black tracking-tight text-sky-600">TripMate</span>
                            <span class="text-xs uppercase font-bold tracking-widest bg-sky-100 text-sky-800 px-2.5 py-1 rounded-md">Official Receipt</span>
                        </div>
                        <p class="text-xs text-slate-400 mt-1">Sistem Perencanaan & Optimasi Perjalanan Terpadu</p>
                    </div>

                    <div class="text-right">
                        <p class="text-xs uppercase tracking-wider text-slate-400 font-bold">Kode Struk</p>
                        <p class="font-mono font-bold text-slate-800 text-sm">TRIP-{{ str_pad($travelPlan->id, 6, '0', STR_PAD_LEFT) }}</p>
                        <p class="text-xs text-slate-400 mt-0.5">Tanggal: {{ now()->format('d M Y, H:i') }} WIB</p>
                    </div>
                </div>

                <!-- PLAN INFO -->
                <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100 grid grid-cols-1 sm:grid-cols-4 gap-6">
                    <div>
                        <p class="text-xs text-slate-400 font-medium">Nama Perjalanan</p>
                        <p class="font-extrabold text-slate-800 text-base mt-0.5">{{ $travelPlan->nama_perjalanan }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-medium">Tujuan Utama</p>
                        <p class="font-bold text-slate-800 text-sm mt-0.5">📍 {{ $travelPlan->tujuan ?? 'Indonesia' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-medium">Periode Perjalanan</p>
                        <p class="font-bold text-slate-800 text-sm mt-0.5">
                            {{ $travelPlan->tanggal_mulai ? $travelPlan->tanggal_mulai->format('d M Y') : '-' }} — {{ $travelPlan->tanggal_selesai ? $travelPlan->tanggal_selesai->format('d M Y') : '-' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-medium">Jenis Perjalanan</p>
                        @if($travelPlan->travel)
                            <p class="font-extrabold text-sky-700 text-sm mt-0.5">🚌 {{ $travelPlan->travel->nama_travel }}</p>
                            <p class="text-[10px] text-sky-600 font-bold mt-1">Pemesanan untuk: {{ $travelPlan->jumlah_peserta }} Peserta (Kursi)</p>
                        @else
                            <p class="font-bold text-slate-600 text-sm mt-0.5">🚶 Perencanaan Mandiri</p>
                        @endif
                    </div>
                </div>

                <!-- FINANCIAL HIGHLIGHTS -->
                <div>
                    <h4 class="text-xs uppercase font-extrabold tracking-wider text-slate-400 mb-3">Ringkasan Keuangan</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="p-5 rounded-2xl bg-sky-50/80 border border-sky-100">
                            <p class="text-xs font-semibold text-sky-700">Total Anggaran (Budget)</p>
                            <p class="text-2xl font-black text-sky-700 mt-1">Rp {{ number_format($travelPlan->budget, 0, ',', '.') }}</p>
                        </div>
                        <div class="p-5 rounded-2xl bg-rose-50/80 border border-rose-100">
                            <p class="text-xs font-semibold text-rose-700">Total Realisasi Pengeluaran</p>
                            <p class="text-2xl font-black text-rose-700 mt-1">Rp {{ number_format($travelPlan->total_expenses, 0, ',', '.') }}</p>
                        </div>
                        @php $sisaBudget = $travelPlan->budget - $travelPlan->total_expenses; @endphp
                        <div class="p-5 rounded-2xl {{ $sisaBudget >= 0 ? 'bg-emerald-50/80 border-emerald-100 text-emerald-800' : 'bg-amber-50/80 border-amber-100 text-amber-800' }}">
                            <p class="text-xs font-semibold">{{ $sisaBudget >= 0 ? 'Sisa Budget (Efisiensi)' : 'Over Budget (Selisih)' }}</p>
                            <p class="text-2xl font-black mt-1">Rp {{ number_format(abs($sisaBudget), 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <!-- DESTINATIONS VISITED -->
                <div>
                    <h4 class="text-xs uppercase font-extrabold tracking-wider text-slate-400 mb-3">Daftar Destinasi Terdaftar</h4>
                    @if($travelPlan->destinasis && $travelPlan->destinasis->count() > 0)
                        <div class="border border-slate-200 rounded-2xl overflow-hidden">
                            <table class="w-full text-left text-xs sm:text-sm">
                                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase font-semibold">
                                    <tr>
                                        <th class="py-3 px-4">#</th>
                                        <th class="py-3 px-4">Nama Destinasi</th>
                                        <th class="py-3 px-4">Kota</th>
                                        <th class="py-3 px-4">Kategori</th>
                                        <th class="py-3 px-4 text-right">Harga Tiket</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach($travelPlan->destinasis as $idx => $d)
                                        <tr>
                                            <td class="py-3 px-4 font-bold text-slate-400">{{ $idx + 1 }}</td>
                                            <td class="py-3 px-4 font-bold text-slate-800">{{ $d->nama_destinasi }}</td>
                                            <td class="py-3 px-4 text-slate-600">{{ $d->kota }}</td>
                                            <td class="py-3 px-4 text-slate-600">{{ $d->kategori }}</td>
                                            <td class="py-3 px-4 text-right font-semibold text-slate-800">
                                                {{ $d->harga == 0 ? 'Gratis' : 'Rp ' . number_format($d->harga, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-slate-400 text-xs italic">Tidak ada destinasi terdaftar.</p>
                    @endif
                </div>

                <!-- EXPENSES BREAKDOWN CATEGORY -->
                <div>
                    <h4 class="text-xs uppercase font-extrabold tracking-wider text-slate-400 mb-3">Rincian Pengeluaran Berdasarkan Kategori</h4>
                    @if($travelPlan->expenses && $travelPlan->expenses->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @foreach($expensesByCategory as $category => $items)
                                @php $catTotal = $items->sum('jumlah'); @endphp
                                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/70 flex justify-between items-center">
                                    <div>
                                        <p class="font-bold text-slate-800 text-sm">🏷️ {{ $category }}</p>
                                        <p class="text-xs text-slate-400">{{ $items->count() }} Transaksi</p>
                                    </div>
                                    <span class="font-extrabold text-slate-800 text-sm">
                                        Rp {{ number_format($catTotal, 0, ',', '.') }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-slate-400 text-xs italic">Tidak ada catatan pengeluaran.</p>
                    @endif
                </div>

                <!-- RECEIPT FOOTER -->
                <div class="border-t-2 border-dashed border-slate-200 pt-6 text-center text-xs text-slate-400 space-y-1">
                    <p class="font-semibold text-slate-600">Terima kasih telah merencanakan perjalanan bersama TripMate!</p>
                    <p>Struk ini dibuat secara otomatis oleh sistem Tripmate Web & Mobile Integration.</p>
                </div>
            </div>

            <!-- RATING SECTION -->
            <div class="bg-white rounded-3xl border border-slate-200 p-8 sm:p-12 shadow-xl no-print mt-6 space-y-6">
                <div>
                    <h3 class="text-xl font-extrabold text-slate-900">Beri Ulasan Perjalanan Anda ⭐</h3>
                    <p class="text-xs text-slate-500 mt-1">Ulasan Anda membantu kami meningkatkan kualitas destinasi dan layanan travel di TripMate.</p>
                </div>

                <div class="divide-y divide-slate-100 space-y-6">
                    @if($travelPlan->travel)
                        <!-- Rate Travel Package -->
                        @php
                            $travelRating = $userRatings->where('travel_id', $travelPlan->travel_id)->first();
                        @endphp
                        <div class="pt-6 first:pt-0">
                            <div class="flex items-center justify-between flex-wrap gap-4">
                                <div>
                                    <h4 class="font-bold text-slate-800">🚌 Agen Travel: {{ $travelPlan->travel->nama_travel }}</h4>
                                    <p class="text-xs text-slate-400">Berikan penilaian Anda terhadap pelayanan Agen Travel ini.</p>
                                </div>
                                <form action="{{ route('ratings.store', ['type' => 'travel', 'id' => $travelPlan->travel_id]) }}" method="POST" class="w-full sm:w-auto mt-2">
                                    @csrf
                                    <div class="flex items-center gap-3">
                                        <!-- Star inputs -->
                                        <div class="flex gap-1" x-data="{ currentRating: {{ $travelRating ? $travelRating->skor_rating : 0 }}, hoverRating: 0 }">
                                            @for($i = 1; $i <= 5; $i++)
                                                <label class="cursor-pointer">
                                                    <input type="radio" name="rating" value="{{ $i }}" class="sr-only" {{ ($travelRating && $travelRating->skor_rating == $i) ? 'checked' : '' }} required>
                                                    <svg class="w-7 h-7 transition" 
                                                         :class="(hoverRating || currentRating) >= {{ $i }} ? 'text-amber-400 fill-amber-400' : 'text-slate-300'"
                                                         @click="currentRating = {{ $i }}"
                                                         @mouseover="hoverRating = {{ $i }}"
                                                         @mouseleave="hoverRating = 0"
                                                         fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.907c.961 0 1.36 1.246.582 1.817l-3.97 2.883a1 1 0 00-.364 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.971-2.883a1 1 0 00-1.17 0l-3.97 2.883c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.364-1.118L2.98 9.42c-.778-.57-.38-1.817.583-1.817h4.906a1 1 0 00.95-.69l1.519-4.674z" />
                                                    </svg>
                                                </label>
                                            @endfor
                                        </div>
                                    </div>
                                    <div class="mt-3 flex gap-2">
                                        <input type="text" name="review" value="{{ $travelRating ? $travelRating->komentar : '' }}" placeholder="Tulis ulasan Anda..." class="w-full text-xs rounded-xl border-slate-200 focus:ring-sky-500 focus:border-sky-500 py-1.5">
                                        <button type="submit" class="px-4 py-1.5 bg-sky-600 hover:bg-sky-700 text-white font-bold text-xs rounded-xl shadow-sm transition">Kirim</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Rate Destinasi yang Disediakan Paket -->
                        @if($travelPlan->travel->destinasis && $travelPlan->travel->destinasis->count() > 0)
                            @foreach($travelPlan->travel->destinasis as $d)
                                @php
                                    $destRating = $userRatings->where('destinasi_id', $d->id)->first();
                                @endphp
                                <div class="pt-6 border-t border-slate-100">
                                    <div class="flex items-center justify-between flex-wrap gap-4">
                                        <div>
                                            <h4 class="font-bold text-slate-800">📍 {{ $d->nama_destinasi }} ({{ $d->kota }})</h4>
                                            <p class="text-xs text-slate-400">Berikan penilaian Anda untuk destinasi ini.</p>
                                        </div>
                                        <form action="{{ route('ratings.store', ['type' => 'destination', 'id' => $d->id]) }}" method="POST" class="w-full sm:w-auto mt-2">
                                            @csrf
                                            <div class="flex items-center gap-3">
                                                <div class="flex gap-1" x-data="{ currentRating: {{ $destRating ? $destRating->skor_rating : 0 }}, hoverRating: 0 }">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <label class="cursor-pointer">
                                                            <input type="radio" name="rating" value="{{ $i }}" class="sr-only" {{ ($destRating && $destRating->skor_rating == $i) ? 'checked' : '' }} required>
                                                            <svg class="w-7 h-7 transition" 
                                                                 :class="(hoverRating || currentRating) >= {{ $i }} ? 'text-amber-400 fill-amber-400' : 'text-slate-300'"
                                                                 @click="currentRating = {{ $i }}"
                                                                 @mouseover="hoverRating = {{ $i }}"
                                                                 @mouseleave="hoverRating = 0"
                                                                 fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.907c.961 0 1.36 1.246.582 1.817l-3.97 2.883a1 1 0 00-.364 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.971-2.883a1 1 0 00-1.17 0l-3.97 2.883c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.364-1.118L2.98 9.42c-.778-.57-.38-1.817.583-1.817h4.906a1 1 0 00.95-.69l1.519-4.674z" />
                                                            </svg>
                                                        </label>
                                                    @endfor
                                                </div>
                                            </div>
                                            <div class="mt-3 flex gap-2">
                                                <input type="text" name="review" value="{{ $destRating ? $destRating->komentar : '' }}" placeholder="Tulis ulasan Anda..." class="w-full text-xs rounded-xl border-slate-200 focus:ring-sky-500 focus:border-sky-500 py-1.5">
                                                <button type="submit" class="px-4 py-1.5 bg-sky-600 hover:bg-sky-700 text-white font-bold text-xs rounded-xl shadow-sm transition">Kirim</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                    @else
                        <!-- Rate Destinasi Rencana Mandiri -->
                        @if($travelPlan->destinasis && $travelPlan->destinasis->count() > 0)
                            @foreach($travelPlan->destinasis as $d)
                                @php
                                    $destRating = $userRatings->where('destinasi_id', $d->id)->first();
                                @endphp
                                <div class="pt-6 first:pt-0 border-t border-slate-100 first:border-0">
                                    <div class="flex items-center justify-between flex-wrap gap-4">
                                        <div>
                                            <h4 class="font-bold text-slate-800">📍 {{ $d->nama_destinasi }} ({{ $d->kota }})</h4>
                                            <p class="text-xs text-slate-400">Berikan penilaian Anda untuk destinasi ini.</p>
                                        </div>
                                        <form action="{{ route('ratings.store', ['type' => 'destination', 'id' => $d->id]) }}" method="POST" class="w-full sm:w-auto mt-2">
                                            @csrf
                                            <div class="flex items-center gap-3">
                                                <div class="flex gap-1" x-data="{ currentRating: {{ $destRating ? $destRating->skor_rating : 0 }}, hoverRating: 0 }">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <label class="cursor-pointer">
                                                            <input type="radio" name="rating" value="{{ $i }}" class="sr-only" {{ ($destRating && $destRating->skor_rating == $i) ? 'checked' : '' }} required>
                                                            <svg class="w-7 h-7 transition" 
                                                                 :class="(hoverRating || currentRating) >= {{ $i }} ? 'text-amber-400 fill-amber-400' : 'text-slate-300'"
                                                                 @click="currentRating = {{ $i }}"
                                                                 @mouseover="hoverRating = {{ $i }}"
                                                                 @mouseleave="hoverRating = 0"
                                                                 fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.907c.961 0 1.36 1.246.582 1.817l-3.97 2.883a1 1 0 00-.364 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.971-2.883a1 1 0 00-1.17 0l-3.97 2.883c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.364-1.118L2.98 9.42c-.778-.57-.38-1.817.583-1.817h4.906a1 1 0 00.95-.69l1.519-4.674z" />
                                                            </svg>
                                                        </label>
                                                    @endfor
                                                </div>
                                            </div>
                                            <div class="mt-3 flex gap-2">
                                                <input type="text" name="review" value="{{ $destRating ? $destRating->komentar : '' }}" placeholder="Tulis ulasan Anda..." class="w-full text-xs rounded-xl border-slate-200 focus:ring-sky-500 focus:border-sky-500 py-1.5">
                                                <button type="submit" class="px-4 py-1.5 bg-sky-600 hover:bg-sky-700 text-white font-bold text-xs rounded-xl shadow-sm transition">Kirim</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
