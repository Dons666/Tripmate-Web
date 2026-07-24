<x-app-layout>
    <!-- Header Image / Banner -->
    <div class="w-full bg-[#4A90E2] pt-8 pb-12 px-6 rounded-b-[30px] shadow-sm text-center">
        <div class="inline-flex items-center justify-center mb-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
            </svg>
        </div>
        <h2 class="text-white text-2xl font-bold">Temukan Rute Tercepat</h2>
        <p class="text-white/80 text-sm mt-1">Hemat waktu perjalanan Anda antar destinasi</p>
    </div>

    <div class="bg-gray-50 min-h-screen pb-12 -mt-6">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Input Card -->
            <div class="bg-white rounded-2xl shadow-md p-6 mb-6">
                <form id="dijkstraForm" class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1.5 uppercase tracking-wider">Titik Awal</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            </div>
                            <input type="text" id="startPoint" list="destinasiList" placeholder="Masukkan Nama Tempat Awal (cth: Dago)..." class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#4A90E2] bg-gray-50 text-sm font-medium" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1.5 uppercase tracking-wider">Titik Tujuan</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            </div>
                            <input type="text" id="endPoint" list="destinasiList" placeholder="Masukkan Nama Tempat Tujuan (cth: Braga)..." class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#4A90E2] bg-gray-50 text-sm font-medium" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1.5 uppercase tracking-wider">Budget Maksimal (Rupiah)</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500 font-bold text-sm">
                                Rp
                            </div>
                            <input type="number" id="budgetLimit" placeholder="Masukkan Nominal Budget Perjalanan..." class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#4A90E2] bg-gray-50 text-sm font-medium" required min="0">
                        </div>
                    </div>

                    <datalist id="destinasiList">
                        @foreach($destinasis as $d)
                            <option value="{{ $d->nama_destinasi }}">{{ $d->kota }}</option>
                        @endforeach
                    </datalist>

                    <div class="pt-2">
                        <button type="submit" id="btnSubmit" class="w-full py-3.5 bg-[#4A90E2] hover:bg-blue-600 text-white rounded-xl font-bold shadow-sm transition flex items-center justify-center gap-2">
                            <span>Kalkulasi Rute</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Loading State -->
            <div id="loadingState" class="hidden py-8 text-center">
                <div class="inline-block animate-spin rounded-full h-10 w-10 border-b-2 border-[#4A90E2] mb-4"></div>
            </div>

            <!-- Error State -->
            <div id="errorState" class="hidden mb-6 px-5 py-4 bg-red-50 border border-red-200 rounded-xl">
                <p class="text-red-500 font-medium text-sm" id="errorText"></p>
            </div>

            <!-- Result Area (Green Card) -->
            <div id="resultArea" class="hidden">
                <div class="bg-green-50 border border-green-200 rounded-2xl p-6 shadow-sm">
                    <div class="flex items-center gap-2 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <h3 class="text-lg font-bold text-green-600">Rute Ditemukan!</h3>
                    </div>
                    
                    <hr class="border-green-200 mb-4">
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="bg-white/80 p-3 rounded-xl border border-green-100">
                            <p class="text-xs text-gray-400">Total Jarak</p>
                            <p class="text-base font-bold text-gray-800"><span id="resDistance">0</span> km</p>
                        </div>
                        <div class="bg-white/80 p-3 rounded-xl border border-green-100">
                            <p class="text-xs text-gray-400">Total Biaya Wisata</p>
                            <p class="text-base font-bold text-gray-800">Rp <span id="resCost">0</span></p>
                        </div>
                        <div class="bg-white/80 p-3 rounded-xl border border-green-100">
                            <p class="text-xs text-gray-400">Sisa Budget</p>
                            <p class="text-base font-bold text-green-700">Rp <span id="resRemaining">0</span></p>
                        </div>
                    </div>
                    
                    <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Lintasan Tempat Yang Dapat Dikunjungi:</h4>
                    <div id="routeList" class="space-y-1">
                        <!-- Items disisipkan via JS -->
                    </div>

                    <!-- Form Simpan Rute -->
                    <form action="{{ route('travel-plans.save-integrated-route') }}" method="POST" id="saveRouteForm" class="mt-8 border-t border-green-200 pt-6">
                        @csrf
                        <h4 class="text-sm font-bold text-green-800 mb-3">Jadikan Rencana Perjalanan!</h4>
                        <div class="flex flex-col sm:flex-row gap-3">
                            <input type="text" name="nama_perjalanan" placeholder="Beri Nama (Misal: Liburan Dago-Braga)" class="flex-1 px-4 py-3 rounded-xl border border-green-200 focus:ring-2 focus:ring-green-500 bg-white text-sm font-medium shadow-sm" required>
                            <input type="hidden" name="budget" id="inputSaveBudget" value="0">
                            <div id="hiddenDestinasiInputs"></div>
                            <button type="submit" class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl shadow-md transition whitespace-nowrap flex items-center justify-center gap-2">
                                💾 Simpan ke Perencanaan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.getElementById('dijkstraForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const start = document.getElementById('startPoint').value;
            const end = document.getElementById('endPoint').value;
            const budget = document.getElementById('budgetLimit').value;
            
            if(!start || !end || !budget) return;

            const btnSubmit = document.getElementById('btnSubmit');
            const loading = document.getElementById('loadingState');
            const resultArea = document.getElementById('resultArea');
            const errorArea = document.getElementById('errorState');
            
            btnSubmit.disabled = true;
            loading.classList.remove('hidden');
            resultArea.classList.add('hidden');
            errorArea.classList.add('hidden');

            try {
                const response = await fetch('/api/integrated-route', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        start: start,
                        end: end,
                        budget: parseFloat(budget)
                    })
                });
                
                const data = await response.json();
                
                loading.classList.add('hidden');
                btnSubmit.disabled = false;

                if(response.ok && data.status === 'success') {
                    // Hitung total jarak di JS
                    let totalDistance = 0.0;
                    for (let i = 0; i < data.route.length - 1; i++) {
                        let a = data.route[i];
                        let b = data.route[i+1];
                        totalDistance += Math.sqrt(
                            Math.pow(parseFloat(b.latitude) - parseFloat(a.latitude), 2) +
                            Math.pow(parseFloat(b.longitude) - parseFloat(a.longitude), 2)
                        );
                    }
                    
                    document.getElementById('resDistance').innerText = (totalDistance * 100).toFixed(1); // Kali 100 untuk skala km perkiraan
                    document.getElementById('resCost').innerText = new Intl.NumberFormat('id-ID').format(data.total_cost);
                    document.getElementById('resRemaining').innerText = new Intl.NumberFormat('id-ID').format(data.remaining_budget);
                    
                    const list = document.getElementById('routeList');
                    const hiddenInputs = document.getElementById('hiddenDestinasiInputs');
                    
                    document.getElementById('inputSaveBudget').value = budget;
                    list.innerHTML = '';
                    hiddenInputs.innerHTML = '';
                    
                    data.route.forEach((node, index) => {
                        // Tambahkan hidden input untuk form Simpan Perencanaan
                        hiddenInputs.insertAdjacentHTML('beforeend', `<input type="hidden" name="destinasi_ids[]" value="${node.id}">`);
                        
                        const isLast = index === data.route.length - 1;
                        
                        const itemHtml = `
                            <div class="flex items-center gap-3 py-2 bg-white rounded-xl px-4 border border-green-100/50 shadow-sm">
                                <div class="w-6 h-6 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-[10px] font-bold shrink-0">
                                    ${index + 1}
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-bold text-gray-800">${node.nama_destinasi}</p>
                                    <p class="text-[10px] text-gray-400">💵 Rp ${new Intl.NumberFormat('id-ID').format(node.harga)} · 📍 ${node.kota}</p>
                                </div>
                            </div>
                        `;
                        list.insertAdjacentHTML('beforeend', itemHtml);
                        
                        if (!isLast) {
                            const arrowHtml = `
                                <div class="pl-4 py-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" /></svg>
                                </div>
                            `;
                            list.insertAdjacentHTML('beforeend', arrowHtml);
                        }
                    });
                    
                    resultArea.classList.remove('hidden');
                } else {
                    throw new Error(data.message || 'Terjadi kesalahan');
                }
                
            } catch (error) {
                loading.classList.add('hidden');
                btnSubmit.disabled = false;
                document.getElementById('errorText').innerText = 'Gagal menemukan rute: ' + error.message;
                errorArea.classList.remove('hidden');
            }
        });
    </script>
</x-app-layout>
