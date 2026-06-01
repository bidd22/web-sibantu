@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-5">Buat Pengaduan Baru</h2>
        <form method="POST" action="{{ route('pengaduan.store') }}">
            @csrf
            <div class="mb-4">
                <label class="block font-medium text-gray-700 mb-1">Judul</label>
                <input type="text" name="judul" class="w-full border border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-indigo-200" required>
            </div>
            <div class="mb-5">
                <label class="block font-medium text-gray-700 mb-1">Isi Pengaduan</label>
                <textarea name="isi" rows="5" class="w-full border border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-indigo-200" required></textarea>
            </div>
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-xl font-semibold hover:bg-indigo-700 transition">Kirim</button>
        </form>
    </div>
</div>
@endsection