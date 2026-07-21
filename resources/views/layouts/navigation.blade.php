<nav class="bg-white/80 backdrop-blur-md shadow-sm sticky top-0 z-50 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <a href="{{ route('home') }}" class="text-2xl font-bold tracking-tight text-sky-600">
                TripMate
            </a>

            <div class="hidden md:flex items-center gap-1">
                <a href="{{ route('home') }}" class="px-4 py-2 rounded-lg text-sm font-medium text-gray-500 hover:text-sky-600 hover:bg-sky-50 transition {{ request()->routeIs('home') ? 'nav-active' : '' }}">
                    Home
                </a>
                <a href="{{ route('travel-plans.index') }}" class="px-4 py-2 rounded-lg text-sm font-medium text-gray-500 hover:text-sky-600 hover:bg-sky-50 transition {{ request()->routeIs('travel-plans.index') ? 'nav-active' : '' }}">
                    Rencana
                </a>
                <a href="{{ route('bookmarks.index') }}" class="px-4 py-2 rounded-lg text-sm font-medium text-gray-500 hover:text-sky-600 hover:bg-sky-50 transition {{ request()->routeIs('bookmarks.index') ? 'nav-active' : '' }}">
                    Bookmarks
                </a>
            </div>

            <div class="flex items-center gap-3">
                <a href="javascript:history.back()" class="text-sm text-gray-500 hover:text-sky-600 font-medium flex items-center gap-1 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    <span class="hidden sm:inline">Kembali</span>
                </a>

                @auth
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 hover:opacity-80 transition">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" class="w-8 h-8 rounded-full object-cover border-2 border-sky-100 shadow-sm">
                        @else
                            <div class="w-8 h-8 bg-sky-100 text-sky-600 rounded-full flex items-center justify-center text-xs font-bold border-2 border-white shadow-sm">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        @endif
                        <span class="text-sm font-medium text-gray-700 hidden sm:inline">{{ Auth::user()->name }}</span>
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>