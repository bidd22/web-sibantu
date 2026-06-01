@extends('layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto space-y-6 antialiased">
    <!-- Breadcrumbs / Back button -->
    <div class="flex items-center justify-between pb-2">
        <a href="{{ route('admin.menus.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-500 hover:text-slate-900 transition duration-150">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
            Kembali ke Manajemen Menu
        </a>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/40 overflow-hidden">
        <!-- Card Header -->
        <div class="px-6 py-5 bg-gradient-to-r from-amber-50/60 to-slate-50/60 border-b border-slate-200/60">
            <h2 class="text-xl font-black text-slate-900">Ubah Data Menu Navigasi</h2>
            <p class="text-xs text-slate-500 font-medium mt-0.5">Modifikasi rincian tautan menu navigasi yang telah terdaftar di sistem.</p>
        </div>

        <!-- Form Body -->
        <form method="POST" action="{{ route('admin.menus.update', $menu) }}" class="p-6 space-y-5">
            @csrf
            @method('PUT')

            <!-- Judul Menu -->
            <div class="space-y-1.5">
                <label class="text-[11px] uppercase font-extrabold text-slate-400 tracking-wider">Judul Menu / Teks Tautan</label>
                <input type="text" 
                       name="title" 
                       value="{{ old('title', $menu->title) }}" 
                       placeholder="Contoh: Beranda, Hubungi Kami" 
                       class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 transition duration-200" 
                       required>
            </div>

            <!-- URL -->
            <div class="space-y-1.5">
                <label class="text-[11px] uppercase font-extrabold text-slate-400 tracking-wider">Target URL / ID Jangkar</label>
                <input type="text" 
                       name="url" 
                       value="{{ old('url', $menu->url) }}" 
                       placeholder="Contoh: #beranda atau /kontak" 
                       class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 transition duration-200" 
                       required>
            </div>

            <!-- Urutan -->
            <div class="space-y-1.5">
                <label class="text-[11px] uppercase font-extrabold text-slate-400 tracking-wider">Nomor Urutan Tampilan</label>
                <input type="number" 
                       name="order" 
                       value="{{ old('order', $menu->order) }}" 
                       class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 transition duration-200" 
                       required>
                <p class="text-[10px] text-slate-400 font-medium">Urutan yang lebih rendah akan ditampilkan lebih dulu di menu utama.</p>
            </div>

            <!-- Footer Action Buttons -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-2">
                <a href="{{ route('admin.menus.index') }}" 
                   class="px-5 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-bold rounded-xl transition duration-150">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2.5 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white text-xs font-extrabold rounded-xl shadow-lg shadow-amber-500/10 hover:shadow-xl hover:shadow-amber-500/20 hover:-translate-y-0.5 transition-all duration-200">
                    Update Menu
                </button>
            </div>
        </form>
    </div>
</div>
@endsection