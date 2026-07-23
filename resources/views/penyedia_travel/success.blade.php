<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Berhasil - TripMate Partner</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans text-slate-800 antialiased min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-white rounded-3xl shadow-2xl border border-slate-100 p-8 text-center">
        <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
        </div>
        <h1 class="text-2xl font-extrabold text-slate-900 mb-2">Pendaftaran Terkirim!</h1>
        <p class="text-slate-600 text-sm mb-6 leading-relaxed">
            Terima kasih telah mendaftarkan usaha travel Anda di TripMate. Data & berkas Anda telah tersimpan dan sedang ditinjau oleh tim administrator kami.
        </p>

        <div class="space-y-3">
            <a href="{{ route('home') }}" class="block w-full py-3 bg-sky-600 hover:bg-sky-700 text-white font-bold rounded-xl text-sm transition shadow-lg shadow-sky-600/30">
                Kembali ke Beranda
            </a>
            <a href="{{ route('penyedia-travel.create') }}" class="block w-full py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl text-sm transition">
                Daftarkan Travel Lain
            </a>
        </div>
    </div>
</body>
</html>
