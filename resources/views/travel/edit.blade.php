<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil Travel - TripMate</title>
    <!-- Google Fonts Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 font-sans text-slate-800 antialiased min-h-screen">
    <!-- Navbar Top -->
    <header class="bg-slate-900 text-white sticky top-0 z-50 border-b border-slate-800 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="{{ route('travel.dashboard') }}" class="text-2xl font-extrabold text-sky-400 tracking-tight flex items-center gap-2">
                <span>TripMate</span>
                <span class="text-[10px] font-black px-2.5 py-0.5 bg-sky-500/20 text-sky-300 rounded-full border border-sky-500/30 uppercase">Edit Profile</span>
            </a>
            <a href="{{ route('travel.dashboard') }}" class="text-xs sm:text-sm font-bold text-slate-300 hover:text-white flex items-center gap-1.5 transition">
                <svg class="w-4 h-4 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Dashboard
            </a>
        </div>
    </header>

    <!-- Main Container -->
    <main class="max-w-5xl mx-auto px-4 py-8 sm:px-6">
        
        <!-- Header Info Notice -->
        <div style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: #ffffff;" class="rounded-3xl p-6 sm:p-8 shadow-xl mb-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
            <div>
                <span class="px-3 py-1 bg-amber-500/20 text-amber-300 rounded-full text-[10px] font-black uppercase tracking-wider mb-2 inline-block border border-amber-500/30">
                    ℹ️ Verifikasi Perubahan Admin
                </span>
                <h1 class="text-2xl font-extrabold text-white">Formulir Perubahan Data Travel</h1>
                <p class="text-xs sm:text-sm text-slate-300 mt-1 max-w-xl">
                    Perubahan data profil atau armada akan dikirim ke Admin untuk diverifikasi (ACC). <strong>Akun Anda tetap aktif</strong> dan dapat digunakan seperti biasa.
                </p>
            </div>
            <a href="{{ route('travel.dashboard') }}" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-700 text-slate-200 rounded-xl text-xs font-bold transition border border-slate-700 shrink-0">
                Batal & Kembali
            </a>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-3xl shadow-xl border border-slate-200/80 overflow-hidden">
            <div class="p-6 bg-slate-900 text-white border-b border-slate-800 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="text-xl">✏️</span>
                    <div>
                        <h2 class="text-base font-bold">Edit Detail Usaha & Armada Travel</h2>
                        <p class="text-xs text-slate-400">Pastikan seluruh data yang Anda masukkan sudah benar dan akurat.</p>
                    </div>
                </div>
            </div>

            <form action="{{ route('travel.dashboard.update') }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-8">
                @csrf

                <!-- Section 1: Informasi Usaha -->
                <div>
                    <h3 class="text-xs font-black uppercase tracking-wider text-sky-600 mb-4 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-sky-500"></span> 1. Informasi Utama Usaha
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="nama_travel" class="block text-xs font-bold text-slate-700 mb-1.5">Nama Usaha Travel <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_travel" id="nama_travel" value="{{ old('nama_travel', $penyediaTravel->nama_travel ?? '') }}" required
                                class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-xs font-semibold focus:border-sky-500 focus:ring-2 focus:ring-sky-200 transition shadow-sm"
                                placeholder="Contoh: Java Travel Express">
                        </div>

                        <div>
                            <label for="email" class="block text-xs font-bold text-slate-700 mb-1.5">Email Akun (Read-only)</label>
                            <input type="email" value="{{ $penyediaTravel->email ?? Auth::user()->email }}" disabled
                                class="w-full rounded-2xl border border-slate-200 bg-slate-100 text-slate-500 px-4 py-3 text-xs font-semibold cursor-not-allowed">
                        </div>

                        <div>
                            <label for="kota_asal_travel" class="block text-xs font-bold text-slate-700 mb-1.5">Kota Asal / Area Operasional</label>
                            <input type="text" name="kota_asal_travel" id="kota_asal_travel" value="{{ old('kota_asal_travel', $penyediaTravel->kota_asal_travel ?? '') }}"
                                class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-xs font-semibold focus:border-sky-500 focus:ring-2 focus:ring-sky-200 transition shadow-sm"
                                placeholder="Contoh: Surabaya, Malang, Jakarta">
                        </div>

                        <div>
                            <label for="nomor_hp_pemilik_travel" class="block text-xs font-bold text-slate-700 mb-1.5">Nomor HP / WhatsApp Pemilik <span class="text-red-500">*</span></label>
                            <input type="tel" name="nomor_hp_pemilik_travel" id="nomor_hp_pemilik_travel" value="{{ old('nomor_hp_pemilik_travel', $penyediaTravel->nomor_hp_pemilik_travel ?? '') }}" required
                                class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-xs font-semibold focus:border-sky-500 focus:ring-2 focus:ring-sky-200 transition shadow-sm"
                                placeholder="Contoh: 081234567890">
                        </div>

                        <div class="sm:col-span-2">
                            <label for="alamat_travel" class="block text-xs font-bold text-slate-700 mb-1.5">Alamat Lengkap Kantor / Garasi Travel</label>
                            <textarea name="alamat_travel" id="alamat_travel" rows="2"
                                class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-xs font-semibold focus:border-sky-500 focus:ring-2 focus:ring-sky-200 transition shadow-sm"
                                placeholder="Jalan, No, RT/RW, Kecamatan, Kabupaten/Kota">{{ old('alamat_travel', $penyediaTravel->alamat_travel ?? '') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Multi-Armada, Harga, & Foto Per Jenis -->
                <div class="pt-6 border-t border-slate-100">
                    <h3 class="text-xs font-black uppercase tracking-wider text-indigo-600 mb-4 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-indigo-500"></span> 2. Armada Kendaraan, Tarif, & Foto
                    </h3>

                    <div class="bg-slate-50/80 p-5 sm:p-6 rounded-3xl border border-slate-200/80 space-y-4 shadow-sm">
                        <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 12px; border-bottom: 1px solid #e2e8f0; margin-bottom: 16px;">
                            <div>
                                <h4 style="font-size: 14px; font-weight: 800; color: #0f172a; margin: 0;">Daftar Kendaraan, Tarif, & Foto Khusus Armada</h4>
                                <p style="font-size: 11px; color: #64748b; margin: 2px 0 0 0;">Isi jumlah unit, nama armada, tarif sewa, dan unggah foto khusus per jenis kendaraan.</p>
                            </div>
                            <button type="button" onclick="addVehicleRow()" style="background: #0284c7; color: #ffffff !important; border: none; padding: 8px 16px; border-radius: 10px; font-weight: 800; font-size: 12px; cursor: pointer; box-shadow: 0 4px 6px -1px rgba(2, 132, 199, 0.3);">
                                + Tambah Kendaraan
                            </button>
                        </div>

                        <!-- Dynamic Rows Container -->
                        <div id="vehicle-rows-container" class="space-y-4">
                            <!-- Dynamic rows injected by JS -->
                        </div>

                        <!-- Hidden fields for model compatibility -->
                        <input type="hidden" name="jenis_kendaraan" id="jenis_kendaraan_hidden">
                        <input type="hidden" name="harga" id="harga_hidden" value="{{ old('harga', $penyediaTravel->harga ?? 0) }}">
                    </div>
                </div>

                <!-- Section 3: Hari Operasional (Senin - Minggu Toggle) & Rekening -->
                <div class="pt-6 border-t border-slate-100">
                    <h3 class="text-xs font-black uppercase tracking-wider text-emerald-600 mb-4 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span> 3. Hari Operasional & Pembayaran
                    </h3>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Day Status Selector -->
                        <div class="lg:col-span-2" style="background: #ffffff; padding: 20px; border-radius: 20px; border: 1px solid #cbd5e1; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                            <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 12px; border-bottom: 1px solid #f1f5f9; margin-bottom: 12px;">
                                <div>
                                    <h4 style="font-size: 14px; font-weight: 800; color: #0f172a; margin: 0;">Status Hari Operasional (Senin - Minggu)</h4>
                                    <p style="font-size: 11px; color: #64748b; margin: 2px 0 0 0;">Klik tombol hari untuk mengubah status <strong>Buka (🟢)</strong> atau <strong>Libur (🔴)</strong>.</p>
                                </div>
                                <div style="display: flex; gap: 8px; align-items: center;">
                                    <button type="button" onclick="setAllDays(true)" style="background: #dcfce7; color: #15803d; border: 1px solid #86efac; padding: 6px 12px; border-radius: 10px; font-weight: 800; font-size: 11px; cursor: pointer;">
                                        Semua Buka
                                    </button>
                                    <button type="button" onclick="setAllDays(false)" style="background: #ffe4e6; color: #be123c; border: 1px solid #fda4af; padding: 6px 12px; border-radius: 10px; font-weight: 800; font-size: 11px; cursor: pointer;">
                                        Semua Libur
                                    </button>
                                </div>
                            </div>

                            <!-- 7 Day Badges Toggle Grid -->
                            <div id="day-toggles-container" style="display: flex; flex-wrap: wrap; gap: 10px; margin: 14px 0;">
                                <!-- Rendered dynamically by JS -->
                            </div>

                            <!-- Summary preview text -->
                            <div style="display: flex; align-items: center; justify-content: space-between; font-size: 12px; padding-top: 10px; border-top: 1px solid #f1f5f9;">
                                <span style="color: #64748b; font-weight: 600;">Ringkasan Jadwal:</span>
                                <span id="schedule-preview-badge" style="font-weight: 800; color: #047857; background: #ecfdf5; padding: 6px 14px; border-radius: 10px; border: 1px solid #a7f3d0;">
                                    Setiap Hari (Senin - Minggu)
                                </span>
                            </div>

                            <!-- Hidden Input for Form Submission -->
                            <input type="hidden" name="jadwal_ketersediaan" id="jadwal_ketersediaan_hidden" value="{{ old('jadwal_ketersediaan', $penyediaTravel->jadwal_ketersediaan ?? '') }}">
                        </div>

                        <!-- Rekening Bank -->
                        <div>
                            <label for="rekening" class="block text-xs font-bold text-slate-700 mb-1.5">Nomor Rekening Bank Pembayaran</label>
                            <input type="text" name="rekening" id="rekening" value="{{ old('rekening', $penyediaTravel->rekening ?? '') }}"
                                class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-xs font-semibold focus:border-sky-500 focus:ring-2 focus:ring-sky-200 transition shadow-sm"
                                placeholder="Contoh: BCA 1234567890 a.n Nama Pemilik">
                        </div>
                    </div>
                </div>

                <!-- Section 4: Dokumen Uploads -->
                <div class="pt-6 border-t border-slate-100">
                    <h3 class="text-xs font-black uppercase tracking-wider text-amber-600 mb-4 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span> 4. Berkas Legalitas Usaha
                    </h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200">
                            <label class="block text-xs font-bold text-slate-800 mb-1.5">Surat Izin Usaha Travel</label>
                            @if(isset($penyediaTravel->surat_izin_usaha_travel) && $penyediaTravel->surat_izin_usaha_travel)
                                <div class="text-xs text-emerald-600 font-bold mb-2 flex items-center gap-1">
                                    <span>✓ Berkas Terunggah</span>
                                </div>
                            @endif
                            <input type="file" name="surat_izin_usaha_travel" class="text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-sky-100 file:text-sky-700 hover:file:bg-sky-200 transition">
                        </div>

                        <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200">
                            <label class="block text-xs font-bold text-slate-800 mb-1.5">KTP Pemilik Travel</label>
                            @if(isset($penyediaTravel->ktp_pemilik) && $penyediaTravel->ktp_pemilik)
                                <div class="text-xs text-emerald-600 font-bold mb-2 flex items-center gap-1">
                                    <span>✓ KTP Terunggah</span>
                                </div>
                            @endif
                            <input type="file" name="ktp_pemilik" class="text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-sky-100 file:text-sky-700 hover:file:bg-sky-200 transition">
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-6 border-t border-slate-100 flex items-center justify-between gap-4">
                    <a href="{{ route('travel.dashboard') }}" class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-2xl text-xs transition">
                        Batal
                    </a>
                    <button type="submit" class="px-8 py-3.5 bg-gradient-to-r from-sky-600 to-blue-600 hover:from-sky-700 hover:to-blue-700 text-white font-extrabold rounded-2xl text-xs sm:text-sm transition shadow-lg shadow-sky-600/30 flex items-center gap-2">
                        <span>Simpan Perubahan Data</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </button>
                </div>
            </form>
        </div>
    </main>

    <!-- JS for Dynamic Vehicle + Day Status Toggle -->
    <script>
        const initialRawVehicle = @json($penyediaTravel->jenis_kendaraan ?? '');
        const initialDefaultPrice = @json($penyediaTravel->harga ?? 0);
        const initialFotosArray = @json($penyediaTravel->fotos_array ?? []);
        let vehicleRowCounter = 0;

        function parseInitialVehicles(rawStr, defaultPrice, photosArray = []) {
            if (!rawStr) return [{ qty: '1', name: '', seats: '', price: '', photo: '' }];
            const items = rawStr.split(',');
            const parsed = [];
            items.forEach((item, index) => {
                let str = item.trim();
                if (!str) return;

                let qty = '1';
                const qtyMatch = str.match(/^(\d+)\s*Unit\s+(.*)$/i);
                if (qtyMatch) {
                    qty = qtyMatch[1];
                    str = qtyMatch[2].trim();
                }

                const photo = (photosArray && photosArray[index]) ? photosArray[index] : '';

                let name = str;
                let price = defaultPrice > 0 ? defaultPrice : '';
                let seats = '';

                // Extract Price (Rp ...)
                const priceMatch = str.match(/^(.*?)\s*\((?:Rp\s*)?([\d\.]+)\)$/i);
                if (priceMatch) {
                    name = priceMatch[1].trim();
                    price = priceMatch[2].replace(/\./g, '');
                }

                // Extract Seats/Capacity (e.g. (14 Kursi) or (14 Orang))
                const seatsMatch = name.match(/^(.*?)\s*\((?:(\d+)\s*(?:Kursi|Orang|Pax|Seat))\)$/i) || name.match(/^(.*?)\s*[-–]\s*(\d+)\s*(?:Kursi|Orang|Pax|Seat)/i);
                if (seatsMatch) {
                    name = seatsMatch[1].trim();
                    seats = seatsMatch[2];
                }

                parsed.push({ qty: qty, name: name, seats: seats, price: price, photo: photo });
            });
            return parsed.length > 0 ? parsed : [{ qty: '1', name: '', seats: '', price: '', photo: '' }];
        }

        function createRowHTML(qty = '1', name = '', seats = '', price = '', photo = '') {
            const rowIndex = vehicleRowCounter++;
            const photoPreview = photo ? `
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
                    <img src="/storage/${photo}" alt="Foto Armada" style="width: 44px; height: 44px; object-fit: cover; border-radius: 10px; border: 1.5px solid #059669; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <div>
                        <span style="font-size: 11px; color: #059669; font-weight: 800; display: block;">✓ Foto Terunggah</span>
                        <span style="font-size: 10px; color: #64748b;">Pilih file baru jika ingin mengganti</span>
                    </div>
                    <input type="hidden" name="existing_foto_armada[${rowIndex}]" value="${photo}">
                </div>
            ` : '';

            return `
                <div class="vehicle-row" style="background: #ffffff; padding: 18px; border-radius: 20px; border: 1.5px solid #cbd5e1; box-shadow: 0 2px 4px rgba(0,0,0,0.03); margin-bottom: 14px; position: relative;">
                    <button type="button" onclick="removeVehicleRow(this)" style="position: absolute; top: 14px; right: 14px; background: #fef2f2; color: #ef4444; border: 1px solid #fca5a5; width: 32px; height: 32px; border-radius: 10px; font-weight: 800; font-size: 14px; cursor: pointer; display: flex; align-items: center; justify-content: center;" title="Hapus Kendaraan Ini">
                        ✕
                    </button>
                    <div style="display: flex; flex-direction: row; gap: 16px; align-items: flex-start; flex-wrap: wrap;">
                        <!-- Left Inputs -->
                        <div style="flex: 2; min-width: 260px; display: flex; flex-direction: column; gap: 12px;">
                            <div style="display: flex; gap: 10px;">
                                <div style="width: 80px; shrink: 0;">
                                    <label style="display: block; font-size: 11px; font-weight: 700; color: #475569; margin-bottom: 4px;">Jumlah Unit</label>
                                    <input type="number" class="v-qty" style="width: 100%; border: 1px solid #94a3b8; border-radius: 10px; padding: 9px 8px; font-size: 13px; font-weight: 800; color: #0f172a; outline: none; background: #ffffff; text-align: center; box-sizing: border-box;"
                                        placeholder="1" value="${qty || 1}" min="1" step="1">
                                </div>
                                <div style="flex: 1;">
                                    <label style="display: block; font-size: 11px; font-weight: 700; color: #475569; margin-bottom: 4px;">Nama Kendaraan / Armada</label>
                                    <input type="text" class="v-name" style="width: 100%; border: 1px solid #94a3b8; border-radius: 10px; padding: 9px 12px; font-size: 13px; font-weight: 600; color: #0f172a; outline: none; background: #ffffff; box-sizing: border-box;"
                                        placeholder="Contoh: Toyota HiAce Commuter" value="${name}">
                                </div>
                            </div>
                            <div style="display: flex; gap: 10px;">
                                <div style="width: 120px; shrink: 0;">
                                    <label style="display: block; font-size: 11px; font-weight: 700; color: #475569; margin-bottom: 4px;">Kapasitas (Orang)</label>
                                    <input type="number" class="v-seats" style="width: 100%; border: 1px solid #94a3b8; border-radius: 10px; padding: 9px 8px; font-size: 13px; font-weight: 800; color: #0f172a; outline: none; background: #ffffff; text-align: center; box-sizing: border-box;"
                                        placeholder="14" value="${seats || ''}" min="1" step="1">
                                </div>
                                <div style="flex: 1;">
                                    <label style="display: block; font-size: 11px; font-weight: 700; color: #475569; margin-bottom: 4px;">Tarif Sewa Per Hari</label>
                                    <div style="position: relative; display: flex; align-items: center; width: 100%;">
                                        <span style="position: absolute; left: 12px; font-size: 13px; font-weight: 800; color: #0284c7; z-index: 10; pointer-events: none;">Rp</span>
                                        <input type="number" class="v-price" style="width: 100%; border: 1px solid #94a3b8; border-radius: 10px; padding: 9px 12px 9px 38px; font-size: 13px; font-weight: 800; color: #0f172a; outline: none; background: #ffffff; box-sizing: border-box;"
                                            placeholder="350000" value="${price}" min="0" step="1000">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Photo Box -->
                        <div style="flex: 1; min-width: 200px; background: #f8fafc; padding: 12px; border-radius: 14px; border: 1px dashed #cbd5e1; display: flex; flex-direction: column; justify-content: center; gap: 6px;">
                            <label style="display: block; font-size: 11px; font-weight: 700; color: #334155;">Foto Kendaraan Ini</label>
                            ${photoPreview}
                            <input type="file" name="foto_armada[${rowIndex}]" accept="image/*" style="font-size: 11px; width: 100%; color: #64748b;">
                        </div>
                    </div>
                </div>
            `;
        }

        function addVehicleRow(qty = '1', name = '', seats = '', price = '', photo = '') {
            const container = document.getElementById('vehicle-rows-container');
            container.insertAdjacentHTML('beforeend', createRowHTML(qty, name, seats, price, photo));
        }

        function removeVehicleRow(btn) {
            const rows = document.querySelectorAll('.vehicle-row');
            if (rows.length > 1) {
                btn.closest('.vehicle-row').remove();
            } else {
                const inputs = btn.closest('.vehicle-row').querySelectorAll('input');
                inputs.forEach(i => i.value = '');
            }
        }

        // Day Status Toggle Logic
        const daysOfWeek = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        let dayStatus = {
            'Senin': true,
            'Selasa': true,
            'Rabu': true,
            'Kamis': true,
            'Jumat': true,
            'Sabtu': true,
            'Minggu': true
        };

        const initialScheduleStr = @json($penyediaTravel->jadwal_ketersediaan ?? '');

        function initScheduleStatus() {
            if (initialScheduleStr) {
                if (initialScheduleStr.toLowerCase().includes('libur')) {
                    daysOfWeek.forEach(day => {
                        const regex = new RegExp(day + '\\s*:\\s*Libur', 'i');
                        if (regex.test(initialScheduleStr) || initialScheduleStr.includes(`Libur: ${day}`)) {
                            dayStatus[day] = false;
                        }
                    });
                } else if (initialScheduleStr.toLowerCase().includes('buka:')) {
                    daysOfWeek.forEach(day => {
                        dayStatus[day] = initialScheduleStr.includes(day);
                    });
                }
            }
            renderDayToggles();
        }

        function renderDayToggles() {
            const container = document.getElementById('day-toggles-container');
            if (!container) return;
            container.innerHTML = '';
            
            daysOfWeek.forEach(day => {
                const isBuka = dayStatus[day];
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.onclick = () => toggleDay(day);
                btn.style.cssText = isBuka 
                    ? 'flex: 1 1 80px; max-width: 110px; background: #ecfdf5; color: #047857; border: 1.5px solid #a7f3d0; padding: 10px 8px; border-radius: 14px; font-weight: 700; font-size: 12px; cursor: pointer; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 5px; transition: all 0.2s; box-shadow: 0 1px 2px rgba(0,0,0,0.03);'
                    : 'flex: 1 1 80px; max-width: 110px; background: #fef2f2; color: #b91c1c; border: 1.5px solid #fca5a5; padding: 10px 8px; border-radius: 14px; font-weight: 700; font-size: 12px; cursor: pointer; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 5px; transition: all 0.2s; box-shadow: 0 1px 2px rgba(0,0,0,0.03);';
                
                btn.innerHTML = `
                    <span style="font-size: 12px; font-weight: 800; color: #0f172a;">${day}</span>
                    <span style="font-size: 10px; font-weight: 900; text-transform: uppercase; padding: 3px 8px; border-radius: 8px; background: ${isBuka ? '#d1fae5' : '#fee2e2'}; color: ${isBuka ? '#047857' : '#b91c1c'}; border: 1px solid ${isBuka ? '#6ee7b7' : '#fca5a5'};">
                        ${isBuka ? '🟢 Buka' : '🔴 Libur'}
                    </span>
                `;
                container.appendChild(btn);
            });

            updateHiddenSchedule();
        }

        function toggleDay(day) {
            dayStatus[day] = !dayStatus[day];
            renderDayToggles();
        }

        function setAllDays(val) {
            daysOfWeek.forEach(d => dayStatus[d] = val);
            renderDayToggles();
        }

        function updateHiddenSchedule() {
            const bukaDays = daysOfWeek.filter(d => dayStatus[d]);
            const liburDays = daysOfWeek.filter(d => !dayStatus[d]);
            
            let result = '';
            if (bukaDays.length === 7) {
                result = 'Setiap Hari (Senin - Minggu)';
            } else if (bukaDays.length === 0) {
                result = 'Tutup (Sementara)';
            } else {
                let parts = [];
                if (bukaDays.length > 0) parts.push(`Buka: ${bukaDays.join(', ')}`);
                if (liburDays.length > 0) parts.push(`Libur: ${liburDays.join(', ')}`);
                result = parts.join(' | ');
            }
            
            const hiddenInput = document.getElementById('jadwal_ketersediaan_hidden');
            if (hiddenInput) hiddenInput.value = result;

            const previewBadge = document.getElementById('schedule-preview-badge');
            if (previewBadge) previewBadge.innerText = result;
        }

        document.addEventListener('DOMContentLoaded', () => {
            initScheduleStatus();
            const initialData = parseInitialVehicles(initialRawVehicle, initialDefaultPrice, initialFotosArray);
            initialData.forEach(item => addVehicleRow(item.qty, item.name, item.seats, item.price, item.photo));

            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', (e) => {
                    const qtys = document.querySelectorAll('.v-qty');
                    const names = document.querySelectorAll('.v-name');
                    const seatsList = document.querySelectorAll('.v-seats');
                    const prices = document.querySelectorAll('.v-price');
                    const combined = [];
                    let firstPrice = 0;

                    names.forEach((nameInput, index) => {
                        const nameVal = nameInput.value.trim();
                        const priceVal = prices[index] ? prices[index].value.trim() : '';
                        const qtyVal = qtys[index] ? qtys[index].value.trim() : '1';
                        const seatsVal = seatsList[index] ? seatsList[index].value.trim() : '';

                        if (nameVal) {
                            let formattedSeats = (seatsVal && Number(seatsVal) > 0) ? ` (${seatsVal} Kursi)` : '';
                            let formattedPrice = '';
                            if (priceVal && !isNaN(priceVal) && Number(priceVal) > 0) {
                                const numPrice = Number(priceVal);
                                if (firstPrice === 0) firstPrice = numPrice;
                                formattedPrice = ` (Rp ${numPrice.toLocaleString('id-ID')})`;
                            }
                            const unitPrefix = (qtyVal && Number(qtyVal) > 0) ? `${qtyVal} Unit ` : '';
                            combined.push(`${unitPrefix}${nameVal}${formattedSeats}${formattedPrice}`);
                        }
                    });

                    document.getElementById('jenis_kendaraan_hidden').value = combined.join(', ');
                    if (firstPrice > 0) {
                        document.getElementById('harga_hidden').value = firstPrice;
                    }
                });
            }
        });
    </script>
</body>
</html>
