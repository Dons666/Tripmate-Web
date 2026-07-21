<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>TripMate</title>

    @vite(['resources/css/app.css','resources/js/app.js'])

    {{-- Google Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>

        *{
            font-family:'Poppins',sans-serif;
        }

        html{
            scroll-behavior:smooth;
        }

        body{
            background:#F8FBFF;
            color:#1E293B;
        }

        .primary{
            color:#1E88E5;
        }

        .bg-primary{
            background:#1E88E5;
        }

        .bg-primary:hover{
            background:#1565C0;
        }

        .border-primary{
            border-color:#1E88E5;
        }

        .hero-overlay{
            background:linear-gradient(
                90deg,
                rgba(0,35,80,.75),
                rgba(30,136,229,.30),
                rgba(255,255,255,0)
            );
        }

    </style>

</head>

<body>

{{-- ========================= --}}
{{-- Navbar --}}
{{-- ========================= --}}

<nav class="fixed w-full bg-white shadow-sm z-50">

    <div class="max-w-7xl mx-auto flex justify-between items-center h-20 px-8">

        <!-- Logo -->

        <a href="/" class="text-4xl font-bold text-blue-600">

            TripMate

        </a>

        <!-- Menu -->

        <div class="hidden lg:flex gap-10 font-medium">

            <a href="#" class="text-blue-600">Home</a>

            <a href="#">Destinasi</a>

            <a href="#">Kuliner</a>

            <a href="#">Penginapan</a>

            <a href="#">Tentang</a>

        </div>

        <!-- Button -->

        <div class="flex gap-4">

            <a href="{{ route('login') }}"
               class="border border-gray-300 rounded-xl px-6 py-3 hover:bg-gray-100">

                Login

            </a>

            <a href="{{ route('register') }}"
               class="bg-primary text-white rounded-xl px-6 py-3">

                Daftar

            </a>

        </div>

    </div>

</nav>



{{-- ========================= --}}
{{-- HERO SECTION --}}
{{-- ========================= --}}

<section
    class="relative h-screen bg-cover bg-center"
    style="background-image:url('{{ asset('images/hero.jpg') }}')">

    <div class="absolute inset-0 hero-overlay"></div>

    <div class="relative max-w-7xl mx-auto h-full flex items-center px-8">

        <div class="max-w-2xl text-white">

            {{-- Badge --}}

            <div
                class="inline-flex items-center gap-2
                       bg-blue-500/20
                       backdrop-blur-md
                       border border-blue-300
                       rounded-full
                       px-5 py-2 mb-8">

                ✈️ Teman Perjalanan Terbaikmu

            </div>

            {{-- Heading --}}

            <h1
                class="text-6xl lg:text-7xl
                       font-extrabold
                       leading-tight">

                Jelajahi Destinasi

                <br>

                Wisata

                <span class="text-blue-300">

                    Impian Anda

                </span>

            </h1>

            {{-- Sub Title --}}

            <p
                class="mt-8
                       text-xl
                       text-gray-200
                       leading-9">

                TripMate membantu Anda menemukan destinasi wisata,
                kuliner, dan penginapan terbaik menggunakan
                teknologi

                <span class="font-semibold">

                    Content-Based Filtering.

                </span>

            </p>

            {{-- Button --}}

            <div class="flex gap-5 mt-10">

                <a href="{{ route('register') }}"

                   class="bg-blue-600 hover:bg-blue-700
                          transition
                          rounded-xl
                          px-8 py-4
                          font-semibold">

                    Mulai Perjalanan

                </a>

                <a href="#feature"

                   class="bg-white/20
                          backdrop-blur
                          border border-white
                          hover:bg-white/30
                          rounded-xl
                          px-8 py-4
                          font-semibold">

                    Pelajari Lebih Lanjut

                </a>

            </div>

            {{-- Rating --}}

            <div class="flex items-center gap-6 mt-12">

                <div class="flex -space-x-4">

                    <img src="https://i.pravatar.cc/100?img=1"

                         class="w-12 h-12 rounded-full border-2 border-white">

                    <img src="https://i.pravatar.cc/100?img=2"

                         class="w-12 h-12 rounded-full border-2 border-white">

                    <img src="https://i.pravatar.cc/100?img=3"

                         class="w-12 h-12 rounded-full border-2 border-white">

                </div>

                <div>

                    <div class="text-yellow-400 text-xl">

                        ★★★★★

                        <span class="text-white ml-2">

                            4.9/5

                        </span>

                    </div>

                    <p class="text-gray-300">

                        Dipercaya oleh 10.000+ wisatawan

                    </p>

                </div>

            </div>

        </div>

    </div>

</section>

{{-- ===================================== --}}
{{-- CATEGORY SECTION --}}
{{-- ===================================== --}}

<section class="py-24 bg-white">

    <div class="max-w-7xl mx-auto px-8">

        {{-- Heading --}}

        <div class="text-center">

            <h2 class="text-5xl font-bold">

                Kategori

                <span class="text-blue-600">

                    Wisata

                </span>

            </h2>

            <p class="mt-5 text-gray-500 text-lg">

                Temukan berbagai jenis destinasi wisata sesuai minat perjalanan Anda.

            </p>

        </div>



        {{-- Card --}}

        <div class="grid lg:grid-cols-6 md:grid-cols-3 grid-cols-2 gap-8 mt-16">



            {{-- Alam --}}

            <div class="bg-white rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-300 hover:-translate-y-3">

                <img

                    src="{{ asset('images/category/alam.jpg') }}"

                    class="h-44 w-full object-cover">

                <div class="p-5">

                    <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center text-3xl mb-4">

                        🏔

                    </div>

                    <h3 class="font-bold text-xl">

                        Wisata Alam

                    </h3>

                    <p class="text-gray-500 mt-2">

                        Pegunungan, hutan, air terjun, dan panorama alam.

                    </p>

                </div>

            </div>



            {{-- Kuliner --}}

            <div class="bg-white rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-300 hover:-translate-y-3">

                <img

                    src="{{ asset('images/category/kuliner.jpg') }}"

                    class="h-44 w-full object-cover">

                <div class="p-5">

                    <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center text-3xl mb-4">

                        🍜

                    </div>

                    <h3 class="font-bold text-xl">

                        Wisata Kuliner

                    </h3>

                    <p class="text-gray-500 mt-2">

                        Menjelajahi makanan khas berbagai daerah.

                    </p>

                </div>

            </div>



            {{-- Budaya --}}

            <div class="bg-white rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-300 hover:-translate-y-3">

                <img

                    src="{{ asset('images/category/budaya.jpg') }}"

                    class="h-44 w-full object-cover">

                <div class="p-5">

                    <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center text-3xl mb-4">

                        🏛

                    </div>

                    <h3 class="font-bold text-xl">

                        Wisata Budaya

                    </h3>

                    <p class="text-gray-500 mt-2">

                        Mengenal budaya dan tradisi Indonesia.

                    </p>

                </div>

            </div>



            {{-- Pantai --}}

            <div class="bg-white rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-300 hover:-translate-y-3">

                <img

                    src="{{ asset('images/category/pantai.jpg') }}"

                    class="h-44 w-full object-cover">

                <div class="p-5">

                    <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center text-3xl mb-4">

                        🏖

                    </div>

                    <h3 class="font-bold text-xl">

                        Wisata Pantai

                    </h3>

                    <p class="text-gray-500 mt-2">

                        Pantai indah dengan panorama laut terbaik.

                    </p>

                </div>

            </div>



            {{-- Keluarga --}}

            <div class="bg-white rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-300 hover:-translate-y-3">

                <img

                    src="{{ asset('images/category/keluarga.jpg') }}"

                    class="h-44 w-full object-cover">

                <div class="p-5">

                    <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center text-3xl mb-4">

                        👨‍👩‍👧

                    </div>

                    <h3 class="font-bold text-xl">

                        Wisata Keluarga

                    </h3>

                    <p class="text-gray-500 mt-2">

                        Destinasi nyaman untuk liburan bersama keluarga.

                    </p>

                </div>

            </div>



            {{-- Sejarah --}}

            <div class="bg-white rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-300 hover:-translate-y-3">

                <img

                    src="{{ asset('images/category/sejarah.jpg') }}"

                    class="h-44 w-full object-cover">

                <div class="p-5">

                    <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center text-3xl mb-4">

                        🕌

                    </div>

                    <h3 class="font-bold text-xl">

                        Wisata Sejarah

                    </h3>

                    <p class="text-gray-500 mt-2">

                        Menelusuri bangunan dan situs bersejarah.

                    </p>

                </div>

            </div>

        </div>

    </div>

</section>

{{-- ===================================== --}}
{{-- FEATURE SECTION --}}
{{-- ===================================== --}}

<section id="feature" class="py-24 bg-slate-50">

    <div class="max-w-7xl mx-auto px-8">

        <div class="text-center">

            <h2 class="text-5xl font-bold">

                Mengapa Memilih

                <span class="text-blue-600">

                    TripMate?

                </span>

            </h2>

            <p class="mt-5 text-lg text-gray-500">

                TripMate membantu pengguna menemukan destinasi wisata yang sesuai dengan preferensi secara cepat dan mudah menggunakan metode Content-Based Filtering.

            </p>

        </div>


        <div class="grid lg:grid-cols-4 md:grid-cols-2 gap-8 mt-20">


            {{-- CARD 1 --}}

            <div class="bg-white rounded-3xl shadow-lg p-8 hover:shadow-2xl transition hover:-translate-y-3">

                <div class="w-20 h-20 rounded-full bg-blue-100 flex items-center justify-center text-4xl">

                    🎯

                </div>

                <h3 class="text-2xl font-bold mt-8">

                    Rekomendasi Personal

                </h3>

                <p class="mt-4 text-gray-500 leading-8">

                    Sistem memberikan rekomendasi destinasi wisata berdasarkan kategori, kota, budget, dan preferensi Hidden Gem menggunakan metode Content-Based Filtering.

                </p>

            </div>



            {{-- CARD 2 --}}

            <div class="bg-white rounded-3xl shadow-lg p-8 hover:shadow-2xl transition hover:-translate-y-3">

                <div class="w-20 h-20 rounded-full bg-blue-100 flex items-center justify-center text-4xl">

                    🔍

                </div>

                <h3 class="text-2xl font-bold mt-8">

                    Pencarian Mudah

                </h3>

                <p class="mt-4 text-gray-500 leading-8">

                    Temukan destinasi wisata, kuliner, dan penginapan melalui pencarian yang sederhana serta mudah digunakan.

                </p>

            </div>



            {{-- CARD 3 --}}

            <div class="bg-white rounded-3xl shadow-lg p-8 hover:shadow-2xl transition hover:-translate-y-3">

                <div class="w-20 h-20 rounded-full bg-blue-100 flex items-center justify-center text-4xl">

                    ❤️

                </div>

                <h3 class="text-2xl font-bold mt-8">

                    Bookmark Favorit

                </h3>

                <p class="mt-4 text-gray-500 leading-8">

                    Simpan destinasi favorit sehingga lebih mudah ditemukan kembali ketika akan merencanakan perjalanan.

                </p>

            </div>



            {{-- CARD 4 --}}

            <div class="bg-white rounded-3xl shadow-lg p-8 hover:shadow-2xl transition hover:-translate-y-3">

                <div class="w-20 h-20 rounded-full bg-blue-100 flex items-center justify-center text-4xl">

                    🗺️

                </div>

                <h3 class="text-2xl font-bold mt-8">

                    Perencanaan Wisata

                </h3>

                <p class="mt-4 text-gray-500 leading-8">

                    Membantu pengguna menyusun rencana perjalanan wisata secara lebih efektif sesuai kebutuhan dan preferensi.

                </p>

            </div>

        </div>

    </div>

</section>

{{-- ===================================== --}}
{{-- POPULAR DESTINATION --}}
{{-- ===================================== --}}

<section class="py-24 bg-white">

    <div class="max-w-7xl mx-auto px-8">

        <div class="flex justify-between items-center mb-14">

            <div>

                <h2 class="text-5xl font-bold">

                    Destinasi

                    <span class="text-blue-600">

                        Populer

                    </span>

                </h2>

                <p class="text-gray-500 mt-4">

                    Jelajahi destinasi wisata favorit yang banyak dikunjungi wisatawan.

                </p>

            </div>

            <a href="#"

               class="text-blue-600 font-semibold hover:underline">

                Lihat Semua →

            </a>

        </div>


        <div class="grid lg:grid-cols-3 gap-10">

            {{-- CARD 1 --}}

            <div class="bg-white rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-300">

                <div class="relative">

                    <img src="{{ asset('images/destination/kawah-putih.jpg') }}"

                         class="h-72 w-full object-cover">

                    <div class="absolute top-5 right-5">

                        <button class="bg-white rounded-full p-3 shadow">

                            ❤️

                        </button>

                    </div>

                </div>

                <div class="p-7">

                    <div class="flex justify-between">

                        <h3 class="text-2xl font-bold">

                            Kawah Putih

                        </h3>

                        <span class="text-yellow-500">

                            ⭐ 4.8

                        </span>

                    </div>

                    <p class="text-gray-500 mt-3">

                        📍 Ciwidey, Bandung

                    </p>

                    <p class="mt-4 text-gray-600">

                        Destinasi wisata alam dengan danau kawah berwarna putih kehijauan yang menjadi ikon wisata Bandung.

                    </p>

                    <div class="flex justify-between items-center mt-7">

                        <span class="text-blue-600 font-bold text-xl">

                            Rp35.000

                        </span>

                        <button

                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl">

                            Detail

                        </button>

                    </div>

                </div>

            </div>



            {{-- CARD 2 --}}

            <div class="bg-white rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition">

                <img src="{{ asset('images/destination/farmhouse.jpg') }}"

                     class="h-72 w-full object-cover">

                <div class="p-7">

                    <div class="flex justify-between">

                        <h3 class="text-2xl font-bold">

                            Farm House

                        </h3>

                        <span class="text-yellow-500">

                            ⭐4.7

                        </span>

                    </div>

                    <p class="text-gray-500 mt-3">

                        📍 Lembang

                    </p>

                    <p class="mt-4 text-gray-600">

                        Tempat wisata keluarga dengan konsep Eropa yang cocok untuk berfoto.

                    </p>

                    <div class="flex justify-between items-center mt-7">

                        <span class="text-blue-600 font-bold text-xl">

                            Rp35.000

                        </span>

                        <button

                            class="bg-blue-600 text-white px-6 py-3 rounded-xl">

                            Detail

                        </button>

                    </div>

                </div>

            </div>



            {{-- CARD 3 --}}

            <div class="bg-white rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition">

                <img src="{{ asset('images/destination/braga.jpg') }}"

                     class="h-72 w-full object-cover">

                <div class="p-7">

                    <div class="flex justify-between">

                        <h3 class="text-2xl font-bold">

                            Braga

                        </h3>

                        <span class="text-yellow-500">

                            ⭐4.9

                        </span>

                    </div>

                    <p class="text-gray-500 mt-3">

                        📍 Kota Bandung

                    </p>

                    <p class="mt-4 text-gray-600">

                        Kawasan bersejarah dengan bangunan klasik dan pusat kuliner terkenal.

                    </p>

                    <div class="flex justify-between items-center mt-7">

                        <span class="text-blue-600 font-bold text-xl">

                            Gratis

                        </span>

                        <button

                            class="bg-blue-600 text-white px-6 py-3 rounded-xl">

                            Detail

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

{{-- ===================================== --}}
{{-- CALL TO ACTION --}}
{{-- ===================================== --}}

<section class="py-24 bg-gradient-to-r from-blue-600 to-sky-500 text-white">

    <div class="max-w-7xl mx-auto px-8">

        <div class="grid lg:grid-cols-2 gap-16 items-center">

            <div>

                <h2 class="text-5xl font-bold leading-tight">

                    Siap Menjelajahi

                    <br>

                    Destinasi Impian Anda?

                </h2>

                <p class="mt-8 text-xl text-blue-100 leading-9">

                    Temukan rekomendasi destinasi wisata terbaik sesuai
                    preferensi Anda menggunakan teknologi
                    <strong>Content-Based Filtering.</strong>

                </p>

                <div class="mt-10 flex gap-5">

                    <a href="{{ route('register') }}"
                       class="bg-white text-blue-600 px-8 py-4 rounded-xl font-semibold hover:bg-gray-100 transition">

                        Mulai Sekarang

                    </a>

                    <a href="#"
                       class="border border-white px-8 py-4 rounded-xl hover:bg-white hover:text-blue-600 transition">

                        Pelajari Lagi

                    </a>

                </div>

            </div>

            <div class="flex justify-center">

                <img
                    src="{{ asset('images/travel.png') }}"
                    class="w-[450px]">

            </div>

        </div>

    </div>

</section>


{{-- ===================================== --}}
{{-- FOOTER --}}
{{-- ===================================== --}}

<footer class="bg-slate-900 text-gray-300">

    <div class="max-w-7xl mx-auto px-8 py-20">

        <div class="grid lg:grid-cols-4 gap-12">

            {{-- Logo --}}

            <div>

                <h2 class="text-4xl font-bold text-white">

                    Trip<span class="text-blue-500">Mate</span>

                </h2>

                <p class="mt-6 leading-8">

                    TripMate merupakan aplikasi rekomendasi destinasi wisata
                    berbasis Content-Based Filtering yang membantu pengguna
                    menemukan destinasi sesuai preferensi.

                </p>

            </div>



            {{-- Menu --}}

            <div>

                <h3 class="text-white text-xl font-semibold mb-6">

                    Menu

                </h3>

                <ul class="space-y-4">

                    <li><a href="#" class="hover:text-blue-400">Home</a></li>

                    <li><a href="#" class="hover:text-blue-400">Destinasi</a></li>

                    <li><a href="#" class="hover:text-blue-400">Kuliner</a></li>

                    <li><a href="#" class="hover:text-blue-400">Penginapan</a></li>

                    <li><a href="#" class="hover:text-blue-400">Tentang</a></li>

                </ul>

            </div>



            {{-- Support --}}

            <div>

                <h3 class="text-white text-xl font-semibold mb-6">

                    Bantuan

                </h3>

                <ul class="space-y-4">

                    <li>FAQ</li>

                    <li>Privacy Policy</li>

                    <li>Terms & Condition</li>

                    <li>Contact</li>

                </ul>

            </div>



            {{-- Contact --}}

            <div>

                <h3 class="text-white text-xl font-semibold mb-6">

                    Kontak

                </h3>

                <ul class="space-y-5">

                    <li>

                        📍 Bandung, Indonesia

                    </li>

                    <li>

                        📧 tripmate@gmail.com

                    </li>

                    <li>

                        ☎ +62 81234567890

                    </li>

                </ul>



                <div class="flex gap-4 mt-8">

                    <a href="#"
                       class="w-12 h-12 rounded-full bg-blue-600 flex items-center justify-center hover:bg-blue-500">

                        F

                    </a>

                    <a href="#"
                       class="w-12 h-12 rounded-full bg-blue-600 flex items-center justify-center hover:bg-blue-500">

                        I

                    </a>

                    <a href="#"
                       class="w-12 h-12 rounded-full bg-blue-600 flex items-center justify-center hover:bg-blue-500">

                        X

                    </a>

                </div>

            </div>

        </div>

    </div>


    <div class="border-t border-slate-700 py-6">

        <div class="max-w-7xl mx-auto px-8 flex justify-between items-center">

            <p>

                © 2026 TripMate. All Rights Reserved.

            </p>

            <p>

                Developed by TripMate Team

            </p>

        </div>

    </div>

</footer>

</body>
</html>