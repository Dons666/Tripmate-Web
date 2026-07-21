<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Bookmark Saya ❤️</h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header Section -->
            <div class="rounded-3xl bg-gradient-to-r from-sky-500 to-cyan-400 overflow-hidden shadow-lg mb-8">
                <div class="relative px-8 py-10">
                    <div class="absolute -top-8 -right-8 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
                    <div class="absolute -bottom-10 -left-6 w-48 h-48 bg-white/10 rounded-full blur-2xl"></div>

                    <div class="relative flex items-center gap-4">
                        <div class="w-14 h-14 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center text-3xl">
                            ❤️
                        </div>
                        <div>
                            <h1 class="text-2xl md:text-3xl font-bold text-white">Bookmark Saya</h1>
                            <p class="text-white/90 mt-1">
                                {{ $bookmarks->count() }} destinasi favorit tersimpan
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alert Success -->
            @if(session('success'))
                <div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 p-4 rounded-2xl mb-6 text-sm font-medium">
                    <span class="text-lg">✅</span>
                    {{ session('success') }}
                </div>
            @endif

            @if($bookmarks->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($bookmarks as $bookmark)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl hover:-translate-y-2 transition-all duration-300 ease-out group">

                        <!-- Thumbnail -->
                        <div class="h-36 w-full bg-gradient-to-br from-sky-100 to-cyan-50 relative overflow-hidden flex items-center justify-center">
                            @if($bookmark->destinasi->gambar)
                                <img src="{{ $bookmark->destinasi->gambar }}" alt="{{ $bookmark->destinasi->nama_destinasi }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <span class="text-5xl opacity-60">🏞️</span>
                            @endif

                            <span class="absolute top-3 right-3 w-8 h-8 bg-white/90 backdrop-blur rounded-full flex items-center justify-center text-red-500 shadow-sm">
                                ❤️
                            </span>
                        </div>

                        <div class="p-5">
                            <h3 class="font-bold text-gray-900 leading-tight mb-2">{{ $bookmark->destinasi->nama_destinasi }}</h3>
                            <p class="text-gray-500 text-sm mb-4 flex items-center gap-1">
                                📍 {{ $bookmark->destinasi->kota }}
                            </p>

                            <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                                <a href="{{ route('destinasi.show', $bookmark->destinasi->id) }}" class="text-sm text-sky-600 hover:text-sky-700 font-semibold hover:underline transition">
                                    Lihat Detail →
                                </a>

                                <form action="{{ route('bookmarks.toggle') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="destinasi_id" value="{{ $bookmark->destinasi->id }}">
                                    <button type="submit" class="flex items-center gap-1 text-red-500 hover:text-red-600 text-sm font-medium hover:underline transition">
                                        🗑️ Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @else
                <!-- Empty State -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 text-center py-20 px-6">
                    <div class="w-20 h-20 bg-sky-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-4xl">📑</span>
                    </div>
                    <p class="font-bold text-xl text-slate-900">Belum ada bookmark</p>
                    <p class="text-gray-500 mt-2 max-w-sm mx-auto">
                        Mulai simpan destinasi favoritmu supaya lebih mudah ditemukan lagi nanti.
                    </p>
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 mt-6 bg-sky-600 hover:bg-sky-700 text-white px-6 py-3 rounded-2xl font-semibold transition active:scale-95 shadow-lg">
                        Jelajahi Destinasi
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>