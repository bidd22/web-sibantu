@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#f8fafc] py-8 antialiased">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        
        <div class="flex flex-col md:flex-row md:items-center md:justify-between border-b border-slate-200/80 pb-6 gap-4">
            <div class="space-y-1">
                <div class="flex items-center gap-2 text-xs font-semibold text-rose-600 uppercase tracking-wider">
                    <span>Sistem Pusat Kontrol</span>
                    <span class="text-slate-300">•</span>
                    <span class="text-slate-500 font-normal">Aspirasi & Keamanan</span>
                </div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Daftar Pengaduan Warga</h1>
                <p class="text-sm font-medium text-slate-500">Otorisasi penuh untuk meninjau, mengubah status penanganan, dan merespons laporan warga.</p>
            </div>
        </div>

        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs flex flex-col xl:flex-row xl:items-center justify-between gap-4">
            <div class="space-y-0.5">
                <h2 class="text-xs font-bold uppercase tracking-wider text-slate-400">Navigasi Dashboard</h2>
                <p class="text-xs text-slate-500 font-medium">Beralih antar menu manajemen dengan cepat melalui panel kontrol terintegrasi.</p>
            </div>
            
            <div class="flex flex-wrap items-center gap-2 p-1.5 bg-slate-50 border border-slate-100 rounded-xl self-start xl:self-auto">
                <a href="{{ route('admin.pengajuans.index') }}" 
                   class="px-4 py-2 text-xs font-bold rounded-lg transition-all duration-300 flex items-center gap-2 text-indigo-600 hover:bg-indigo-50/70">
                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                    Kelola Pengajuan
                </a>

                <a href="{{ route('admin.pengaduans.index') }}" 
                   class="px-4 py-2 text-xs font-bold rounded-lg transition-all duration-300 flex items-center gap-2 bg-rose-600 text-white shadow-md shadow-rose-100 scale-105">
                    <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                    Pengaduan Warga
                </a>

                <a href="{{ route('admin.programs.index') }}" 
                   class="px-4 py-2 text-xs font-bold rounded-lg transition-all duration-300 flex items-center gap-2 text-emerald-600 hover:bg-emerald-50/70">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    Atur Program
                </a>

                <a href="{{ route('admin.menus.index') }}" 
                   class="px-4 py-2 text-xs font-bold rounded-lg transition-all duration-300 flex items-center gap-2 text-amber-600 hover:bg-amber-50/70">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                    Navigasi
                </a>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-md shadow-slate-100/50 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/70 border-b border-slate-200 text-xs font-bold uppercase tracking-wider text-slate-500">
                            <th class="py-4 px-6 w-12 text-center">No</th>
                            <th class="py-4 px-6 w-1/4">Informasi Pelapor</th>
                            <th class="py-4 px-6">Subjek Laporan</th>
                            <th class="py-4 px-6">Isi Pengaduan</th>
                            <th class="py-4 px-6 w-44 text-center">Status Pemrosesan</th>
                            <th class="py-4 px-6 w-24 text-center">Aksi</th>
                        </tr>
                    </thead>
                    
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                        @foreach($pengaduans as $index => $p)
                        <tr class="hover:bg-slate-50/60 transition duration-200 group/row">
                            <td class="py-4.5 px-6 text-center font-bold text-slate-400 text-xs">
                                {{ sprintf('%02d', $index + 1) }}
                            </td>
                            
                            <td class="py-4.5 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-indigo-50 to-purple-50 text-indigo-600 border border-indigo-100/70 flex items-center justify-center text-xs font-black shadow-xs shrink-0 group-hover/row:from-rose-600 group-hover/row:to-pink-600 group-hover/row:text-white group-hover/row:border-transparent transition-all duration-300">
                                        {{ strtoupper(substr($p->user->name ?? 'W', 0, 1)) }}
                                    </div>
                                    <span class="font-bold text-slate-900 group-hover/row:text-rose-600 transition duration-150">{{ $p->user->name }}</span>
                                </div>
                            </td>
                            
                            <td class="py-4.5 px-6 font-bold text-slate-800">
                                {{ $p->judul }}
                            </td>
                            
                            <td class="py-4.5 px-6 text-xs text-slate-500 leading-relaxed font-medium">
                                {{ Str::limit($p->isi, 60) }}
                            </td>
                            
                            <td class="py-4.5 px-6 text-center">
                                <form method="POST" action="{{ route('admin.pengaduans.update', $p) }}" class="inline-block w-full">
                                    @csrf @method('PATCH')
                                    <select name="status" onchange="this.form.submit()" 
                                        class="w-full text-xs font-bold rounded-xl px-3 py-1.5 bg-white border border-slate-200 text-slate-700 cursor-pointer shadow-xs focus:outline-none focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition duration-200 appearance-none text-center
                                        @if($p->status == 'diterima') text-blue-700 bg-blue-50/50 border-blue-200/80
                                        @elseif($p->status == 'proses') text-amber-700 bg-amber-50/50 border-amber-200/80
                                        @elseif($p->status == 'selesai') text-emerald-700 bg-emerald-50/50 border-emerald-200/80
                                        @endif">
                                        <option value="diterima" {{ $p->status=='diterima'?'selected':'' }}>🔹 Diterima</option>
                                        <option value="proses" {{ $p->status=='proses'?'selected':'' }}>🔸 Proses</option>
                                        <option value="selesai" {{ $p->status=='selesai'?'selected':'' }}>🔹 Selesai</option>
                                    </select>
                                </form>
                            </td>
                            
                            <td class="py-4.5 px-6 text-center">
                                <form method="POST" action="{{ route('admin.pengaduans.destroy', $p) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengaduan ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition duration-150" title="Hapus Laporan">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection