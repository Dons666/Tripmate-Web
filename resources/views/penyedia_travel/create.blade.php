<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Partner Travel - TripMate</title>
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
    <!-- Header -->
    <header class="bg-slate-900 text-white sticky top-0 z-50 border-b border-slate-800 shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="{{ route('home') }}" class="text-2xl font-extrabold text-sky-400 tracking-tight flex items-center gap-2">
                <span>TripMate</span>
                <span class="text-[10px] font-black px-2.5 py-0.5 bg-sky-500/20 text-sky-300 rounded-full border border-sky-500/30 uppercase">Partner Registration</span>
            </a>
            <a href="{{ route('register') }}" class="text-xs sm:text-sm font-bold text-slate-300 hover:text-white flex items-center gap-1.5 transition">
                <svg class="w-4 h-4 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Pendaftaran User
            </a>
        </div>
    </header>

    <!-- Main Container -->
    <main class="max-w-3xl mx-auto px-4 py-12 sm:px-6">
        <!-- Title Header -->
        <div class="text-center mb-10">
            <span class="inline-block px-3.5 py-1 bg-amber-500/10 border border-amber-500/20 text-amber-700 rounded-full text-xs font-black uppercase tracking-wider mb-3">
                Mitra Travel Resmi
            </span>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Daftarkan Usaha Travel Anda</h1>
            <p class="text-slate-500 mt-2 text-xs sm:text-sm max-w-lg mx-auto font-medium">
                Isi formulir pendaftaran di bawah ini. Setelah terdaftar, akun Anda akan masuk ke status <strong>Pending</strong> untuk diverifikasi (ACC) oleh Admin.
            </p>
        </div>

        <!-- Alert Error Summary -->
        @if ($errors->any())
            <div class="mb-8 bg-rose-50 border border-rose-200 p-5 rounded-3xl shadow-sm">
                <div class="flex items-center mb-2 text-rose-800 font-bold text-sm">
                    <svg class="w-5 h-5 text-rose-500 mr-2 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                    <span>Mohon periksa kembali kolom yang diisi:</span>
                </div>
                <ul class="list-disc pl-7 text-xs text-rose-700 space-y-1 font-medium">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Card -->
        <div class="bg-white rounded-3xl shadow-xl border border-slate-200/80 overflow-hidden">
            <div class="p-6 bg-slate-900 text-white border-b border-slate-800 flex items-center justify-between">
                <span class="text-xs font-black uppercase tracking-wider text-sky-400">Formulir Kemitraan</span>
                <span class="text-[11px] text-slate-400">Langkah 1 dari 1</span>
            </div>

            <form action="{{ route('penyedia-travel.store') }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-10 space-y-8">
                @csrf

                <!-- Section 1: Akun & Kontak -->
                <div class="space-y-6">
                    <h3 class="text-xs font-black uppercase tracking-wider text-sky-600 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-sky-500"></span> Data Akun & Pemilik
                    </h3>

                    <div>
                        <label for="nama_travel" class="block text-xs font-bold text-slate-700 mb-1.5">Nama Usaha Travel <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_travel" id="nama_travel" value="{{ old('nama_travel') }}" required
                            class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-xs font-semibold focus:border-sky-500 focus:ring-2 focus:ring-sky-200 transition shadow-sm"
                            placeholder="Contoh: Java Travel Express">
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-700 mb-1.5">Email Travel <span class="text-red-500">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                            class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-xs font-semibold focus:border-sky-500 focus:ring-2 focus:ring-sky-200 transition shadow-sm"
                            placeholder="Contoh: travel@domain.com">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="password" class="block text-xs font-bold text-slate-700 mb-1.5">Password <span class="text-red-500">*</span></label>
                            <input type="password" name="password" id="password" required minlength="8"
                                class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-xs font-semibold focus:border-sky-500 focus:ring-2 focus:ring-sky-200 transition shadow-sm"
                                placeholder="Minimal 8 karakter">
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-xs font-bold text-slate-700 mb-1.5">Konfirmasi Password <span class="text-red-500">*</span></label>
                            <input type="password" name="password_confirmation" id="password_confirmation" required minlength="8"
                                class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-xs font-semibold focus:border-sky-500 focus:ring-2 focus:ring-sky-200 transition shadow-sm"
                                placeholder="Ulangi password">
                        </div>
                    </div>

                    <div>
                        <label for="nomor_hp_pemilik_travel" class="block text-xs font-bold text-slate-700 mb-1.5">Nomor HP / WhatsApp Pemilik <span class="text-red-500">*</span></label>
                        <input type="tel" name="nomor_hp_pemilik_travel" id="nomor_hp_pemilik_travel" value="{{ old('nomor_hp_pemilik_travel') }}" required
                            class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-xs font-semibold focus:border-sky-500 focus:ring-2 focus:ring-sky-200 transition shadow-sm"
                            placeholder="Contoh: 081234567890">
                    </div>
                </div>

                <!-- Section 2: Legalitas & Upload -->
                <div class="pt-6 border-t border-slate-100 space-y-6">
                    <h3 class="text-xs font-black uppercase tracking-wider text-amber-600 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span> Berkas Verifikasi Legalitas
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200">
                            <label for="surat_izin_usaha_travel" class="block text-xs font-bold text-slate-800 mb-1.5">Surat Izin Usaha Travel <span class="text-red-500">*</span></label>
                            <input type="file" name="surat_izin_usaha_travel" id="surat_izin_usaha_travel" required
                                class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-sky-100 file:text-sky-700 hover:file:bg-sky-200 transition">
                            <p class="text-[11px] text-slate-400 mt-1.5">Format PDF, JPG, atau PNG (Maks 5MB).</p>
                        </div>

                        <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200">
                            <label for="ktp_pemilik" class="block text-xs font-bold text-slate-800 mb-1.5">KTP Pemilik Travel <span class="text-red-500">*</span></label>
                            <input type="file" name="ktp_pemilik" id="ktp_pemilik" required
                                class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-sky-100 file:text-sky-700 hover:file:bg-sky-200 transition">
                            <p class="text-[11px] text-slate-400 mt-1.5">Foto KTP pemilik travel (JPG, PNG, PDF).</p>
                        </div>
                    </div>
                </div>

                <!-- Submit Action Buttons -->
                <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a href="{{ route('register') }}" class="px-6 py-3 rounded-2xl border border-slate-300 text-xs font-bold text-slate-700 hover:bg-slate-50 transition">
                        Batal
                    </a>
                    <button type="submit" class="px-8 py-3.5 rounded-2xl bg-gradient-to-r from-sky-600 to-blue-600 hover:from-sky-700 hover:to-blue-700 text-white text-xs font-extrabold shadow-lg shadow-sky-600/30 transition flex items-center gap-2">
                        <span>Kirim Pendaftaran (Pending ACC)</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
