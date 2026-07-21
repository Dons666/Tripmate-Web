<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TripMate') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">

    <link href="https://fonts.bunny.net/css?family=figtree:400;500;600;700;800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="font-sans antialiased bg-slate-100">

<div class="min-h-screen grid lg:grid-cols-2">

    <!-- ========================= -->
    <!-- LEFT SIDE -->
    <!-- ========================= -->

    <div class="hidden lg:flex relative overflow-hidden">

        <!-- Background Image -->

        <img
            id="heroImage"
            src="{{ asset('images/gedung-sate.jpg') }}"
            alt="TripMate"
            class="absolute inset-0 w-full h-full object-cover transition-all duration-1000">

        <!-- Overlay -->

        <div class="absolute inset-0 bg-gradient-to-r from-sky-950/90 via-sky-700/60 to-sky-500/30"></div>

        <!-- Content -->

        <div class="relative z-10 flex flex-col justify-center px-20 text-white">

            <!-- Logo -->

            <span
                class="uppercase
                       tracking-[8px]
                       font-semibold
                       text-sky-200">

                TripMate

            </span>

            <!-- Heading -->

            <h1
                id="heroTitle"
                class="text-6xl
                       font-extrabold
                       mt-6
                       leading-tight">

                Temukan

                <br>

                Destinasi Wisata

                <br>

                Terbaikmu

            </h1>

            <!-- Description -->

            <p
                id="heroDescription"
                class="mt-8
                       text-xl
                       leading-9
                       text-sky-100
                       max-w-xl">

                Jelajahi destinasi wisata, kuliner,
                dan penginapan terbaik di Bandung
                dan Jakarta berdasarkan preferensi
                perjalananmu menggunakan
                sistem rekomendasi TripMate.

            </p>


            <!-- Indicator -->

            <div class="flex gap-3 mt-14">

                <span class="dot w-3 h-3 rounded-full bg-white opacity-100"></span>

                <span class="dot w-3 h-3 rounded-full bg-white opacity-40"></span>

                <span class="dot w-3 h-3 rounded-full bg-white opacity-40"></span>

                <span class="dot w-3 h-3 rounded-full bg-white opacity-40"></span>

            </div>

        </div>

    </div>

        <!-- ========================= -->
    <!-- RIGHT SIDE -->
    <!-- ========================= -->

    <div class="flex items-center justify-center bg-slate-50 p-8">

        <div class="w-full max-w-md">

            <!-- Logo -->

            <div class="text-center mb-10">

                <a href="{{ route('home') }}" class="inline-flex items-center gap-3">

                    <div class="text-left">

                        <h1 class="text-4xl font-extrabold text-sky-600">

                            TripMate

                        </h1>


                    </div>

                </a>

            </div>


            <!-- Login Card -->

            <div
                class="bg-white
                       rounded-3xl
                       shadow-2xl
                       border
                       border-slate-200
                       p-7">

                <div class="mb-8">

                

                </div>

                <!-- Breeze Login/Register -->

                {{ $slot }}

            </div>

            <!-- Footer -->

            <div class="text-center mt-8">

                <p
                    class="text-gray-400
                           text-sm">

                    © {{ date('Y') }}

                    <span class="font-semibold text-sky-600">

                        TripMate

                    </span>

                    • All Rights Reserved

                </p>

            </div>

        </div>

    </div>

</div>

<script>

const slides = [

{
    image: "{{ asset('images/gedung-sate.jpg') }}",
    title: "Temukan<br>Destinasi Wisata<br>Terbaikmu",
    description: "Jelajahi destinasi wisata, kuliner, dan penginapan terbaik di Bandung dan Jakarta berdasarkan preferensi perjalananmu menggunakan sistem rekomendasi TripMate."
},

{
    image: "{{ asset('images/braga.jpg') }}",
    title: "Nikmati<br>Suasana Braga<br>Bandung",
    description: "Jelajahi kawasan bersejarah Braga yang dipenuhi bangunan klasik, kuliner, dan suasana kota yang ikonik."
},

{
    image: "{{ asset('images/kawah-putih.jpg') }}",
    title: "Eksplorasi<br>Keindahan<br>Kawah Putih",
    description: "Temukan pesona wisata alam Ciwidey dengan panorama danau vulkanik yang memukau."
},

{
    image: "{{ asset('images/monas.jpg') }}",
    title: "Jelajahi<br>Ikon Kota<br>Jakarta",
    description: "Temukan berbagai destinasi menarik di Jakarta mulai dari Monas, Kota Tua, hingga wisata kuliner."
}

];

let current = 0;

const heroImage = document.getElementById("heroImage");
const heroTitle = document.getElementById("heroTitle");
const heroDescription = document.getElementById("heroDescription");
const dots = document.querySelectorAll(".dot");

function changeSlide(){

    current++;

    if(current >= slides.length){

        current = 0;

    }

    heroImage.style.opacity = 0;

    setTimeout(()=>{

        heroImage.src = slides[current].image;

        heroTitle.innerHTML = slides[current].title;

        heroDescription.innerHTML = slides[current].description;

        heroImage.style.opacity = 1;

    },400);

    dots.forEach((dot,index)=>{

        if(index===current){

            dot.classList.remove("opacity-40");

            dot.classList.add("opacity-100");

        }

        else{

            dot.classList.remove("opacity-100");

            dot.classList.add("opacity-40");

        }

    });

}

setInterval(changeSlide,5000);

</script>

</body>

</html>