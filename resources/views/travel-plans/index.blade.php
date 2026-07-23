<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Rencana Perjalanan 💼</h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <!-- Form Buat Rencana Baru -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-10">
                <div class="bg-sky-600 px-6 py-4">
                    <h3 class="font-bold text-white text-lg">Buat Rencana Baru</h3>
                    <p class="text-sky-100 text-xs mt-0.5">Isi detail perjalananmu di bawah ini</p>
                </div>

                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 m-6 mb-0 rounded-r-xl">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <h3 class="text-sm font-bold text-red-800">Gagal menyimpan rencana:</h3>
                        </div>
                        <ul class="mt-2 ml-7 list-disc text-xs text-red-700">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('travel-plans.store') }}" method="POST" enctype="multipart/form-data" id="formRencana">
                    @csrf

                    <!-- Foto Sampul -->
                    <div class="px-6 pt-6 pb-4 border-b border-gray-100">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Foto Sampul Perjalanan</label>
                        <div id="coverPreview" class="w-full h-40 rounded-xl border-2 border-dashed border-gray-200 flex flex-col items-center justify-center cursor-pointer hover:border-sky-400 hover:bg-sky-50/50 transition-all" onclick="document.getElementById('foto_sampul').click()">
                            <svg class="w-8 h-8 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <p class="text-xs text-gray-400 font-medium">Klik untuk pilih foto</p>
                            <p class="text-[10px] text-gray-300 mt-0.5">JPG, PNG, maks 2MB</p>
                        </div>
                        <input type="file" name="foto_sampul" id="foto_sampul" accept="image/*" class="hidden">
                    </div>

                    <!-- Detail Perjalanan -->
                    <div class="px-6 py-5 border-b border-gray-100 space-y-4">
                        <h4 class="text-sm font-bold text-gray-700 flex items-center gap-2">📋 Detail Perjalanan</h4>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-1.5">Judul Perjalanan <span class="text-red-400">*</span></label>
                            <input type="text" name="nama_perjalanan" placeholder="Jelajah Kuliner Bandung Gen Z" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-1.5">Destinasi / Tujuan <span class="text-red-400">*</span></label>
                            <input type="text" name="tujuan" placeholder="Bandung, Indonesia" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-1.5">Catatan <span class="text-gray-300 font-normal">(opsional)</span></label>
                            <textarea name="catatan" rows="2" placeholder="Misal: bawa jaket karena dingin..." class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition resize-none"></textarea>
                        </div>
                    </div>

                    <!-- Waktu & Alokasi Dana -->
                    <div class="px-6 py-5 border-b border-gray-100 space-y-4">
                        <h4 class="text-sm font-bold text-gray-700 flex items-center gap-2">🕒 Waktu & Alokasi Dana</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 mb-1.5">Tanggal Berangkat <span class="text-red-400">*</span></label>
                                <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition" required>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 mb-1.5">Tanggal Kembali <span class="text-red-400">*</span></label>
                                <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition" required>
                            </div>
                        </div>
                        <div id="durasiBox" class="hidden bg-sky-50 border border-sky-100 rounded-xl px-4 py-3 flex items-center gap-3">
                            <div class="w-9 h-9 bg-sky-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs text-sky-500 font-medium">Lama Perjalanan</p>
                                <p class="text-sm font-bold text-sky-700" id="durasiText">- hari</p>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-1.5">Target Budget Total (Rp)</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-xs font-bold text-gray-400">Rp</span>
                                <input type="number" name="budget" id="budgetInput" placeholder="5.000.000" class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition">
                            </div>
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="px-6 py-5 bg-gray-50">
                        <button type="submit" class="w-full bg-sky-600 text-white font-bold py-3 px-6 rounded-xl hover:bg-sky-700 active:scale-[0.98] transition-all text-sm flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Simpan Rencana Perjalanan
                        </button>
                    </div>
                </form>
            </div>

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 p-4 rounded-xl mb-6 text-sm font-medium flex items-center gap-2">
                    <span class="text-lg">✅</span> {{ session('success') }}
                </div>
            @endif

            @php
                $plans = Auth::user()->travelPlans()->latest()->get();
                $activePlans = $plans->filter(fn($p) => $p->status !== 'Selesai' && $p->status !== 'Dibatalkan');
                $completedPlans = $plans->filter(fn($p) => $p->status === 'Selesai');
                $cancelledPlans = $plans->filter(fn($p) => $p->status === 'Dibatalkan');
            @endphp

            <!-- ============================= -->
            <!-- RENCANA AKTIF               -->
            <!-- ============================= -->
            <div class="mb-10">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-gray-800">Rencana Saya</h3>
                    <span class="text-xs text-gray-400 font-medium">{{ $activePlans->count() }} aktif</span>
                </div>

                @if($activePlans->count() > 0)
                <div class="space-y-3">
                    @foreach($activePlans as $plan)
                        <a href="{{ route('travel-plans.show', $plan->id) }}" class="block bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition group">
                            @if($plan->foto_sampul)
                                <div class="h-28 w-full overflow-hidden">
                                    <img src="{{ Storage::url($plan->foto_sampul) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                </div>
                            @else
                                <div class="h-28 w-full bg-gradient-to-br from-sky-100 to-sky-50 flex items-center justify-center">
                                    <span class="text-4xl opacity-40">🗺️</span>
                                </div>
                            @endif
                            <div class="p-4">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-bold text-gray-900 text-sm truncate">{{ $plan->nama_perjalanan }}</h4>
                                        <p class="text-gray-400 text-xs mt-1 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                            {{ $plan->tujuan ?? 'Belum ditentukan' }}
                                        </p>
                                    </div>
                                    <div class="text-right ml-4 flex-shrink-0">
                                        <p class="text-[10px] text-gray-400 font-medium uppercase tracking-wide">Budget</p>
                                        <p class="font-bold text-sky-600 text-sm">Rp {{ number_format($plan->budget, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3 mt-3 pt-3 border-t border-gray-50">
                                    <span class="text-[11px] text-gray-400 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        @if($plan->tanggal_mulai) {{ $plan->tanggal_mulai->format('d M Y') }} @else - @endif
                                    </span>
                                    <span class="text-gray-200">•</span>
                                    <span class="text-[11px] text-gray-400 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        @php
                                            $durasi = 0;
                                            if($plan->tanggal_mulai && $plan->tanggal_selesai) {
                                                $durasi = $plan->tanggal_mulai->diffInDays($plan->tanggal_selesai);
                                                if($durasi < 1) $durasi = 1;
                                            }
                                        @endphp
                                        {{ $durasi > 0 ? $durasi . ' hari' : '-' }}
                                    </span>
                                    @php
                                        $statusColor = match($plan->status ?? 'Perencanaan Aktif') {
                                            'Perencanaan Aktif' => 'bg-sky-100 text-sky-700',
                                            'Sedang Berjalan'   => 'bg-amber-100 text-amber-700',
                                            default             => 'bg-gray-100 text-gray-600',
                                        };
                                    @endphp
                                    <span class="ml-auto text-[10px] font-semibold px-2.5 py-0.5 rounded-full {{ $statusColor }}">
                                        {{ $plan->status ?? 'Perencanaan Aktif' }}
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
                @else
                    <div class="text-center py-12 text-gray-400 bg-white rounded-2xl border border-gray-100">
                        <p class="text-4xl mb-3">🗓️</p>
                        <p class="font-bold text-gray-500">Belum ada rencana aktif</p>
                        <p class="text-xs text-gray-300 mt-1">Buat rencana perjalanan pertamamu di atas</p>
                    </div>
                @endif
            </div>

            <!-- ============================= -->
            <!-- RIWAYAT PERJALANAN          -->
            <!-- ============================= -->
            @if($completedPlans->count() > 0)
            <div class="mb-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2">
                        <h3 class="font-bold text-gray-800">Riwayat Perjalanan</h3>
                        <span class="bg-green-100 text-green-700 text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $completedPlans->count() }}</span>
                    </div>
                    <button onclick="toggleHistory()" id="btnToggleHistory" class="text-xs text-gray-400 hover:text-gray-600 font-medium flex items-center gap-1 transition">
                        <span id="historyToggleText">Tutup</span>
                        <svg id="historyToggleIcon" class="w-3.5 h-3.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                </div>

                <div id="historyContainer" class="space-y-3">
                    @foreach($completedPlans as $plan)
                        <a href="{{ route('travel-plans.show', $plan->id) }}" class="block bg-white rounded-2xl shadow-sm border border-green-100 overflow-hidden hover:shadow-md transition group">
                            @if($plan->foto_sampul)
                                <div class="h-24 w-full overflow-hidden relative">
                                    <img src="{{ Storage::url($plan->foto_sampul) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 grayscale-[30%]">
                                    <div class="absolute inset-0 bg-gradient-to-t from-white/60 to-transparent"></div>
                                </div>
                            @else
                                <div class="h-24 w-full bg-gradient-to-br from-green-50 to-green-100/50 flex items-center justify-center">
                                    <span class="text-3xl opacity-30">✅</span>
                                </div>
                            @endif
                            <div class="p-4">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-bold text-gray-700 text-sm truncate">{{ $plan->nama_perjalanan }}</h4>
                                        <p class="text-gray-400 text-xs mt-1">📍 {{ $plan->tujuan ?? '-' }}</p>
                                    </div>
                                    <div class="text-right ml-4 flex-shrink-0">
                                        <p class="text-[10px] text-gray-400 font-medium">Total Pengeluaran</p>
                                        <p class="font-bold text-gray-700 text-sm">Rp {{ number_format($plan->total_expenses, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3 mt-3 pt-3 border-t border-gray-50">
                                    <span class="text-[11px] text-gray-400">
                                        @if($plan->tanggal_mulai) {{ $plan->tanggal_mulai->format('d M Y') }} @else - @endif
                                    </span>
                                    <span class="text-gray-200">•</span>
                                    <span class="text-[11px] text-gray-400">
                                        @php
                                            $durasi = 0;
                                            if($plan->tanggal_mulai && $plan->tanggal_selesai) {
                                                $durasi = $plan->tanggal_mulai->diffInDays($plan->tanggal_selesai);
                                                if($durasi < 1) $durasi = 1;
                                            }
                                        @endphp
                                        {{ $durasi > 0 ? $durasi . ' hari' : '-' }}
                                    </span>
                                    <span class="ml-auto text-[10px] font-semibold px-2.5 py-0.5 rounded-full bg-green-100 text-green-700">✅ Selesai</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- ============================= -->
            <!-- DIBATALKAN                  -->
            <!-- ============================= -->
            @if($cancelledPlans->count() > 0)
            <div>
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2">
                        <h3 class="font-bold text-gray-500">Dibatalkan</h3>
                        <span class="bg-red-100 text-red-600 text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $cancelledPlans->count() }}</span>
                    </div>
                    <button onclick="toggleCancelled()" id="btnToggleCancelled" class="text-xs text-gray-400 hover:text-gray-600 font-medium flex items-center gap-1 transition">
                        <span id="cancelledToggleText">Tutup</span>
                        <svg id="cancelledToggleIcon" class="w-3.5 h-3.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                </div>
                <div id="cancelledContainer" class="space-y-3">
                    @foreach($cancelledPlans as $plan)
                        <a href="{{ route('travel-plans.show', $plan->id) }}" class="block bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition opacity-60 hover:opacity-100 group">
                            <div class="p-4">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-bold text-gray-500 text-sm truncate line-through">{{ $plan->nama_perjalanan }}</h4>
                                        <p class="text-gray-300 text-xs mt-1">📍 {{ $plan->tujuan ?? '-' }}</p>
                                    </div>
                                    <span class="text-[10px] font-semibold px-2.5 py-0.5 rounded-full bg-red-100 text-red-600 flex-shrink-0 ml-3">Dibatalkan</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Jika kosong semua -->
            @if($plans->count() === 0)
                <div class="text-center py-16 text-gray-400">
                    <p class="text-5xl mb-4">🗓️</p>
                    <p class="font-bold text-lg text-gray-500">Belum ada rencana</p>
                    <p class="text-xs text-gray-300 mt-1">Buat rencana perjalanan pertamamu di atas</p>
                </div>
            @endif

        </div>
    </div>

    <script>
        // Hitung durasi
        const mulai = document.getElementById('tanggal_mulai');
        const selesai = document.getElementById('tanggal_selesai');
        const durasiBox = document.getElementById('durasiBox');
        const durasiText = document.getElementById('durasiText');

        function hitungDurasi() {
            if (mulai.value && selesai.value) {
                const start = new Date(mulai.value);
                const end = new Date(selesai.value);
                const diff = Math.ceil((end - start) / (1000 * 60 * 60 * 24));
                if (diff > 0) {
                    durasiBox.classList.remove('hidden');
                    durasiText.textContent = diff + ' hari';
                } else {
                    durasiBox.classList.add('hidden');
                }
            } else {
                durasiBox.classList.add('hidden');
            }
        }
        mulai.addEventListener('change', hitungDurasi);
        selesai.addEventListener('change', hitungDurasi);

        // Preview foto
        document.getElementById('foto_sampul').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('coverPreview');
            if (file) {
                const reader = new FileReader();
                reader.onload = function(ev) {
                    preview.innerHTML = '<img src="' + ev.target.result + '" class="w-full h-full object-cover rounded-xl">';
                };
                reader.readAsDataURL(file);
            }
        });

        // Toggle Riwayat
        function toggleHistory() {
            const container = document.getElementById('historyContainer');
            const text = document.getElementById('historyToggleText');
            const icon = document.getElementById('historyToggleIcon');
            if (container.style.display === 'none') {
                container.style.display = '';
                text.textContent = 'Tutup';
                icon.style.transform = 'rotate(0deg)';
            } else {
                container.style.display = 'none';
                text.textContent = 'Lihat';
                icon.style.transform = 'rotate(-90deg)';
            }
        }

        // Toggle Dibatalkan
        function toggleCancelled() {
            const container = document.getElementById('cancelledContainer');
            const text = document.getElementById('cancelledToggleText');
            const icon = document.getElementById('cancelledToggleIcon');
            if (container.style.display === 'none') {
                container.style.display = '';
                text.textContent = 'Tutup';
                icon.style.transform = 'rotate(0deg)';
            } else {
                container.style.display = 'none';
                text.textContent = 'Lihat';
                icon.style.transform = 'rotate(-90deg)';
            }
        }
    </script>
</x-app-layout>