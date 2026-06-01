@extends('layouts.app')

@section('content')
<div>
    <h2 class="text-2xl font-bold text-gray-900 mb-6">Riwayat Pengajuan</h2>
    @if($pengajuans->isEmpty())
        <div class="bg-white rounded-2xl border border-gray-100 p-12 text-center text-gray-400">
            Belum ada pengajuan. <a href="{{ route('pengajuan.create') }}" class="text-indigo-600">Ajukan sekarang</a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($pengajuans as $p)
            <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm hover:shadow transition">
                <div class="flex flex-wrap justify-between items-start">
                    <div>
                        <h3 class="font-bold text-gray-800">{{ $p->program->nama_program }}</h3>
                        <p class="text-gray-500 text-sm mt-1">{{ Str::limit($p->alasan, 80) }}</p>
                        <span class="text-xs text-gray-400 mt-2 block">{{ $p->created_at->format('d M Y') }}</span>
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
</div>
@endsection