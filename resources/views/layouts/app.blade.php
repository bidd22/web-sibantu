<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SIBANTU</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; background: #f8fafc; }
    </style>
</head>
<body>
    <div class="min-h-screen flex flex-col">
        @include('layouts.navigation')
        <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm">
                    {{ session('success') }}
                </div>
            @endif
            @yield('content')
        </main>
        <footer class="border-t border-gray-100 py-6 text-center text-gray-400 text-sm">
            <div class="max-w-7xl mx-auto px-4">
                <p>© {{ date('Y') }} SIBANTU – Sistem Informasi Bantuan untuk Masyarakat</p>
                <p class="text-xs mt-1">Membantu sesama dengan transparan dan tepat sasaran</p>
            </div>
        </footer>
    </div>
</body>
</html>