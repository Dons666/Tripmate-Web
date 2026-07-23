<x-guest-layout>

    <!-- HEADER -->
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-extrabold text-slate-900">Masuk ke Akun</h2>
        <p class="text-slate-500 mt-3 leading-relaxed">Temukan rekomendasi wisata terbaik di Bandung dan Jakarta sesuai preferensi perjalanan Anda.</p>
    </div>

    @if(session('appeal_success'))
        <div class="mb-5 bg-green-50 border border-green-200 text-green-800 p-4 rounded-xl text-sm font-medium">
            ✅ {{ session('appeal_success') }}
        </div>
    @endif

    @if(session('info'))
        <div class="mb-5 bg-sky-50 border border-sky-200 text-sky-800 p-4 rounded-xl text-sm font-medium">
            ℹ️ {{ session('info') }}
        </div>
    @endif

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

            @if($errors->has('email') && Str::contains($errors->first('email'), 'dinonaktifkan'))
                <div class="mt-3 p-3 bg-amber-50 border border-amber-200 rounded-xl text-xs text-amber-800">
                    <p class="font-bold mb-1">Akun Anda sedang dinonaktifkan oleh Admin.</p>
                    <button type="button" onclick="openAppealModal('{{ old('email') }}')" class="font-bold text-sky-600 hover:text-sky-800 underline cursor-pointer">
                        👉 Klik di sini untuk Ajukan Banding
                    </button>
                </div>
            @endif
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

        <!-- REGISTER & APPEAL LINK -->
        <div class="grid grid-cols-1 gap-2 text-center">
            <div class="bg-sky-50 rounded-xl p-4 border border-sky-100">
                <span class="text-sm text-slate-500">Baru di TripMate?</span>
                <a href="{{ route('register') }}" class="font-bold text-sky-600 hover:text-sky-700 ml-1">Buat Akun</a>
            </div>
            <button type="button" onclick="openAppealModal()" class="text-xs text-slate-500 hover:text-sky-600 font-medium py-1">
                Akun dinonaktifkan? <span class="text-sky-600 font-bold underline">Ajukan Banding Akun</span>
            </button>
        </div>

    </form>

    <!-- MODAL AJUKAN BANDING -->
    <div id="appealModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl relative border border-slate-100">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                <h3 class="text-lg font-bold text-slate-800">Form Ajukan Banding Akun</h3>
                <button type="button" onclick="closeAppealModal()" class="text-slate-400 hover:text-slate-600 p-1 text-xl font-bold">&times;</button>
            </div>

            <p class="text-xs text-slate-500 mb-4 leading-relaxed">
                Jika Anda merasa akun Anda dinonaktifkan secara keliru, silakan tuliskan alasan dan penjelasan peninjauan ulang untuk Tim Admin.
            </p>

            <form action="{{ route('appeal.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="appeal_email" class="block text-xs font-bold text-slate-700 mb-1">Email Akun</label>
                    <input type="email" id="appeal_email" name="email" required placeholder="Masukkan email akun Anda" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-sky-500 focus:border-sky-500 bg-slate-50">
                </div>

                <div class="mb-5">
                    <label for="appeal_reason" class="block text-xs font-bold text-slate-700 mb-1">Alasan & Penjelasan Banding</label>
                    <textarea id="appeal_reason" name="reason" rows="4" required minlength="10" placeholder="Jelaskan alasan mengapa akun Anda layak diaktifkan kembali..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-sky-500 focus:border-sky-500 bg-slate-50"></textarea>
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="closeAppealModal()" class="px-4 py-2 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-xl transition">Batal</button>
                    <button type="submit" class="px-5 py-2 text-xs font-bold text-white bg-sky-600 hover:bg-sky-700 rounded-xl transition shadow">Kirim Pengajuan Banding</button>
                </div>
            </form>
        </div>
    </div>

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
    function openAppealModal(email = '') {
        const modal = document.getElementById('appealModal');
        const emailInput = document.getElementById('appeal_email');
        if (email) {
            emailInput.value = email;
        }
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    }

    function closeAppealModal() {
        const modal = document.getElementById('appealModal');
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    }
</script>