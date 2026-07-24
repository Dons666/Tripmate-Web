<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ➕ Tambah Paket Perjalanan Baru
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-6 sm:p-8">
                    <form action="{{ route('travel.packages.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Nama Paket Wisata</label>
                            <input type="text" name="nama_travel" required class="w-full rounded-xl border-slate-300 focus:border-sky-500 focus:ring focus:ring-sky-200 transition" placeholder="Misal: Paket Wisata Lembang 3 Hari">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Deskripsi Singkat</label>
                            <textarea name="deskripsi" rows="3" required class="w-full rounded-xl border-slate-300 focus:border-sky-500 focus:ring focus:ring-sky-200 transition" placeholder="Jelaskan rute, itinerary, atau info menarik lainnya..."></textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1">Harga Paket (Per Pax)</label>
                                <input type="number" name="harga_paket" required min="0" class="w-full rounded-xl border-slate-300 focus:border-sky-500 focus:ring focus:ring-sky-200 transition" placeholder="Misal: 350000">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1">Tanggal Keberangkatan</label>
                                <input type="date" name="tanggal_keberangkatan" required min="{{ date('Y-m-d') }}" class="w-full rounded-xl border-slate-300 focus:border-sky-500 focus:ring focus:ring-sky-200 transition">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1">Kota / Destinasi Utama</label>
                                <input type="text" name="kota" required class="w-full rounded-xl border-slate-300 focus:border-sky-500 focus:ring focus:ring-sky-200 transition" placeholder="Misal: Bandung">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1">Layanan / Fasilitas</label>
                                <input type="text" name="layanan" required class="w-full rounded-xl border-slate-300 focus:border-sky-500 focus:ring focus:ring-sky-200 transition" placeholder="Misal: Hiace 14 Seat, AC, Driver">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1">Nomor Kontak (WhatsApp)</label>
                                <input type="text" name="kontak" required class="w-full rounded-xl border-slate-300 focus:border-sky-500 focus:ring focus:ring-sky-200 transition" placeholder="Misal: 08123456789">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-bold text-slate-700 mb-1">Armada / Kendaraan Utama</label>
                                <select name="armada_id" required class="w-full rounded-xl border-slate-300 focus:border-sky-500 focus:ring focus:ring-sky-200 transition">
                                    <option value="">-- Pilih Armada --</option>
                                    @foreach($armadas as $armada)
                                        <option value="{{ $armada->id }}">{{ $armada->nama_kendaraan }} (Kapasitas: {{ $armada->kapasitas_kursi }} Kursi)</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-4">
                            <h4 class="font-bold text-slate-700">Pilih Rute Perjalanan</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label class="block text-xs font-bold text-sky-700 mb-1">🏞️ Destinasi Wisata</label>
                                    <select name="wisata_ids[]" multiple class="w-full rounded-xl border-slate-300 focus:border-sky-500 focus:ring focus:ring-sky-200 transition text-sm" style="height: 120px;">
                                        @foreach($wisatas as $dest)
                                            <option value="{{ $dest->id }}">{{ $dest->nama_destinasi }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-amber-600 mb-1">🍽️ Destinasi Kuliner</label>
                                    <select name="kuliner_ids[]" multiple class="w-full rounded-xl border-slate-300 focus:border-amber-500 focus:ring focus:ring-amber-200 transition text-sm" style="height: 120px;">
                                        @foreach($kuliners as $dest)
                                            <option value="{{ $dest->id }}">{{ $dest->nama_destinasi }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-indigo-600 mb-1">🏨 Penginapan (Hotel/Villa)</label>
                                    <select name="penginapan_ids[]" multiple class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 transition text-sm" style="height: 120px;">
                                        @foreach($penginapans as $dest)
                                            <option value="{{ $dest->id }}">{{ $dest->nama_destinasi }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <p class="text-[10px] text-slate-500">Tahan tombol Ctrl (Windows) atau Cmd (Mac) untuk memilih lebih dari satu pada masing-masing kategori.</p>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Foto / Poster Paket</label>
                            <input type="file" name="gambar" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100 transition">
                            <p class="text-xs text-slate-400 mt-1">Upload gambar menarik agar user tertarik memesan (opsional).</p>
                        </div>

                        <div class="pt-6 border-t border-slate-100 flex gap-3">
                            <button type="submit" class="px-6 py-3 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl font-bold transition flex items-center gap-2">
                                ✅ Simpan Paket
                            </button>
                            <a href="{{ route('travel.dashboard') }}" class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl font-bold transition">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
