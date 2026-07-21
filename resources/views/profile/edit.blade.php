<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profil Saya') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Header Profil dengan Avatar -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 flex flex-col md:flex-row items-center gap-6">
                @if(Auth::user()->avatar)
                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" class="w-24 h-24 rounded-full object-cover shadow-inner border-4 border-sky-100">
                @else
                    <div class="w-24 h-24 bg-sky-100 text-sky-600 rounded-full flex items-center justify-center text-4xl font-extrabold shadow-inner">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @endif

                <div class="text-center md:text-left flex-1">
                    <h3 class="text-2xl font-bold text-gray-900">{{ Auth::user()->name }}</h3>
                    <p class="text-gray-500 text-sm">{{ Auth::user()->email }}</p>
                    <span class="mt-2 inline-block px-3 py-1 text-xs font-semibold rounded-full {{ Auth::user()->role === 'admin' ? 'bg-red-100 text-red-600' : 'bg-sky-100 text-sky-600' }}">
                        {{ ucfirst(Auth::user()->role) }}
                    </span>
                </div>
                <a href="{{ route('preference.create') }}" class="bg-sky-50 text-sky-600 font-medium px-5 py-2.5 rounded-xl hover:bg-sky-100 transition text-sm flex items-center gap-2">
                    Ubah Preferensi
                </a>
            </div>

            <!-- Informasi Profil & Upload Foto -->
            <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 space-y-6">
                @csrf
                @method('patch')

                <h3 class="text-lg font-bold text-gray-800 mb-2">Informasi Profil</h3>

                <!-- Upload Foto Profil -->
                <div>
                    <x-input-label for="avatar" :value="__('Foto Profil')" class="text-gray-700 font-medium text-sm"/>
                    <input type="file" id="avatar" name="avatar" accept="image/*" class="mt-1 block w-full text-sm text-gray-500
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-full file:border-0
                        file:text-sm file:font-semibold
                        file:bg-sky-50 file:text-sky-700
                        hover:file:bg-sky-100" />
                    <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
                    <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG, max 2MB.</p>
                </div>

                <!-- Nama -->
                <div>
                    <x-input-label for="name" :value="__('Nama Lengkap')" class="text-gray-700 font-medium text-sm"/>
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full rounded-xl border-gray-200 focus:ring-sky-500 focus:border-sky-500 text-sm" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-medium text-sm"/>
                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full rounded-xl border-gray-200 focus:ring-sky-500 focus:border-sky-500 text-sm" :value="old('email', $user->email)" required autocomplete="username" />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <div>
                            <p class="text-sm mt-2 text-gray-800">
                                {{ __('Your email address is unverified.') }}
                                <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500">
                                    {{ __('Click here to re-send the verification email.') }}
                                </button>
                            </p>
                            @if (session('status') === 'verification-link-sent')
                                <p class="text-sm mt-2 font-medium text-green-600">
                                    {{ __('A new verification link has been sent to your email address.') }}
                                </p>
                            @endif
                        </div>
                    @endif
                </div>

                <div class="flex items-center gap-4">
                    <x-primary-button class="bg-sky-600 hover:bg-sky-700 rounded-xl">{{ __('Simpan Perubahan') }}</x-primary-button>

                    @if (session('status') === 'profile-updated')
                        <p x-data="{ show: true }" x-init="setTimeout(() => show = false, 2000)" x-show="show" x-transition class="text-sm text-gray-600">✅ Tersimpan.</p>
                    @endif
                </div>
            </form>

            <!-- Update Password -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                <h3 class="text-lg font-bold text-gray-800 mb-6">Ubah Password</h3>
                <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                    @csrf
                    @method('put')

                    <!-- Password Saat Ini -->
                    <div>
                        <x-input-label for="current_password" :value="__('Password Saat Ini')" class="text-gray-700 font-medium text-sm"/>
                        <div class="relative mt-1">
                            <x-text-input id="current_password" name="current_password" type="password" class="block w-full pr-12 rounded-xl border-gray-200 focus:ring-sky-500 focus:border-sky-500 text-sm" autocomplete="current-password" />
                            <button type="button" onclick="togglePw('current_password')" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition p-1">
                                <svg class="w-5 h-5 eye-current_password" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-1.274 7-9.542 7S4.057 19.458 0 16c1.274 4.057 5.064 7 9.542 7z"></path></svg>
                            </button>
                        </div>
                        <x-input-error class="mt-2" :messages="$errors->get('current_password')" />
                    </div>

                    <!-- Password Baru -->
                    <div>
                        <x-input-label for="password" :value="__('Password Baru')" class="text-gray-700 font-medium text-sm"/>
                        <div class="relative mt-1">
                            <x-text-input id="password" name="password" type="password" class="block w-full pr-12 rounded-xl border-gray-200 focus:ring-sky-500 focus:border-sky-500 text-sm" autocomplete="new-password" />
                            <button type="button" onclick="togglePw('password')" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition p-1">
                                <svg class="w-5 h-5 eye-password" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-1.274 7-9.542 7S4.057 19.458 0 16c1.274 4.057 5.064 7 9.542 7z"></path></svg>
                            </button>
                        </div>
                        <x-input-error class="mt-2" :messages="$errors->get('password')" />
                    </div>

                    <!-- Konfirmasi Password -->
                    <div>
                        <x-input-label for="password_confirmation" :value="__('Konfirmasi Password Baru')" class="text-gray-700 font-medium text-sm"/>
                        <div class="relative mt-1">
                            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="block w-full pr-12 rounded-xl border-gray-200 focus:ring-sky-500 focus:border-sky-500 text-sm" autocomplete="new-password" />
                            <button type="button" onclick="togglePw('password_confirmation')" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition p-1">
                                <svg class="w-5 h-5 eye-password_confirmation" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-1.274 7-9.542 7S4.057 19.458 0 16c1.274 4.057 5.064 7 9.542 7z"></path></svg>
                            </button>
                        </div>
                        <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button class="bg-sky-600 hover:bg-sky-700 rounded-xl">{{ __('Ubah Password') }}</x-primary-button>

                        @if (session('status') === 'password-updated')
                            <p x-data="{ show: true }" x-init="setTimeout(() => show = false, 2000)" x-show="show" x-transition class="text-sm text-gray-600">✅ Password berhasil diubah.</p>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Tombol Logout -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Keluar Akun</h3>
                    <p class="text-sm text-gray-500">Keluarkan akun Anda dari perangkat ini.</p>
                </div>
                <form id="logout-form" method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="button" id="logoutBtn" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2.5 px-6 rounded-xl transition duration-200">Logout</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <script>
    // Toggle password visibility
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

    // Logout SweetAlert2
    document.addEventListener('DOMContentLoaded', function () {
        const logoutBtn = document.getElementById('logoutBtn');
        if (!logoutBtn) return;

        logoutBtn.addEventListener('click', function (e) {
            e.preventDefault();

            Swal.fire({
                title: 'Keluar Akun?',
                text: 'Anda akan keluar dari akun TripMate dan harus login kembali untuk mengakses seluruh fitur aplikasi.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: '<i class="fas fa-sign-out-alt"></i> Ya, Logout',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                reverseButtons: true,
                focusCancel: true,
                allowOutsideClick: false,
                allowEscapeKey: true,
                allowEnterKey: true,
                backdrop: 'rgba(0,0,0,0.55)',
                showClass: { popup: 'animate__animated animate__zoomIn animate__faster' },
                hideClass: { popup: 'animate__animated animate__zoomOut animate__faster' }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        });
    });
    </script>
</x-app-layout>