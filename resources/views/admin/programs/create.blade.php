@extends('layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto space-y-6 antialiased">
    <!-- Breadcrumbs / Back button -->
    <div class="flex items-center justify-between pb-2">
        <a href="{{ route('admin.programs.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-500 hover:text-slate-900 transition duration-150">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
            Kembali ke Daftar Program
        </a>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/40 overflow-hidden">
        <!-- Card Header -->
        <div class="px-6 py-5 bg-gradient-to-r from-emerald-50/60 to-slate-50/60 border-b border-slate-200/60">
            <h2 class="text-xl font-black text-slate-900">Tambah Program Bantuan</h2>
            <p class="text-xs text-slate-500 font-medium mt-0.5">Buat klasifikasi program bantuan sosial baru untuk masyarakat.</p>
        </div>

        <!-- Form Body -->
        <form method="POST" action="{{ route('admin.programs.store') }}" class="p-6 space-y-5">
            @csrf

            <!-- Nama Program -->
            <div class="space-y-1.5">
                <label class="text-[11px] uppercase font-extrabold text-slate-400 tracking-wider">Nama Program Bantuan</label>
                <input type="text" 
                       name="nama_program" 
                       placeholder="Contoh: Bantuan Langsung Tunai (BLT) Desa" 
                       class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition duration-200" 
                       required>
            </div>

            <!-- Deskripsi -->
            <div class="space-y-1.5">
                <label class="text-[11px] uppercase font-extrabold text-slate-400 tracking-wider">Deskripsi Cakupan & Kriteria</label>
                <textarea name="deskripsi" 
                          rows="4" 
                          placeholder="Jelaskan kriteria warga penerima, bentuk bantuan, dan persyaratan administratif lainnya secara rinci..." 
                          class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition duration-200" 
                          required></textarea>
            </div>

            <!-- Grid Kuota & Deadline -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <!-- Kuota -->
                <div class="space-y-1.5">
                    <label class="text-[11px] uppercase font-extrabold text-slate-400 tracking-wider">Kuota Alokasi (Penerima KK)</label>
                    <div class="relative">
                        <input type="number" 
                               name="kuota" 
                               placeholder="Contoh: 150" 
                               class="w-full text-xs font-semibold pl-4 pr-12 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition duration-200" 
                               required>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400 text-xs font-bold">
                            KK
                        </div>
                    </div>
                </div>

                <!-- Deadline -->
                <div class="space-y-1.5">
                    <label class="text-[11px] uppercase font-extrabold text-slate-400 tracking-wider">Batas Akhir Pendaftaran</label>
                    <input type="date" 
                           name="deadline" 
                           class="w-full text-xs font-semibold px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition duration-200" 
                           required>
                </div>
            </div>

            <!-- Footer Action Buttons -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-2">
                <a href="{{ route('admin.programs.index') }}" 
                   class="px-5 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-bold rounded-xl transition duration-150">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2.5 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white text-xs font-extrabold rounded-xl shadow-lg shadow-emerald-600/10 hover:shadow-xl hover:shadow-emerald-600/20 hover:-translate-y-0.5 transition-all duration-200">
                    Simpan Program
                </button>
            </div>
        </form>
    </div>
</div>
@endsection