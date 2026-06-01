@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between border-b border-gray-100 pb-4">
        <div>
            <h1 class="text-xl font-bold text-gray-900 tracking-tight">Admin</h1>
            <p class="text-xs text-gray-500 mt-0.5">Ringkasan statistik data permohonan bantuan dan pengaduan warga.</p>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Pengajuan -->
        <a href="{{ route('admin.pengajuans.index') }}" class="bg-white rounded-lg p-4 border border-gray-200 shadow-sm flex items-center justify-between hover:bg-gray-50 transition">
            <div>
                <p class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Total Pengajuan</p>
                <p class="text-2xl font-extrabold text-gray-990 mt-1">{{ $totalPengajuan }}</p>
            </div>
            <div class="w-9 h-9 bg-indigo-50 text-indigo-600 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
        </a>

        <!-- Pending -->
        <a href="{{ route('admin.pengajuans.index') }}" class="bg-white rounded-lg p-4 border border-gray-200 shadow-sm flex items-center justify-between relative hover:bg-gray-50 transition">
            @if($pending > 0)
            <span class="absolute top-3 right-3 flex h-1.5 w-1.5">
                <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-amber-500"></span>
            </span>
            @endif
            <div>
                <p class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Pending</p>
                <p class="text-2xl font-extrabold text-amber-600 mt-1">{{ $pending }}</p>
            </div>
            <div class="w-9 h-9 bg-amber-50 text-amber-600 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </a>

        <!-- Pengaduan -->
        <a href="{{ route('admin.pengaduans.index') }}" class="bg-white rounded-lg p-4 border border-gray-200 shadow-sm flex items-center justify-between hover:bg-gray-50 transition">
            <div>
                <p class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Pengaduan</p>
                <p class="text-2xl font-extrabold text-red-600 mt-1">{{ $totalPengaduan }}</p>
            </div>
            <div class="w-9 h-9 bg-red-50 text-red-600 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
            </div>
        </a>

        <!-- Warga Terdaftar -->
        <div class="bg-white rounded-lg p-4 border border-gray-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Warga Terdaftar</p>
                <p class="text-2xl font-extrabold text-green-600 mt-1">{{ $totalWarga }}</p>
            </div>
            <div class="w-9 h-9 bg-green-50 text-green-600 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Menu Pusat Kontrol (Disatukan Menjadi Satu Jalur Akses Cepat yang Ringkas) -->
    <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-sm font-bold text-gray-900">Pusat Manajemen Sistem</h2>
            <p class="text-xs text-gray-400 mt-0.5">Akses cepat modifikasi data program, verifikasi berkas pengajuan, konfigurasi menu, dan respons pengaduan.</p>
        </div>
        <div class="flex items-center gap-2 shrink-0">
            <a href="{{ route('admin.pengajuans.index') }}" class="px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-600 text-xs font-semibold rounded transition">
                Kelola Pengajuan
            </a>
            <a href="{{ route('admin.pengaduans.index') }}" class="px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 text-xs font-semibold rounded transition">
                Pengaduan
            </a>
            <a href="{{ route('admin.programs.index') }}" class="px-3 py-1.5 bg-green-50 hover:bg-green-100 text-green-600 text-xs font-semibold rounded transition">
                Atur Program
            </a>
            <a href="{{ route('admin.menus.index') }}" class="px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-600 text-xs font-semibold rounded transition">
                Navigasi
            </a>
        </div>
    </div>

    <!-- Aktivitas Terbaru Widgets -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <!-- Pengajuan Terbaru -->
        <div class="bg-white border border-gray-200 rounded-lg p-4 space-y-3 shadow-sm">
            <div class="flex items-center justify-between border-b border-gray-100 pb-2">
                <h3 class="font-bold text-gray-800 text-xs tracking-wide uppercase flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Pengajuan Terbaru
                </h3>
                <a href="{{ route('admin.pengajuans.index') }}" class="text-xs font-semibold text-indigo-600 hover:underline">Lihat Semua</a>
            </div>
            
            <div class="divide-y divide-gray-50">
                @forelse($recentPengajuans as $p)
                <div class="py-2.5 flex items-center justify-between first:pt-0 last:pb-0">
                    <div class="flex items-center gap-3">
                        <div class="w-7 h-7 rounded bg-indigo-50 text-indigo-600 flex items-center justify-center text-xs font-bold">
                            {{ strtoupper(substr($p->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="text-xs font-semibold text-gray-900">{{ $p->user->name }}</div>
                            <div class="text-[10px] text-gray-400">{{ $p->program->nama_program }}</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-[10px] text-gray-400 hidden sm:block">{{ $p->created_at->diffForHumans() }}</span>
                        @if($p->status === 'pending')
                            <span class="px-2 py-0.5 rounded bg-amber-50 border border-amber-200 text-amber-700 text-[10px] font-semibold">Pending</span>
                        @elseif($p->status === 'disetujui')
                            <span class="px-2 py-0.5 rounded bg-emerald-50 border border-emerald-200 text-emerald-700 text-[10px] font-semibold">Setuju</span>
                        @else
                            <span class="px-2 py-0.5 rounded bg-rose-50 border border-rose-200 text-rose-700 text-[10px] font-semibold">Tolak</span>
                        @endif
                    </div>
                </div>
                @empty
                <div class="py-4 text-center text-xs text-gray-400">Belum ada pengajuan masuk.</div>
                @endforelse
            </div>
        </div>

        <!-- Pengaduan Terbaru -->
        <div class="bg-white border border-gray-200 rounded-lg p-4 space-y-3 shadow-sm">
            <div class="flex items-center justify-between border-b border-gray-100 pb-2">
                <h3 class="font-bold text-gray-800 text-xs tracking-wide uppercase flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    Pengaduan Terbaru
                </h3>
                <a href="{{ route('admin.pengaduans.index') }}" class="text-xs font-semibold text-indigo-600 hover:underline">Lihat Semua</a>
            </div>

            <div class="divide-y divide-gray-50">
                @forelse($recentPengaduans as $p)
                <div class="py-2.5 flex items-center justify-between first:pt-0 last:pb-0">
                    <div class="flex items-center gap-3">
                        <div class="w-7 h-7 rounded bg-red-50 text-red-600 flex items-center justify-center text-xs font-bold">
                            {{ strtoupper(substr($p->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="text-xs font-semibold text-gray-900">{{ $p->user->name }}</div>
                            <div class="text-[10px] text-gray-400 truncate max-w-[150px] sm:max-w-xs">{{ $p->judul }}</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-[10px] text-gray-400 hidden sm:block">{{ $p->created_at->diffForHumans() }}</span>
                        @if($p->status === 'diterima')
                            <span class="px-2 py-0.5 rounded bg-blue-50 border border-blue-200 text-blue-700 text-[10px] font-semibold">Diterima</span>
                        @elseif($p->status === 'proses')
                            <span class="px-2 py-0.5 rounded bg-amber-50 border border-amber-200 text-amber-700 text-[10px] font-semibold">Proses</span>
                        @else
                            <span class="px-2 py-0.5 rounded bg-emerald-50 border border-emerald-200 text-emerald-700 text-[10px] font-semibold">Selesai</span>
                        @endif
                    </div>
                </div>
                @empty
                <div class="py-4 text-center text-xs text-gray-400">Belum ada pengaduan masuk.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection