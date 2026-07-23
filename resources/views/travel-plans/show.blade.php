<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $travelPlan->nama_perjalanan }}</h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 p-3 rounded-xl text-sm font-medium">✅ {{ session('success') }}</div>
            @endif

            <!-- Tombol Aksi -->
            <div class="flex justify-end gap-3">
                @if($travelPlan->status !== 'Selesai')
                    <form action="{{ route('travel-plans.complete', $travelPlan) }}" method="POST">
                        @csrf
                        <button type="submit" class="text-sm text-green-700 hover:text-green-800 font-medium flex items-center gap-1.5 bg-green-50 border border-green-200 px-4 py-2 rounded-xl hover:bg-green-100 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Selesaikan Perjalanan
                        </button>
                    </form>
                @endif
                <button type="button" onclick="openDeleteModal()" class="text-sm text-red-500 hover:text-red-700 font-medium flex items-center gap-1.5 bg-white border border-red-200 px-4 py-2 rounded-xl hover:bg-red-50 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Hapus Rencana
                </button>
            </div>

            <!-- Banner Selesai -->
            @if($travelPlan->status === 'Selesai')
            <div class="bg-green-50 border border-green-200 rounded-2xl p-5 flex items-center gap-4">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-green-800">Perjalanan Telah Selesai</h3>
                    <p class="text-sm text-green-600 mt-0.5">Rencana ini sudah ditandai selesai dan masuk ke Riwayat Perjalanan.</p>
                </div>
                <a href="{{ route('travel-plans.index') }}" class="text-sm text-green-700 font-semibold hover:underline flex-shrink-0">Lihat Riwayat →</a>
            </div>
            @endif

            <!-- TRAVEL AGENT & ESCROW STATUS CARD -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6 sm:p-8 space-y-6">
                <div class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-100 pb-6">
                    <div>
                        <span class="text-xs uppercase font-extrabold tracking-widest text-slate-400">Mode Perjalanan</span>
                        <h3 class="text-xl font-extrabold text-slate-900 mt-0.5">
                            @if($travelPlan->travel)
                                🚌 Didampingi Agen Travel: <span class="text-sky-600">{{ $travelPlan->travel->nama_travel }}</span>
                            @else
                                🚶 Perencanaan Mandiri (Tanpa Travel)
                            @endif
                        </h3>
                    </div>

                    <!-- ACTION BUTTONS -->
                    <div>
                        @if($travelPlan->travel)
                            @if(!$travelPlan->is_checkout)
                                <a href="{{ route('travel-plans.checkout', $travelPlan) }}" class="px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-sm rounded-2xl shadow-lg transition flex items-center gap-2">
                                    🛒 Checkout & Bayar Paket Travel (Rp {{ number_format($travelPlan->travel->harga_paket, 0, ',', '.') }})
                                </a>
                            @else
                                <span class="px-4 py-2 bg-emerald-100 text-emerald-800 rounded-xl text-xs font-extrabold inline-flex items-center gap-1.5">
                                    ✓ Checkout Pembayaran Berhasil (Status Escrow Active)
                                </span>
                            @endif
                        @else
                            <span class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-semibold inline-flex items-center gap-1.5">
                                ℹ️ Perencanaan Mandiri (Tanpa Pembayaran)
                            </span>
                        @endif
                    </div>
                </div>

                <!-- DETAILED ESCROW & TRIP STATUS BANNER -->
                @if($travelPlan->travel && $travelPlan->is_checkout)
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-5 rounded-2xl bg-gradient-to-r from-sky-50 to-indigo-50 border border-sky-100">
                        <div>
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Status Rekening Bersama (Escrow)</p>
                            @if($travelPlan->payment_status === 'escrow_held')
                                <p class="text-sm font-extrabold text-emerald-700 mt-1 flex items-center gap-1.5">
                                    🔒 Uang Disimpan Aman oleh Admin (Escrow)
                                </p>
                                <p class="text-xs text-slate-500 mt-0.5">Dana di-holding Admin dan baru diteruskan ke Travel saat tur selesai.</p>
                            @elseif($travelPlan->payment_status === 'payout_released')
                                <p class="text-sm font-extrabold text-indigo-700 mt-1 flex items-center gap-1.5">
                                    💸 Uang Telah Diteruskan Admin ke Agen Travel
                                </p>
                                <p class="text-xs text-slate-500 mt-0.5">Transaksi tur perjalanan selesai sepenuhnya!</p>
                            @endif
                        </div>

                        <div>
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Status Keberangkatan Tur</p>
                            @if($travelPlan->trip_status === 'in_progress')
                                <p class="text-sm font-extrabold text-sky-700 mt-1 flex items-center gap-1.5 animate-pulse">
                                    🚀 Perjalanan Sedang Berjalan (Didampingi Travel)
                                </p>
                                <p class="text-xs text-slate-500 mt-0.5">Pihak Agen Travel telah secara resmi memulai tur hari ini.</p>
                            @elseif($travelPlan->trip_status === 'completed')
                                <p class="text-sm font-extrabold text-emerald-700 mt-1 flex items-center gap-1.5">
                                    🏁 Perjalanan Berakhir (Tur Selesai)
                                </p>
                                <p class="text-xs text-slate-500 mt-0.5">Agen Travel telah menyelesaikan tur. Menunggu verifikasi pencairan dana Admin.</p>
                            @else
                                <p class="text-sm font-extrabold text-amber-700 mt-1 flex items-center gap-1.5">
                                    ⏳ Menunggu Keberangkatan Tur
                                </p>
                                <p class="text-xs text-slate-500 mt-0.5">Tur akan dimulai oleh Travel pada tanggal {{ $travelPlan->tanggal_mulai ? $travelPlan->tanggal_mulai->format('d M Y') : 'keberangkatan' }}.</p>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- GANTI AGEN TRAVEL FORM -->
                <form action="{{ route('travel-plans.attach-travel', $travelPlan) }}" method="POST" class="flex flex-wrap items-center gap-3 pt-2">
                    @csrf
                    <label class="text-xs font-bold text-slate-600">Pilih Agen Travel:</label>
                    <select name="travel_id" class="text-xs rounded-xl border-slate-300 py-2 px-3 focus:ring-sky-500 focus:border-sky-500">
                        <option value="">-- Perencanaan Mandiri (Tanpa Travel) --</option>
                        @foreach($travels as $t)
                            <option value="{{ $t->id }}" {{ $travelPlan->travel_id == $t->id ? 'selected' : '' }}>
                                🚌 {{ $t->nama_travel }} (Rp {{ number_format($t->harga_paket, 0, ',', '.') }})
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-xs font-bold transition">
                        Simpan Mode Perjalanan
                    </button>
                </form>
            </div>

            <!-- Info Rencana & Budget -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div>
                        <p class="text-xs text-gray-400">Status</p>
                        @php
                            $statusColor = match($travelPlan->status ?? 'Perencanaan Aktif') {
                                'Perencanaan Aktif' => 'bg-sky-100 text-sky-700',
                                'Sedang Berjalan'   => 'bg-amber-100 text-amber-700',
                                'Selesai'           => 'bg-green-100 text-green-700',
                                'Dibatalkan'        => 'bg-red-100 text-red-700',
                                default             => 'bg-gray-100 text-gray-600',
                            };
                        @endphp
                        <span class="inline-block mt-1 text-xs font-semibold px-3 py-1 rounded-full {{ $statusColor }}">
                            {{ $travelPlan->status ?? 'Perencanaan Aktif' }}
                        </span>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Tanggal</p>
                        <p class="font-semibold text-gray-800 mt-1">{{ $travelPlan->tanggal_mulai ? $travelPlan->tanggal_mulai->format('d M Y') : '-' }} s/d {{ $travelPlan->tanggal_selesai ? $travelPlan->tanggal_selesai->format('d M Y') : '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Total Budget</p>
                        <p class="font-bold text-sky-600 text-xl mt-1">Rp {{ number_format($travelPlan->budget, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Sisa Budget</p>
                        @php $sisa = $travelPlan->budget - $travelPlan->total_expenses; @endphp
                        <p class="font-bold {{ $sisa < 0 ? 'text-red-500' : 'text-green-500' }} text-xl mt-1">Rp {{ number_format($sisa, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Destinasi -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-800 mb-4">Daftar Destinasi</h3>
                    @if($travelPlan->destinasis->count() > 0)
                        <div class="space-y-3">
                            @foreach($travelPlan->destinasis as $dest)
                                <div class="flex items-center gap-3 bg-gray-50 rounded-xl p-3 hover:bg-sky-50 transition group">
                                    <a href="{{ route('destinasi.show', $dest) }}" class="flex-shrink-0">
                                        @if($dest->gambar)
                                            <img src="{{ $dest->gambar }}" class="w-14 h-14 rounded-lg object-cover" alt="">
                                        @else
                                            <div class="w-14 h-14 rounded-lg bg-gray-200 flex items-center justify-center text-xl">📍</div>
                                        @endif
                                    </a>
                                    <a href="{{ route('destinasi.show', $dest) }}" class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-gray-800 group-hover:text-sky-600 transition truncate">{{ $dest->nama_destinasi }}</p>
                                        <p class="text-xs text-gray-400 mt-0.5">📍 {{ $dest->kota }} · {{ $dest->kategori }}</p>
                                        @if($dest->harga == 0)
                                            <p class="text-xs text-green-500 font-semibold mt-0.5">Gratis</p>
                                        @else
                                            <p class="text-xs text-sky-500 font-semibold mt-0.5">Rp {{ number_format($dest->harga, 0, ',', '.') }}</p>
                                        @endif
                                    </a>
                                    <form action="{{ route('travel-plans.removeDestinasi', [$travelPlan, $dest]) }}" method="POST" class="flex-shrink-0">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-gray-300 hover:text-red-500 transition p-1" title="Hapus dari rencana">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-400 text-sm">Belum ada destinasi. Tambahkan dari halaman detail destinasi!</p>
                    @endif
                </div>

                <!-- Expense Tracker -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-800 mb-4">Catatan Pengeluaran 💰</h3>
                    
                    @if($travelPlan->status !== 'Selesai')
                    <form action="{{ route('expenses.store', $travelPlan) }}" method="POST" class="mb-6 bg-sky-50 p-4 rounded-xl border border-sky-100">
                        @csrf
                        <div class="grid grid-cols-2 gap-3">
                            <input type="text" name="nama_pengeluaran" placeholder="Nama (ex: Tiket Pesawat)" class="col-span-2 px-3 py-2 rounded-lg border border-gray-200 text-sm" required>
                            <input type="number" name="jumlah" placeholder="Jumlah (Rp)" class="px-3 py-2 rounded-lg border border-gray-200 text-sm" required>
                            <input type="date" name="tanggal" class="px-3 py-2 rounded-lg border border-gray-200 text-sm" required>
                            <input type="text" name="kategori" placeholder="Kategori (ex: Transport)" class="col-span-2 px-3 py-2 rounded-lg border border-gray-200 text-sm">
                        </div>
                        <button type="submit" class="mt-3 w-full bg-sky-600 text-white py-2 rounded-lg text-sm font-medium hover:bg-sky-700">Tambah Pengeluaran</button>
                    </form>
                    @endif

                    @if($travelPlan->expenses->count() > 0)
                    <ul class="space-y-3">
                        @foreach($travelPlan->expenses->sortByDesc('tanggal') as $expense)
                            <li class="flex justify-between items-center text-sm border-b border-gray-50 pb-2">
                                <div>
                                    <p class="font-medium text-gray-800">{{ $expense->nama_pengeluaran }}</p>
                                    <p class="text-xs text-gray-400">{{ $expense->tanggal->format('d M Y') }}</p>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="font-semibold text-red-500">- Rp {{ number_format($expense->jumlah, 0, ',', '.') }}</span>
                                    @if($travelPlan->status !== 'Selesai')
                                    <form action="{{ route('expenses.destroy', $expense) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-gray-300 hover:text-red-500">✕</button>
                                    </form>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <div class="mt-4 pt-4 border-t border-gray-200 flex justify-between font-bold text-gray-900">
                        <span>Total Pengeluaran</span>
                        <span>Rp {{ number_format($travelPlan->total_expenses, 0, ',', '.') }}</span>
                    </div>
                    @else
                        <p class="text-gray-400 text-sm text-center">Belum ada pengeluaran.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL: KONFIRMASI HAPUS -->
    <div id="modalHapus" style="display:none; position:fixed; inset:0; z-index:9999;">
        <div onclick="closeDeleteModal()" style="position:absolute; inset:0; background:rgba(0,0,0,0.5); backdrop-filter:blur(4px);"></div>
        <div style="position:relative; display:flex; align-items:center; justify-content:center; min-height:100vh; padding:1rem;">
            <div style="background:white; border-radius:1rem; box-shadow:0 25px 50px -12px rgba(0,0,0,0.25); width:100%; max-width:24rem; overflow:hidden;">
                <div style="padding:2rem 1.5rem 0; text-align:center;">
                    <div style="width:4rem; height:4rem; border-radius:50%; background:#fef2f2; display:flex; align-items:center; justify-content:center; margin:0 auto 1rem;">
                        <svg style="width:2rem; height:2rem; color:#ef4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </div>
                    <h3 style="font-size:1.125rem; font-weight:700; color:#111827; margin:0 0 0.5rem;">Hapus Rencana?</h3>
                    <p style="font-size:0.875rem; color:#6b7280; margin:0; line-height:1.5;">
                        Rencana "<strong>{{ $travelPlan->nama_perjalanan }}</strong>" beserta semua destinasi dan catatan pengeluaran di dalamnya akan dihapus permanen.
                    </p>
                </div>
                <div style="padding:1.5rem; display:flex; gap:0.75rem;">
                    <button onclick="closeDeleteModal()" style="flex:1; padding:0.75rem; border-radius:0.75rem; border:1px solid #e5e7eb; background:white; color:#374151; font-weight:600; font-size:0.875rem; cursor:pointer;" onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='white'">
                        Batal
                    </button>
                    <form action="{{ route('travel-plans.destroy', $travelPlan) }}" method="POST" style="flex:1;">
                        @csrf @method('DELETE')
                        <button type="submit" style="width:100%; padding:0.75rem; border-radius:0.75rem; border:none; background:#ef4444; color:white; font-weight:600; font-size:0.875rem; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:0.5rem;" onmouseover="this.style.background='#dc2626'" onmouseout="this.style.background='#ef4444'">
                            <svg style="width:1rem; height:1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            Ya, Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openDeleteModal() {
            document.getElementById('modalHapus').style.display = 'block';
            document.body.style.overflow = 'hidden';
        }
        function closeDeleteModal() {
            document.getElementById('modalHapus').style.display = 'none';
            document.body.style.overflow = '';
        }
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeDeleteModal();
        });
    </script>
</x-app-layout>