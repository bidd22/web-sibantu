@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Dashboard</h1>
            <p class="text-gray-500 mt-1">Pantau statistik permohonan bantuan, kelola pengaduan warga, dan konfigurasi sistem secara efisien.</p>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
        <!-- Total Pengajuan -->
        <a href="{{ route('admin.pengajuans.index') }}" 
           class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md hover:scale-[1.01] active:scale-[0.99] hover:border-indigo-200 transition-all duration-200 flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-xs font-semibold uppercase tracking-wider">Total Pengajuan</p>
                    <p class="text-3xl font-extrabold text-gray-900 mt-1">{{ $totalPengajuan }}</p>
                </div>
                <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center shadow-inner">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs text-indigo-600 font-medium">
                <span>Kelola pengajuan</span>
                <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
            </div>
        </a>

        <!-- Pending -->
        <a href="{{ route('admin.pengajuans.index') }}" 
           class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md hover:scale-[1.01] active:scale-[0.99] hover:border-amber-200 transition-all duration-200 flex flex-col justify-between relative">
            @if($pending > 0)
            <span class="absolute top-4 right-4 flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span>
            </span>
            @endif
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-xs font-semibold uppercase tracking-wider">Pending</p>
                    <p class="text-3xl font-extrabold text-amber-600 mt-1">{{ $pending }}</p>
                </div>
                <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center shadow-inner">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs text-amber-600 font-medium">
                <span>Perlu tindakan segera</span>
                <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
            </div>
        </a>

        <!-- Pengaduan -->
        <a href="{{ route('admin.pengaduans.index') }}" 
           class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md hover:scale-[1.01] active:scale-[0.99] hover:border-red-200 transition-all duration-200 flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-xs font-semibold uppercase tracking-wider">Pengaduan</p>
                    <p class="text-3xl font-extrabold text-red-600 mt-1">{{ $totalPengaduan }}</p>
                </div>
                <div class="w-12 h-12 bg-red-50 text-red-600 rounded-2xl flex items-center justify-center shadow-inner">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs text-red-600 font-medium">
                <span>Kelola pengaduan</span>
                <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
            </div>
        </a>

        <!-- Warga Terdaftar -->
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-xs font-semibold uppercase tracking-wider">Warga Terdaftar</p>
                    <p class="text-3xl font-extrabold text-green-600 mt-1">{{ $totalWarga }}</p>
                </div>
                <div class="w-12 h-12 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center shadow-inner">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs text-gray-400 font-medium">
                <span>Tergabung dalam sistem</span>
            </div>
        </div>
    </div>

    <!-- Quick Actions Control Center -->
    <div class="space-y-4">
        <h2 class="text-lg font-bold text-gray-900 tracking-tight flex items-center gap-2">
            <span class="w-2.5 h-2.5 rounded-full bg-indigo-600"></span>
            Menu Pusat Kontrol
        </h2>
        <div class="grid md:grid-cols-2 gap-5">
            <!-- Kelola Pengajuan -->
            <a href="{{ route('admin.pengajuans.index') }}" 
               class="relative bg-white rounded-2xl border border-gray-100 p-6 flex flex-col justify-between hover:shadow-lg hover:border-indigo-100 hover:scale-[1.01] group transition-all duration-300">
                <div class="space-y-3">
                    <div class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center">
                        <svg class="w-5.5 h-5.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800 text-base">Kelola Pengajuan Bantuan</h3>
                        <p class="text-xs text-gray-400 mt-1 leading-relaxed">Tinjau alasan permohonan bantuan dari warga, verifikasi dokumen, dan berikan persetujuan atau penolakan bantuan.</p>
                    </div>
                </div>
                <div class="mt-6 flex items-center text-xs font-bold text-indigo-600 gap-1">
                    <span>Buka Kelola Pengajuan</span>
                    <svg class="w-4 h-4 group-hover:translate-x-1.5 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg>
                </div>
            </a>

            <!-- Kelola Pengaduan -->
            <a href="{{ route('admin.pengaduans.index') }}" 
               class="relative bg-white rounded-2xl border border-gray-100 p-6 flex flex-col justify-between hover:shadow-lg hover:border-indigo-100 hover:scale-[1.01] group transition-all duration-300">
                <div class="space-y-3">
                    <div class="w-10 h-10 bg-red-50 text-red-600 rounded-xl flex items-center justify-center">
                        <svg class="w-5.5 h-5.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800 text-base">Kelola Pengaduan Warga</h3>
                        <p class="text-xs text-gray-400 mt-1 leading-relaxed">Respons aspirasi, saran, kritik, dan keluhan masyarakat terkait penyelenggaraan bantuan secara transparan.</p>
                    </div>
                </div>
                <div class="mt-6 flex items-center text-xs font-bold text-indigo-600 gap-1">
                    <span>Buka Kelola Pengaduan</span>
                    <svg class="w-4 h-4 group-hover:translate-x-1.5 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg>
                </div>
            </a>

            <!-- Program Bantuan -->
            <a href="{{ route('admin.programs.index') }}" 
               class="relative bg-white rounded-2xl border border-gray-100 p-6 flex flex-col justify-between hover:shadow-lg hover:border-indigo-100 hover:scale-[1.01] group transition-all duration-300">
                <div class="space-y-3">
                    <div class="w-10 h-10 bg-green-50 text-green-600 rounded-xl flex items-center justify-center">
                        <svg class="w-5.5 h-5.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.62 48.62 0 0112 20.9c4.956 0 9.31-1.766 12.23-4.707-.13-2.115-.298-4.234-.51-6.347M12 2.25l-9 4.75 9 4.75 9-4.75-9-4.75z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800 text-base">Atur Program Bantuan</h3>
                        <p class="text-xs text-gray-400 mt-1 leading-relaxed">Buat program bantuan sosial baru, sunting persyaratan & kuota, serta atur tenggat waktu penutupan pendaftaran.</p>
                    </div>
                </div>
                <div class="mt-6 flex items-center text-xs font-bold text-indigo-600 gap-1">
                    <span>Buka Program Bantuan</span>
                    <svg class="w-4 h-4 group-hover:translate-x-1.5 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg>
                </div>
            </a>

            <!-- Manajemen Menu -->
            <a href="{{ route('admin.menus.index') }}" 
               class="relative bg-white rounded-2xl border border-gray-100 p-6 flex flex-col justify-between hover:shadow-lg hover:border-indigo-100 hover:scale-[1.01] group transition-all duration-300">
                <div class="space-y-3">
                    <div class="w-10 h-10 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center">
                        <svg class="w-5.5 h-5.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V17.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25v-1.5zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V17.25A2.25 2.25 0 0118 19.5h-2.25a2.25 2.25 0 01-2.25-2.25v-1.5z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800 text-base">Manajemen Menu Navigasi</h3>
                        <p class="text-xs text-gray-400 mt-1 leading-relaxed">Sesuaikan tautan navigasi aplikasi, tambah menu kustom, dan atur struktur halaman informasi publik.</p>
                    </div>
                </div>
                <div class="mt-6 flex items-center text-xs font-bold text-indigo-600 gap-1">
                    <span>Buka Manajemen Menu</span>
                    <svg class="w-4 h-4 group-hover:translate-x-1.5 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg>
                </div>
            </a>
        </div>
    </div>

    <!-- Aktivitas Terbaru Widgets -->
    <div class="grid lg:grid-cols-2 gap-6">
        <!-- Pengajuan Terbaru -->
        <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-gray-50 pb-3">
                <h3 class="font-extrabold text-gray-800 text-sm tracking-wide uppercase flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Pengajuan Terbaru
                </h3>
                <a href="{{ route('admin.pengajuans.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 transition">Lihat Semua</a>
            </div>
            
            <div class="divide-y divide-gray-50">
                @forelse($recentPengajuans as $p)
                <div class="py-3 flex items-center justify-between first:pt-0 last:pb-0">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-indigo-500 to-purple-600 flex items-center justify-center text-white text-xs font-bold shadow-sm">
                            {{ strtoupper(substr($p->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="text-xs font-bold text-gray-900">{{ $p->user->name }}</div>
                            <div class="text-[10px] text-gray-400">{{ $p->program->nama_program }}</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-[10px] text-gray-400 hidden sm:block">{{ $p->created_at->diffForHumans() }}</span>
                        @if($p->status === 'pending')
                            <span class="px-2 py-0.5 rounded-full bg-amber-50 border border-amber-200 text-amber-700 text-[10px] font-bold">Pending</span>
                        @elseif($p->status === 'disetujui')
                            <span class="px-2 py-0.5 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 text-[10px] font-bold">Setuju</span>
                        @else
                            <span class="px-2 py-0.5 rounded-full bg-rose-50 border border-rose-200 text-rose-700 text-[10px] font-bold">Tolak</span>
                        @endif
                    </div>
                </div>
                @empty
                <div class="py-6 text-center text-xs text-gray-400">Belum ada pengajuan masuk.</div>
                @endforelse
            </div>
        </div>

        <!-- Pengaduan Terbaru -->
        <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-gray-50 pb-3">
                <h3 class="font-extrabold text-gray-800 text-sm tracking-wide uppercase flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    Pengaduan Terbaru
                </h3>
                <a href="{{ route('admin.pengaduans.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 transition">Lihat Semua</a>
            </div>

            <div class="divide-y divide-gray-50">
                @forelse($recentPengaduans as $p)
                <div class="py-3 flex items-center justify-between first:pt-0 last:pb-0">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-rose-500 to-amber-500 flex items-center justify-center text-white text-xs font-bold shadow-sm">
                            {{ strtoupper(substr($p->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="text-xs font-bold text-gray-900">{{ $p->user->name }}</div>
                            <div class="text-[10px] text-gray-400 truncate max-w-[150px] sm:max-w-xs">{{ $p->judul }}</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-[10px] text-gray-400 hidden sm:block">{{ $p->created_at->diffForHumans() }}</span>
                        @if($p->status === 'diterima')
                            <span class="px-2 py-0.5 rounded-full bg-blue-50 border border-blue-200 text-blue-700 text-[10px] font-bold">Diterima</span>
                        @elseif($p->status === 'proses')
                            <span class="px-2 py-0.5 rounded-full bg-amber-50 border border-amber-200 text-amber-700 text-[10px] font-bold">Proses</span>
                        @else
                            <span class="px-2 py-0.5 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 text-[10px] font-bold">Selesai</span>
                        @endif
                    </div>
                </div>
                @empty
                <div class="py-6 text-center text-xs text-gray-400">Belum ada pengaduan masuk.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection