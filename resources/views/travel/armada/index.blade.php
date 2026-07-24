<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                🚐 Kelola Armada & Kapasitas Kursi
            </h2>
            <a href="{{ route('travel.dashboard') }}" class="text-sm font-semibold text-slate-600 hover:text-sky-600">
                ← Kembali ke Dashboard
            </a>
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

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- FORM TAMBAH ARMADA -->
                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm h-fit sticky top-24">
                    <h3 class="font-extrabold text-slate-800 mb-4 text-lg">➕ Tambah Armada Baru</h3>
                    <form action="{{ route('travel.armada.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-extrabold text-slate-500 uppercase tracking-wider mb-1">Nama Kendaraan</label>
                            <input type="text" name="nama_kendaraan" required placeholder="Cth: Toyota Hiace Commuter" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition">
                        </div>
                        <div>
                            <label class="block text-xs font-extrabold text-slate-500 uppercase tracking-wider mb-1">Nomor Polisi (Opsional)</label>
                            <input type="text" name="nomor_polisi" placeholder="Cth: D 1234 ABC" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition">
                        </div>
                        <div>
                            <label class="block text-xs font-extrabold text-slate-500 uppercase tracking-wider mb-1">Kapasitas Kursi (Penumpang)</label>
                            <input type="number" name="kapasitas_kursi" required min="1" placeholder="Cth: 15" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition">
                        </div>
                        <button type="submit" class="w-full bg-sky-600 hover:bg-sky-700 text-white font-extrabold text-sm py-3 rounded-xl transition shadow-md hover:shadow-lg">
                            Simpan Armada
                        </button>
                    </form>
                </div>

                <!-- DAFTAR ARMADA -->
                <div class="md:col-span-2 space-y-4">
                    <h3 class="font-extrabold text-slate-800 mb-4 text-lg">📋 Daftar Armada Anda</h3>
                    
                    @forelse($armadas as $armada)
                        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                            <div>
                                <h4 class="font-extrabold text-slate-800 text-lg">{{ $armada->nama_kendaraan }}</h4>
                                <div class="flex items-center gap-3 mt-1">
                                    <span class="bg-slate-100 text-slate-600 text-xs font-bold px-2.5 py-1 rounded-lg border border-slate-200">
                                        🎫 Plat: {{ $armada->nomor_polisi ?: '-' }}
                                    </span>
                                    <span class="bg-emerald-50 text-emerald-700 text-xs font-bold px-2.5 py-1 rounded-lg border border-emerald-200">
                                        💺 Kapasitas: {{ $armada->kapasitas_kursi }} Kursi
                                    </span>
                                </div>
                                <p class="text-xs text-slate-500 mt-2 font-medium">Terhubung dengan {{ $armada->travels()->count() }} Paket Travel</p>
                            </div>

                            <div class="flex items-center gap-2 w-full sm:w-auto">
                                <button type="button" onclick="editArmada({{ $armada->id }}, '{{ addslashes($armada->nama_kendaraan) }}', '{{ addslashes($armada->nomor_polisi) }}', {{ $armada->kapasitas_kursi }})" class="flex-1 sm:flex-none px-4 py-2 bg-amber-50 text-amber-700 hover:bg-amber-100 rounded-xl text-xs font-extrabold transition text-center border border-amber-200">
                                    Edit
                                </button>
                                <form action="{{ route('travel.armada.destroy', $armada) }}" method="POST" class="flex-1 sm:flex-none" onsubmit="return confirm('Yakin ingin menghapus armada ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full px-4 py-2 bg-rose-50 text-rose-700 hover:bg-rose-100 rounded-xl text-xs font-extrabold transition border border-rose-200">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white p-8 rounded-2xl border border-slate-200 text-center shadow-sm">
                            <div class="text-4xl mb-3">🚐</div>
                            <h4 class="font-extrabold text-slate-800 text-lg">Belum Ada Armada</h4>
                            <p class="text-sm text-slate-500 mt-1">Tambahkan kendaraan pertama Anda melalui form di samping.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL EDIT ARMADA -->
    <div id="editModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeEditModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-slate-200">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-extrabold text-gray-900 mb-4" id="modal-title">✏️ Edit Armada</h3>
                    <form id="editForm" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="block text-xs font-extrabold text-slate-500 uppercase tracking-wider mb-1">Nama Kendaraan</label>
                            <input type="text" id="edit_nama_kendaraan" name="nama_kendaraan" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                        </div>
                        <div>
                            <label class="block text-xs font-extrabold text-slate-500 uppercase tracking-wider mb-1">Nomor Polisi</label>
                            <input type="text" id="edit_nomor_polisi" name="nomor_polisi" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                        </div>
                        <div>
                            <label class="block text-xs font-extrabold text-slate-500 uppercase tracking-wider mb-1">Kapasitas Kursi</label>
                            <input type="number" id="edit_kapasitas_kursi" name="kapasitas_kursi" required min="1" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                        </div>
                        <div class="mt-5 sm:mt-6 sm:flex sm:flex-row-reverse gap-2">
                            <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-sky-600 text-base font-extrabold text-white hover:bg-sky-700 sm:text-sm">
                                Simpan Perubahan
                            </button>
                            <button type="button" onclick="closeEditModal()" class="mt-3 w-full inline-flex justify-center rounded-xl border border-slate-300 shadow-sm px-4 py-2 bg-white text-base font-bold text-slate-700 hover:bg-slate-50 sm:mt-0 sm:text-sm">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function editArmada(id, nama, plat, kapasitas) {
            document.getElementById('editForm').action = '/travel/armada/' + id;
            document.getElementById('edit_nama_kendaraan').value = nama;
            document.getElementById('edit_nomor_polisi').value = plat;
            document.getElementById('edit_kapasitas_kursi').value = kapasitas;
            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
