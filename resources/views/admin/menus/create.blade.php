@extends('layouts.app')
@section('content')
<div class="py-12"><div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4">Tambah Menu</h2>
    <form method="POST" action="{{ route('admin.menus.store') }}">
        @csrf
        <div class="mb-4"><label>Judul Menu</label><input type="text" name="title" class="w-full rounded border-gray-300" required></div>
        <div class="mb-4"><label>URL</label><input type="text" name="url" class="w-full rounded border-gray-300" required></div>
        <div class="mb-4"><label>Urutan</label><input type="number" name="order" class="w-full rounded border-gray-300" value="0"></div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
    </form>
</div></div>
@endsection