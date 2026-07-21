<x-app-layout>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Header -->
  <!-- Header Section -->
    <div class="rounded-3xl bg-gradient-to-r from-sky-500 to-cyan-400 overflow-hidden shadow-lg mb-8">
        <div class="relative px-8 py-10">
            <div class="absolute -top-8 -right-8 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
            <div class="absolute -bottom-10 -left-6 w-48 h-48 bg-white/10 rounded-full blur-2xl"></div>

            <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center text-3xl flex-shrink-0">
                        ✨
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-white">
                            Rekomendasi Untuk Anda
                        </h1>
                        <p class="text-white/90 mt-1">
                            Destinasi yang direkomendasikan berdasarkan preferensi perjalanan Anda.
                        </p>
                    </div>
                </div>

                <a href="{{ route('home') }}"
                   class="inline-flex items-center gap-2 bg-white/20 backdrop-blur hover:bg-white/30 text-white font-semibold px-4 py-2 rounded-xl transition self-start md:self-auto">
                    ← Kembali ke Home
                </a>
            </div>
        </div>
    </div>

    <!-- Info Card -->
    <div class="bg-sky-50 border border-sky-100 rounded-2xl p-5 mb-8">

        <div class="flex items-center gap-4">

            <div>

                <h2 class="font-bold text-slate-800">
                    Personalized Recommendation
                </h2>

                <p class="text-sm text-slate-500">
                    Rekomendasi ini berdasarkan preferensi perjalanan yang Anda pilih.
                </p>

            </div>

        </div>

    </div>

    <!-- Destinasi -->
    @if($recommendations->count())

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

        @foreach($recommendations as $destinasi)

            <a href="{{ route('destinasi.show', $destinasi->id) }}"
               class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition group block">

                <!-- Gambar -->
                <div class="h-48 w-full bg-gray-200 relative overflow-hidden">

                    @if($destinasi->gambar)

                        <img
                            src="{{ $destinasi->gambar }}"
                            alt="{{ $destinasi->nama_destinasi }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">

                    @else

                        <div class="w-full h-full flex items-center justify-center text-gray-400">

                            <svg class="w-12 h-12"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>

                            </svg>

                        </div>

                    @endif

                    @if($destinasi->hidden_gem)

                        <span class="absolute top-2 left-2 bg-yellow-400 text-yellow-900 text-xs font-bold px-2 py-1 rounded-full">
                            Hidden Gem 💎
                        </span>

                    @endif

                </div>

                <!-- Content -->
                <div class="p-5">

                    <div class="flex justify-between items-start mb-2">

                        <h3 class="font-bold text-gray-900 leading-tight">
                            {{ Str::limit($destinasi->nama_destinasi, 25) }}
                        </h3>

                        <span class="text-yellow-500 text-sm font-semibold flex items-center gap-1">
                            @if(($destinasi->ratings_count ?? 0) > 0)
                                ⭐ {{ number_format($destinasi->average_rating, 1) }}
                            @else
                                Belum ada ulasan
                            @endif
                        </span>

                    </div>

                    <p class="text-gray-500 text-sm mb-4">
                        📍 {{ $destinasi->kota }} • {{ $destinasi->kategori }}
                    </p>





                    <div class="flex justify-between items-center">

                        @if($destinasi->harga == 0)

    <span class="text-green-600 font-bold">
        Gratis
    </span>

@else

    <span class="text-sky-600 font-bold">
        Rp {{ number_format($destinasi->harga, 0, ',', '.') }}
    </span>

@endif

                        <span class="text-sm text-sky-600 hover:underline font-medium">
                            Detail →
                        </span>

                    </div>

                </div>

            </a>

        @endforeach

    </div>

    @else

<div class="bg-white rounded-3xl p-16 text-center border border-gray-100 shadow-sm">

    <div class="text-6xl mb-5">
        🧭
    </div>

    <h3 class="text-2xl font-bold text-gray-800 mb-3">
        Belum Menemukan Rekomendasi
    </h3>

    <p class="text-gray-500 max-w-xl mx-auto leading-relaxed">
        Belum ada destinasi yang sesuai dengan preferensi yang Anda pilih.
        Coba ubah kategori wisata, budget, atau nonaktifkan
        <strong>Hidden Gem</strong> agar lebih banyak rekomendasi dapat ditampilkan.
    </p>

    <!-- Tips -->
    <div class="mt-8 max-w-lg mx-auto rounded-2xl border border-amber-200 bg-amber-50 p-5 text-left">

        <h4 class="font-semibold text-amber-800 mb-3">
            💡 Tips
        </h4>

        <ul class="space-y-2 text-sm text-amber-700 list-disc pl-5">

            <li>
                Pilih lebih dari satu kategori wisata untuk memperoleh hasil yang lebih beragam.
            </li>

            <li>
                Gunakan budget <strong>Sedang</strong> atau <strong>Mahal</strong> apabila rekomendasi masih kosong.
            </li>

            <li>
                Nonaktifkan <strong>Hidden Gem</strong> agar lebih banyak destinasi dapat ditampilkan.
            </li>

            <li>
                Jika memilih <strong>Penginapan</strong>, disarankan tidak mengombinasikannya dengan kategori wisata lainnya agar hasil rekomendasi dan rentang budget lebih sesuai.
            </li>

        </ul>

    </div>

    <!-- Tombol -->
    <div class="mt-8">

        <a href="{{ route('preference.create') }}"
           class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-sky-600 text-white font-semibold hover:bg-sky-700 transition">

            ⚙️ Ubah Preferensi

        </a>

    </div>

</div>

@endif

</div>

</x-app-layout>