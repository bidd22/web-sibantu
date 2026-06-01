@extends('layouts.app')

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

<div class="space-y-8" x-data="{
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
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Kelola Pengajuan Bantuan</h1>
            <p class="text-gray-500 mt-1">Verifikasi, setujui, atau tolak permohonan bantuan dari masyarakat secara transparan.</p>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
        <!-- Total -->
        <div @click="statusFilter = 'semua'" 
             class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md hover:scale-[1.01] active:scale-[0.99] cursor-pointer transition-all duration-200"
             :class="statusFilter === 'semua' ? 'ring-2 ring-indigo-500 border-transparent bg-indigo-50/10' : ''">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-xs font-semibold uppercase tracking-wider">Total Pengajuan</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1" x-text="stats.total"></p>
                </div>
                <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center shadow-inner">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs text-indigo-600 font-medium">
                <span>Lihat semua data</span>
                <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
            </div>
        </div>

        <!-- Pending -->
        <div @click="statusFilter = 'pending'" 
             class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md hover:scale-[1.01] active:scale-[0.99] cursor-pointer transition-all duration-200"
             :class="statusFilter === 'pending' ? 'ring-2 ring-amber-500 border-transparent bg-amber-50/10' : ''">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-xs font-semibold uppercase tracking-wider">Pending</p>
                    <p class="text-3xl font-bold text-amber-600 mt-1" x-text="stats.pending"></p>
                </div>
                <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center shadow-inner relative">
                    <span class="absolute top-1.5 right-1.5 flex h-2.5 w-2.5" x-show="stats.pending > 0">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-amber-500"></span>
                    </span>
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs text-amber-600 font-medium">
                <span>Butuh verifikasi</span>
                <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
            </div>
        </div>

        <!-- Disetujui -->
        <div @click="statusFilter = 'disetujui'" 
             class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md hover:scale-[1.01] active:scale-[0.99] cursor-pointer transition-all duration-200"
             :class="statusFilter === 'disetujui' ? 'ring-2 ring-emerald-500 border-transparent bg-emerald-50/10' : ''">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-xs font-semibold uppercase tracking-wider">Disetujui</p>
                    <p class="text-3xl font-bold text-emerald-600 mt-1" x-text="stats.disetujui"></p>
                </div>
                <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center shadow-inner">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs text-emerald-600 font-medium">
                <span>Pengajuan lolos</span>
                <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
            </div>
        </div>

        <!-- Ditolak -->
        <div @click="statusFilter = 'ditolak'" 
             class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md hover:scale-[1.01] active:scale-[0.99] cursor-pointer transition-all duration-200"
             :class="statusFilter === 'ditolak' ? 'ring-2 ring-rose-500 border-transparent bg-rose-50/10' : ''">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-xs font-semibold uppercase tracking-wider">Ditolak</p>
                    <p class="text-3xl font-bold text-rose-600 mt-1" x-text="stats.ditolak"></p>
                </div>
                <div class="w-12 h-12 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center shadow-inner">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs text-rose-600 font-medium">
                <span>Pengajuan ditolak</span>
                <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
            </div>
        </div>
    </div>

    <!-- Filter & Pencarian -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-4 rounded-2xl border border-gray-100 shadow-sm">
        <!-- Tab status -->
        <div class="flex flex-wrap items-center gap-1.5 bg-gray-100/70 p-1.5 rounded-xl self-start">
            <button @click="statusFilter = 'semua'"
                    class="px-4 py-2 rounded-lg text-xs font-semibold tracking-wide transition duration-150"
                    :class="statusFilter === 'semua' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-950'">
                Semua
            </button>
            <button @click="statusFilter = 'pending'"
                    class="px-4 py-2 rounded-lg text-xs font-semibold tracking-wide transition duration-150 flex items-center gap-1.5"
                    :class="statusFilter === 'pending' ? 'bg-white text-amber-700 shadow-sm' : 'text-gray-500 hover:text-gray-950'">
                Pending
                <span class="w-2 h-2 rounded-full bg-amber-500" x-show="stats.pending > 0"></span>
            </button>
            <button @click="statusFilter = 'disetujui'"
                    class="px-4 py-2 rounded-lg text-xs font-semibold tracking-wide transition duration-150"
                    :class="statusFilter === 'disetujui' ? 'bg-white text-emerald-700 shadow-sm' : 'text-gray-500 hover:text-gray-950'">
                Disetujui
            </button>
            <button @click="statusFilter = 'ditolak'"
                    class="px-4 py-2 rounded-lg text-xs font-semibold tracking-wide transition duration-150"
                    :class="statusFilter === 'ditolak' ? 'bg-white text-rose-700 shadow-sm' : 'text-gray-500 hover:text-gray-950'">
                Ditolak
            </button>
        </div>

        <!-- Search Input -->
        <div class="relative w-full md:max-w-xs">
            <input type="text" 
                   x-model="search" 
                   placeholder="Cari nama, program..." 
                   class="w-full text-sm pl-10 pr-8 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-150">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <!-- Clear Button -->
            <button x-show="search !== ''" @click="search = ''" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </div>

    <!-- Data List (Desktop Table & Mobile Cards) -->
    <div>
        <!-- Loading / Kosong State -->
        <template x-if="filteredPengajuans.length === 0">
            <div class="bg-white border border-gray-100 rounded-2xl p-12 text-center shadow-sm">
                <div class="w-16 h-16 bg-gray-50 text-gray-400 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900">Tidak ada pengajuan ditemukan</h3>
                <p class="text-gray-500 text-sm mt-1 max-w-sm mx-auto">Kami tidak dapat menemukan data pengajuan yang cocok dengan pencarian atau filter status Anda.</p>
                <button @click="search = ''; statusFilter = 'semua'" class="mt-4 inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-600 text-white text-xs font-semibold rounded-xl hover:bg-indigo-700 transition">
                    Atur Ulang Pencarian
                </button>
            </div>
        </template>

        <!-- Desktop Table View -->
        <template x-if="filteredPengajuans.length > 0">
            <div class="hidden lg:block bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50 border-b border-gray-100">
                                <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-gray-500">Pemohon</th>
                                <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-gray-500">Program Bantuan</th>
                                <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-gray-500">Alasan</th>
                                <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-gray-500">Tanggal</th>
                                <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-gray-500 text-center">Status</th>
                                <th class="py-4 px-6 text-xs font-semibold uppercase tracking-wider text-gray-500 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <template x-for="p in filteredPengajuans" :key="p.id">
                                <tr class="hover:bg-slate-50/50 transition-colors duration-150">
                                    <!-- Pemohon -->
                                    <td class="py-4 px-6">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-indigo-500 to-purple-600 flex items-center justify-center text-white text-sm font-bold shadow-sm"
                                                 x-text="p.pemohon.charAt(0).toUpperCase()">
                                            </div>
                                            <div>
                                                <div class="font-bold text-gray-900" x-text="p.pemohon"></div>
                                                <div class="text-xs text-gray-400" x-text="p.email"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <!-- Program -->
                                    <td class="py-4 px-6">
                                        <div class="font-semibold text-gray-800" x-text="p.program"></div>
                                    </td>
                                    <!-- Alasan -->
                                    <td class="py-4 px-6">
                                        <div class="text-sm text-gray-500 max-w-xs truncate" x-text="p.alasan"></div>
                                    </td>
                                    <!-- Tanggal -->
                                    <td class="py-4 px-6 text-sm text-gray-500" x-text="p.tanggal"></td>
                                    <!-- Status -->
                                    <td class="py-4 px-6 text-center">
                                        <!-- Pending -->
                                        <span x-show="p.status === 'pending'" 
                                              class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-50 text-amber-700 border border-amber-200/60 rounded-full text-xs font-bold shadow-sm">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                            Pending
                                        </span>
                                        <!-- Disetujui -->
                                        <span x-show="p.status === 'disetujui'" 
                                              class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200/60 rounded-full text-xs font-bold shadow-sm">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Disetujui
                                        </span>
                                        <!-- Ditolak -->
                                        <span x-show="p.status === 'ditolak'" 
                                              class="inline-flex items-center gap-1.5 px-3 py-1 bg-rose-50 text-rose-700 border border-rose-200/60 rounded-full text-xs font-bold shadow-sm">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                            Ditolak
                                        </span>
                                    </td>
                                    <!-- Aksi -->
                                    <td class="py-4 px-6 text-right">
                                        <div class="inline-flex items-center gap-2">
                                            <!-- Detail Button -->
                                            <button @click="openModal(p)"
                                                    class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-indigo-700 bg-indigo-50 border border-indigo-100 rounded-lg hover:bg-indigo-100 hover:text-indigo-800 transition duration-150">
                                                Detail
                                            </button>

                                            <!-- Quick actions if pending -->
                                            <template x-if="p.status === 'pending'">
                                                <div class="flex gap-1">
                                                    <!-- Approve -->
                                                    <button @click="submitStatus(p.updateRoute, 'disetujui')"
                                                            title="Setujui Pengajuan"
                                                            class="p-1.5 text-emerald-700 bg-emerald-50 border border-emerald-100 hover:bg-emerald-100 hover:text-emerald-800 rounded-lg transition duration-150">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                                        </svg>
                                                    </button>
                                                    <!-- Reject -->
                                                    <button @click="submitStatus(p.updateRoute, 'ditolak')"
                                                            title="Tolak Pengajuan"
                                                            class="p-1.5 text-rose-700 bg-rose-50 border border-rose-100 hover:bg-rose-100 hover:text-rose-800 rounded-lg transition duration-150">
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

        <!-- Mobile Card View -->
        <template x-if="filteredPengajuans.length > 0">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 lg:hidden">
                <template x-for="p in filteredPengajuans" :key="p.id">
                    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex flex-col justify-between space-y-4 hover:shadow-md transition">
                        <!-- Top Row: Avatar & Status -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-500 to-purple-600 flex items-center justify-center text-white text-sm font-bold shadow-sm"
                                     x-text="p.pemohon.charAt(0).toUpperCase()">
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900" x-text="p.pemohon"></h4>
                                    <p class="text-xs text-gray-400" x-text="p.tanggal"></p>
                                </div>
                            </div>
                            <!-- Status Badges -->
                            <div>
                                <span x-show="p.status === 'pending'" class="inline-flex items-center gap-1 px-2.5 py-0.5 bg-amber-50 text-amber-700 border border-amber-200 rounded-full text-xs font-bold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                    Pending
                                </span>
                                <span x-show="p.status === 'disetujui'" class="inline-flex items-center gap-1 px-2.5 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full text-xs font-bold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Setuju
                                </span>
                                <span x-show="p.status === 'ditolak'" class="inline-flex items-center gap-1 px-2.5 py-0.5 bg-rose-50 text-rose-700 border border-rose-200 rounded-full text-xs font-bold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                    Tolak
                                </span>
                            </div>
                        </div>

                        <!-- Mid Row: Program & Description -->
                        <div class="space-y-1.5 border-t border-gray-50 pt-3">
                            <div class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Program Bantuan</div>
                            <div class="font-bold text-gray-800" x-text="p.program"></div>
                            <div class="text-sm text-gray-500 line-clamp-2 mt-1" x-text="p.alasan"></div>
                        </div>

                        <!-- Action buttons -->
                        <div class="flex items-center justify-between pt-3 border-t border-gray-50">
                            <span class="text-xs text-gray-400" x-text="p.email"></span>
                            
                            <div class="flex items-center gap-2">
                                <button @click="openModal(p)"
                                        class="px-3 py-1.5 text-xs font-semibold text-indigo-700 bg-indigo-50 border border-indigo-100 rounded-lg hover:bg-indigo-100 transition">
                                    Detail
                                </button>
                                
                                <template x-if="p.status === 'pending'">
                                    <div class="flex gap-1.5">
                                        <button @click="submitStatus(p.updateRoute, 'disetujui')"
                                                class="px-2 py-1.5 bg-emerald-50 text-emerald-700 border border-emerald-100 hover:bg-emerald-100 rounded-lg transition">
                                            Setuju
                                        </button>
                                        <button @click="submitStatus(p.updateRoute, 'ditolak')"
                                                class="px-2 py-1.5 bg-rose-50 text-rose-700 border border-rose-100 hover:bg-rose-100 rounded-lg transition">
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

    <!-- Hidden Form untuk Submit Aksi Cepat -->
    <form id="update-status-form" method="POST" style="display: none;">
        @csrf
        @method('PATCH')
        <input type="hidden" name="status" id="update-status-value">
    </form>

    <!-- Modal Detail View -->
    <div x-show="showDetail" 
         class="fixed inset-0 z-50 overflow-y-auto" 
         style="display: none;"
         @keydown.escape.window="showDetail = false">
        
        <!-- Backdrop -->
        <div x-show="showDetail"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="showDetail = false"
             class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity"></div>

        <!-- Modal Dialog Box -->
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div x-show="showDetail"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative bg-white rounded-3xl shadow-2xl max-w-2xl w-full overflow-hidden transform transition-all border border-gray-100">
                
                <!-- Header -->
                <div class="px-6 py-5 bg-gradient-to-r from-indigo-50/50 to-purple-50/50 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Detail Permohonan Bantuan</h3>
                        <p class="text-xs text-gray-500 mt-0.5">Dikirim pada tanggal <span class="font-semibold" x-text="selected.tanggal"></span></p>
                    </div>
                    <button @click="showDetail = false" class="text-gray-400 hover:text-gray-600 bg-white hover:bg-gray-100 p-2 rounded-full border border-gray-100 shadow-sm transition">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Body -->
                <div class="p-6 space-y-6 max-h-[70vh] overflow-y-auto">
                    <!-- Status Header di Modal -->
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-2xl">
                        <span class="text-sm font-semibold text-gray-500">Status Pengajuan Saat Ini</span>
                        <div>
                            <span x-show="selected.status === 'pending'" class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-50 text-amber-700 border border-amber-200 rounded-full text-xs font-bold">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                Pending
                            </span>
                            <span x-show="selected.status === 'disetujui'" class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full text-xs font-bold">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Disetujui
                            </span>
                            <span x-show="selected.status === 'ditolak'" class="inline-flex items-center gap-1.5 px-3 py-1 bg-rose-50 text-rose-700 border border-rose-200 rounded-full text-xs font-bold">
                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                Ditolak
                            </span>
                        </div>
                    </div>

                    <!-- Grid Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Kolom Kiri: Pemohon -->
                        <div class="space-y-4">
                            <h4 class="text-xs font-bold text-indigo-600 uppercase tracking-widest flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                                Informasi Pemohon
                            </h4>
                            <div class="bg-gray-50/50 p-4 rounded-2xl border border-gray-100 space-y-3">
                                <div>
                                    <label class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Nama Lengkap</label>
                                    <div class="text-sm font-bold text-gray-900" x-text="selected.pemohon"></div>
                                </div>
                                <div>
                                    <label class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Email</label>
                                    <div class="text-sm font-medium text-gray-700 flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                                        <span x-text="selected.email"></span>
                                    </div>
                                </div>
                                <div>
                                    <label class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Nomor HP</label>
                                    <div class="text-sm font-medium text-gray-700 flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3"/></svg>
                                        <span x-text="selected.phone"></span>
                                    </div>
                                </div>
                                <div>
                                    <label class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Alamat Tinggal</label>
                                    <div class="text-sm font-medium text-gray-700 flex items-start gap-1.5">
                                        <svg class="w-4 h-4 text-gray-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                                        <span x-text="selected.address"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Kolom Kanan: Program -->
                        <div class="space-y-4">
                            <h4 class="text-xs font-bold text-purple-600 uppercase tracking-widest flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.62 48.62 0 0112 20.9c4.956 0 9.31-1.766 12.23-4.707-.13-2.115-.298-4.234-.51-6.347M12 2.25l-9 4.75 9 4.75 9-4.75-9-4.75z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 12.75l-9-4.75M12 12.75l9-4.75"/></svg>
                                Detail Program Bantuan
                            </h4>
                            <div class="bg-gray-50/50 p-4 rounded-2xl border border-gray-100 space-y-3">
                                <div>
                                    <label class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Nama Program</label>
                                    <div class="text-sm font-bold text-gray-900" x-text="selected.program"></div>
                                </div>
                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <label class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Sisa Kuota</label>
                                        <div class="text-sm font-semibold text-gray-800" x-text="selected.programKuota + ' Orang'"></div>
                                    </div>
                                    <div>
                                        <label class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Deadline</label>
                                        <div class="text-sm font-semibold text-gray-800" x-text="selected.programDeadline"></div>
                                    </div>
                                </div>
                                <div>
                                    <label class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Deskripsi Program</label>
                                    <div class="text-xs text-gray-500 mt-0.5 line-clamp-3" x-text="selected.programDeskripsi"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Alasan Pengajuan Bantuan -->
                    <div class="space-y-2 pt-2">
                        <h4 class="text-xs font-bold text-gray-700 uppercase tracking-widest flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l3.055-3.861a.908.908 0 01.865-.501c1.153-.086 2.294-.213 3.423-.379 1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/></svg>
                            Alasan Permohonan
                        </h4>
                        <div class="bg-indigo-50/30 p-5 rounded-2xl border border-indigo-100/50 relative overflow-hidden">
                            <div class="absolute -top-4 -right-2 text-7xl font-serif text-indigo-100/40 select-none pointer-events-none">“</div>
                            <blockquote class="text-sm text-gray-700 leading-relaxed italic relative z-10 whitespace-pre-line" x-text="selected.alasan"></blockquote>
                        </div>
                    </div>
                </div>

                <!-- Footer / Tombol Aksi -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex flex-wrap items-center justify-between gap-3">
                    <button @click="showDetail = false" class="px-4 py-2 border border-gray-200 hover:bg-gray-100 text-gray-600 rounded-xl text-sm font-semibold transition">
                        Tutup
                    </button>

                    <!-- Pilihan jika status pending -->
                    <template x-if="selected.status === 'pending'">
                        <div class="flex items-center gap-2">
                            <button @click="submitStatus(selected.updateRoute, 'ditolak'); showDetail = false;" 
                                    class="px-4 py-2 bg-rose-50 text-rose-700 border border-rose-100 hover:bg-rose-100 rounded-xl text-sm font-semibold transition flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                Tolak Pengajuan
                            </button>
                            <button @click="submitStatus(selected.updateRoute, 'disetujui'); showDetail = false;" 
                                    class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-semibold transition flex items-center gap-1.5 shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                Setujui Pengajuan
                            </button>
                        </div>
                    </template>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection