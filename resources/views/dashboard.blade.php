@extends('layouts.app')

@section('content')
<style>
    .program-card {
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        border: 1.5px solid #e2e8f0;
        background: white;
    }
    .program-card:hover {
        border-color: #c7d2fe;
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.06);
    }
    .program-card.selected {
        border-color: #6366f1;
        background: #fafafe;
        box-shadow: 0 4px 16px rgba(99, 102, 241, 0.1);
    }
    .radio-dot {
        width: 18px; height: 18px;
        border-radius: 50%;
        border: 2px solid #cbd5e1;
        transition: all 0.2s ease;
        position: relative;
        flex-shrink: 0;
    }
    .radio-dot::after {
        content: '';
        position: absolute;
        inset: 3px;
        border-radius: 50%;
        background: #6366f1;
        transform: scale(0);
        transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .program-card.selected .radio-dot {
        border-color: #6366f1;
    }
    .program-card.selected .radio-dot::after {
        transform: scale(1);
    }
    .stepper-line {
        transition: width 0.5s ease-in-out;
    }
    .fade-up {
        animation: fadeUp 0.5s ease-out both;
    }
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(12px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="relative min-h-screen pb-12">
    {{-- Hero & Greeting --}}
    <section id="beranda" class="scroll-mt-24 mb-8 fade-up">
        <div class="relative overflow-hidden bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 text-white rounded-2xl p-6 md:p-8 border border-slate-800/60">
            {{-- Subtle glow --}}
            <div class="absolute -right-16 -top-16 w-56 h-56 bg-indigo-500/8 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -left-16 -bottom-16 w-56 h-56 bg-purple-500/8 rounded-full blur-3xl pointer-events-none"></div>

            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 relative z-10">
                <div class="space-y-2.5">
                    <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full bg-white/5 border border-white/10 text-indigo-300 text-[11px] font-semibold tracking-wide uppercase">
                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-400 animate-pulse"></span>
                        Portal Layanan Warga
                    </div>
                    <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight">
                        Halo, <span class="bg-gradient-to-r from-indigo-200 to-purple-200 bg-clip-text text-transparent">{{ Auth::user()->name }}</span>
                    </h1>
                    <p class="text-slate-400 max-w-xl text-sm leading-relaxed">
                        Selamat datang di SIBANTU. Ajukan bantuan sosial dan sampaikan pengaduan secara transparan.
                    </p>
                </div>
                <div class="flex-shrink-0 flex items-center gap-3.5 bg-white/5 backdrop-blur-sm px-4 py-3 rounded-xl border border-white/10">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-500 to-purple-500 flex items-center justify-center text-white text-sm font-bold">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                    <div>
                        <div class="text-[11px] text-slate-500 font-medium">Hari Ini</div>
                        <div class="text-sm font-semibold text-white">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @php
        $all_pengajuans = \App\Models\Pengajuan::where('user_id', Auth::id())->with('program')->latest()->get();
        $all_pengaduans = \App\Models\Pengaduan::where('user_id', Auth::id())->latest()->get();
        $count_pending = $all_pengajuans->where('status', 'pending')->count();
        $count_disetujui = $all_pengajuans->where('status', 'disetujui')->count();
        $count_pengaduan_aktif = $all_pengaduans->whereIn('status', ['diterima', 'proses'])->count();
    @endphp

    {{-- Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8" style="animation-delay: 0.1s">
        <div class="bg-white border border-slate-200/80 rounded-xl p-4 flex items-center gap-3.5 hover:border-slate-300 transition fade-up" style="animation-delay: 0.1s">
            <div class="w-10 h-10 rounded-lg bg-amber-50 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Diproses</p>
                <h4 class="text-xl font-bold text-slate-800">{{ $count_pending }}</h4>
            </div>
        </div>
        <div class="bg-white border border-slate-200/80 rounded-xl p-4 flex items-center gap-3.5 hover:border-slate-300 transition fade-up" style="animation-delay: 0.15s">
            <div class="w-10 h-10 rounded-lg bg-emerald-50 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Disetujui</p>
                <h4 class="text-xl font-bold text-slate-800">{{ $count_disetujui }}</h4>
            </div>
        </div>
        <div class="bg-white border border-slate-200/80 rounded-xl p-4 flex items-center gap-3.5 hover:border-slate-300 transition fade-up" style="animation-delay: 0.2s">
            <div class="w-10 h-10 rounded-lg bg-indigo-50 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z"/>
                </svg>
            </div>
            <div>
                <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Pengaduan Aktif</p>
                <h4 class="text-xl font-bold text-slate-800">{{ $count_pengaduan_aktif }}</h4>
            </div>
        </div>
    </div>

    {{-- Main Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Left: Form Pengajuan --}}
        <div class="lg:col-span-2 space-y-6">
            <section id="ajukan" class="scroll-mt-24 fade-up" style="animation-delay: 0.25s">
                <div class="bg-white border border-slate-200/80 rounded-2xl overflow-hidden">
                    
                    {{-- Header --}}
                    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-5 text-white relative overflow-hidden">
                        <div class="absolute -right-8 -top-8 w-24 h-24 bg-white/5 rounded-full blur-xl pointer-events-none"></div>
                        <div class="relative z-10">
                            <h2 class="text-lg font-bold flex items-center gap-2.5">
                                <svg class="w-5 h-5 text-indigo-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                                </svg>
                                Ajukan Bantuan Sosial
                            </h2>
                            <p class="text-indigo-200 text-xs mt-1">Pilih program dan tuliskan alasan pengajuan Anda</p>
                        </div>
                    </div>

                    {{-- Form --}}
                    <form method="POST" action="{{ route('pengajuan.store') }}" class="p-6 space-y-7" id="formPengajuan">
                        @csrf
                        
                        {{-- Step 1 --}}
                        <div class="space-y-3.5">
                            <div class="flex items-center gap-2">
                                <span class="w-5 h-5 rounded-full bg-indigo-100 text-indigo-600 font-bold flex items-center justify-center text-[10px]">1</span>
                                <h3 class="font-semibold text-slate-700 text-sm">Pilih Program Bantuan</h3>
                            </div>

                            @php
                                $programs = \App\Models\BantuanProgram::where('deadline', '>=', now())->get();
                            @endphp

                            @if($programs->isEmpty())
                                <div class="bg-slate-50 border border-dashed border-slate-200 rounded-xl p-5 text-center text-slate-400 text-sm">
                                    Tidak ada program bantuan aktif saat ini.
                                </div>
                            @else
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    @foreach($programs as $program)
                                        @php
                                            $colors = [
                                                ['bg-indigo-50', 'text-indigo-500'],
                                                ['bg-violet-50', 'text-violet-500'],
                                                ['bg-sky-50', 'text-sky-500'],
                                                ['bg-teal-50', 'text-teal-500'],
                                            ];
                                            $c = $colors[$loop->index % count($colors)];
                                        @endphp
                                        <div class="program-card rounded-xl p-4" data-program-id="{{ $program->id }}">
                                            <div class="flex items-start gap-3">
                                                <div class="w-9 h-9 rounded-lg {{ $c[0] }} {{ $c[1] }} flex items-center justify-center flex-shrink-0">
                                                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/>
                                                    </svg>
                                                </div>
                                                <div class="flex-1 min-w-0 space-y-1">
                                                    <h4 class="font-semibold text-slate-700 text-sm truncate" title="{{ $program->nama_program }}">
                                                        {{ $program->nama_program }}
                                                    </h4>
                                                    <p class="text-slate-400 text-xs leading-relaxed line-clamp-2">
                                                        {{ $program->deskripsi }}
                                                    </p>
                                                    <div class="flex flex-wrap gap-x-3 gap-y-0.5 pt-1 text-[10px] font-medium text-slate-400">
                                                        <span>Kuota: <span class="text-slate-500">{{ $program->kuota }}</span></span>
                                                        <span>Batas: <span class="text-slate-500">{{ \Carbon\Carbon::parse($program->deadline)->format('d M Y') }}</span></span>
                                                    </div>
                                                </div>
                                                <div class="radio-dot mt-1"></div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <input type="hidden" name="program_id" id="selected_program_id" required>
                            @endif
                        </div>

                        {{-- Step 2 --}}
                        <div class="space-y-3.5">
                            <div class="flex items-center gap-2">
                                <span class="w-5 h-5 rounded-full bg-indigo-100 text-indigo-600 font-bold flex items-center justify-center text-[10px]">2</span>
                                <h3 class="font-semibold text-slate-700 text-sm">Alasan Pengajuan</h3>
                            </div>
                            <textarea name="alasan" rows="4" required
                                class="w-full border border-slate-200 rounded-xl px-4 py-3 text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/15 focus:border-indigo-400 transition text-sm resize-none" 
                                placeholder="Jelaskan kondisi Anda saat ini dan alasan pengajuan bantuan..."></textarea>
                        </div>

                        {{-- Submit --}}
                        <div>
                            <button type="submit" 
                                class="w-full sm:w-auto bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold py-2.5 px-6 rounded-xl transition duration-200 shadow-sm hover:shadow-md text-sm">
                                Kirim Pengajuan
                            </button>
                        </div>
                    </form>
                </div>
            </section>
        </div>

        {{-- Right Panel --}}
        <div class="space-y-6">
            
            {{-- Riwayat Status --}}
            <section id="riwayat" class="scroll-mt-24 fade-up" style="animation-delay: 0.3s">
                <div class="bg-white border border-slate-200/80 rounded-2xl p-5 space-y-4">
                    <div class="flex justify-between items-center pb-3 border-b border-slate-100">
                        <h2 class="text-sm font-bold text-slate-700 flex items-center gap-2">
                            <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/>
                            </svg>
                            Status Pengajuan
                        </h2>
                        <span class="text-[10px] bg-slate-100 text-slate-500 px-2 py-0.5 rounded-full font-medium">
                            {{ $all_pengajuans->count() }}
                        </span>
                    </div>

                    @if($all_pengajuans->isEmpty())
                        <div class="bg-slate-50 border border-dashed border-slate-200 rounded-xl p-5 text-center text-slate-400 text-xs">
                            Belum ada riwayat pengajuan.
                        </div>
                    @else
                        <div class="space-y-3 max-h-[400px] overflow-y-auto pr-1">
                            @foreach($all_pengajuans as $p)
                                <div class="bg-slate-50/60 border border-slate-100 rounded-xl p-3.5 space-y-3 hover:border-slate-200 transition">
                                    <div class="flex justify-between items-start gap-2">
                                        <div class="min-w-0">
                                            <h4 class="font-semibold text-slate-700 text-xs truncate" title="{{ $p->program->nama_program }}">
                                                {{ $p->program->nama_program }}
                                            </h4>
                                            <p class="text-slate-400 text-[10px] mt-0.5">
                                                {{ $p->created_at->format('d M Y') }}
                                            </p>
                                        </div>
                                        @if($p->status == 'pending')
                                            <span class="px-2 py-0.5 rounded-full text-[9px] font-semibold bg-amber-50 text-amber-600 border border-amber-100">Pending</span>
                                        @elseif($p->status == 'disetujui')
                                            <span class="px-2 py-0.5 rounded-full text-[9px] font-semibold bg-emerald-50 text-emerald-600 border border-emerald-100">Disetujui</span>
                                        @else
                                            <span class="px-2 py-0.5 rounded-full text-[9px] font-semibold bg-rose-50 text-rose-600 border border-rose-100">Ditolak</span>
                                        @endif
                                    </div>

                                    <p class="text-slate-500 text-[11px] leading-relaxed line-clamp-2">{{ $p->alasan }}</p>

                                    {{-- Stepper --}}
                                    <div class="relative pt-1.5">
                                        <div class="absolute top-[14px] left-[8%] right-[8%] h-px bg-slate-200"></div>
                                        @php
                                            $lineWidth = 'w-0';
                                            if($p->status == 'pending') $lineWidth = 'w-[50%]';
                                            if($p->status == 'disetujui' || $p->status == 'ditolak') $lineWidth = 'w-full';
                                        @endphp
                                        <div class="absolute top-[14px] left-[8%] h-px bg-indigo-400 stepper-line {{ $lineWidth }}"></div>

                                        <div class="flex justify-between text-center relative">
                                            <div class="flex flex-col items-center flex-1">
                                                <div class="w-5 h-5 rounded-full bg-indigo-500 text-white flex items-center justify-center ring-2 ring-indigo-100">
                                                    <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                                </div>
                                                <span class="text-[8px] font-medium text-indigo-500 mt-1">Diajukan</span>
                                            </div>
                                            <div class="flex flex-col items-center flex-1">
                                                @if($p->status == 'pending')
                                                    <div class="w-5 h-5 rounded-full bg-amber-500 text-white flex items-center justify-center ring-2 ring-amber-100 animate-pulse">
                                                        <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5"/></svg>
                                                    </div>
                                                    <span class="text-[8px] font-medium text-amber-500 mt-1">Ditinjau</span>
                                                @else
                                                    <div class="w-5 h-5 rounded-full bg-indigo-500 text-white flex items-center justify-center ring-2 ring-indigo-100">
                                                        <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                                    </div>
                                                    <span class="text-[8px] font-medium text-indigo-500 mt-1">Ditinjau</span>
                                                @endif
                                            </div>
                                            <div class="flex flex-col items-center flex-1">
                                                @if($p->status == 'pending')
                                                    <div class="w-5 h-5 rounded-full bg-slate-200 text-slate-400 flex items-center justify-center">
                                                        <div class="w-1.5 h-1.5 rounded-full bg-slate-300"></div>
                                                    </div>
                                                    <span class="text-[8px] font-medium text-slate-400 mt-1">Keputusan</span>
                                                @elseif($p->status == 'disetujui')
                                                    <div class="w-5 h-5 rounded-full bg-emerald-500 text-white flex items-center justify-center ring-2 ring-emerald-100">
                                                        <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                                    </div>
                                                    <span class="text-[8px] font-medium text-emerald-600 mt-1">Disetujui</span>
                                                @else
                                                    <div class="w-5 h-5 rounded-full bg-rose-500 text-white flex items-center justify-center ring-2 ring-rose-100">
                                                        <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                                    </div>
                                                    <span class="text-[8px] font-medium text-rose-600 mt-1">Ditolak</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </section>

            {{-- Pengaduan --}}
            <section id="pengaduan" class="scroll-mt-24 fade-up" style="animation-delay: 0.35s">
                <div class="bg-white border border-slate-200/80 rounded-2xl p-5 space-y-4">
                    <div class="flex justify-between items-center pb-3 border-b border-slate-100">
                        <h2 class="text-sm font-bold text-slate-700 flex items-center gap-2">
                            <svg class="w-4 h-4 text-rose-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z"/>
                            </svg>
                            Pengaduan Saya
                        </h2>
                        <button id="showPengaduanForm" 
                            class="bg-slate-100 hover:bg-slate-200 text-slate-600 px-2.5 py-1 rounded-lg text-[11px] font-semibold transition flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                            Baru
                        </button>
                    </div>

                    {{-- Form --}}
                    <div id="pengaduanForm" class="hidden overflow-hidden bg-slate-50 border border-slate-200/60 rounded-xl p-4 transition-all duration-300">
                        <form method="POST" action="{{ route('pengaduan.store') }}" class="space-y-3">
                            @csrf
                            <div>
                                <label class="block text-[10px] font-semibold text-slate-500 uppercase tracking-wider mb-1">Judul</label>
                                <input type="text" name="judul" required
                                    class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/15 focus:border-indigo-400 transition"
                                    placeholder="Ringkasan pengaduan">
                            </div>
                            <div>
                                <label class="block text-[10px] font-semibold text-slate-500 uppercase tracking-wider mb-1">Isi Pengaduan</label>
                                <textarea name="isi" rows="3" required
                                    class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/15 focus:border-indigo-400 transition resize-none"
                                    placeholder="Jelaskan keluhan Anda..."></textarea>
                            </div>
                            <div class="flex gap-2">
                                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg text-xs transition">
                                    Kirim
                                </button>
                                <button type="button" id="cancelPengaduan"
                                    class="bg-slate-200 hover:bg-slate-300 text-slate-600 font-semibold py-2 px-4 rounded-lg text-xs transition">
                                    Batal
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- List --}}
                    <div class="space-y-3 max-h-[340px] overflow-y-auto pr-1">
                        @forelse($all_pengaduans as $p)
                            <div class="bg-slate-50/60 border border-slate-100 rounded-xl p-3.5 hover:border-slate-200 transition">
                                <div class="flex justify-between items-start gap-2 mb-1.5">
                                    <h4 class="font-semibold text-slate-700 text-xs truncate max-w-[65%]">{{ $p->judul }}</h4>
                                    @if($p->status == 'diterima')
                                        <span class="px-2 py-0.5 rounded-full text-[8px] font-semibold bg-slate-100 text-slate-500 border border-slate-200">Diterima</span>
                                    @elseif($p->status == 'proses')
                                        <span class="px-2 py-0.5 rounded-full text-[8px] font-semibold bg-blue-50 text-blue-500 border border-blue-100">Proses</span>
                                    @else
                                        <span class="px-2 py-0.5 rounded-full text-[8px] font-semibold bg-emerald-50 text-emerald-500 border border-emerald-100">Selesai</span>
                                    @endif
                                </div>
                                <p class="text-slate-500 text-[11px] leading-relaxed mb-1.5 line-clamp-2">{{ $p->isi }}</p>
                                <span class="text-[9px] text-slate-400 font-medium">{{ $p->created_at->diffForHumans() }}</span>
                            </div>
                        @empty
                            <div class="bg-slate-50 border border-dashed border-slate-200 rounded-xl p-5 text-center text-slate-400 text-xs">
                                Belum ada riwayat pengaduan.
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Card selection
        const cards = document.querySelectorAll('.program-card');
        const hiddenInput = document.getElementById('selected_program_id');
        
        cards.forEach(card => {
            card.addEventListener('click', () => {
                cards.forEach(c => c.classList.remove('selected'));
                card.classList.add('selected');
                if (hiddenInput) {
                    hiddenInput.value = card.getAttribute('data-program-id');
                }
            });
        });

        // Toggle pengaduan form
        const showBtn = document.getElementById('showPengaduanForm');
        const cancelBtn = document.getElementById('cancelPengaduan');
        const formDiv = document.getElementById('pengaduanForm');
        
        if (showBtn && formDiv) {
            showBtn.addEventListener('click', () => {
                formDiv.classList.toggle('hidden');
                if (!formDiv.classList.contains('hidden')) {
                    formDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                }
            });
        }
        if (cancelBtn && formDiv) {
            cancelBtn.addEventListener('click', () => formDiv.classList.add('hidden'));
        }

        // Hash scroll
        if (window.location.hash) {
            const el = document.querySelector(window.location.hash);
            if (el) {
                setTimeout(() => el.scrollIntoView({ behavior: 'smooth', block: 'start' }), 150);
            }
        }
    });
</script>
@endsection