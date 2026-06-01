<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SIBANTU Admin Panel</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="h-full text-gray-900" x-data="{ sidebarOpen: false }">
    <!-- Mobile Sidebar Backdrop -->
    <div x-show="sidebarOpen" 
         class="fixed inset-0 z-40 bg-slate-900/40 backdrop-blur-sm lg:hidden transition-opacity"
         @click="sidebarOpen = false"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"></div>

    <!-- Mobile Sidebar Container -->
    <div x-show="sidebarOpen" 
         class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-slate-100 flex flex-col justify-between lg:hidden transition-transform duration-300 transform"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="-translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="-translate-x-full">
        
        <div>
            <!-- Sidebar Header -->
            <div class="h-16 flex items-center px-6 border-b border-slate-100 justify-between">
                <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">SIBANTU</a>
                <button @click="sidebarOpen = false" class="text-slate-400 hover:text-slate-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <!-- Navigation Links -->
            <nav class="p-4 space-y-1">
                @include('layouts.admin-links')
            </nav>
        </div>

        <!-- Sidebar Profile -->
        <div class="p-4 border-t border-slate-100">
            @include('layouts.admin-profile')
        </div>
    </div>

    <!-- Desktop Sidebar (Large screens) -->
    <div class="hidden lg:flex lg:flex-col lg:w-64 lg:fixed lg:inset-y-0 lg:z-30 bg-white border-r border-slate-100 flex-shrink-0 justify-between">
        <div>
            <!-- Sidebar Header -->
            <div class="h-16 flex items-center px-6 border-b border-slate-100">
                <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">SIBANTU <span class="text-[10px] font-semibold text-indigo-500 uppercase tracking-widest px-1.5 py-0.5 bg-indigo-50 rounded border border-indigo-100 ml-1">Admin</span></a>
            </div>
            <!-- Navigation Links -->
            <nav class="p-4 space-y-1">
                @include('layouts.admin-links')
            </nav>
        </div>

        <!-- Sidebar Profile -->
        <div class="p-4 border-t border-slate-100">
            @include('layouts.admin-profile')
        </div>
    </div>

    <!-- Right Content Area -->
    <div class="lg:pl-64 flex flex-col min-h-screen">
        <!-- Top Navigation Bar -->
        <header class="h-16 bg-white border-b border-slate-100 flex items-center justify-between px-4 sm:px-6 lg:px-8 sticky top-0 z-20">
            <div class="flex items-center gap-4">
                <!-- Hamburger Button (Mobile Only) -->
                <button @click="sidebarOpen = true" class="text-slate-500 hover:text-slate-700 lg:hidden p-2 rounded-lg hover:bg-slate-50 transition">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                <!-- Breadcrumbs/Current section indicator -->
                <div class="flex items-center gap-2 text-xs font-semibold text-slate-400">
                    <span>Admin Panel</span>
                    <svg class="w-3 h-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    <span class="text-slate-600">
                        @if(request()->routeIs('admin.dashboard')) Dashboard
                        @elseif(request()->routeIs('admin.pengajuans.*')) Pengajuan Bantuan
                        @elseif(request()->routeIs('admin.pengaduans.*')) Pengaduan Warga
                        @elseif(request()->routeIs('admin.programs.*')) Program Bantuan
                        @elseif(request()->routeIs('admin.menus.*')) Manajemen Menu
                        @endif
                    </span>
                </div>
            </div>

            <!-- Top bar Actions -->
            <div class="flex items-center gap-4">
                <a href="{{ route('dashboard') }}" class="text-xs font-semibold text-slate-500 hover:text-indigo-600 bg-slate-50 hover:bg-indigo-50 border border-slate-200 hover:border-indigo-100 px-3.5 py-2 rounded-xl transition duration-150 flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>
                    Halaman Warga
                </a>
            </div>
        </header>

        <!-- Main Body Wrapper -->
        <main class="flex-grow py-8 px-4 sm:px-6 lg:px-8 max-w-7xl w-full mx-auto">
            <!-- Toast / Alerts -->
            @if(session('success'))
                <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3.5 rounded-2xl text-sm flex items-center gap-2 shadow-sm animate-pulse" x-data="{ show: true }" x-show="show">
                    <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div class="flex-grow font-medium">{{ session('success') }}</div>
                    <button @click="show = false" class="text-emerald-400 hover:text-emerald-600 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3.5 rounded-2xl text-sm flex items-center gap-2 shadow-sm" x-data="{ show: true }" x-show="show">
                    <svg class="w-5 h-5 text-rose-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div class="flex-grow font-medium">{{ session('error') }}</div>
                    <button @click="show = false" class="text-rose-400 hover:text-rose-600 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            @endif

            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-slate-100 py-6 text-center text-slate-400 text-xs">
            <p>© {{ date('Y') }} SIBANTU – Sistem Informasi Bantuan untuk Masyarakat</p>
            <p class="text-[10px] text-slate-300 mt-1">Panel Admin Premium – Dikembangkan untuk efisiensi dan transparansi publik</p>
        </footer>
    </div>
</body>
</html>
