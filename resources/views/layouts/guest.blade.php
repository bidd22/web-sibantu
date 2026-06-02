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
            .auth-bg {
                background: #f8fafc;
                position: relative;
                overflow: hidden;
            }
            .auth-bg::before {
                content: '';
                position: absolute;
                top: -30%;
                left: -10%;
                width: 500px;
                height: 500px;
                background: radial-gradient(circle, rgba(99, 102, 241, 0.06) 0%, transparent 70%);
                pointer-events: none;
            }
            .auth-bg::after {
                content: '';
                position: absolute;
                bottom: -20%;
                right: -5%;
                width: 400px;
                height: 400px;
                background: radial-gradient(circle, rgba(139, 92, 246, 0.04) 0%, transparent 70%);
                pointer-events: none;
            }
            .auth-card {
                background: #ffffff;
                border: 1px solid #e8ecf2;
                border-radius: 20px;
                box-shadow:
                    0 1px 3px rgba(0, 0, 0, 0.04),
                    0 8px 32px rgba(99, 102, 241, 0.06);
                transition: box-shadow 0.4s ease;
            }
            .auth-card:hover {
                box-shadow:
                    0 1px 3px rgba(0, 0, 0, 0.04),
                    0 12px 40px rgba(99, 102, 241, 0.09);
            }
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(12px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            .fade-in-up {
                animation: fadeInUp 0.5s ease-out both;
            }
        </style>
    </head>
    <body class="text-gray-900 antialiased auth-bg min-h-screen flex flex-col items-center justify-center px-4 py-12">

        <!-- Brand Header -->
        <div class="mb-8 text-center fade-in-up">
            <a href="/" class="inline-flex flex-col items-center gap-1.5 group">
                <span class="text-3xl font-extrabold tracking-tight bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent transition-transform duration-300 group-hover:scale-105">SIBANTU</span>
                <span class="text-[9px] font-bold tracking-[0.2em] text-slate-400 uppercase">Bantuan Sosial Modern</span>
            </a>
        </div>

        <!-- Auth Card -->
        <div class="auth-card w-full max-w-md px-8 py-10 md:px-10 md:py-12 fade-in-up" style="animation-delay: 0.1s;">
            {{ $slot }}
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center fade-in-up" style="animation-delay: 0.2s;">
            <p class="text-[11px] text-slate-400 font-medium">
                © {{ date('Y') }} SIBANTU · Membangun kepedulian bersama
            </p>
        </div>

    </body>
</html>
