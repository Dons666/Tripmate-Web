<x-guest-layout>

    <!-- HEADER -->
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-extrabold text-slate-900">Masuk ke Akun</h2>
        <p class="text-slate-500 mt-3 leading-relaxed">Temukan rekomendasi wisata terbaik di Bandung dan Jakarta sesuai preferensi perjalanan Anda.</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- EMAIL -->
        <div class="mb-5">
            <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
            <x-text-input
                id="email"
                class="block w-full px-4 py-3 rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-sky-500 focus:ring-sky-500"
                type="email"
                name="email"
                :value="old('email')"
                required
                autofocus
                autocomplete="username"
                placeholder="Masukkan email Anda" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- PASSWORD -->
        <div class="mb-5">
            <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
            <div class="relative">
                <x-text-input
                    id="password"
                    class="block w-full px-4 py-3 pr-12 rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-sky-500 focus:ring-sky-500"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="Masukkan password" />
                <button
                    type="button"
                    onclick="togglePassword()"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition p-1"
                    id="togglePwBtn">
                    <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-1.274 7-9.542 7S4.057 19.458 0 16c1.274 4.057 5.064 7 9.542 7z"></path></svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- REMEMBER -->
        <div class="flex items-center justify-between mb-6">
            <label class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-sky-600 shadow-sm focus:ring-sky-500" name="remember">
                <span class="ml-2 text-sm text-slate-600">Ingat saya</span>
            </label>
            @if (Route::has('password.request'))
                <a class="text-sm font-medium text-sky-600 hover:text-sky-700" href="{{ route('password.request') }}">Lupa Password?</a>
            @endif
        </div>

        <!-- BUTTON LOGIN -->
        <button type="submit" class="w-full py-3 rounded-xl bg-sky-600 hover:bg-sky-700 text-white font-bold transition duration-200 shadow-lg shadow-sky-500/20">
            Masuk & Jelajahi Destinasi
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

        <!-- REGISTER -->
        <div class="text-center bg-sky-50 rounded-xl p-4 border border-sky-100">
            <span class="text-sm text-slate-500">Baru di TripMate?</span>
            <a href="{{ route('register') }}" class="font-bold text-sky-600 hover:text-sky-700 ml-1">Buat Akun</a>
        </div>

    </form>

</x-guest-layout>

<script>
    function togglePassword() {
        const pw = document.getElementById('password');
        const btn = document.getElementById('togglePwBtn');
        
        if (pw.type === 'password') {
            pw.type = 'text';
            btn.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.593 0 5.487 5.487 0 011.593 0M6.05 15.25a3.375 3.375 0 016.75 0 3.375 3.375 0 016.75 0zM15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.056 14.333 4.78 19 12 19c4.78 0 8.944-4.667 10.066-6.777A10.523 10.523 0 0012 4.5c-4.78 0-8.944 4.667-10.066 6.777"></path></svg>';
        } else {
            pw.type = 'password';
            btn.innerHTML = '<svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-1.274 7-9.542 7S4.057 19.458 0 16c1.274 4.057 5.064 7 9.542 7z"></path></svg>';
        }
    }
</script>