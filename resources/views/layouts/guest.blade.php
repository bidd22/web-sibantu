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
                background: 
                    radial-gradient(circle at 50% 50%, rgba(79, 70, 229, 0.08) 0%, rgba(255, 255, 255, 0) 100%),
                    linear-gradient(to right, rgba(99, 102, 241, 0.04) 1px, transparent 1px),
                    linear-gradient(to bottom, rgba(99, 102, 241, 0.04) 1px, transparent 1px),
                    #f8fafc;
                background-size: 100% 100%, 24px 24px, 24px 24px;
            }
        </style>
    </head>
    <body class="text-gray-900 antialiased hero-gradient min-h-screen relative overflow-x-hidden flex items-center justify-center py-16">
        <!-- Floating decorative blurs -->
        <div class="absolute top-0 left-1/4 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-gradient-to-tr from-indigo-300/10 to-indigo-500/10 rounded-full blur-[100px] pointer-events-none animate-pulse" style="animation-duration: 8s;"></div>
        <div class="absolute bottom-0 right-1/4 translate-x-1/2 translate-y-1/2 w-[600px] h-[600px] bg-gradient-to-tr from-purple-300/10 to-purple-500/10 rounded-full blur-[120px] pointer-events-none animate-pulse" style="animation-duration: 12s;"></div>

        <div class="w-full max-w-md px-6 flex flex-col items-center">
            <div class="z-10 mb-4 text-center">
                <a href="/" class="flex flex-col items-center gap-1.5 group transition">
                    <span class="text-4xl font-extrabold tracking-tight bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent group-hover:scale-105 transition-transform duration-300">SIBANTU</span>
                    <span class="text-[10px] font-bold tracking-widest text-indigo-500/80 uppercase">Sistem Bantuan Sosial Modern</span>
                </a>
            </div>

            <div class="w-full mt-4 px-8 py-9 bg-white/80 backdrop-blur-lg border border-white/60 shadow-[0_25px_60px_rgba(79,70,229,0.06)] rounded-3xl z-10 transition-all duration-300 hover:shadow-[0_30px_70px_rgba(79,70,229,0.12)]">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
