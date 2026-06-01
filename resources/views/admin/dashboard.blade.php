@extends('layouts.app')

@section('content')
<div>
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Admin Dashboard</h1>
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-2xl shadow-sm p-5 border border-gray-100">
            <div class="flex items-center justify-between">
                <div><p class="text-gray-500 text-sm">Total Pengajuan</p><p class="text-3xl font-bold">{{ $totalPengajuan }}</p></div>
                <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center">📋</div>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-sm p-5 border border-gray-100">
            <div class="flex items-center justify-between">
                <div><p class="text-gray-500 text-sm">Pending</p><p class="text-3xl font-bold text-yellow-600">{{ $pending }}</p></div>
                <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">⏳</div>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-sm p-5 border border-gray-100">
            <div class="flex items-center justify-between">
                <div><p class="text-gray-500 text-sm">Pengaduan</p><p class="text-3xl font-bold">{{ $totalPengaduan }}</p></div>
                <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">💬</div>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-sm p-5 border border-gray-100">
            <div class="flex items-center justify-between">
                <div><p class="text-gray-500 text-sm">Warga Terdaftar</p><p class="text-3xl font-bold">{{ $totalWarga }}</p></div>
                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">👥</div>
            </div>
        </div>
    </div>
    <div class="grid md:grid-cols-2 gap-5 mt-8">
        <a href="{{ route('admin.pengajuans.index') }}" class="bg-white border border-gray-200 rounded-xl p-4 flex justify-between items-center hover:shadow transition">Kelola Pengajuan <span>→</span></a>
        <a href="{{ route('admin.pengaduans.index') }}" class="bg-white border border-gray-200 rounded-xl p-4 flex justify-between items-center hover:shadow transition">Kelola Pengaduan <span>→</span></a>
        <a href="{{ route('admin.programs.index') }}" class="bg-white border border-gray-200 rounded-xl p-4 flex justify-between items-center hover:shadow transition">Program Bantuan <span>→</span></a>
        <a href="{{ route('admin.menus.index') }}" class="bg-white border border-gray-200 rounded-xl p-4 flex justify-between items-center hover:shadow transition">Manajemen Menu <span>→</span></a>
    </div>
</div>
@endsection