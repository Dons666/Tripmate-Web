<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🛒 Checkout Pembayaran Paket Travel
        </h2>
    </x-slot>

    <div class="py-10 bg-slate-100 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <div class="flex items-center justify-between">
                <a href="{{ route('travel-plans.show', $travelPlan) }}" class="text-sm font-semibold text-slate-600 hover:text-sky-600 flex items-center gap-1">
                    ← Kembali ke Detail Rencana
                </a>
            </div>

            <!-- CHECKOUT CARD -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-10 shadow-xl space-y-8">
                
                <!-- HEADER & TRAVEL INFO -->
                <div class="border-b border-slate-100 pb-6 flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <span class="text-xs uppercase font-extrabold tracking-widest text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">
                            Pemesanan Resmi Travel
                        </span>
                        <h1 class="text-2xl font-extrabold text-slate-900 mt-2">{{ $travelPlan->nama_perjalanan }}</h1>
                        <p class="text-xs text-slate-500 mt-1">
                            📍 {{ $travelPlan->tujuan ?? 'Indonesia' }} · {{ $travelPlan->tanggal_mulai ? $travelPlan->tanggal_mulai->format('d M Y') : '-' }} s/d {{ $travelPlan->tanggal_selesai ? $travelPlan->tanggal_selesai->format('d M Y') : '-' }}
                        </p>
                    </div>

                    @if($travelPlan->travel)
                        <div class="bg-sky-50 p-4 rounded-2xl border border-sky-100 flex items-center gap-3">
                            <img src="{{ $travelPlan->travel->gambar }}" alt="" class="w-12 h-12 rounded-xl object-cover">
                            <div>
                                <p class="text-xs text-slate-400 font-bold uppercase">Mitra Agen Travel</p>
                                <h4 class="font-extrabold text-sky-900 text-sm">{{ $travelPlan->travel->nama_travel }}</h4>
                                <p class="text-xs text-sky-700 font-semibold">{{ $travelPlan->travel->layanan }}</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- ITEM INVOICE TABLE -->
                <div class="space-y-3">
                    <h3 class="text-xs uppercase font-extrabold tracking-wider text-slate-400">Rincian Komponen Biaya</h3>
                    
                    <div class="border border-slate-200 rounded-2xl overflow-hidden divide-y divide-slate-100">
                        @if($travelPlan->travel)
                            <div class="p-4 flex items-center justify-between bg-slate-50">
                                <div>
                                    <p class="font-bold text-slate-800 text-sm">🚌 Paket Travel: {{ $travelPlan->travel->nama_travel }}</p>
                                    <p class="text-xs text-slate-500">Armada AC, Layanan Supir, Tiket Masuk & Pemandu Tur</p>
                                </div>
                                <span class="font-extrabold text-slate-800 text-sm">
                                    Rp {{ number_format($travelPlan->travel->harga_paket, 0, ',', '.') }}
                                </span>
                            </div>
                        @endif

                        @php $totalTiket = $travelPlan->destinasis->sum('harga'); @endphp
                        <div class="p-4 flex items-center justify-between">
                            <div>
                                <p class="font-bold text-slate-800 text-sm">🎟️ Tiket Destinasi Wisata ({{ $travelPlan->destinasis->count() }} Tempat)</p>
                                <p class="text-xs text-slate-500">
                                    {{ $travelPlan->destinasis->pluck('nama_destinasi')->implode(', ') }}
                                </p>
                            </div>
                            <span class="font-extrabold text-slate-800 text-sm">
                                Rp {{ number_format($totalTiket, 0, ',', '.') }}
                            </span>
                        </div>

                        @if($travelPlan->expenses->count() > 0)
                            @php $totalExpenseCatatan = $travelPlan->expenses->sum('jumlah'); @endphp
                            <div class="p-4 flex items-center justify-between">
                                <div>
                                    <p class="font-bold text-slate-800 text-sm">💰 Catatan Pengeluaran Tambahan</p>
                                    <p class="text-xs text-slate-500">{{ $travelPlan->expenses->count() }} Item Transaksi</p>
                                </div>
                                <span class="font-extrabold text-slate-800 text-sm">
                                    Rp {{ number_format($totalExpenseCatatan, 0, ',', '.') }}
                                </span>
                            </div>
                        @endif
                    </div>

                    @php 
                        $grandTotal = ($travelPlan->travel ? $travelPlan->travel->harga_paket : 0) + $totalTiket + ($travelPlan->expenses ? $travelPlan->expenses->sum('jumlah') : 0);
                    @endphp

                    <div class="p-5 rounded-2xl bg-gradient-to-r from-slate-900 to-sky-950 text-white flex items-center justify-between shadow-lg">
                        <div>
                            <p class="text-xs text-sky-300 font-bold uppercase tracking-wider">Total Tagihan Checkout</p>
                            <p class="text-xs text-slate-300">Termasuk Pajak & Layanan Travel</p>
                        </div>
                        <p class="text-2xl font-black text-emerald-400">Rp {{ number_format($grandTotal, 0, ',', '.') }}</p>
                    </div>
                </div>

                <!-- PAYMENT METHOD FORM -->
                <form action="{{ route('travel-plans.process-checkout', $travelPlan) }}" method="POST" enctype="multipart/form-data" class="space-y-6 pt-4 border-t border-slate-100">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- QRIS Section -->
                        <div class="space-y-4">
                            <label class="block text-xs uppercase font-extrabold tracking-wider text-slate-400">Scan QRIS untuk Membayar</label>
                            <div class="bg-slate-50 border-2 border-slate-200 rounded-3xl p-6 flex flex-col items-center justify-center text-center">
                                <img src="{{ asset('img/qris.png') }}" alt="QRIS" class="w-64 max-w-full rounded-xl shadow-md border border-slate-200 mb-4">
                                <p class="text-sm font-bold text-slate-700">GoPay, OVO, DANA, BCA, Mandiri, dll.</p>
                                <p class="text-xs text-slate-500 mt-1">Pastikan nominal sesuai dengan tagihan.</p>
                                <input type="hidden" name="metode_pembayaran" value="QRIS">
                            </div>
                        </div>

                        <!-- Upload Bukti -->
                        <div class="space-y-4">
                            <label class="block text-xs uppercase font-extrabold tracking-wider text-slate-400">Unggah Bukti Pembayaran</label>
                            
                            <div class="bg-white border-2 border-dashed border-slate-300 rounded-3xl p-8 flex flex-col items-center justify-center text-center hover:border-sky-500 transition cursor-pointer relative">
                                <input type="file" name="payment_proof" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" required accept="image/*">
                                <div class="text-4xl mb-3">📸</div>
                                <p class="text-sm font-bold text-slate-700">Klik atau Tarik file ke sini</p>
                                <p class="text-xs text-slate-500 mt-1">Format: JPG, PNG, max 2MB.</p>
                            </div>

                            @error('payment_proof')
                                <p class="text-red-500 text-xs font-bold">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold py-4 px-6 rounded-2xl shadow-xl transition flex items-center justify-center gap-2 text-base">
                        <span>✅</span> Kirim Bukti Pembayaran
                    </button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
