@extends('layouts.app')
@section('content')
<div class="py-12"><div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4">Edit Menu</h2>
    <form method="POST" action="{{ route('admin.menus.update', $menu) }}">
        @csrf @method('PUT')
        <div class="mb-4"><label>Judul Menu</label><input type="text" name="title" value="{{ old('title', $menu->title) }}" class="w-full rounded border-gray-300" required></div>
        <div class="mb-4"><label>URL</label><input type="text" name="url" value="{{ old('url', $menu->url) }}" class="w-full rounded border-gray-300" required></div>
        <div class="mb-4"><label>Urutan</label><input type="number" name="order" value="{{ old('order', $menu->order) }}" class="w-full rounded border-gray-300"></div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
    </form>
</div></div>
@endsection