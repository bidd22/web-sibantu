@extends('layouts.app')

@section('content')
<style>
    .ornament-blur {
        position: fixed;
        width: 350px;
        height: 350px;
        background: radial-gradient(circle, rgba(99,102,241,0.12) 0%, rgba(99,102,241,0) 70%);
        border-radius: 50%;
        pointer-events: none;
        z-index: -1;
        filter: blur(30px);
    }
    .program-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        border: 1px solid #f1f5f9;
        background: white;
    }
    .program-card:hover {
        transform: translateY(-2px);
        border-color: #cbd5e1;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -4px rgba(0, 0, 0, 0.05);
    }
    .program-card.selected {
        border-color: #6366f1;
        background-color: #f8fafc;
        box-shadow: 0 10px 20px -3px rgba(99, 102, 241, 0.15), 0 4px 6px -4px rgba(99, 102, 241, 0.15);
    }
    .radio-indicator {
        position: relative;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        border: 2px solid #cbd5e1;
        background: white;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .radio-indicator::after {
        content: '';
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #6366f1;
        transform: scale(0);
        transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .program-card.selected .radio-indicator {
        border-color: #6366f1;
    }
    .program-card.selected .radio-indicator::after {
        transform: scale(1);
    }
    /* Stepper line transition */
    .stepper-progress {
        transition: width 0.5s ease-in-out;
    }
</style>

<div class="relative min-h-screen pb-12">
    <!-- Ornament Backgrounds -->
    <div class="ornament-blur top-10 left-10"></div>
    <div class="ornament-blur bottom-20 right-10" style="background: radial-gradient(circle, rgba(168,85,247,0.08) 0%, rgba(168,85,247,0) 70%);"></div>

    <!-- Section 1: Hero & Greeting (#beranda) -->
    <section id="beranda" class="scroll-mt-24 mb-8">
        <div class="relative overflow-hidden bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 text-white rounded-3xl p-6 md:p-8 shadow-xl shadow-indigo-950/20 border border-slate-800">
            <!-- Decorative light patterns -->
            <div class="absolute -right-10 -top-10 w-44 h-44 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -left-10 -bottom-10 w-44 h-44 bg-purple-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 relative z-10">
                <div class="space-y-3">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/20 border border-indigo-500/30 text-indigo-300 text-xs font-semibold tracking-wide uppercase">
                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-400 animate-pulse"></span>
                        Portal Layanan Warga
                    </div>
                    <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight">
                        Halo, <span class="bg-gradient-to-r from-indigo-200 via-purple-200 to-pink-200 bg-clip-text text-transparent">{{ Auth::user()->name }}</span>! 👋
                    </h1>
                    <p class="text-slate-300 max-w-2xl text-sm md:text-base leading-relaxed">
                        Selamat datang di SIBANTU. Portal layanan terpadu untuk pengajuan bantuan sosial dan penyampaian pengaduan masyarakat secara transparan, terpercaya, dan akuntabel.
                    </p>
                </div>
                <!-- Profile snapshot / date info -->
                <div class="flex-shrink-0 flex items-center gap-4 bg-slate-800/40 backdrop-blur-sm px-5 py-4 rounded-2xl border border-slate-700/30">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-indigo-500 to-purple-600 flex items-center justify-center text-white text-lg font-bold shadow-md shadow-indigo-500/20">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                    <div>
                        <div class="text-xs text-slate-400 font-medium">Hari Ini</div>
                        <div class="text-sm font-bold text-white">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @php
        // Fetch queries dynamically for stats & listing
        $all_pengajuans = \App\Models\Pengajuan::where('user_id', Auth::id())->with('program')->latest()->get();
        $all_pengaduans = \App\Models\Pengaduan::where('user_id', Auth::id())->latest()->get();
        
        $count_pending = $all_pengajuans->where('status', 'pending')->count();
        $count_disetujui = $all_pengajuans->where('status', 'disetujui')->count();
        $count_pengaduan_aktif = $all_pengaduans->whereIn('status', ['diterima', 'proses'])->count();
    @endphp

    <!-- Stats Widgets Row -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">
        <!-- Widget 1: Pending -->
        <div class="bg-white/80 backdrop-blur-sm border border-slate-100/80 rounded-2xl p-5 shadow-sm hover:shadow-md transition duration-300 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl font-semibold">
                ⏳
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Pengajuan Diproses</p>
                <h4 class="text-2xl font-bold text-slate-800 mt-0.5">{{ $count_pending }}</h4>
            </div>
        </div>
        <!-- Widget 2: Disetujui -->
        <div class="bg-white/80 backdrop-blur-sm border border-slate-100/80 rounded-2xl p-5 shadow-sm hover:shadow-md transition duration-300 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl font-semibold">
                ✅
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Bantuan Disetujui</p>
                <h4 class="text-2xl font-bold text-slate-800 mt-0.5">{{ $count_disetujui }}</h4>
            </div>
        </div>
        <!-- Widget 3: Pengaduan Aktif -->
        <div class="bg-white/80 backdrop-blur-sm border border-slate-100/80 rounded-2xl p-5 shadow-sm hover:shadow-md transition duration-300 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl font-semibold">
                📢
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Pengaduan Aktif</p>
                <h4 class="text-2xl font-bold text-slate-800 mt-0.5">{{ $count_pengaduan_aktif }}</h4>
            </div>
        </div>
    </div>

    <!-- Main Grid Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Panel: Ajukan Bantuan (Takes 2 cols) -->
        <div class="lg:col-span-2 space-y-8">
            <section id="ajukan" class="scroll-mt-24">
                <div class="bg-white border border-slate-100/70 rounded-3xl shadow-lg shadow-slate-100/40 overflow-hidden">
                    
                    <!-- Header Form -->
                    <div class="relative bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-6 text-white overflow-hidden">
                        <div class="absolute -right-8 -top-8 w-28 h-28 bg-white/10 rounded-full blur-xl pointer-events-none"></div>
                        <div class="relative z-10">
                            <h2 class="text-xl md:text-2xl font-bold flex items-center gap-2">
                                <span>📦</span> Ajukan Bantuan Sosial
                            </h2>
                            <p class="text-indigo-100 text-xs md:text-sm mt-1">Pilih salah satu program bantuan aktif dan tuliskan alasan pengajuan Anda</p>
                        </div>
                    </div>

                    <!-- Form -->
                    <form method="POST" action="{{ route('pengajuan.store') }}" class="p-6 md:p-8 space-y-8" id="formPengajuan">
                        @csrf
                        
                        <!-- Step 1: Pilih Program -->
                        <div class="space-y-4">
                            <div class="flex items-center gap-2">
                                <span class="w-6 h-6 rounded-full bg-indigo-50 text-indigo-600 font-bold flex items-center justify-center text-xs">1</span>
                                <h3 class="font-bold text-slate-800 text-base md:text-lg">Pilih Program Bantuan</h3>
                            </div>

                            @php
                                $programs = \App\Models\BantuanProgram::where('deadline', '>=', now())->get();
                            @endphp

                            @if($programs->isEmpty())
                                <div class="bg-slate-50 border border-slate-200/50 rounded-2xl p-6 text-center text-slate-400 text-sm">
                                    Tidak ada program bantuan sosial aktif saat ini.
                                </div>
                            @else
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    @foreach($programs as $program)
                                        <div class="program-card border rounded-2xl p-5 transition relative" data-program-id="{{ $program->id }}">
                                            
                                            <!-- Icon selection -->
                                            @php
                                                if($loop->index % 3 == 0) {
                                                    $bgIcon = 'bg-indigo-50 text-indigo-600';
                                                    $icon = '📦';
                                                } elseif($loop->index % 3 == 1) {
                                                    $bgIcon = 'bg-purple-50 text-purple-600';
                                                    $icon = '🎓';
                                                } else {
                                                    $bgIcon = 'bg-pink-50 text-pink-600';
                                                    $icon = '💼';
                                                }
                                            @endphp

                                            <div class="flex items-start gap-4">
                                                <div class="w-11 h-11 rounded-xl {{ $bgIcon }} flex items-center justify-center text-xl flex-shrink-0">
                                                    {{ $icon }}
                                                </div>

                                                <div class="flex-1 space-y-1 min-w-0">
                                                    <h4 class="font-bold text-slate-800 text-sm md:text-base truncate" title="{{ $program->nama_program }}">
                                                        {{ $program->nama_program }}
                                                    </h4>
                                                    <p class="text-slate-500 text-xs leading-relaxed line-clamp-2">
                                                        {{ $program->deskripsi }}
                                                    </p>
                                                    
                                                    <!-- Meta Info -->
                                                    <div class="flex flex-wrap gap-x-3 gap-y-1 pt-1.5 text-[10px] font-semibold text-slate-400">
                                                        <span class="flex items-center gap-1">
                                                            📊 Kuota: <span class="text-slate-600">{{ $program->kuota }}</span>
                                                        </span>
                                                        <span class="flex items-center gap-1">
                                                            📅 Deadline: <span class="text-slate-600">{{ \Carbon\Carbon::parse($program->deadline)->format('d M Y') }}</span>
                                                        </span>
                                                    </div>
                                                </div>

                                                <!-- Indicator -->
                                                <div class="radio-indicator flex-shrink-0 mt-0.5"></div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <input type="hidden" name="program_id" id="selected_program_id" required>
                            @endif
                        </div>

                        <!-- Step 2: Alasan -->
                        <div class="space-y-4">
                            <div class="flex items-center gap-2">
                                <span class="w-6 h-6 rounded-full bg-indigo-50 text-indigo-600 font-bold flex items-center justify-center text-xs">2</span>
                                <h3 class="font-bold text-slate-800 text-base md:text-lg">Alasan Pengajuan</h3>
                            </div>
                            
                            <textarea name="alasan" rows="4" required
                                class="w-full border border-slate-200 rounded-2xl px-4 py-3 text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-200 resize-none text-sm" 
                                placeholder="Ceritakan secara jujur mengenai kondisi Anda saat ini dan alasan kuat mengapa Anda berhak menerima bantuan ini..."></textarea>
                        </div>

                        <!-- Submit -->
                        <div>
                            <button type="submit" 
                                class="w-full sm:w-auto bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold py-3 px-8 rounded-2xl transition duration-300 shadow-md shadow-indigo-600/10 hover:shadow-indigo-600/25 hover:-translate-y-0.5 active:translate-y-0 text-sm">
                                Kirim Pengajuan Bantuan
                            </button>
                        </div>
                    </form>
                </div>
            </section>
        </div>

        <!-- Right Panel: Status & Pengaduan (1 col) -->
        <div class="space-y-8">
            
            <!-- Riwayat Section -->
            <section id="riwayat" class="scroll-mt-24">
                <div class="bg-white border border-slate-100 rounded-3xl shadow-lg shadow-slate-100/40 p-6 space-y-6">
                    <div class="flex justify-between items-center border-b border-slate-100 pb-4">
                        <h2 class="text-base md:text-lg font-bold text-slate-800 flex items-center gap-2">
                            <span>📋</span> Status Pengajuan
                        </h2>
                        <span class="text-xs bg-slate-50 text-slate-500 px-2.5 py-1 rounded-full font-medium">
                            Total: {{ $all_pengajuans->count() }}
                        </span>
                    </div>

                    @if($all_pengajuans->isEmpty())
                        <div class="bg-slate-50/50 border border-dashed border-slate-200 rounded-2xl p-6 text-center text-slate-400 text-xs md:text-sm">
                            Belum ada riwayat pengajuan bantuan.
                        </div>
                    @else
                        <div class="space-y-5 max-h-[420px] overflow-y-auto pr-1">
                            @foreach($all_pengajuans as $p)
                                <div class="bg-slate-50/50 border border-slate-100 rounded-2xl p-4 space-y-4 shadow-sm hover:border-slate-200 transition">
                                    <div class="flex justify-between items-start gap-2">
                                        <div class="min-w-0">
                                            <h4 class="font-bold text-slate-800 text-xs md:text-sm truncate" title="{{ $p->program->nama_program }}">
                                                {{ $p->program->nama_program }}
                                            </h4>
                                            <p class="text-slate-400 text-[10px] font-medium mt-0.5">
                                                Diajukan: {{ $p->created_at->format('d M Y') }}
                                            </p>
                                        </div>

                                        <!-- Badge Status -->
                                        @if($p->status == 'pending')
                                            <span class="px-2 py-0.5 rounded-full text-[9px] font-semibold bg-amber-50 text-amber-600 border border-amber-100">
                                                Pending
                                            </span>
                                        @elseif($p->status == 'disetujui')
                                            <span class="px-2 py-0.5 rounded-full text-[9px] font-semibold bg-emerald-50 text-emerald-600 border border-emerald-100">
                                                Disetujui
                                            </span>
                                        @else
                                            <span class="px-2 py-0.5 rounded-full text-[9px] font-semibold bg-rose-50 text-rose-600 border border-rose-100">
                                                Ditolak
                                            </span>
                                        @endif
                                    </div>

                                    <p class="text-slate-500 text-xs leading-relaxed line-clamp-2">
                                        {{ $p->alasan }}
                                    </p>

                                    <!-- Visual Stepper -->
                                    <div class="relative pt-2">
                                        <!-- Background line -->
                                        <div class="absolute top-[18px] left-[5%] right-[5%] h-0.5 bg-slate-200 -z-10"></div>
                                        
                                        <!-- Active line -->
                                        @php
                                            $lineWidth = 'w-0';
                                            if($p->status == 'pending') $lineWidth = 'w-[50%]';
                                            if($p->status == 'disetujui' || $p->status == 'ditolak') $lineWidth = 'w-[100%]';
                                        @endphp
                                        <div class="absolute top-[18px] left-[5%] h-0.5 bg-indigo-500 -z-10 stepper-progress {{ $lineWidth }}"></div>

                                        <div class="flex justify-between text-center">
                                            <!-- Step 1 -->
                                            <div class="flex flex-col items-center flex-1">
                                                <div class="w-6 h-6 rounded-full bg-indigo-500 text-white flex items-center justify-center text-[10px] font-bold ring-4 ring-indigo-50">
                                                    ✓
                                                </div>
                                                <span class="text-[9px] font-semibold text-indigo-500 mt-1">Diajukan</span>
                                            </div>

                                            <!-- Step 2 -->
                                            <div class="flex flex-col items-center flex-1">
                                                @if($p->status == 'pending')
                                                    <div class="w-6 h-6 rounded-full bg-amber-500 text-white flex items-center justify-center text-[10px] font-bold ring-4 ring-amber-50 animate-pulse">
                                                        ⏳
                                                    </div>
                                                    <span class="text-[9px] font-semibold text-amber-500 mt-1">Ditinjau</span>
                                                @else
                                                    <div class="w-6 h-6 rounded-full bg-indigo-500 text-white flex items-center justify-center text-[10px] font-bold ring-4 ring-indigo-50">
                                                        ✓
                                                    </div>
                                                    <span class="text-[9px] font-semibold text-indigo-500 mt-1">Ditinjau</span>
                                                @endif
                                            </div>

                                            <!-- Step 3 -->
                                            <div class="flex flex-col items-center flex-1">
                                                @if($p->status == 'pending')
                                                    <div class="w-6 h-6 rounded-full bg-slate-200 text-slate-400 flex items-center justify-center text-[10px] font-bold">
                                                        •
                                                    </div>
                                                    <span class="text-[9px] font-medium text-slate-400 mt-1">Keputusan</span>
                                                @elseif($p->status == 'disetujui')
                                                    <div class="w-6 h-6 rounded-full bg-emerald-500 text-white flex items-center justify-center text-[10px] font-bold ring-4 ring-emerald-50">
                                                        ✓
                                                    </div>
                                                    <span class="text-[9px] font-semibold text-emerald-600 mt-1">Disetujui</span>
                                                @else
                                                    <div class="w-6 h-6 rounded-full bg-rose-500 text-white flex items-center justify-center text-[10px] font-bold ring-4 ring-rose-50">
                                                        ✗
                                                    </div>
                                                    <span class="text-[9px] font-semibold text-rose-600 mt-1">Ditolak</span>
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

            <!-- Pengaduan Section -->
            <section id="pengaduan" class="scroll-mt-24">
                <div class="bg-white border border-slate-100 rounded-3xl shadow-lg shadow-slate-100/40 p-6 space-y-6">
                    <div class="flex justify-between items-center border-b border-slate-100 pb-4">
                        <h2 class="text-base md:text-lg font-bold text-slate-800 flex items-center gap-2">
                            <span>💬</span> Pengaduan Saya
                        </h2>
                        <button id="showPengaduanForm" 
                            class="bg-indigo-50 hover:bg-indigo-100 text-indigo-600 px-3 py-1.5 rounded-xl text-xs font-bold transition duration-200 flex items-center gap-1 border border-indigo-100">
                            <span>+</span> Baru
                        </button>
                    </div>

                    <!-- Collapsible Form -->
                    <div id="pengaduanForm" class="hidden overflow-hidden bg-slate-50 border border-slate-200/50 rounded-2xl p-5 shadow-inner transition-all duration-300">
                        <form method="POST" action="{{ route('pengaduan.store') }}" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-[10px] font-bold text-slate-600 uppercase tracking-wider mb-1">Judul Pengaduan</label>
                                <input type="text" name="judul" required
                                    class="w-full border border-slate-200 rounded-xl px-3 py-2 text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition"
                                    placeholder="Contoh: Saluran air tersumbat">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-600 uppercase tracking-wider mb-1">Isi Pengaduan</label>
                                <textarea name="isi" rows="3" required
                                    class="w-full border border-slate-200 rounded-xl px-3 py-2 text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition resize-none"
                                    placeholder="Ceritakan keluhan Anda secara jelas..."></textarea>
                            </div>
                            <div class="flex gap-2">
                                <button type="submit" 
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-xl text-xs shadow transition">
                                    Kirim
                                </button>
                                <button type="button" id="cancelPengaduan"
                                    class="bg-slate-200 hover:bg-slate-300 text-slate-600 font-bold py-2 px-4 rounded-xl text-xs transition">
                                    Batal
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- List -->
                    <div id="listPengaduan" class="space-y-4 max-h-[350px] overflow-y-auto pr-1">
                        @forelse($all_pengaduans as $p)
                            <div class="bg-white border border-slate-100 rounded-2xl p-4 hover:border-slate-200 transition shadow-sm">
                                <div class="flex justify-between items-start gap-2 mb-2">
                                    <h4 class="font-bold text-slate-800 text-xs md:text-sm truncate max-w-[65%]">
                                        {{ $p->judul }}
                                    </h4>
                                    
                                    @if($p->status == 'diterima')
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[8px] font-bold bg-slate-50 text-slate-600 border border-slate-200">
                                            Diterima
                                        </span>
                                    @elseif($p->status == 'proses')
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[8px] font-bold bg-blue-50 text-blue-600 border border-blue-100">
                                            Proses
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[8px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-100">
                                            Selesai
                                        </span>
                                    @endif
                                </div>
                                <p class="text-slate-500 text-xs leading-relaxed mb-2">
                                    {{ $p->isi }}
                                </p>
                                <span class="text-[9px] text-slate-400 font-medium">🕒 {{ $p->created_at->diffForHumans() }}</span>
                            </div>
                        @empty
                            <div class="bg-slate-50/50 border border-dashed border-slate-200 rounded-2xl p-6 text-center text-slate-400 text-xs md:text-sm">
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
                
                const programId = card.getAttribute('data-program-id');
                if (hiddenInput) {
                    hiddenInput.value = programId;
                }
            });
        });

        // Toggle form pengaduan
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
            cancelBtn.addEventListener('click', () => {
                formDiv.classList.add('hidden');
            });
        }

        // Hash scroll on load
        if (window.location.hash) {
            const el = document.querySelector(window.location.hash);
            if (el) {
                setTimeout(() => {
                    el.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }, 100);
            }
        }
    });
</script>
@endsection