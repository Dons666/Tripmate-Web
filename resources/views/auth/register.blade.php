<x-guest-layout>

    <!-- HEADER -->
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-extrabold text-slate-900">Buat Akun TripMate</h2>
        <p class="text-slate-500 mt-3 leading-relaxed">Mulai perjalananmu rencanakan dan dapatkan rekomendasi destinasi terbaik sesuai preferensimu.</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- NAMA -->
        <div class="mb-5">
            <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap</label>
            <x-text-input id="name" name="name" type="text" class="block w-full px-4 py-3 rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-sky-500 focus:ring-sky-500" :value="old('name')" required autofocus autocomplete="name" placeholder="Masukkan nama lengkap" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- EMAIL -->
        <div class="mb-5">
            <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
            <x-text-input id="email" name="email" type="email" class="block w-full px-4 py-3 rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-sky-500 focus:ring-sky-500" :value="old('email')" required autocomplete="username" placeholder="Masukkan email Anda" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- PASSWORD -->
        <div class="mb-5">
            <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
            <div class="relative mt-1">
                <x-text-input id="password" name="password" type="password" class="block w-full pr-12 rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-sky-500 focus:ring-sky-500" required autocomplete="new-password" placeholder="Minimal 8 karakter" />
                <button type="button" onclick="togglePw('password')" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition p-1">
                    <svg class="w-5 h-5 eye-password" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-1.274 7-9.542 7S4.057 19.458 0 16c1.274 4.057 5.064 7 9.542 7z"></path></svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- KONFIRMASI PASSWORD -->
        <div class="mb-6">
            <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-2">Konfirmasi Password</label>
            <div class="relative mt-1">
                <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="block w-full pr-12 rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-sky-500 focus:ring-sky-500" required autocomplete="new-password" placeholder="Ulangi password Anda" />
                <button type="button" onclick="togglePw('password_confirmation')" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition p-1">
                    <svg class="w-5 h-5 eye-password_confirmation" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-1.274 7-9.542 7S4.057 19.458 0 16c1.274 4.057 5.064 7 9.542 7z"></path></svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- BUTTON REGISTER -->
        <button type="submit" class="w-full py-3 rounded-xl bg-sky-600 hover:bg-sky-700 text-white font-bold transition duration-200 shadow-lg shadow-sky-500/20">
            Daftar & Mulai Perjalanan
        </button>

        <!-- DIVIDER -->
        <div class="relative my-8">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-slate-200"></div>
            </div>
            <div class="relative flex justify-center">
                <span class="bg-white px-4 text-sm text-slate-400">atau</span>
            </div>
        </div>

        <!-- LOGIN -->
        <div class="text-center bg-sky-50 rounded-xl p-4 border border-sky-100 mb-3">
            <span class="text-sm text-slate-500">Sudah punya akun?</span>
            <a href="{{ route('login') }}" class="font-bold text-sky-600 hover:text-sky-700 ml-1">Masuk Sekarang</a>
        </div>

        <!-- DAFTAR SEBAGAI TRAVEL -->
        <div class="text-center bg-slate-50 hover:bg-sky-50/50 rounded-xl p-4 border border-slate-200 hover:border-sky-200 transition">
            <span class="text-xs font-medium text-slate-500 block mb-1">Punya Usaha & Armada Travel?</span>
            <a href="{{ route('penyedia-travel.create') }}" class="font-bold text-sky-600 hover:text-sky-700 text-sm inline-flex items-center gap-1.5">
                <span>Daftar sebagai Penyedia Travel</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
        </div>

    </form>

</x-guest-layout>

<script>
function togglePw(fieldId) {
    const input = document.getElementById(fieldId);
    const btn = input.closest('.relative').querySelector('button svg');
    const isHidden = input.type === 'password';

    input.type = isHidden ? 'text' : 'password';

    if (!isHidden) {
        btn.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.593 0 5.487 5.487 0 011.593 0M6.05 15.25a3.375 3.375 0 016.75 0 3.375 3.375 0 016.75 0zM15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.056 14.333 4.78 19 12 19c4.78 0 8.944-4.667 10.066-6.777A10.523 10.523 0 0012 4.5c-4.78 0-8.944 4.667-10.066 6.777"></path>';
    } else {
        btn.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-1.274 7-9.542 7S4.057 19.458 0 16c1.274 4.057 5.064 7 9.542 7z"></path>';
    }
}
</script>