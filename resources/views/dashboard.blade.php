@extends('layouts.app')

@section('content')
<style>
    .ornament-blur {
        position: fixed;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(99,102,241,0.12) 0%, rgba(99,102,241,0) 70%);
        border-radius: 50%;
        pointer-events: none;
        z-index: -1;
    }
    .program-card {
        transition: all 0.2s ease;
        cursor: pointer;
        border: 1px solid #e5e7eb;
        background: white;
    }
    .program-card.selected {
        border-color: #4f46e5;
        background-color: #eef2ff;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.15);
    }
    .radio-indicator {
        width: 18px;
        height: 18px;
        border-radius: 50%;
        border: 2px solid #cbd5e1;
        background: white;
        transition: all 0.1s;
    }
    .program-card.selected .radio-indicator {
        border-color: #4f46e5;
        background-color: #4f46e5;
        box-shadow: inset 0 0 0 3px white;
    }
    .program-icon {
        width: 40px;
        height: 40px;
        background: #eef2ff;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }
</style>

<div class="relative">
    <div class="ornament-blur top-20 left-0"></div>
    <div class="ornament-blur bottom-20 right-0" style="background: radial-gradient(circle, rgba(168,85,247,0.1) 0%, rgba(0,0,0,0) 70%);"></div>

    <section id="beranda" class="scroll-mt-20 mb-12">
        <div class="text-center md:text-left">
            <h1 class="text-3xl font-bold text-gray-900">Halo, {{ Auth::user()->name }}! 👋</h1>
            <p class="text-gray-500 mt-1">SIBANTU hadir untuk Anda. Pilih layanan di bawah.</p>
        </div>
    </section>

    <section id="ajukan" class="scroll-mt-20 mb-16">
        <div class="bg-white/70 backdrop-blur-sm rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-indigo-500 to-purple-500 px-6 py-4">
                <h2 class="text-xl font-bold text-white">📦 Ajukan Bantuan</h2>
                <p class="text-indigo-100 text-sm">Pilih program yang sesuai dengan kebutuhan Anda</p>
            </div>
            <form method="POST" action="{{ route('pengajuan.store') }}" class="p-6 space-y-5" id="formPengajuan">
                @csrf
                <div>
                    <label class="block font-medium text-gray-700 mb-3">Pilih Program Bantuan</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        @foreach(\App\Models\BantuanProgram::where('deadline', '>=', now())->get() as $program)
                        <div class="program-card rounded-xl p-4 hover:shadow-md transition" data-program-id="{{ $program->id }}">
                            <div class="flex items-start gap-3">
                                <div class="program-icon">
                                    @if($loop->index % 3 == 0) 📦 @elseif($loop->index % 3 == 1) 🎓 @else 💼 @endif
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-bold text-gray-800">{{ $program->nama_program }}</h3>
                                    <p class="text-gray-500 text-sm mt-1">{{ Str::limit($program->deskripsi, 70) }}</p>
                                    <div class="flex flex-wrap gap-3 mt-2 text-xs text-gray-400">
                                        <span>📊 Kuota: {{ $program->kuota }}</span>
                                        <span>📅 Deadline: {{ \Carbon\Carbon::parse($program->deadline)->format('d M Y') }}</span>
                                    </div>
                                </div>
                                <div class="radio-indicator flex-shrink-0 mt-1"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <input type="hidden" name="program_id" id="selected_program_id" required>
                </div>
                <div>
                    <label class="block font-medium text-gray-700 mb-1">Alasan Pengajuan</label>
                    <textarea name="alasan" rows="4" class="w-full border border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-indigo-200" placeholder="Ceritakan kondisi Anda..."></textarea>
                </div>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-6 rounded-xl transition shadow-md">Kirim Pengajuan</button>
            </form>
        </div>
    </section>

    <section id="riwayat" class="scroll-mt-20 mb-16">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">📋 Riwayat Pengajuan</h2>
        @php
            $pengajuans = \App\Models\Pengajuan::where('user_id', Auth::id())->with('program')->latest()->get();
        @endphp
        @if($pengajuans->isEmpty())
            <div class="bg-white/80 backdrop-blur-sm rounded-xl border border-gray-100 p-8 text-center text-gray-400">Belum ada pengajuan.</div>
        @else
            <div class="space-y-4">
                @foreach($pengajuans as $p)
                <div class="bg-white/80 backdrop-blur-sm rounded-xl border border-gray-100 p-4 shadow-sm hover:shadow transition">
                    <div class="flex justify-between items-start flex-wrap gap-2">
                        <div>
                            <h3 class="font-bold text-gray-800">{{ $p->program->nama_program }}</h3>
                            <p class="text-gray-500 text-sm mt-1">{{ Str::limit($p->alasan, 80) }}</p>
                            <span class="text-xs text-gray-400">{{ $p->created_at->format('d M Y') }}</span>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-medium
                            @if($p->status=='pending') bg-yellow-100 text-yellow-700
                            @elseif($p->status=='disetujui') bg-green-100 text-green-700
                            @else bg-red-100 text-red-700 @endif">
                            {{ $p->status }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </section>

    <section id="pengaduan" class="scroll-mt-20 mb-16">
        <div class="flex flex-wrap justify-between items-center gap-3 mb-4">
            <h2 class="text-2xl font-bold text-gray-900">💬 Pengaduan Saya</h2>
            <button id="showPengaduanForm" class="bg-indigo-600 text-white px-4 py-2 rounded-full text-sm font-medium shadow hover:bg-indigo-700">+ Buat Pengaduan</button>
        </div>
        <div id="pengaduanForm" class="hidden mb-6 bg-white/80 backdrop-blur-sm rounded-xl border border-gray-100 p-5 shadow-sm">
            <form method="POST" action="{{ route('pengaduan.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="block font-medium text-gray-700 mb-1">Judul</label>
                    <input type="text" name="judul" class="w-full border border-gray-200 rounded-xl px-4 py-2" required>
                </div>
                <div class="mb-3">
                    <label class="block font-medium text-gray-700 mb-1">Isi Pengaduan</label>
                    <textarea name="isi" rows="3" class="w-full border border-gray-200 rounded-xl px-4 py-2" required></textarea>
                </div>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-xl text-sm">Kirim Pengaduan</button>
            </form>
        </div>
        <div id="listPengaduan">
            @php
                $pengaduans = \App\Models\Pengaduan::where('user_id', Auth::id())->latest()->get();
            @endphp
            @forelse($pengaduans as $p)
                <div class="bg-white/80 backdrop-blur-sm rounded-xl border border-gray-100 p-4 mb-3 shadow-sm">
                    <div class="flex justify-between flex-wrap gap-2">
                        <h3 class="font-bold text-gray-800">{{ $p->judul }}</h3>
                        <span class="text-xs px-2 py-1 rounded-full
                            @if($p->status=='diterima') bg-gray-100 text-gray-600
                            @elseif($p->status=='proses') bg-blue-100 text-blue-700
                            @else bg-green-100 text-green-700 @endif">
                            {{ $p->status }}
                        </span>
                    </div>
                    <p class="text-gray-600 text-sm mt-1">{{ $p->isi }}</p>
                    <span class="text-xs text-gray-400">{{ $p->created_at->diffForHumans() }}</span>
                </div>
            @empty
                <div class="bg-white/80 backdrop-blur-sm rounded-xl border border-gray-100 p-6 text-center text-gray-400">Belum ada pengaduan.</div>
            @endforelse
        </div>
    </section>
</div>

<script>
    // Card selection
    const cards = document.querySelectorAll('.program-card');
    const hiddenInput = document.getElementById('selected_program_id');
    cards.forEach(card => {
        card.addEventListener('click', () => {
            cards.forEach(c => c.classList.remove('selected'));
            card.classList.add('selected');
            hiddenInput.value = card.getAttribute('data-program-id');
        });
    });
    // Toggle form pengaduan
    const btn = document.getElementById('showPengaduanForm');
    const formDiv = document.getElementById('pengaduanForm');
    if(btn && formDiv) btn.addEventListener('click', () => formDiv.classList.toggle('hidden'));
    // Hash scroll
    if(window.location.hash) {
        const el = document.querySelector(window.location.hash);
        if(el) el.scrollIntoView({ behavior: 'smooth' });
    }
</script>
@endsection