@extends('layouts.admin')

@section('content')
<div class="space-y-6 antialiased">
    <!-- Header Dashboard -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between border-b border-slate-200/60 pb-5 gap-4 fade-in-up">
        <div class="space-y-1">
            <div class="flex items-center gap-2 text-xs font-bold text-slate-500 uppercase tracking-widest">
                <span class="px-2 py-0.5 bg-slate-100 border border-slate-200 rounded-md">Ikhtisar</span>
                <span class="text-slate-300">•</span>
                <span class="text-slate-500 font-medium">Statistik Sistem</span>
            </div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Dashboard Admin</h1>
            <p class="text-xs font-medium text-slate-500">Ringkasan operasional data permohonan bantuan dan laporan pengaduan warga.</p>
        </div>
    </div>

    <!-- Statistik Cards (Neutral Grid) -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 fade-in-up" style="animation-delay: 0.1s;">
        <!-- Total Pengajuan -->
        <a href="{{ route('admin.pengajuans.index') }}" class="group bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:shadow-md hover:border-slate-300 hover:-translate-y-0.5 transition-all duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-500 text-[10px] font-bold uppercase tracking-wider">Total Pengajuan</p>
                    <p class="text-3xl font-black text-slate-900 mt-1">{{ $totalPengajuan }}</p>
                </div>
                <div class="w-12 h-12 bg-slate-50 text-slate-500 rounded-2xl flex items-center justify-center border border-slate-100 group-hover:bg-slate-800 group-hover:text-white transition-colors duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-[10px] text-slate-500 font-extrabold uppercase tracking-wider opacity-0 group-hover:opacity-100 transition-opacity transform translate-x-[-10px] group-hover:translate-x-0 group-hover:text-slate-800">
                <span>Kelola Data</span>
                <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
            </div>
        </a>

        <!-- Pending -->
        <a href="{{ route('admin.pengajuans.index') }}" class="group bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:shadow-md hover:border-slate-300 hover:-translate-y-0.5 transition-all duration-200 relative">
            @if($pending > 0)
            <span class="absolute top-4 right-4 flex h-2.5 w-2.5">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-slate-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-slate-500"></span>
            </span>
            @endif
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-500 text-[10px] font-bold uppercase tracking-wider">Perlu Verifikasi</p>
                    <p class="text-3xl font-black text-slate-900 mt-1">{{ $pending }}</p>
                </div>
                <div class="w-12 h-12 bg-slate-50 text-slate-500 rounded-2xl flex items-center justify-center border border-slate-100 group-hover:bg-slate-800 group-hover:text-white transition-colors duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-[10px] text-slate-500 font-extrabold uppercase tracking-wider opacity-0 group-hover:opacity-100 transition-opacity transform translate-x-[-10px] group-hover:translate-x-0 group-hover:text-slate-800">
                <span>Tinjau Sekarang</span>
                <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
            </div>
        </a>

        <!-- Pengaduan -->
        <a href="{{ route('admin.pengaduans.index') }}" class="group bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:shadow-md hover:border-slate-300 hover:-translate-y-0.5 transition-all duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-500 text-[10px] font-bold uppercase tracking-wider">Pengaduan</p>
                    <p class="text-3xl font-black text-slate-900 mt-1">{{ $totalPengaduan }}</p>
                </div>
                <div class="w-12 h-12 bg-slate-50 text-slate-500 rounded-2xl flex items-center justify-center border border-slate-100 group-hover:bg-slate-800 group-hover:text-white transition-colors duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-[10px] text-slate-500 font-extrabold uppercase tracking-wider opacity-0 group-hover:opacity-100 transition-opacity transform translate-x-[-10px] group-hover:translate-x-0 group-hover:text-slate-800">
                <span>Respon Laporan</span>
                <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
            </div>
        </a>

        <!-- Warga Terdaftar -->
        <div class="group bg-white rounded-2xl p-5 border border-slate-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-500 text-[10px] font-bold uppercase tracking-wider">Warga Terdaftar</p>
                    <p class="text-3xl font-black text-slate-900 mt-1">{{ $totalWarga }}</p>
                </div>
                <div class="w-12 h-12 bg-slate-50 text-slate-500 rounded-2xl flex items-center justify-center border border-slate-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-[10px] text-slate-400 font-extrabold uppercase tracking-wider">
                <span>Pengguna Aktif</span>
            </div>
        </div>
    </div>

    <!-- Menu Pusat Kontrol (Netral) -->
    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4 fade-in-up" style="animation-delay: 0.2s;">
        <div class="space-y-0.5">
            <h2 class="text-sm font-black text-slate-900">Pusat Manajemen Sistem</h2>
            <p class="text-xs text-slate-500 font-medium">Akses cepat modifikasi data program, verifikasi berkas pengajuan, konfigurasi menu, dan respons pengaduan.</p>
        </div>
        <div class="flex flex-wrap items-center gap-2 p-1.5 bg-slate-50 border border-slate-200/60 rounded-xl self-start sm:self-auto">
            <a href="{{ route('admin.pengajuans.index') }}" class="px-4 py-2 text-xs font-extrabold rounded-lg transition duration-150 text-slate-600 hover:text-slate-900 hover:bg-white hover:shadow-sm">
                Kelola Pengajuan
            </a>
            <a href="{{ route('admin.pengaduans.index') }}" class="px-4 py-2 text-xs font-extrabold rounded-lg transition duration-150 text-slate-600 hover:text-slate-900 hover:bg-white hover:shadow-sm">
                Pengaduan
            </a>
            <a href="{{ route('admin.programs.index') }}" class="px-4 py-2 text-xs font-extrabold rounded-lg transition duration-150 text-slate-600 hover:text-slate-900 hover:bg-white hover:shadow-sm">
                Atur Program
            </a>
            <a href="{{ route('admin.menus.index') }}" class="px-4 py-2 text-xs font-extrabold rounded-lg transition duration-150 text-slate-600 hover:text-slate-900 hover:bg-white hover:shadow-sm">
                Navigasi
            </a>
        </div>
    </div>

    <!-- Aktivitas Terbaru Widgets (Netral) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 fade-in-up" style="animation-delay: 0.3s;">
        <!-- Pengajuan Terbaru -->
        <div class="bg-white border border-slate-200 rounded-2xl p-0 shadow-sm overflow-hidden flex flex-col">
            <div class="px-5 py-4 bg-slate-50/80 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-extrabold text-slate-800 text-xs tracking-wider uppercase flex items-center gap-2">
                    <div class="w-6 h-6 rounded-md bg-slate-200/50 text-slate-600 flex items-center justify-center border border-slate-200">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    Pengajuan Terbaru
                </h3>
                <a href="{{ route('admin.pengajuans.index') }}" class="text-[10px] font-extrabold uppercase tracking-wider text-slate-500 hover:text-slate-900 hover:bg-slate-200/50 px-2.5 py-1 rounded-md transition">Lihat Semua</a>
            </div>
            
            <div class="divide-y divide-slate-100 flex-1">
                @forelse($recentPengajuans as $p)
                <div class="p-4 hover:bg-slate-50/50 transition flex items-center justify-between group">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center text-xs font-black border border-slate-200">
                            {{ strtoupper(substr($p->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="text-sm font-extrabold text-slate-900 transition">{{ $p->user->name }}</div>
                            <div class="text-[11px] font-medium text-slate-500 mt-0.5 truncate max-w-[200px]">{{ $p->program->nama_program }}</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-[10px] font-medium text-slate-400 hidden sm:block">{{ $p->created_at->diffForHumans() }}</span>
                        @if($p->status === 'pending')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-slate-50 text-slate-600 border border-slate-200 rounded-md text-[10px] font-bold tracking-wide">
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400 animate-pulse"></span> Pending
                            </span>
                        @elseif($p->status === 'disetujui')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-slate-800 text-slate-100 border border-slate-700 rounded-md text-[10px] font-bold tracking-wide">
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Setuju
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-slate-100 text-slate-500 border border-slate-300 rounded-md text-[10px] font-bold tracking-wide">
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span> Tolak
                            </span>
                        @endif
                    </div>
                </div>
                @empty
                <div class="p-8 text-center flex flex-col items-center">
                    <div class="w-12 h-12 bg-slate-50 text-slate-300 rounded-xl flex items-center justify-center mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                    </div>
                    <span class="text-xs font-bold text-slate-400">Belum ada pengajuan baru.</span>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Pengaduan Terbaru -->
        <div class="bg-white border border-slate-200 rounded-2xl p-0 shadow-sm overflow-hidden flex flex-col">
            <div class="px-5 py-4 bg-slate-50/80 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-extrabold text-slate-800 text-xs tracking-wider uppercase flex items-center gap-2">
                    <div class="w-6 h-6 rounded-md bg-slate-200/50 text-slate-600 flex items-center justify-center border border-slate-200">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    </div>
                    Pengaduan Warga
                </h3>
                <a href="{{ route('admin.pengaduans.index') }}" class="text-[10px] font-extrabold uppercase tracking-wider text-slate-500 hover:text-slate-900 hover:bg-slate-200/50 px-2.5 py-1 rounded-md transition">Lihat Semua</a>
            </div>

            <div class="divide-y divide-slate-100 flex-1">
                @forelse($recentPengaduans as $p)
                <div class="p-4 hover:bg-slate-50/50 transition flex items-center justify-between group">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center text-xs font-black border border-slate-200">
                            {{ strtoupper(substr($p->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="text-sm font-extrabold text-slate-900 transition">{{ $p->user->name }}</div>
                            <div class="text-[11px] font-medium text-slate-500 mt-0.5 truncate max-w-[150px] sm:max-w-[200px]">{{ $p->judul }}</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-[10px] font-medium text-slate-400 hidden sm:block">{{ $p->created_at->diffForHumans() }}</span>
                        @if($p->status === 'diterima')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-slate-100 text-slate-600 border border-slate-300 rounded-md text-[10px] font-bold tracking-wide">
                                Diterima
                            </span>
                        @elseif($p->status === 'proses')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-slate-50 text-slate-600 border border-slate-200 rounded-md text-[10px] font-bold tracking-wide">
                                Proses
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-slate-800 text-slate-100 border border-slate-700 rounded-md text-[10px] font-bold tracking-wide">
                                Selesai
                            </span>
                        @endif
                    </div>
                </div>
                @empty
                <div class="p-8 text-center flex flex-col items-center">
                    <div class="w-12 h-12 bg-slate-50 text-slate-300 rounded-xl flex items-center justify-center mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    </div>
                    <span class="text-xs font-bold text-slate-400">Belum ada pengaduan masuk.</span>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<style>
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(15px); }
    to { opacity: 1; transform: translateY(0); }
}
.fade-in-up {
    animation: fadeInUp 0.5s ease-out forwards;
    opacity: 0;
}
</style>
@endsection