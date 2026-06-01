@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Pengaduan Saya</h2>
        <a href="{{ route('pengaduan.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-full text-sm font-medium shadow hover:bg-indigo-700">+ Baru</a>
    </div>
    @forelse($pengaduans as $p)
        <div class="bg-white rounded-xl border border-gray-100 p-5 mb-4 shadow-sm">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="font-bold text-gray-800">{{ $p->judul }}</h3>
                    <p class="text-gray-600 text-sm mt-1">{{ $p->isi }}</p>
                    <span class="text-xs text-gray-400 mt-2 block">{{ $p->created_at->diffForHumans() }}</span>
                </div>
                <span class="px-3 py-1 rounded-full text-xs font-medium
                    @if($p->status=='diterima') bg-gray-100 text-gray-600
                    @elseif($p->status=='proses') bg-blue-100 text-blue-700
                    @else bg-green-100 text-green-700 @endif">
                    {{ $p->status }}
                </span>
            </div>
        </div>
    @empty
        <div class="bg-white rounded-2xl border border-gray-100 p-12 text-center text-gray-400">
            Belum ada pengaduan. <a href="{{ route('pengaduan.create') }}" class="text-indigo-600">Buat sekarang</a>
        </div>
    @endforelse
</div>
@endsection