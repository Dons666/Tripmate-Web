<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                🚌 Dashboard Portal Mitra Agen Travel
            </h2>
            @if(isset($penyediaTravel))
                <a href="{{ route('travel.dashboard.edit') }}" class="px-4 py-2 bg-sky-600 hover:bg-sky-700 text-white rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-sm">
                    ✏️ Edit Profil & Armada Travel
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-10 bg-slate-100 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-2xl text-sm font-semibold flex items-center gap-2 shadow-sm">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-2xl text-sm font-semibold flex items-center gap-2 shadow-sm">
                    ⚠️ {{ session('error') }}
                </div>
            @endif

            <!-- PROFILE & MITRA STATUS HEADER -->
            <div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-sky-900 text-white rounded-3xl p-6 sm:p-8 shadow-xl flex flex-wrap items-center justify-between gap-6 relative overflow-hidden">
                <div class="flex items-center gap-5 relative z-10">
                    @if(!empty($travel->gambar))
                        <img src="{{ $travel->gambar }}" alt="" class="w-20 h-20 rounded-2xl object-cover border-2 border-white/20 shadow-md">
                    @else
                        <div class="w-20 h-20 rounded-2xl bg-sky-500/20 border border-sky-400/30 flex items-center justify-center text-3xl font-black">
                            🚌
                        </div>
                    @endif
                    <div>
                        <div class="flex items-center gap-2 flex-wrap mb-1">
                            @php
                                $accStatus = $penyediaTravel->status ?? 'approved';
                                $statusBadge = match($accStatus) {
                                    'approved' => 'bg-emerald-500/20 text-emerald-300 border-emerald-500/30',
                                    'pending'  => 'bg-amber-500/20 text-amber-300 border-amber-500/30',
                                    'rejected' => 'bg-rose-500/20 text-rose-300 border-rose-500/30',
                                    default    => 'bg-sky-500/20 text-sky-300 border-sky-500/30',
                                };
                                $statusLabel = match($accStatus) {
                                    'approved' => '✓ Status Kemitraan: Aktif (ACC Admin)',
                                    'pending'  => '⏳ Menunggu Verifikasi Admin',
                                    'rejected' => '✕ Kemitraan Ditolak',
                                    default    => 'Mitra Agen Resmi',
                                };
                            @endphp
                            <span class="px-3 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider border {{ $statusBadge }}">
                                {{ $statusLabel }}
                            </span>
                        </div>
                        <h1 class="text-2xl sm:text-3xl font-black">{{ $penyediaTravel->nama_travel ?? $travel->nama_travel ?? Auth::user()->name }}</h1>
                        <p class="text-xs text-sky-200 mt-1">
                            📍 {{ $penyediaTravel->kota_asal_travel ?? $travel->kota ?? 'Indonesia' }} · 📱 {{ $penyediaTravel->nomor_hp_pemilik_travel ?? $travel->kontak ?? '-' }} · ✉️ {{ $penyediaTravel->email ?? Auth::user()->email }}
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-3 relative z-10">
                    <a href="{{ route('travel.dashboard.edit') }}" class="px-5 py-2.5 bg-sky-500 hover:bg-sky-600 text-white rounded-xl text-xs font-extrabold transition shadow-md flex items-center gap-1.5">
                        ✏️ Edit Profil & Armada
                    </a>
                </div>
            </div>

            <!-- TAB GRID: INFORMASI USAHA & ARMADA TRAVEL -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- DETAIL USAHA & REKENING -->
                <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-sm space-y-4">
                    <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                        <h3 class="font-extrabold text-slate-800 text-sm flex items-center gap-2">
                            🏢 Informasi Usaha Travel
                        </h3>
                        <span class="text-[10px] font-bold text-slate-400 uppercase">Detail Legal</span>
                    </div>

                    <div class="space-y-3 text-xs">
                        <div>
                            <p class="text-slate-400 font-medium">Alamat Kantor / Garasi</p>
                            <p class="font-bold text-slate-800 mt-0.5">{{ $penyediaTravel->alamat_travel ?? 'Belum diisi' }}</p>
                        </div>
                        <div>
                            <p class="text-slate-400 font-medium">Jenis Armada / Kendaraan</p>
                            <p class="font-bold text-slate-800 mt-0.5">🚐 {{ $penyediaTravel->jenis_kendaraan ?? $travel->layanan ?? 'Bus Pariwisata / Minibus' }}</p>
                        </div>
                        <div>
                            <p class="text-slate-400 font-medium">Harga Tarif Paket</p>
                            <p class="font-black text-sky-600 text-sm mt-0.5">Rp {{ number_format($penyediaTravel->harga ?? $travel->harga_paket ?? 350000, 0, ',', '.') }} / Paket</p>
                        </div>
                        <div>
                            <p class="text-slate-400 font-medium">Nomor Rekening Pencairan Admin</p>
                            <p class="font-mono font-bold text-slate-800 mt-0.5 bg-slate-50 p-2 rounded-xl border border-slate-200">
                                💳 {{ $penyediaTravel->rekening ?? 'BCA - 1234567890 a/n Travel Owner' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-slate-400 font-medium">Jadwal Ketersediaan</p>
                            <p class="font-semibold text-slate-700 mt-0.5">{{ $penyediaTravel->jadwal_ketersediaan ?? 'Setiap Hari (08:00 - 20:00 WIB)' }}</p>
                        </div>
                    </div>
                </div>

                <!-- DOKUMEN & FOTO ARMADA -->
                <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-200/80 p-6 shadow-sm space-y-4">
                    <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                        <h3 class="font-extrabold text-slate-800 text-sm flex items-center gap-2">
                            🚌 Galeri Armada & Dokumentasi Legalitas Usaha
                        </h3>
                        <a href="{{ route('travel.dashboard.edit') }}" class="text-xs font-bold text-sky-600 hover:underline">
                            + Kelola Armada
                        </a>
                    </div>

                    <!-- FOTO ARMADA DISPLAY -->
                    @php
                        $fotoArmada = [];
                        if(!empty($penyediaTravel->foto_kendaraan)) {
                            $decoded = json_decode($penyediaTravel->foto_kendaraan, true);
                            $fotoArmada = is_array($decoded) ? $decoded : [$penyediaTravel->foto_kendaraan];
                        }
                    @endphp

                    @if(!empty($fotoArmada))
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            @foreach($fotoArmada as $img)
                                <div class="relative group rounded-2xl overflow-hidden border border-slate-200 aspect-video">
                                    <img src="{{ str_starts_with($img, 'http') ? $img : asset('storage/' . $img) }}" alt="Armada" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 flex items-center gap-3">
                                <span class="text-3xl">🚍</span>
                                <div>
                                    <p class="text-xs font-bold text-slate-800">Armada AC Executive</p>
                                    <p class="text-[11px] text-slate-400">Audio, Reclining Seat, USB Charger</p>
                                </div>
                            </div>
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 flex items-center gap-3">
                                <span class="text-3xl">📄</span>
                                <div>
                                    <p class="text-xs font-bold text-slate-800">Surat Izin Usaha Travel</p>
                                    <p class="text-[11px] text-emerald-600 font-semibold">Terverifikasi Admin (SIUP Terlampir)</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- BOOKINGS & ESCROW SCHEDULE LIST -->
            <div class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-sm space-y-6">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div>
                        <h3 class="text-lg font-extrabold text-slate-900">📅 Jadwal Tur & Pemesanan Pelanggan (Status Transaksi)</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Kelola tombol <strong>Perjalanan Dimulai</strong> & <strong>Perjalanan Berakhir</strong> untuk memicu pencairan dana Escrow oleh Admin.</p>
                    </div>
                    <span class="text-xs font-extrabold px-3 py-1 bg-sky-50 text-sky-700 rounded-full border border-sky-100">
                        {{ $bookings->count() }} Booking Berlangsung
                    </span>
                </div>

                @if($bookings->count() > 0)
                    <div class="space-y-4">
                        @foreach($bookings as $booking)
                            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/70 hover:border-sky-300 transition space-y-4">
                                <div class="flex flex-wrap items-start justify-between gap-4 border-b border-slate-200/60 pb-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-sky-100 text-sky-700 flex items-center justify-center font-bold text-base">
                                            👤
                                        </div>
                                        <div>
                                            <h4 class="font-extrabold text-slate-800 text-base">{{ $booking->nama_perjalanan }}</h4>
                                            <p class="text-xs text-slate-500">
                                                Pemesan: <strong>{{ $booking->user->name ?? 'Pelanggan' }}</strong> ({{ $booking->user->email ?? '-' }})
                                            </p>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-3 flex-wrap">
                                        @php
                                            $tripBadge = match($booking->trip_status) {
                                                'ready'       => 'bg-amber-100 text-amber-800 border-amber-300',
                                                'in_progress' => 'bg-sky-100 text-sky-800 border-sky-300 animate-pulse',
                                                'completed'   => 'bg-emerald-100 text-emerald-800 border-emerald-300',
                                                default       => 'bg-slate-100 text-slate-700 border-slate-300',
                                            };
                                            $tripLabel = match($booking->trip_status) {
                                                'ready'       => '⏳ Menunggu Keberangkatan',
                                                'in_progress' => '🚀 Sedang Berjalan',
                                                'completed'   => '🏁 Perjalanan Berakhir',
                                                default       => 'Perencanaan',
                                            };
                                        @endphp
                                        <span class="text-xs font-bold px-3 py-1 rounded-full border {{ $tripBadge }}">
                                            {{ $tripLabel }}
                                        </span>

                                        @php
                                            $payBadge = match($booking->payment_status) {
                                                'escrow_held'     => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                                'payout_released' => 'bg-indigo-50 text-indigo-700 border-indigo-200 font-bold',
                                                default           => 'bg-slate-50 text-slate-600 border-slate-200',
                                            };
                                            $payLabel = match($booking->payment_status) {
                                                'escrow_held'     => '🔒 Uang Disimpan Admin (Escrow)',
                                                'payout_released' => '💸 Dana Berhasil Diteruskan Admin',
                                                default           => 'Unpaid',
                                            };
                                        @endphp
                                        <span class="text-xs font-semibold px-3 py-1 rounded-full border {{ $payBadge }}">
                                            {{ $payLabel }}
                                        </span>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs">
                                    <div class="bg-white p-3 rounded-xl border border-slate-100">
                                        <p class="text-slate-400 font-medium">Jadwal Tanggal Tur</p>
                                        <p class="font-bold text-slate-800 mt-0.5">
                                            📅 {{ $booking->tanggal_mulai ? $booking->tanggal_mulai->format('d M Y') : '-' }} — {{ $booking->tanggal_selesai ? $booking->tanggal_selesai->format('d M Y') : '-' }}
                                        </p>
                                    </div>
                                    <div class="bg-white p-3 rounded-xl border border-slate-100">
                                        <p class="text-slate-400 font-medium">Destinasi Mampir ({{ $booking->destinasis->count() }})</p>
                                        <p class="font-bold text-slate-800 mt-0.5 truncate">
                                            📍 {{ $booking->destinasis->pluck('nama_destinasi')->implode(', ') ?: 'Belum ditentukan' }}
                                        </p>
                                    </div>
                                    <div class="bg-white p-3 rounded-xl border border-slate-100">
                                        <p class="text-slate-400 font-medium">Nilai Paket Tur Travel</p>
                                        <p class="font-extrabold text-sky-600 mt-0.5">
                                            Rp {{ number_format($travel->harga_paket ?? $booking->budget, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>

                                <!-- ACTION BUTTONS FOR TRAVEL AGENT -->
                                <div class="pt-2 flex items-center justify-end gap-3 border-t border-slate-200/50">
                                    @if($booking->trip_status === 'ready' || $booking->trip_status === 'planning')
                                        <form action="{{ route('travel.portal.start-trip', $booking) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow-md transition flex items-center gap-1.5">
                                                🚩 Klik: Perjalanan Dimulai
                                            </button>
                                        </form>
                                    @elseif($booking->trip_status === 'in_progress')
                                        <form action="{{ route('travel.portal.end-trip', $booking) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="px-5 py-2.5 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold rounded-xl shadow-md transition flex items-center gap-1.5">
                                                🏁 Klik: Perjalanan Berakhir
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-xs text-emerald-700 font-bold bg-emerald-50 px-4 py-2 rounded-xl border border-emerald-200">
                                            ✓ Tur Selesai. Menunggu Transfer Pencairan Admin
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-10 bg-slate-50 rounded-2xl border border-slate-100 space-y-2">
                        <span class="text-3xl">📅</span>
                        <p class="text-xs font-bold text-slate-700">Belum Ada Pemesanan Paket Tur dari Pengguna</p>
                        <p class="text-xs text-slate-400">Setiap kali pengguna memilih agen travel Anda dan melakukan checkout, pemesanan akan otomatis muncul di sini.</p>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
