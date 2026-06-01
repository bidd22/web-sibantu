@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#f8fafc] via-[#f1f5f9] to-[#eef2f6] py-8 antialiased">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between border-b border-slate-200/60 pb-5 gap-4">
            <div class="space-y-1">
                <div class="flex items-center gap-2 text-xs font-bold text-indigo-600 uppercase tracking-widest">
                    <span class="px-2 py-0.5 bg-indigo-50 border border-indigo-100 rounded-md">Pusat Kendali</span>
                    <span class="text-slate-300">•</span>
                    <span class="text-slate-500 font-medium">Manajemen Program</span>
                </div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Program Bantuan</h1>
                <p class="text-xs font-medium text-slate-500">Konfigurasi alokasi bantuan sosial, batasan kuota penerima, dan masa aktif pendaftaran.</p>
            </div>
            
            <a href="{{ route('admin.programs.create') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white text-xs font-extrabold rounded-xl shadow-lg shadow-emerald-600/20 hover:shadow-xl hover:shadow-emerald-600/30 hover:-translate-y-0.5 transition-all duration-200 shrink-0 self-start sm:self-auto">
                <svg class="w-4 h-4 text-emerald-100" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Tambah Program
            </a>
        </div>

        <div class="bg-white/80 backdrop-blur-md border border-slate-200 rounded-2xl p-5 shadow-sm flex flex-col xl:flex-row xl:items-center justify-between gap-4">
            <div class="space-y-0.5">
                <h2 class="text-xs font-black uppercase tracking-wider text-slate-400">Navigasi Dashboard</h2>
                <p class="text-xs text-slate-500 font-medium">Beralih antar menu manajemen dengan cepat melalui panel kontrol terintegrasi.</p>
            </div>
            
            <div class="flex flex-wrap items-center gap-2 p-1.5 bg-slate-100/80 border border-slate-200/40 rounded-xl self-start xl:self-auto">
                <a href="{{ route('admin.pengajuans.index') }}" class="px-4 py-2 text-xs font-bold rounded-lg text-indigo-600 hover:bg-indigo-50 transition duration-150">
                    Kelola Pengajuan
                </a>

                <a href="{{ route('admin.pengaduans.index') }}" class="px-4 py-2 text-xs font-bold rounded-lg text-rose-600 hover:bg-rose-50 transition duration-150">
                    Pengaduan Warga
                </a>

                <a href="{{ route('admin.programs.index') }}" 
                   class="px-4 py-2 text-xs font-bold rounded-lg transition-all duration-300 flex items-center gap-2 bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-200 scale-105">
                    <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                    Atur Program
                </a>

                <a href="{{ route('admin.menus.index') }}" class="px-4 py-2 text-xs font-bold rounded-lg text-amber-600 hover:bg-amber-50 transition duration-150">
                    Navigasi
                </a>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-indigo-100 shadow-xl shadow-slate-200/50 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gradient-to-r from-indigo-50/80 to-slate-50/80 border-b border-indigo-100 text-xs font-bold uppercase tracking-wider text-indigo-900/80">
                            <th class="py-4 px-6 w-12 text-center text-indigo-400">No</th>
                            <th class="py-4 px-6 w-1/4">Nama Program</th>
                            <th class="py-4 px-6">Deskripsi Cakupan</th>
                            <th class="py-4 px-6 w-32 text-center">Kuota Sisa</th>
                            <th class="py-4 px-6 w-44 text-center">Batas Waktu (Deadline)</th>
                            <th class="py-4 px-6 w-24 text-center">Aksi Kendali</th>
                        </tr>
                    </thead>
                    
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                        @foreach($programs as $index => $p)
                        <tr class="hover:bg-indigo-50/30 transition duration-150 group/row">
                            <td class="py-4.5 px-6 text-center font-bold text-slate-400 text-xs">
                                {{ sprintf('%02d', $index + 1) }}
                            </td>
                            
                            <td class="py-4.5 px-6 font-extrabold text-slate-900 group-hover/row:text-indigo-600 transition duration-150">
                                {{ $p->nama_program }}
                            </td>
                            
                            <td class="py-4.5 px-6 text-xs text-slate-500 leading-relaxed font-medium">
                                {{ Str::limit($p->deskripsi, 60) }}
                            </td>
                            
                            <td class="py-4.5 px-6 text-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-extrabold border border-emerald-200/60 shadow-xs">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span>
                                    {{ number_format($p->kuota) }} <span class="text-emerald-400 font-normal ml-1">KK</span>
                                </span>
                            </td>
                            
                            <td class="py-4.5 px-6 text-center">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-50 text-amber-800 text-xs font-bold border border-amber-200/60 shadow-xs">
                                    <svg class="w-3.5 h-3.5 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                    </svg>
                                    {{ $p->deadline }}
                                </span>
                            </td>
                            
                            <td class="py-4.5 px-6 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="{{ route('admin.programs.edit', $p) }}" class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition duration-150 border border-transparent hover:border-indigo-100" title="Ubah Data">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>
                                    </a>

                                    <form action="{{ route('admin.programs.destroy', $p) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus program bantuan ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition duration-150 border border-transparent hover:border-rose-100" title="Hapus Program">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
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