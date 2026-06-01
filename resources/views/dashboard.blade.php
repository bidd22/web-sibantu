@extends('layouts.app')

@section('content')
<style>
    :root {
        --navy-950: #0a0f1e;
        --navy-900: #0d1426;
        --navy-800: #112040;
        --navy-700: #1a3260;
        --navy-600: #1e3a72;
        --navy-500: #2451a0;
        --navy-400: #3b6bc4;
        --navy-300: #6190d8;
        --navy-200: #a8c4ef;
        --navy-100: #dce8f7;
        --navy-50:  #f0f5fc;
        --accent:   #2e7cf6;
        --accent-soft: #e8f0fe;
    }

    * { box-sizing: border-box; }

    .program-card {
        transition: all 0.2s ease;
        cursor: pointer;
        border: 1.5px solid #dde4ef;
        background: #fff;
    }
    .program-card:hover {
        border-color: var(--navy-300);
        background: var(--navy-50);
    }
    .program-card.selected {
        border-color: var(--navy-500);
        background: var(--accent-soft);
    }
    .radio-dot {
        width: 17px; height: 17px;
        border-radius: 50%;
        border: 2px solid #c2cfdf;
        transition: all 0.2s ease;
        position: relative;
        flex-shrink: 0;
    }
    .radio-dot::after {
        content: '';
        position: absolute;
        inset: 3px;
        border-radius: 50%;
        background: var(--navy-500);
        transform: scale(0);
        transition: transform 0.18s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .program-card.selected .radio-dot {
        border-color: var(--navy-500);
    }
    .program-card.selected .radio-dot::after {
        transform: scale(1);
    }
    .stepper-line {
        transition: width 0.5s ease-in-out;
    }
    .fade-up {
        animation: fadeUp 0.45s ease-out both;
    }
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(10px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* Scrollbar */
    .scroll-pane { scrollbar-width: thin; scrollbar-color: #c8d8ed transparent; }
    .scroll-pane::-webkit-scrollbar { width: 4px; }
    .scroll-pane::-webkit-scrollbar-thumb { background: #c8d8ed; border-radius: 99px; }
</style>

<div class="relative min-h-screen pb-14">

    {{-- ====== HERO ====== --}}
    <section id="beranda" class="scroll-mt-24 mb-7 fade-up">
        <div class="relative overflow-hidden rounded-2xl text-white"
             style="background: linear-gradient(135deg, var(--navy-900) 0%, var(--navy-700) 60%, var(--navy-800) 100%);
                    border: 1px solid var(--navy-700);">

            {{-- Subtle geometric accent --}}
            <div style="position:absolute;right:-40px;top:-40px;width:200px;height:200px;
                        border-radius:50%;border:40px solid rgba(255,255,255,0.03);pointer-events:none;"></div>
            <div style="position:absolute;left:-20px;bottom:-20px;width:120px;height:120px;
                        border-radius:50%;border:30px solid rgba(255,255,255,0.03);pointer-events:none;"></div>

            <div class="flex flex-col md:flex-row md:items-center justify-between gap-5 p-6 md:p-8 relative">
                <div style="display:flex;flex-direction:column;gap:10px;">
                    <div style="display:inline-flex;align-items:center;gap:7px;padding:5px 12px;
                                background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.12);
                                border-radius:99px;width:fit-content;">
                        <span style="width:7px;height:7px;border-radius:50%;background:var(--navy-200);
                                     display:inline-block;animation:pulse 2s infinite;"></span>
                        <span style="font-size:10px;font-weight:700;letter-spacing:.08em;color:var(--navy-200);
                                     text-transform:uppercase;">Portal Layanan Warga · SIBANTU</span>
                    </div>
                    <h1 style="font-size:clamp(1.3rem,3vw,1.8rem);font-weight:800;letter-spacing:-.02em;margin:0;
                               color:#fff;">
                        Halo, <span style="color:var(--navy-200);">{{ Auth::user()->name }}</span>
                    </h1>
                    <p style="color:rgba(255,255,255,0.45);font-size:.82rem;max-width:420px;line-height:1.65;margin:0;">
                        Ajukan bantuan sosial dan sampaikan pengaduan secara mudah &amp; transparan.
                    </p>
                </div>

                <div style="flex-shrink:0;display:flex;align-items:center;gap:12px;
                             background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);
                             padding:12px 16px;border-radius:14px;backdrop-filter:blur(6px);">
                    <div style="width:40px;height:40px;border-radius:10px;
                                background:var(--navy-500);
                                display:flex;align-items:center;justify-content:center;
                                font-size:.8rem;font-weight:700;color:#fff;letter-spacing:.04em;flex-shrink:0;">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                    <div>
                        <div style="font-size:10px;color:rgba(255,255,255,0.35);font-weight:600;letter-spacing:.05em;text-transform:uppercase;">Hari Ini</div>
                        <div style="font-size:.8rem;font-weight:600;color:#fff;margin-top:2px;">
                            {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @php
        $all_pengajuans   = \App\Models\Pengajuan::where('user_id', Auth::id())->with('program')->latest()->get();
        $all_pengaduans   = \App\Models\Pengaduan::where('user_id', Auth::id())->latest()->get();
        $count_pending    = $all_pengajuans->where('status', 'pending')->count();
        $count_disetujui  = $all_pengajuans->where('status', 'disetujui')->count();
        $count_pengaduan_aktif = $all_pengaduans->whereIn('status', ['diterima', 'proses'])->count();
    @endphp

    {{-- ====== STATS ====== --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-7">
        @php
            $stats = [
                ['label'=>'Diproses','value'=>$count_pending,
                 'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                 'delay'=>'.1s'],
                ['label'=>'Disetujui','value'=>$count_disetujui,
                 'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                 'delay'=>'.15s'],
                ['label'=>'Pengaduan Aktif','value'=>$count_pengaduan_aktif,
                 'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z"/>',
                 'delay'=>'.2s'],
            ];
        @endphp
        @foreach($stats as $s)
        <div class="fade-up" style="animation-delay:{{ $s['delay'] }}">
            <div style="background:#fff;border:1.5px solid #dde4ef;border-radius:14px;
                        padding:14px 16px;display:flex;align-items:center;gap:14px;
                        transition:border-color .2s,box-shadow .2s;"
                 onmouseover="this.style.borderColor='var(--navy-300)';this.style.boxShadow='0 2px 12px rgba(30,58,114,.06)'"
                 onmouseout="this.style.borderColor='#dde4ef';this.style.boxShadow='none'">
                <div style="width:38px;height:38px;border-radius:10px;background:var(--navy-50);
                             border:1px solid var(--navy-100);display:flex;align-items:center;
                             justify-content:center;flex-shrink:0;">
                    <svg style="width:17px;height:17px;color:var(--navy-500);" fill="none"
                         stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        {!! $s['icon'] !!}
                    </svg>
                </div>
                <div>
                    <p style="font-size:10px;font-weight:700;color:#8fa3bf;letter-spacing:.06em;
                               text-transform:uppercase;margin:0 0 2px;">{{ $s['label'] }}</p>
                    <h4 style="font-size:1.35rem;font-weight:800;color:var(--navy-800);margin:0;line-height:1;">
                        {{ $s['value'] }}
                    </h4>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ====== MAIN GRID ====== --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- LEFT: Form Pengajuan --}}
        <div class="lg:col-span-2 space-y-6">
            <section id="ajukan" class="scroll-mt-24 fade-up" style="animation-delay:.25s">
                <div style="background:#fff;border:1.5px solid #dde4ef;border-radius:18px;overflow:hidden;">

                    {{-- Card Header --}}
                    <div style="background:var(--navy-800);padding:20px 24px;position:relative;overflow:hidden;">
                        <div style="position:absolute;right:-20px;top:-20px;width:100px;height:100px;
                                    border-radius:50%;border:25px solid rgba(255,255,255,0.04);pointer-events:none;"></div>
                        <div style="position:relative;z-index:1;">
                            <h2 style="font-size:.95rem;font-weight:700;color:#fff;margin:0 0 3px;
                                       display:flex;align-items:center;gap:8px;">
                                <svg style="width:17px;height:17px;color:var(--navy-200);" fill="none"
                                     stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                                </svg>
                                Ajukan Bantuan Sosial
                            </h2>
                            <p style="color:rgba(255,255,255,.4);font-size:.75rem;margin:0;">
                                Pilih program dan tuliskan alasan pengajuan Anda
                            </p>
                        </div>
                    </div>

                    {{-- Form --}}
                    <form method="POST" action="{{ route('pengajuan.store') }}"
                          class="p-6 space-y-7" id="formPengajuan">
                        @csrf

                        {{-- Step 1 --}}
                        <div class="space-y-3">
                            <div style="display:flex;align-items:center;gap:8px;">
                                <span style="width:20px;height:20px;border-radius:50%;
                                             background:var(--navy-800);color:#fff;
                                             font-size:10px;font-weight:700;
                                             display:flex;align-items:center;justify-content:center;flex-shrink:0;">1</span>
                                <h3 style="font-size:.83rem;font-weight:700;color:var(--navy-800);margin:0;">
                                    Pilih Program Bantuan
                                </h3>
                            </div>

                            @php $programs = \App\Models\BantuanProgram::where('deadline', '>=', now())->get(); @endphp

                            @if($programs->isEmpty())
                                <div style="background:var(--navy-50);border:1.5px dashed #c8d8ed;
                                            border-radius:12px;padding:20px;text-align:center;
                                            color:#8fa3bf;font-size:.82rem;">
                                    Tidak ada program bantuan aktif saat ini.
                                </div>
                            @else
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    @foreach($programs as $program)
                                    <div class="program-card rounded-xl p-4" data-program-id="{{ $program->id }}">
                                        <div style="display:flex;align-items:flex-start;gap:12px;">
                                            <div style="width:36px;height:36px;border-radius:9px;
                                                        background:var(--navy-50);border:1px solid var(--navy-100);
                                                        display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                                <svg style="width:16px;height:16px;color:var(--navy-500);"
                                                     fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/>
                                                </svg>
                                            </div>
                                            <div style="flex:1;min-width:0;">
                                                <h4 style="font-weight:700;color:var(--navy-800);font-size:.82rem;
                                                           margin:0 0 3px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"
                                                    title="{{ $program->nama_program }}">
                                                    {{ $program->nama_program }}
                                                </h4>
                                                <p style="color:#8fa3bf;font-size:.72rem;line-height:1.5;margin:0 0 6px;
                                                           display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                                                    {{ $program->deskripsi }}
                                                </p>
                                                <div style="display:flex;gap:12px;font-size:.68rem;font-weight:600;color:#8fa3bf;">
                                                    <span>Kuota: <span style="color:var(--navy-600);">{{ $program->kuota }}</span></span>
                                                    <span>Batas: <span style="color:var(--navy-600);">{{ \Carbon\Carbon::parse($program->deadline)->format('d M Y') }}</span></span>
                                                </div>
                                            </div>
                                            <div class="radio-dot" style="margin-top:3px;"></div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <input type="hidden" name="program_id" id="selected_program_id" required>
                            @endif
                        </div>

                        {{-- Step 2 --}}
                        <div class="space-y-3">
                            <div style="display:flex;align-items:center;gap:8px;">
                                <span style="width:20px;height:20px;border-radius:50%;
                                             background:var(--navy-800);color:#fff;
                                             font-size:10px;font-weight:700;
                                             display:flex;align-items:center;justify-content:center;flex-shrink:0;">2</span>
                                <h3 style="font-size:.83rem;font-weight:700;color:var(--navy-800);margin:0;">
                                    Alasan Pengajuan
                                </h3>
                            </div>
                            <textarea name="alasan" rows="4" required
                                style="width:100%;border:1.5px solid #dde4ef;border-radius:12px;
                                       padding:12px 14px;color:var(--navy-800);font-size:.83rem;
                                       font-family:inherit;resize:none;outline:none;transition:border-color .2s;
                                       line-height:1.6;background:#fff;"
                                placeholder="Jelaskan kondisi Anda saat ini dan alasan pengajuan bantuan..."
                                onfocus="this.style.borderColor='var(--navy-400)'"
                                onblur="this.style.borderColor='#dde4ef'"></textarea>
                        </div>

                        {{-- Submit --}}
                        <div>
                            <button type="submit"
                                style="background:var(--navy-700);color:#fff;font-weight:700;
                                       padding:10px 24px;border-radius:10px;border:none;cursor:pointer;
                                       font-size:.82rem;letter-spacing:.02em;transition:background .2s,transform .1s;"
                                onmouseover="this.style.background='var(--navy-800)'"
                                onmouseout="this.style.background='var(--navy-700)'"
                                onmousedown="this.style.transform='scale(.98)'"
                                onmouseup="this.style.transform='scale(1)'">
                                Kirim Pengajuan
                            </button>
                        </div>
                    </form>
                </div>
            </section>
        </div>

        {{-- RIGHT PANEL --}}
        <div class="space-y-6">

            {{-- ====== STATUS PENGAJUAN ====== --}}
            <section id="riwayat" class="scroll-mt-24 fade-up" style="animation-delay:.3s">
                <div style="background:#fff;border:1.5px solid #dde4ef;border-radius:18px;padding:20px;">

                    <div style="display:flex;justify-content:space-between;align-items:center;
                                padding-bottom:14px;border-bottom:1px solid #edf1f7;margin-bottom:14px;">
                        <h2 style="font-size:.83rem;font-weight:700;color:var(--navy-800);margin:0;
                                   display:flex;align-items:center;gap:7px;">
                            <svg style="width:15px;height:15px;color:var(--navy-400);" fill="none"
                                 stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/>
                            </svg>
                            Status Pengajuan
                        </h2>
                        <span style="font-size:.68rem;background:var(--navy-50);color:var(--navy-600);
                                     padding:2px 9px;border-radius:99px;font-weight:700;border:1px solid var(--navy-100);">
                            {{ $all_pengajuans->count() }}
                        </span>
                    </div>

                    @if($all_pengajuans->isEmpty())
                        <div style="background:var(--navy-50);border:1.5px dashed #c8d8ed;border-radius:12px;
                                    padding:20px;text-align:center;color:#8fa3bf;font-size:.78rem;">
                            Belum ada riwayat pengajuan.
                        </div>
                    @else
                        <div class="scroll-pane" style="max-height:420px;overflow-y:auto;
                                                         display:flex;flex-direction:column;gap:10px;padding-right:4px;">
                            @foreach($all_pengajuans as $p)
                            <div style="background:var(--navy-50);border:1.5px solid #dde4ef;border-radius:13px;
                                        padding:13px;transition:border-color .2s;"
                                 onmouseover="this.style.borderColor='var(--navy-200)'"
                                 onmouseout="this.style.borderColor='#dde4ef'">

                                <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:8px;margin-bottom:6px;">
                                    <div style="min-width:0;">
                                        <h4 style="font-weight:700;color:var(--navy-800);font-size:.78rem;margin:0 0 2px;
                                                   overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"
                                            title="{{ $p->program->nama_program }}">
                                            {{ $p->program->nama_program }}
                                        </h4>
                                        <p style="color:#8fa3bf;font-size:.68rem;margin:0;">
                                            {{ $p->created_at->format('d M Y') }}
                                        </p>
                                    </div>
                                    @if($p->status == 'pending')
                                        <span style="padding:2px 8px;border-radius:99px;font-size:.65rem;font-weight:700;
                                                     white-space:nowrap;background:#fef9ec;color:#92600a;border:1px solid #f5d98a;">Pending</span>
                                    @elseif($p->status == 'disetujui')
                                        <span style="padding:2px 8px;border-radius:99px;font-size:.65rem;font-weight:700;
                                                     white-space:nowrap;background:#ecfdf4;color:#166534;border:1px solid #a7f3c9;">Disetujui</span>
                                    @else
                                        <span style="padding:2px 8px;border-radius:99px;font-size:.65rem;font-weight:700;
                                                     white-space:nowrap;background:#fef2f2;color:#991b1b;border:1px solid #fca5a5;">Ditolak</span>
                                    @endif
                                </div>

                                <p style="color:#7a90a8;font-size:.72rem;line-height:1.5;margin:0 0 10px;
                                           display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                                    {{ $p->alasan }}
                                </p>

                                {{-- Stepper --}}
                                <div style="position:relative;padding-top:6px;">
                                    <div style="position:absolute;top:14px;left:8%;right:8%;height:1px;background:#d8e5f2;"></div>
                                    @php
                                        $lw = '0%';
                                        if($p->status == 'pending')                                  $lw = '50%';
                                        if($p->status == 'disetujui' || $p->status == 'ditolak')     $lw = '100%';
                                    @endphp
                                    <div style="position:absolute;top:14px;left:8%;height:1px;
                                                background:var(--navy-400);width:{{ $lw }};transition:width .5s ease;"></div>

                                    <div style="display:flex;justify-content:space-between;position:relative;">
                                        {{-- Step: Diajukan --}}
                                        <div style="display:flex;flex-direction:column;align-items:center;flex:1;">
                                            <div style="width:20px;height:20px;border-radius:50%;
                                                        background:var(--navy-600);color:#fff;
                                                        display:flex;align-items:center;justify-content:center;
                                                        box-shadow:0 0 0 3px rgba(30,58,114,.12);">
                                                <svg style="width:10px;height:10px;" fill="none" stroke="currentColor"
                                                     stroke-width="3" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                                </svg>
                                            </div>
                                            <span style="font-size:.6rem;font-weight:600;color:var(--navy-500);margin-top:4px;">Diajukan</span>
                                        </div>

                                        {{-- Step: Ditinjau --}}
                                        <div style="display:flex;flex-direction:column;align-items:center;flex:1;">
                                            @if($p->status == 'pending')
                                                <div style="width:20px;height:20px;border-radius:50%;
                                                            background:#d97706;color:#fff;
                                                            display:flex;align-items:center;justify-content:center;
                                                            box-shadow:0 0 0 3px rgba(217,119,6,.15);
                                                            animation:pulse 2s infinite;">
                                                    <svg style="width:10px;height:10px;" fill="none" stroke="currentColor"
                                                         stroke-width="3" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5"/>
                                                    </svg>
                                                </div>
                                                <span style="font-size:.6rem;font-weight:600;color:#d97706;margin-top:4px;">Ditinjau</span>
                                            @else
                                                <div style="width:20px;height:20px;border-radius:50%;
                                                            background:var(--navy-600);color:#fff;
                                                            display:flex;align-items:center;justify-content:center;
                                                            box-shadow:0 0 0 3px rgba(30,58,114,.12);">
                                                    <svg style="width:10px;height:10px;" fill="none" stroke="currentColor"
                                                         stroke-width="3" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                                    </svg>
                                                </div>
                                                <span style="font-size:.6rem;font-weight:600;color:var(--navy-500);margin-top:4px;">Ditinjau</span>
                                            @endif
                                        </div>

                                        {{-- Step: Keputusan --}}
                                        <div style="display:flex;flex-direction:column;align-items:center;flex:1;">
                                            @if($p->status == 'pending')
                                                <div style="width:20px;height:20px;border-radius:50%;
                                                            background:#dde4ef;display:flex;align-items:center;justify-content:center;">
                                                    <div style="width:6px;height:6px;border-radius:50%;background:#b0bfd4;"></div>
                                                </div>
                                                <span style="font-size:.6rem;font-weight:600;color:#b0bfd4;margin-top:4px;">Keputusan</span>
                                            @elseif($p->status == 'disetujui')
                                                <div style="width:20px;height:20px;border-radius:50%;
                                                            background:#16a34a;color:#fff;
                                                            display:flex;align-items:center;justify-content:center;
                                                            box-shadow:0 0 0 3px rgba(22,163,74,.15);">
                                                    <svg style="width:10px;height:10px;" fill="none" stroke="currentColor"
                                                         stroke-width="3" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                                    </svg>
                                                </div>
                                                <span style="font-size:.6rem;font-weight:600;color:#16a34a;margin-top:4px;">Disetujui</span>
                                            @else
                                                <div style="width:20px;height:20px;border-radius:50%;
                                                            background:#dc2626;color:#fff;
                                                            display:flex;align-items:center;justify-content:center;
                                                            box-shadow:0 0 0 3px rgba(220,38,38,.15);">
                                                    <svg style="width:10px;height:10px;" fill="none" stroke="currentColor"
                                                         stroke-width="3" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                                    </svg>
                                                </div>
                                                <span style="font-size:.6rem;font-weight:600;color:#dc2626;margin-top:4px;">Ditolak</span>
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

            {{-- ====== PENGADUAN ====== --}}
            <section id="pengaduan" class="scroll-mt-24 fade-up" style="animation-delay:.35s">
                <div style="background:#fff;border:1.5px solid #dde4ef;border-radius:18px;padding:20px;">

                    <div style="display:flex;justify-content:space-between;align-items:center;
                                padding-bottom:14px;border-bottom:1px solid #edf1f7;margin-bottom:14px;">
                        <h2 style="font-size:.83rem;font-weight:700;color:var(--navy-800);margin:0;
                                   display:flex;align-items:center;gap:7px;">
                            <svg style="width:15px;height:15px;color:var(--navy-400);" fill="none"
                                 stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z"/>
                            </svg>
                            Pengaduan Saya
                        </h2>
                        <button id="showPengaduanForm"
                            style="background:var(--navy-800);color:#fff;padding:5px 12px;border-radius:8px;
                                   font-size:.72rem;font-weight:700;border:none;cursor:pointer;
                                   display:flex;align-items:center;gap:5px;transition:background .2s;"
                            onmouseover="this.style.background='var(--navy-900)'"
                            onmouseout="this.style.background='var(--navy-800)'">
                            <svg style="width:11px;height:11px;" fill="none" stroke="currentColor"
                                 stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                            </svg>
                            Baru
                        </button>
                    </div>

                    {{-- Pengaduan Form --}}
                    <div id="pengaduanForm"
                         style="display:none;background:var(--navy-50);border:1.5px solid var(--navy-100);
                                border-radius:12px;padding:16px;margin-bottom:14px;">
                        <form method="POST" action="{{ route('pengaduan.store') }}" style="display:flex;flex-direction:column;gap:10px;">
                            @csrf
                            <div>
                                <label style="display:block;font-size:.68rem;font-weight:700;color:#8fa3bf;
                                              letter-spacing:.07em;text-transform:uppercase;margin-bottom:5px;">Judul</label>
                                <input type="text" name="judul" required
                                    style="width:100%;border:1.5px solid #dde4ef;border-radius:8px;
                                           padding:8px 12px;font-size:.8rem;color:var(--navy-800);
                                           outline:none;background:#fff;font-family:inherit;transition:border-color .2s;"
                                    placeholder="Ringkasan pengaduan"
                                    onfocus="this.style.borderColor='var(--navy-400)'"
                                    onblur="this.style.borderColor='#dde4ef'">
                            </div>
                            <div>
                                <label style="display:block;font-size:.68rem;font-weight:700;color:#8fa3bf;
                                              letter-spacing:.07em;text-transform:uppercase;margin-bottom:5px;">Isi Pengaduan</label>
                                <textarea name="isi" rows="3" required
                                    style="width:100%;border:1.5px solid #dde4ef;border-radius:8px;
                                           padding:8px 12px;font-size:.8rem;color:var(--navy-800);
                                           outline:none;background:#fff;resize:none;font-family:inherit;transition:border-color .2s;"
                                    placeholder="Jelaskan keluhan Anda..."
                                    onfocus="this.style.borderColor='var(--navy-400)'"
                                    onblur="this.style.borderColor='#dde4ef'"></textarea>
                            </div>
                            <div style="display:flex;gap:8px;">
                                <button type="submit"
                                    style="background:var(--navy-700);color:#fff;font-weight:700;
                                           padding:7px 16px;border-radius:8px;border:none;cursor:pointer;
                                           font-size:.78rem;transition:background .2s;"
                                    onmouseover="this.style.background='var(--navy-800)'"
                                    onmouseout="this.style.background='var(--navy-700)'">Kirim</button>
                                <button type="button" id="cancelPengaduan"
                                    style="background:#edf1f7;color:#5a7a9a;font-weight:700;
                                           padding:7px 16px;border-radius:8px;border:none;cursor:pointer;
                                           font-size:.78rem;transition:background .2s;"
                                    onmouseover="this.style.background='#dde4ef'"
                                    onmouseout="this.style.background='#edf1f7'">Batal</button>
                            </div>
                        </form>
                    </div>

                    {{-- Pengaduan List --}}
                    <div class="scroll-pane" style="max-height:340px;overflow-y:auto;
                                                     display:flex;flex-direction:column;gap:10px;padding-right:4px;">
                        @forelse($all_pengaduans as $p)
                        <div style="background:var(--navy-50);border:1.5px solid #dde4ef;border-radius:13px;
                                    padding:13px;transition:border-color .2s;"
                             onmouseover="this.style.borderColor='var(--navy-200)'"
                             onmouseout="this.style.borderColor='#dde4ef'">
                            <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:8px;margin-bottom:5px;">
                                <h4 style="font-weight:700;color:var(--navy-800);font-size:.78rem;margin:0;
                                           overflow:hidden;text-overflow:ellipsis;white-space:nowrap;max-width:65%;">
                                    {{ $p->judul }}
                                </h4>
                                @if($p->status == 'diterima')
                                    <span style="padding:2px 8px;border-radius:99px;font-size:.63rem;font-weight:700;
                                                 background:var(--navy-50);color:var(--navy-600);border:1px solid var(--navy-100);white-space:nowrap;">Diterima</span>
                                @elseif($p->status == 'proses')
                                    <span style="padding:2px 8px;border-radius:99px;font-size:.63rem;font-weight:700;
                                                 background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;white-space:nowrap;">Proses</span>
                                @else
                                    <span style="padding:2px 8px;border-radius:99px;font-size:.63rem;font-weight:700;
                                                 background:#ecfdf4;color:#166534;border:1px solid #a7f3c9;white-space:nowrap;">Selesai</span>
                                @endif
                            </div>
                            <p style="color:#7a90a8;font-size:.72rem;line-height:1.5;margin:0 0 6px;
                                       display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                                {{ $p->isi }}
                            </p>
                            <span style="font-size:.65rem;color:#b0bfd4;font-weight:600;">
                                {{ $p->created_at->diffForHumans() }}
                            </span>
                        </div>
                        @empty
                            <div style="background:var(--navy-50);border:1.5px dashed #c8d8ed;border-radius:12px;
                                        padding:20px;text-align:center;color:#8fa3bf;font-size:.78rem;">
                                Belum ada riwayat pengaduan.
                            </div>
                        @endforelse
                    </div>

                </div>
            </section>

        </div>{{-- /right panel --}}
    </div>{{-- /main grid --}}
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
            if (hiddenInput) hiddenInput.value = card.getAttribute('data-program-id');
        });
    });

    // Toggle pengaduan form
    const showBtn   = document.getElementById('showPengaduanForm');
    const cancelBtn = document.getElementById('cancelPengaduan');
    const formDiv   = document.getElementById('pengaduanForm');

    if (showBtn && formDiv) {
        showBtn.addEventListener('click', () => {
            const hidden = formDiv.style.display === 'none';
            formDiv.style.display = hidden ? 'block' : 'none';
            if (hidden) formDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        });
    }
    if (cancelBtn && formDiv) {
        cancelBtn.addEventListener('click', () => formDiv.style.display = 'none');
    }

    // Hash scroll
    if (window.location.hash) {
        const el = document.querySelector(window.location.hash);
        if (el) setTimeout(() => el.scrollIntoView({ behavior: 'smooth', block: 'start' }), 150);
    }
});
</script>
@endsection