<?php use App\Models\Menu; ?>
@php
    $isAdmin = Auth::check() && Auth::user()->role === 'admin';
@endphp
<nav class="bg-white/90 backdrop-blur-md border-b border-slate-100 sticky top-0 z-30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-14">
            {{-- Logo --}}
            <div class="flex-shrink-0">
                <a href="{{ $isAdmin ? route('admin.dashboard') : route('dashboard') }}" class="text-lg font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent tracking-tight">SIBANTU</a>
            </div>

            {{-- Desktop Nav --}}
            <div class="hidden md:flex items-center gap-1 mx-auto">
                @if($isAdmin)
                    <a href="{{ route('admin.dashboard') }}" class="px-3 py-1.5 text-slate-500 hover:text-indigo-600 hover:bg-indigo-50/60 rounded-lg font-medium text-sm transition">Dashboard</a>
                    <a href="{{ route('admin.programs.index') }}" class="px-3 py-1.5 text-slate-500 hover:text-indigo-600 hover:bg-indigo-50/60 rounded-lg font-medium text-sm transition">Program</a>
                    <a href="{{ route('admin.pengajuans.index') }}" class="px-3 py-1.5 text-slate-500 hover:text-indigo-600 hover:bg-indigo-50/60 rounded-lg font-medium text-sm transition">Pengajuan</a>
                    <a href="{{ route('admin.pengaduans.index') }}" class="px-3 py-1.5 text-slate-500 hover:text-indigo-600 hover:bg-indigo-50/60 rounded-lg font-medium text-sm transition">Pengaduan</a>
                    <a href="{{ route('admin.menus.index') }}" class="px-3 py-1.5 text-slate-500 hover:text-indigo-600 hover:bg-indigo-50/60 rounded-lg font-medium text-sm transition">Menu</a>
                @else
                    <a href="#beranda" class="px-3 py-1.5 text-slate-500 hover:text-indigo-600 hover:bg-indigo-50/60 rounded-lg font-medium text-sm transition nav-link" data-target="beranda">Beranda</a>
                    <a href="#ajukan" class="px-3 py-1.5 text-slate-500 hover:text-indigo-600 hover:bg-indigo-50/60 rounded-lg font-medium text-sm transition nav-link" data-target="ajukan">Ajukan Bantuan</a>
                    <a href="#riwayat" class="px-3 py-1.5 text-slate-500 hover:text-indigo-600 hover:bg-indigo-50/60 rounded-lg font-medium text-sm transition nav-link" data-target="riwayat">Lacak Status</a>
                    <a href="#pengaduan" class="px-3 py-1.5 text-slate-500 hover:text-indigo-600 hover:bg-indigo-50/60 rounded-lg font-medium text-sm transition nav-link" data-target="pengaduan">Pengaduan</a>
                @endif
            </div>

            {{-- Right: Profile + Logout --}}
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg bg-gradient-to-r from-indigo-500 to-purple-500 flex items-center justify-center text-white text-[11px] font-bold">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <span class="text-sm font-medium text-slate-600 hidden md:block">{{ Auth::user()->name }}</span>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-xs font-medium text-slate-400 hover:text-rose-500 bg-slate-50 hover:bg-rose-50 border border-slate-200 hover:border-rose-200 px-2.5 py-1.5 rounded-lg transition">Keluar</button>
                </form>

                {{-- Mobile hamburger --}}
                <button id="mobile-menu-button" class="md:hidden text-slate-500 hover:text-slate-700 p-1.5 rounded-lg hover:bg-slate-50 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></svg>
                </button>
            </div>
        </div>

        {{-- Mobile menu --}}
        <div id="mobile-menu" class="md:hidden hidden pb-3 pt-1 border-t border-slate-100">
            <div class="flex flex-col gap-0.5">
                @if($isAdmin)
                    <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 text-slate-600 hover:text-indigo-600 hover:bg-indigo-50/60 rounded-lg text-sm font-medium transition">Dashboard</a>
                    <a href="{{ route('admin.programs.index') }}" class="px-3 py-2 text-slate-600 hover:text-indigo-600 hover:bg-indigo-50/60 rounded-lg text-sm font-medium transition">Program</a>
                    <a href="{{ route('admin.pengajuans.index') }}" class="px-3 py-2 text-slate-600 hover:text-indigo-600 hover:bg-indigo-50/60 rounded-lg text-sm font-medium transition">Pengajuan</a>
                    <a href="{{ route('admin.pengaduans.index') }}" class="px-3 py-2 text-slate-600 hover:text-indigo-600 hover:bg-indigo-50/60 rounded-lg text-sm font-medium transition">Pengaduan</a>
                    <a href="{{ route('admin.menus.index') }}" class="px-3 py-2 text-slate-600 hover:text-indigo-600 hover:bg-indigo-50/60 rounded-lg text-sm font-medium transition">Menu</a>
                @else
                    <a href="#beranda" class="px-3 py-2 text-slate-600 hover:text-indigo-600 hover:bg-indigo-50/60 rounded-lg text-sm font-medium transition nav-link" data-target="beranda">Beranda</a>
                    <a href="#ajukan" class="px-3 py-2 text-slate-600 hover:text-indigo-600 hover:bg-indigo-50/60 rounded-lg text-sm font-medium transition nav-link" data-target="ajukan">Ajukan Bantuan</a>
                    <a href="#riwayat" class="px-3 py-2 text-slate-600 hover:text-indigo-600 hover:bg-indigo-50/60 rounded-lg text-sm font-medium transition nav-link" data-target="riwayat">Lacak Status</a>
                    <a href="#pengaduan" class="px-3 py-2 text-slate-600 hover:text-indigo-600 hover:bg-indigo-50/60 rounded-lg text-sm font-medium transition nav-link" data-target="pengaduan">Pengaduan</a>
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
    // Smooth scroll for user nav
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