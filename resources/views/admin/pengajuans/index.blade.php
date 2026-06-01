@extends('layouts.admin')

@section('content')
@php
    $pengajuansData = $pengajuans->map(function($p) {
        return [
            'id' => $p->id,
            'pemohon' => $p->user->name,
            'email' => $p->user->email,
            'phone' => $p->user->phone ?? '-',
            'address' => $p->user->address ?? '-',
            'program' => $p->program->nama_program,
            'programDeskripsi' => $p->program->deskripsi ?? 'Tidak ada deskripsi.',
            'programKuota' => $p->program->kuota ?? 0,
            'programDeadline' => $p->program->deadline ? \Carbon\Carbon::parse($p->program->deadline)->format('d M Y') : '-',
            'alasan' => $p->alasan,
            'status' => $p->status,
            'tanggal' => $p->created_at->format('d M Y'),
            'updateRoute' => route('admin.pengajuans.update', $p)
        ];
    });
@endphp

<div class="space-y-6 antialiased" x-data="{
    search: '',
    statusFilter: 'semua',
    showDetail: false,
    selected: {},
    pengajuans: {{ json_encode($pengajuansData) }},
    stats: {
        total: {{ $pengajuans->count() }},
        pending: {{ $pengajuans->where('status', 'pending')->count() }},
        disetujui: {{ $pengajuans->where('status', 'disetujui')->count() }},
        ditolak: {{ $pengajuans->where('status', 'ditolak')->count() }}
    },
    get filteredPengajuans() {
        return this.pengajuans.filter(p => {
            const matchesSearch = p.pemohon.toLowerCase().includes(this.search.toLowerCase()) || 
                                  p.program.toLowerCase().includes(this.search.toLowerCase()) ||
                                  p.alasan.toLowerCase().includes(this.search.toLowerCase());
            const matchesStatus = this.statusFilter === 'semua' || p.status === this.statusFilter;
            return matchesSearch && matchesStatus;
        });
    },
    openModal(p) {
        this.selected = p;
        this.showDetail = true;
    },
    submitStatus(route, newStatus) {
        if (confirm(`Apakah Anda yakin ingin mengubah status pengajuan ini menjadi '${newStatus.toUpperCase()}'?`)) {
            const form = document.getElementById('update-status-form');
            form.action = route;
            document.getElementById('update-status-value').value = newStatus;
            form.submit();
        }
    }
}">
    <!-- Header Dashboard -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between border-b border-slate-200/60 pb-5 gap-4">
        <div class="space-y-1">
            <div class="flex items-center gap-2 text-xs font-bold text-indigo-600 uppercase tracking-widest">
                <span class="px-2 py-0.5 bg-indigo-50 border border-indigo-100 rounded-md">Verifikasi</span>
                <span class="text-slate-300">•</span>
                <span class="text-slate-500 font-medium">Data Permohonan</span>
            </div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Kelola Pengajuan Bantuan</h1>
            <p class="text-xs font-medium text-slate-500">Verifikasi, setujui, atau tolak permohonan bantuan dari masyarakat secara transparan.</p>
        </div>
    </div>

    <!-- Quick Navigation Tabs -->
    <div class="bg-white border border-slate-200/60 rounded-2xl p-4 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="space-y-0.5">
            <h2 class="text-xs font-extrabold uppercase tracking-wider text-slate-400">Pusat Kendali Cepat</h2>
            <p class="text-[11px] text-slate-500 font-medium">Beralih antar menu manajemen dengan satu klik.</p>
        </div>
        
        <div class="flex flex-wrap items-center gap-2 p-1 bg-slate-50 border border-slate-100 rounded-xl self-start sm:self-auto">
            <!-- Kelola Pengajuan -->
            <a href="{{ route('admin.pengajuans.index') }}" 
               class="px-4 py-2 text-xs font-extrabold rounded-lg transition duration-150 {{ request()->routeIs('admin.pengajuans.*') ? 'bg-indigo-50 text-indigo-700 shadow-2xs border border-indigo-100/50' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-100/50' }}">
                Kelola Pengajuan
            </a>

            <!-- Pengaduan Warga -->
            <a href="{{ route('admin.pengaduans.index') }}" 
               class="px-4 py-2 text-xs font-extrabold rounded-lg transition duration-150 {{ request()->routeIs('admin.pengaduans.*') ? 'bg-rose-50 text-rose-700 shadow-2xs border border-rose-100/50' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-100/50' }}">
                Pengaduan
            </a>

            <!-- Atur Program -->
            <a href="{{ route('admin.programs.index') }}" 
               class="px-4 py-2 text-xs font-extrabold rounded-lg transition duration-150 {{ request()->routeIs('admin.programs.*') ? 'bg-emerald-50 text-emerald-700 shadow-2xs border border-emerald-100/50' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-100/50' }}">
                Atur Program
            </a>

            <!-- Navigasi (Manajemen Menu) -->
            <a href="{{ route('admin.menus.index') }}" 
               class="px-4 py-2 text-xs font-extrabold rounded-lg transition duration-150 {{ request()->routeIs('admin.menus.*') ? 'bg-amber-50 text-amber-700 shadow-2xs border border-amber-100/50' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-100/50' }}">
                Navigasi
            </a>
        </div>
    </div>

    <!-- Statistik Cards (Interactive Grid Filter) -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total -->
        <div @click="statusFilter = 'semua'" 
             class="bg-white rounded-2xl p-5 border border-indigo-100/40 shadow-xs hover:shadow-md hover:scale-[1.01] active:scale-[0.99] cursor-pointer transition-all duration-200"
             :class="statusFilter === 'semua' ? 'ring-2 ring-indigo-500 border-transparent bg-indigo-50/20' : ''">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Total Pengajuan</p>
                    <p class="text-3xl font-black text-slate-900 mt-1" x-text="stats.total"></p>
                </div>
                <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center shadow-inner border border-indigo-100/50">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs text-indigo-600 font-extrabold">
                <span>Tampilkan semua data</span>
                <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
            </div>
        </div>

        <!-- Pending -->
        <div @click="statusFilter = 'pending'" 
             class="bg-white rounded-2xl p-5 border border-amber-100/40 shadow-xs hover:shadow-md hover:scale-[1.01] active:scale-[0.99] cursor-pointer transition-all duration-200"
             :class="statusFilter === 'pending' ? 'ring-2 ring-amber-500 border-transparent bg-amber-50/20' : ''">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Pending</p>
                    <p class="text-3xl font-black text-amber-600 mt-1" x-text="stats.pending"></p>
                </div>
                <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center shadow-inner border border-amber-100/50 relative">
                    <span class="absolute top-1.5 right-1.5 flex h-2.5 w-2.5" x-show="stats.pending > 0">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-amber-500"></span>
                    </span>
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs text-amber-600 font-extrabold">
                <span>Butuh verifikasi</span>
                <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
            </div>
        </div>

        <!-- Disetujui -->
        <div @click="statusFilter = 'disetujui'" 
             class="bg-white rounded-2xl p-5 border border-emerald-100/40 shadow-xs hover:shadow-md hover:scale-[1.01] active:scale-[0.99] cursor-pointer transition-all duration-200"
             :class="statusFilter === 'disetujui' ? 'ring-2 ring-emerald-500 border-transparent bg-emerald-50/20' : ''">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Disetujui</p>
                    <p class="text-3xl font-black text-emerald-600 mt-1" x-text="stats.disetujui"></p>
                </div>
                <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center shadow-inner border border-emerald-100/50">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs text-emerald-600 font-extrabold">
                <span>Pengajuan lolos</span>
                <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
            </div>
        </div>

        <!-- Ditolak -->
        <div @click="statusFilter = 'ditolak'" 
             class="bg-white rounded-2xl p-5 border border-rose-100/40 shadow-xs hover:shadow-md hover:scale-[1.01] active:scale-[0.99] cursor-pointer transition-all duration-200"
             :class="statusFilter === 'ditolak' ? 'ring-2 ring-rose-500 border-transparent bg-rose-50/20' : ''">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Ditolak</p>
                    <p class="text-3xl font-black text-rose-600 mt-1" x-text="stats.ditolak"></p>
                </div>
                <div class="w-12 h-12 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center shadow-inner border border-rose-100/50">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs text-rose-600 font-extrabold">
                <span>Pengajuan gugur</span>
                <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
            </div>
        </div>
    </div>

    <!-- Filter & Pencarian Bar -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white/90 backdrop-blur-md p-4 rounded-2xl border border-slate-200 shadow-xs">
        <!-- Sub-Tab Filter -->
        <div class="flex flex-wrap items-center gap-1.5 bg-slate-100/80 p-1.5 rounded-xl self-start">
            <button @click="statusFilter = 'semua'"
                    class="px-4 py-2 rounded-lg text-xs font-black uppercase tracking-wider transition duration-150"
                    :class="statusFilter === 'semua' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-500 hover:text-slate-950'">
                Semua
            </button>
            <button @click="statusFilter = 'pending'"
                    class="px-4 py-2 rounded-lg text-xs font-black uppercase tracking-wider transition duration-150 flex items-center gap-1.5"
                    :class="statusFilter === 'pending' ? 'bg-white text-amber-700 shadow-xs' : 'text-slate-500 hover:text-slate-950'">
                Pending
                <span class="w-1.5 h-1.5 rounded-full bg-amber-500" x-show="stats.pending > 0"></span>
            </button>
            <button @click="statusFilter = 'disetujui'"
                    class="px-4 py-2 rounded-lg text-xs font-black uppercase tracking-wider transition duration-150"
                    :class="statusFilter === 'disetujui' ? 'bg-white text-emerald-700 shadow-xs' : 'text-slate-500 hover:text-slate-950'">
                Disetujui
            </button>
            <button @click="statusFilter = 'ditolak'"
                    class="px-4 py-2 rounded-lg text-xs font-black uppercase tracking-wider transition duration-150"
                    :class="statusFilter === 'ditolak' ? 'bg-white text-rose-700 shadow-xs' : 'text-slate-500 hover:text-slate-950'">
                Ditolak
            </button>
        </div>

        <!-- Input Search Box -->
        <div class="relative w-full md:max-w-xs">
            <input type="text" 
                   x-model="search" 
                   placeholder="Cari nama pemohon atau program..." 
                   class="w-full text-xs pl-10 pr-8 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all duration-150 font-medium">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <button x-show="search !== ''" @click="search = ''" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 transition">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </div>

    <!-- Main List Presenter Area -->
    <div>
        <!-- Empty State Container -->
        <template x-if="filteredPengajuans.length === 0">
            <div class="bg-white border border-indigo-50 rounded-2xl p-12 text-center shadow-xs">
                <div class="w-16 h-16 bg-slate-50 text-slate-400 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-slate-100">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                </div>
                <h3 class="text-base font-black text-slate-900">Tidak ada pengajuan ditemukan</h3>
                <p class="text-xs font-medium text-slate-500 mt-1 max-w-xs mx-auto">Sistem tidak dapat menemukan berkas permohonan yang sesuai dengan filter pencarian Anda.</p>
                <button @click="search = ''; statusFilter = 'semua'" class="mt-4 inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-600 text-white text-xs font-bold rounded-xl hover:bg-indigo-700 shadow-lg shadow-indigo-600/10 transition">
                    Reset Filter
                </button>
            </div>
        </template>

        <!-- Desktop View (Luxury Table) -->
        <template x-if="filteredPengajuans.length > 0">
            <div class="hidden lg:block bg-white rounded-2xl border border-indigo-100 shadow-xl shadow-slate-200/40 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gradient-to-r from-indigo-50/70 to-slate-50/70 border-b border-indigo-100 text-xs font-bold uppercase tracking-wider text-indigo-900/80">
                                <th class="py-4 px-6">Pemohon</th>
                                <th class="py-4 px-6">Program Bantuan</th>
                                <th class="py-4 px-6">Alasan Pengajuan</th>
                                <th class="py-4 px-6 w-36">Tanggal Masuk</th>
                                <th class="py-4 px-6 w-32 text-center">Status</th>
                                <th class="py-4 px-6 w-36 text-center">Aksi Kendali</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                            <template x-for="p in filteredPengajuans" :key="p.id">
                                <tr class="hover:bg-indigo-50/30 transition duration-150 group/row">
                                    <!-- Identitas Pemohon -->
                                    <td class="py-4 px-6">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-700 flex items-center justify-center text-white text-xs font-black shadow-md shadow-indigo-500/10"
                                                 x-text="p.pemohon.charAt(0).toUpperCase()">
                                            </div>
                                            <div>
                                                <div class="font-extrabold text-slate-900 group-hover/row:text-indigo-600 transition" x-text="p.pemohon"></div>
                                                <div class="text-xs font-medium text-slate-400 mt-0.5" x-text="p.email"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <!-- Program -->
                                    <td class="py-4 px-6 font-bold text-slate-800" x-text="p.program"></td>
                                    <!-- Alasan -->
                                    <td class="py-4 px-6">
                                        <div class="text-xs text-slate-500 max-w-xs truncate font-medium leading-relaxed" x-text="p.alasan"></div>
                                    </td>
                                    <!-- Tanggal -->
                                    <td class="py-4 px-6 text-xs text-slate-500 font-bold" x-text="p.tanggal"></td>
                                    <!-- Status Badge -->
                                    <td class="py-4 px-6 text-center">
                                        <span x-show="p.status === 'pending'" class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-50 text-amber-700 border border-amber-200/60 rounded-full text-xs font-extrabold shadow-2xs">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                            Pending
                                        </span>
                                        <span x-show="p.status === 'disetujui'" class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200/60 rounded-full text-xs font-extrabold shadow-2xs">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Disetujui
                                        </span>
                                        <span x-show="p.status === 'ditolak'" class="inline-flex items-center gap-1.5 px-3 py-1 bg-rose-50 text-rose-700 border border-rose-200/60 rounded-full text-xs font-extrabold shadow-2xs">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                            Ditolak
                                        </span>
                                    </td>
                                    <!-- Tombol Aksi -->
                                    <td class="py-4 px-6 text-center">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <button @click="openModal(p)"
                                                    class="px-3 py-1.5 text-xs font-extrabold text-indigo-600 bg-indigo-50 border border-indigo-100 rounded-xl hover:bg-indigo-100 hover:text-indigo-700 transition duration-150">
                                                Detail
                                            </button>
                                            
                                            <template x-if="p.status === 'pending'">
                                                <div class="flex gap-1">
                                                    <button @click="submitStatus(p.updateRoute, 'disetujui')" title="Setujui"
                                                            class="p-1.5 text-emerald-600 bg-emerald-50 border border-emerald-100 hover:bg-emerald-500 hover:text-white rounded-xl transition duration-150">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                                        </svg>
                                                    </button>
                                                    <button @click="submitStatus(p.updateRoute, 'ditolak')" title="Tolak"
                                                            class="p-1.5 text-rose-600 bg-rose-50 border border-rose-100 hover:bg-rose-500 hover:text-white rounded-xl transition duration-150">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </template>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </template>

        <!-- Mobile View (Responsive Luxury Cards) -->
        <template x-if="filteredPengajuans.length > 0">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 lg:hidden">
                <template x-for="p in filteredPengajuans" :key="p.id">
                    <div class="bg-white rounded-2xl p-5 border border-indigo-50 shadow-xs flex flex-col justify-between space-y-4 hover:shadow-md transition">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-500 to-indigo-700 flex items-center justify-center text-white text-sm font-black shadow-xs"
                                     x-text="p.pemohon.charAt(0).toUpperCase()">
                                </div>
                                <div>
                                    <h4 class="font-extrabold text-slate-900" x-text="p.pemohon"></h4>
                                    <p class="text-[11px] font-medium text-slate-400" x-text="p.tanggal"></p>
                                </div>
                            </div>
                            <div>
                                <span x-show="p.status === 'pending'" class="inline-flex items-center gap-1 px-2.5 py-0.5 bg-amber-50 text-amber-700 border border-amber-200 rounded-full text-xs font-bold shadow-2xs">
                                    Pending
                                </span>
                                <span x-show="p.status === 'disetujui'" class="inline-flex items-center gap-1 px-2.5 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full text-xs font-bold shadow-2xs">
                                    Setuju
                                </span>
                                <span x-show="p.status === 'ditolak'" class="inline-flex items-center gap-1 px-2.5 py-0.5 bg-rose-50 text-rose-700 border border-rose-200 rounded-full text-xs font-bold shadow-2xs">
                                    Tolak
                                </span>
                            </div>
                        </div>

                        <div class="space-y-1 border-t border-slate-50 pt-3">
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Program Pilihan</div>
                            <div class="font-extrabold text-slate-800 text-sm" x-text="p.program"></div>
                            <div class="text-xs text-slate-500 line-clamp-2 mt-1 font-medium" x-text="p.alasan"></div>
                        </div>

                        <div class="flex items-center justify-between pt-3 border-t border-slate-50">
                            <span class="text-[11px] text-slate-400 font-medium" x-text="p.email"></span>
                            
                            <div class="flex items-center gap-1.5">
                                <button @click="openModal(p)"
                                        class="px-3 py-1.5 text-xs font-bold text-indigo-600 bg-indigo-50 border border-indigo-100 rounded-xl hover:bg-indigo-100 transition">
                                    Detail
                                </button>
                                
                                <template x-if="p.status === 'pending'">
                                    <div class="flex gap-1">
                                        <button @click="submitStatus(p.updateRoute, 'disetujui')"
                                                class="px-2 py-1.5 text-xs font-extrabold bg-emerald-600 text-white rounded-xl shadow-md shadow-emerald-600/10 hover:bg-emerald-700 transition">
                                            Setuju
                                        </button>
                                        <button @click="submitStatus(p.updateRoute, 'ditolak')"
                                                class="px-2 py-1.5 text-xs font-extrabold bg-rose-600 text-white rounded-xl shadow-md shadow-rose-600/10 hover:bg-rose-700 transition">
                                            Tolak
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </template>
    </div>

    <!-- Hidden Native Form (For Secure PATCH Action) -->
    <form id="update-status-form" method="POST" style="display: none;">
        @csrf
        @method('PATCH')
        <input type="hidden" name="status" id="update-status-value">
    </form>

    <!-- Modal View Detail (Premium Glassmorphism Backdrop) -->
    <div x-show="showDetail" 
         class="fixed inset-0 z-50 overflow-y-auto" 
         style="display: none;"
         @keydown.escape.window="showDetail = false">
        
        <!-- Backdrop Backdrop Overlay -->
        <div x-show="showDetail"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="showDetail = false"
             class="fixed inset-0 bg-slate-900/40 backdrop-blur-md transition-opacity"></div>

        <!-- Box Frame Modal Positioner -->
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div x-show="showDetail"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative bg-white rounded-3xl shadow-2xl max-w-2xl w-full overflow-hidden transform transition-all border border-slate-100">
                
                <!-- Modal Top Header -->
                <div class="px-6 py-5 bg-gradient-to-r from-indigo-50/60 to-slate-50/60 border-b border-slate-200/60 flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-black text-slate-900">Berkas Permohonan</h3>
                        <p class="text-xs text-slate-500 font-medium mt-0.5">Dikirim masuk sistem pada tanggal <span class="font-bold text-indigo-600" x-text="selected.tanggal"></span></p>
                    </div>
                    <button @click="showDetail = false" class="text-slate-400 hover:text-slate-600 bg-white hover:bg-slate-100 p-2 rounded-full border border-slate-200 shadow-2xs transition">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Modal Inner Contents -->
                <div class="p-6 space-y-6 max-h-[70vh] overflow-y-auto">
                    <!-- Current State Badge Indicator -->
                    <div class="flex items-center justify-between p-4 bg-slate-50 border border-slate-200/50 rounded-2xl">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Status Validasi Saat Ini</span>
                        <div>
                            <span x-show="selected.status === 'pending'" class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-50 text-amber-700 border border-amber-200 rounded-full text-xs font-black">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                PENDING
                            </span>
                            <span x-show="selected.status === 'disetujui'" class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full text-xs font-black">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                DISETUJUI
                            </span>
                            <span x-show="selected.status === 'ditolak'" class="inline-flex items-center gap-1.5 px-3 py-1 bg-rose-50 text-rose-700 border border-rose-200 rounded-full text-xs font-black">
                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                DITOLAK
                            </span>
                        </div>
                    </div>

                    <!-- Split Profile & Program Info Section Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left Panel: Pemohon Profile -->
                        <div class="space-y-3">
                            <h4 class="text-[11px] font-extrabold text-indigo-600 uppercase tracking-widest flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                                Informasi Profil
                            </h4>
                            <div class="bg-slate-50/60 p-4 rounded-2xl border border-slate-200/60 space-y-3.5">
                                <div>
                                    <label class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Nama Lengkap</label>
                                    <p class="text-sm font-extrabold text-slate-900 mt-0.5" x-text="selected.pemohon"></p>
                                </div>
                                <div>
                                    <label class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Email Akun</label>
                                    <p class="text-xs font-bold text-slate-600 mt-0.5 select-all" x-text="selected.email"></p>
                                </div>
                                <div>
                                    <label class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">No. Telepon / WhatsApp</label>
                                    <p class="text-xs font-bold text-slate-600 mt-0.5" x-text="selected.phone"></p>
                                </div>
                                <div>
                                    <label class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Alamat Domisili KTP</label>
                                    <p class="text-xs font-medium text-slate-600 mt-0.5 leading-relaxed" x-text="selected.address"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Right Panel: Target Program Profile -->
                        <div class="space-y-3">
                            <h4 class="text-[11px] font-extrabold text-indigo-600 uppercase tracking-widest flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18M9.75 18A3.75 3.75 0 100 14.25H21" /></svg>
                                Skema Target Program
                            </h4>
                            <div class="bg-slate-50/60 p-4 rounded-2xl border border-slate-200/60 space-y-3.5">
                                <div>
                                    <label class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Nama Klaster Program</label>
                                    <p class="text-sm font-extrabold text-indigo-900 mt-0.5" x-text="selected.program"></p>
                                </div>
                                <div>
                                    <label class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Sisa Kuota Alokasi</label>
                                    <p class="text-xs font-extrabold text-emerald-700 mt-0.5" x-text="selected.programKuota + ' Kepala Keluarga (KK)'"></p>
                                </div>
                                <div>
                                    <label class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Batas Penutupan Berkas</label>
                                    <p class="text-xs font-bold text-amber-800 mt-0.5" x-text="selected.programDeadline"></p>
                                </div>
                                <div>
                                    <label class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Deskripsi Dasar Bantuan</label>
                                    <p class="text-xs font-medium text-slate-500 mt-0.5 leading-relaxed" x-text="selected.programDeskripsi"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Full Width: Statement Alasan -->
                    <div class="space-y-2 pt-2">
                        <h4 class="text-[11px] font-extrabold text-indigo-600 uppercase tracking-widest">Alasan Mengajukan Permohonan</h4>
                        <div class="bg-indigo-50/30 border border-indigo-100/70 p-4 rounded-2xl text-xs font-medium text-slate-700 leading-relaxed whitespace-pre-line" x-text="selected.alasan"></div>
                    </div>
                </div>

                <!-- Footer Action Buttons Inside Modal -->
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-200/60 flex items-center justify-end gap-2">
                    <button @click="showDetail = false" 
                            class="px-4 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-bold rounded-xl transition">
                        Kembali
                    </button>
                    
                    <template x-if="selected.status === 'pending'">
                        <div class="flex gap-2">
                            <button @click="submitStatus(selected.updateRoute, 'ditolak'); showDetail = false;" 
                                    class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white text-xs font-extrabold rounded-xl shadow-md shadow-rose-600/10 transition">
                                Tolak Berkas
                            </button>
                            <button @click="submitStatus(selected.updateRoute, 'disetujui'); showDetail = false;" 
                                    class="px-4 py-2 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white text-xs font-extrabold rounded-xl shadow-lg shadow-emerald-600/10 transition">
                                Setujui Bantuan
                            </button>
                        </div>
                    </template>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection