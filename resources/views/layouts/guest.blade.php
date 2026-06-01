<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SIBANTU') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                font-family: 'Inter', sans-serif;
            }
            .hero-gradient {
                background: radial-gradient(circle at 50% 50%, rgba(79, 70, 229, 0.05) 0%, rgba(255, 255, 255, 0) 100%), #f8fafc;
            }
        </style>
    </head>
    <body class="text-gray-900 antialiased hero-gradient min-h-screen relative overflow-x-hidden flex items-center justify-center py-12">
        <!-- Floating decorative blurs -->
        <div class="absolute top-0 left-0 -translate-x-1/3 -translate-y-1/3 w-[400px] h-[400px] bg-indigo-200/20 rounded-full blur-[80px] pointer-events-none"></div>
        <div class="absolute bottom-0 right-0 translate-x-1/3 translate-y-1/3 w-[500px] h-[500px] bg-purple-200/20 rounded-full blur-[100px] pointer-events-none"></div>

        <div class="w-full max-w-md px-6 flex flex-col items-center">
            <div class="z-10 mb-2">
                <a href="/" class="flex flex-col items-center gap-1 group transition">
                    <span class="text-3xl font-extrabold tracking-wider bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent group-hover:scale-105 transition-transform duration-300">SIBANTU</span>
                    <span class="text-[10px] font-bold tracking-widest text-indigo-500 uppercase">Sistem Bantuan Sosial</span>
                </a>
            </div>

            <div class="w-full mt-6 px-8 py-8 bg-white/90 backdrop-blur-md border border-slate-100 shadow-[0_20px_50px_rgba(79,70,229,0.06)] rounded-2xl z-10 transition-all duration-300 hover:shadow-[0_25px_60px_rgba(79,70,229,0.1)]">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
