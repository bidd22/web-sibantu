<?php use App\Models\Menu; ?>
@php
    $isAdmin = Auth::check() && Auth::user()->role === 'admin';
@endphp
<nav class="bg-white/80 backdrop-blur-md border-b border-gray-100 sticky top-0 z-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap justify-between items-center h-16">
            <!-- Logo kiri -->
            <div class="flex-shrink-0">
                <a href="{{ $isAdmin ? route('admin.dashboard') : route('dashboard') }}" class="text-xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">SIBANTU</a>
            </div>

            <!-- Menu tengah (desktop) -->
            <div class="hidden md:flex space-x-8 mx-auto">
                @if($isAdmin)
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-indigo-600 font-medium text-sm">Dashboard</a>
                    <a href="{{ route('admin.programs.index') }}" class="text-gray-600 hover:text-indigo-600 font-medium text-sm">Program</a>
                    <a href="{{ route('admin.pengajuans.index') }}" class="text-gray-600 hover:text-indigo-600 font-medium text-sm">Pengajuan</a>
                    <a href="{{ route('admin.pengaduans.index') }}" class="text-gray-600 hover:text-indigo-600 font-medium text-sm">Pengaduan</a>
                    <a href="{{ route('admin.menus.index') }}" class="text-gray-600 hover:text-indigo-600 font-medium text-sm">Menu</a>
                @else
                    <a href="#beranda" class="text-gray-600 hover:text-indigo-600 font-medium text-sm nav-link" data-target="beranda">Beranda</a>
                    <a href="#ajukan" class="text-gray-600 hover:text-indigo-600 font-medium text-sm nav-link" data-target="ajukan">Ajukan Bantuan</a>
                    <a href="#riwayat" class="text-gray-600 hover:text-indigo-600 font-medium text-sm nav-link" data-target="riwayat">Lacak Status</a>
                    <a href="#pengaduan" class="text-gray-600 hover:text-indigo-600 font-medium text-sm nav-link" data-target="pengaduan">Pengaduan</a>
                @endif
            </div>

            <!-- Profile kanan -->
            <div class="flex items-center space-x-4">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-r from-indigo-500 to-purple-500 flex items-center justify-center text-white text-sm font-bold">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <span class="text-sm font-medium text-gray-700 hidden md:block">{{ Auth::user()->name }}</span>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-sm text-gray-500 hover:text-gray-700">Keluar</button>
                </form>
            </div>
        </div>

        <!-- Mobile menu -->
        <div class="md:hidden flex justify-end pb-2">
            <button id="mobile-menu-button" class="text-gray-600 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
        </div>
        <div id="mobile-menu" class="md:hidden hidden pb-4">
            <div class="flex flex-col space-y-2">
                @if($isAdmin)
                    <a href="{{ route('admin.dashboard') }}" class="block text-gray-600 hover:text-indigo-600">Dashboard</a>
                    <a href="{{ route('admin.programs.index') }}" class="block text-gray-600 hover:text-indigo-600">Program</a>
                    <a href="{{ route('admin.pengajuans.index') }}" class="block text-gray-600 hover:text-indigo-600">Pengajuan</a>
                    <a href="{{ route('admin.pengaduans.index') }}" class="block text-gray-600 hover:text-indigo-600">Pengaduan</a>
                    <a href="{{ route('admin.menus.index') }}" class="block text-gray-600 hover:text-indigo-600">Menu</a>
                @else
                    <a href="#beranda" class="block text-gray-600 hover:text-indigo-600 nav-link" data-target="beranda">Beranda</a>
                    <a href="#ajukan" class="block text-gray-600 hover:text-indigo-600 nav-link" data-target="ajukan">Ajukan Bantuan</a>
                    <a href="#riwayat" class="block text-gray-600 hover:text-indigo-600 nav-link" data-target="riwayat">Lacak Status</a>
                    <a href="#pengaduan" class="block text-gray-600 hover:text-indigo-600 nav-link" data-target="pengaduan">Pengaduan</a>
                @endif
            </div>
        </div>
    </div>
</nav>

<script>
    // Toggle mobile
    const toggleBtn = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    if(toggleBtn && mobileMenu) {
        toggleBtn.addEventListener('click', () => mobileMenu.classList.toggle('hidden'));
    }
    // Smooth scroll untuk user
    @if(!$isAdmin)
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('data-target');
            const target = document.getElementById(targetId);
            if(target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                if(mobileMenu && !mobileMenu.classList.contains('hidden')) {
                    mobileMenu.classList.add('hidden');
                }
            }
        });
    });
    @endif
</script>