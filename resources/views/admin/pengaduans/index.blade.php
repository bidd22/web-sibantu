@extends('layouts.admin')

@section('content')
<div class="space-y-6 antialiased" x-data="{
    showDetail: false,
    selected: {},
    openModal(p) {
        this.selected = p;
        this.showDetail = true;
    }
}">
    <!-- Header Dashboard -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between border-b border-slate-200/60 pb-5 gap-4">
        <div class="space-y-1">
            <div class="flex items-center gap-2 text-xs font-bold text-rose-600 uppercase tracking-widest">
                <span class="px-2 py-0.5 bg-rose-50 border border-rose-100 rounded-md">Pusat Aspirasi</span>
                <span class="text-slate-300">•</span>
                <span class="text-slate-500 font-medium">Aspirasi & Keamanan</span>
            </div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Daftar Pengaduan Warga</h1>
            <p class="text-xs font-medium text-slate-500">Otorisasi penuh untuk meninjau, merespons, dan menindaklanjuti aspirasi warga.</p>
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

    <!-- Main Table Container -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-xl shadow-slate-200/40 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gradient-to-r from-rose-50/40 to-slate-50/40 border-b border-slate-200/60 text-xs font-bold uppercase tracking-wider text-slate-500">
                        <th class="py-4 px-6 w-12 text-center">No</th>
                        <th class="py-4 px-6 w-1/4">Informasi Pelapor</th>
                        <th class="py-4 px-6">Subjek Laporan</th>
                        <th class="py-4 px-6">Isi Pengaduan</th>
                        <th class="py-4 px-6 w-44 text-center">Status Pemrosesan</th>
                        <th class="py-4 px-6 w-32 text-center">Aksi Kendali</th>
                    </tr>
                </thead>
                
                <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                    @forelse($pengaduans as $index => $p)
                    <tr class="hover:bg-slate-50/40 transition duration-150 group/row">
                        <td class="py-4.5 px-6 text-center font-bold text-slate-400 text-xs">
                            {{ sprintf('%02d', $index + 1) }}
                        </td>
                        
                        <td class="py-4.5 px-6">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-rose-500 to-pink-600 text-white flex items-center justify-center text-xs font-black shadow-md shadow-rose-500/10 shrink-0">
                                    {{ strtoupper(substr($p->user->name ?? 'W', 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-extrabold text-slate-900 group-hover/row:text-rose-600 transition" x-text="{{ json_encode($p->user->name) }}"></div>
                                    <div class="text-[10px] font-semibold text-slate-400 mt-0.5" x-text="{{ json_encode($p->user->email) }}"></div>
                                </div>
                            </div>
                        </td>
                        
                        <td class="py-4.5 px-6 font-bold text-slate-800">
                            {{ $p->judul }}
                        </td>
                        
                        <td class="py-4.5 px-6 text-xs text-slate-500 leading-relaxed font-medium">
                            {{ Str::limit($p->isi, 60) }}
                        </td>
                        
                        <td class="py-4.5 px-6 text-center">
                            <form method="POST" action="{{ route('admin.pengaduans.update', $p) }}" class="inline-block w-full max-w-[140px] mx-auto">
                                @csrf @method('PATCH')
                                <div class="relative">
                                    <select name="status" onchange="this.form.submit()" 
                                        class="w-full text-xs font-extrabold rounded-xl px-3 py-2 bg-white border border-slate-200 text-slate-700 cursor-pointer shadow-xs focus:outline-none focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition duration-200 appearance-none text-center pr-8
                                        @if($p->status == 'diterima') text-blue-700 bg-blue-50/50 border-blue-200/60
                                        @elseif($p->status == 'proses') text-amber-700 bg-amber-50/50 border-amber-200/60
                                        @elseif($p->status == 'selesai') text-emerald-700 bg-emerald-50/50 border-emerald-200/60
                                        @endif">
                                        <option value="diterima" {{ $p->status=='diterima'?'selected':'' }}>🔹 Diterima</option>
                                        <option value="proses" {{ $p->status=='proses'?'selected':'' }}>🔸 Proses</option>
                                        <option value="selesai" {{ $p->status=='selesai'?'selected':'' }}>🔹 Selesai</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-2.5 pointer-events-none text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </div>
                                </div>
                            </form>
                        </td>
                        
                        <td class="py-4.5 px-6 text-center">
                            <div class="flex items-center justify-center gap-1.5">
                                <button @click="openModal({
                                            name: {{ json_encode($p->user->name) }},
                                            email: {{ json_encode($p->user->email) }},
                                            phone: {{ json_encode($p->user->phone ?? '-') }},
                                            address: {{ json_encode($p->user->address ?? '-') }},
                                            title: {{ json_encode($p->judul) }},
                                            content: {{ json_encode($p->isi) }},
                                            status: '{{ $p->status }}',
                                            date: '{{ $p->created_at->format("d M Y") }}'
                                        })"
                                        class="px-3 py-1.5 text-xs font-extrabold text-rose-600 bg-rose-50 border border-rose-100 rounded-xl hover:bg-rose-100 hover:text-rose-700 transition duration-150 shadow-2xs">
                                    Detail
                                </button>
                                
                                <form method="POST" action="{{ route('admin.pengaduans.destroy', $p) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengaduan ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition duration-150" title="Hapus Laporan">
                                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center">
                            <div class="w-16 h-16 bg-slate-50 text-slate-400 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-slate-100">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                            </div>
                            <h3 class="text-base font-black text-slate-900">Tidak ada pengaduan ditemukan</h3>
                            <p class="text-xs font-medium text-slate-500 mt-1">Belum ada warga yang mengirimkan berkas aspirasi atau pengaduan saat ini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

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
                <div class="px-6 py-5 bg-gradient-to-r from-rose-50/60 to-slate-50/60 border-b border-slate-200/60 flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-black text-slate-900">Berkas Pengaduan Warga</h3>
                        <p class="text-xs text-slate-500 font-medium mt-0.5">Dikirim masuk sistem pada tanggal <span class="font-bold text-rose-600" x-text="selected.date"></span></p>
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
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Status Pemrosesan Laporan</span>
                        <div>
                            <span x-show="selected.status === 'diterima'" class="inline-flex items-center gap-1.5 px-3 py-1 bg-blue-50 text-blue-700 border border-blue-200 rounded-full text-xs font-black">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                DITERIMA
                            </span>
                            <span x-show="selected.status === 'proses'" class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-50 text-amber-700 border border-amber-200 rounded-full text-xs font-black">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                PROSES
                            </span>
                            <span x-show="selected.status === 'selesai'" class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full text-xs font-black">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                SELESAI
                            </span>
                        </div>
                    </div>

                    <!-- Split Profile & Report Info Section Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left Panel: Pelapor Profile -->
                        <div class="space-y-3">
                            <h4 class="text-[11px] font-extrabold text-rose-600 uppercase tracking-widest flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                                Informasi Pelapor
                            </h4>
                            <div class="bg-slate-50/60 p-4 rounded-2xl border border-slate-200/60 space-y-3.5">
                                <div>
                                    <label class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Nama Lengkap</label>
                                    <p class="text-sm font-extrabold text-slate-900 mt-0.5" x-text="selected.name"></p>
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

                        <!-- Right Panel: Report Details -->
                        <div class="space-y-3">
                            <h4 class="text-[11px] font-extrabold text-rose-600 uppercase tracking-widest flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 17.75V5.25A2.25 2.25 0 015.25 3h6a2.25 2.25 0 012.25 2.25V7.5z" /></svg>
                                Informasi Laporan
                            </h4>
                            <div class="bg-slate-50/60 p-4 rounded-2xl border border-slate-200/60 space-y-3.5">
                                <div>
                                    <label class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Subjek Pengaduan</label>
                                    <p class="text-sm font-extrabold text-rose-900 mt-0.5 select-all" x-text="selected.title"></p>
                                </div>
                                <div>
                                    <label class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Metode Pengiriman</label>
                                    <p class="text-xs font-bold text-slate-600 mt-0.5">Sistem Online SIBANTU</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Full Width: Content -->
                    <div class="space-y-2 pt-2">
                        <h4 class="text-[11px] font-extrabold text-rose-600 uppercase tracking-widest">Detail Isi Laporan Pengaduan</h4>
                        <div class="bg-rose-50/30 border border-rose-100/70 p-4 rounded-2xl text-xs font-medium text-slate-700 leading-relaxed whitespace-pre-line select-all" x-text="selected.content"></div>
                    </div>
                </div>

                <!-- Footer Action Buttons Inside Modal -->
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-200/60 flex items-center justify-end">
                    <button @click="showDetail = false" 
                            class="px-5 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-bold rounded-xl transition">
                        Tutup Detail
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection