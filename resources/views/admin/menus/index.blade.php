@extends('layouts.admin')

@section('content')
<div class="space-y-6 antialiased">
    <!-- Header Dashboard -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between border-b border-slate-200/60 pb-5 gap-4">
        <div class="space-y-1">
            <div class="flex items-center gap-2 text-xs font-bold text-amber-600 uppercase tracking-widest">
                <span class="px-2 py-0.5 bg-amber-50 border border-amber-100 rounded-md">Pusat Navigasi</span>
                <span class="text-slate-300">•</span>
                <span class="text-slate-500 font-medium">Pengaturan Tautan</span>
            </div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Manajemen Menu</h1>
            <p class="text-xs font-medium text-slate-500">Konfigurasi menu tautan halaman warga agar dinamis dan responsif.</p>
        </div>
        
        <a href="{{ route('admin.menus.create') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white text-xs font-extrabold rounded-xl shadow-lg shadow-amber-500/20 hover:shadow-xl hover:shadow-amber-500/30 hover:-translate-y-0.5 transition-all duration-200 shrink-0 self-start sm:self-auto">
            <svg class="w-4 h-4 text-amber-100" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Tambah Menu
        </a>
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

    <!-- Luxury Table Container -->
    <div class="bg-white rounded-2xl border border-indigo-100 shadow-xl shadow-slate-200/40 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gradient-to-r from-amber-50/40 to-slate-50/40 border-b border-indigo-100 text-xs font-bold uppercase tracking-wider text-amber-900/80">
                        <th class="py-4 px-6 w-12 text-center text-amber-400">No</th>
                        <th class="py-4 px-6 w-1/3">Judul Menu</th>
                        <th class="py-4 px-6">URL / Target Tautan</th>
                        <th class="py-4 px-6 w-24 text-center">Urutan</th>
                        <th class="py-4 px-6 w-24 text-center">Aksi Kendali</th>
                    </tr>
                </thead>
                
                <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                    @forelse($menus as $index => $menu)
                    <tr class="hover:bg-amber-50/10 transition duration-150 group/row">
                        <td class="py-4.5 px-6 text-center font-bold text-slate-400 text-xs">
                            {{ sprintf('%02d', $index + 1) }}
                        </td>
                        
                        <!-- Judul Menu -->
                        <td class="py-4.5 px-6">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-amber-400 to-amber-600 text-white flex items-center justify-center text-xs font-black shadow-md shadow-amber-500/10 shrink-0">
                                    {{ strtoupper(substr($menu->title ?? 'M', 0, 1)) }}
                                </div>
                                <span class="font-normal text-slate-700 group-hover/row:text-amber-600 transition duration-150">{{ $menu->title }}</span>
                            </div>
                        </td>
                        
                        <!-- URL -->
                        <td class="py-4.5 px-6 font-mono text-xs text-slate-500 select-all font-semibold">
                            {{ $menu->url }}
                        </td>
                        
                        <!-- Urutan -->
                        <td class="py-4.5 px-6 text-center font-bold text-slate-700">
                            {{ $menu->order }}
                        </td>
                        
                        <!-- Tombol Aksi -->
                        <td class="py-4.5 px-6 text-center">
                            <div class="flex items-center justify-center gap-1.5">
                                <a href="{{ route('admin.menus.edit', $menu) }}" class="p-2 text-slate-400 hover:text-amber-600 hover:bg-amber-50 rounded-xl transition duration-150 border border-transparent hover:border-amber-100" title="Ubah Menu">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                </a>

                                <form action="{{ route('admin.menus.destroy', $menu) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus menu ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition duration-150 border border-transparent hover:border-rose-100" title="Hapus Menu">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center">
                            <div class="w-16 h-16 bg-slate-50 text-slate-400 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-slate-100">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                </svg>
                            </div>
                            <h3 class="text-base font-black text-slate-900">Tidak ada menu ditemukan</h3>
                            <p class="text-xs font-medium text-slate-500 mt-1">Gunakan tombol 'Tambah Menu' untuk mendaftarkan tautan navigasi baru.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection