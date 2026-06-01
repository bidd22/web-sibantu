@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-indigo-500 to-purple-500 px-6 py-4">
            <h2 class="text-xl font-bold text-white">Ajukan Bantuan</h2>
            <p class="text-indigo-100 text-sm">Isi data dengan jujur</p>
        </div>
        <form method="POST" action="{{ route('pengajuan.store') }}" class="p-6 space-y-5">
            @csrf
            <div>
                <label class="block font-medium text-gray-700 mb-1">Program Bantuan</label>
                <select name="program_id" class="w-full border border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 outline-none transition" required>
                    <option value="">Pilih program</option>
                    @foreach($programs as $program)
                        <option value="{{ $program->id }}">{{ $program->nama_program }} (Kuota: {{ $program->kuota }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block font-medium text-gray-700 mb-1">Alasan Pengajuan</label>
                <textarea name="alasan" rows="5" class="w-full border border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 outline-none transition" placeholder="Ceritakan kondisi Anda..."></textarea>
            </div>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-6 rounded-xl transition shadow-md">Kirim Pengajuan</button>
        </form>
    </div>
</div>
@endsection