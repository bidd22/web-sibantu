@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded shadow">
            <div class="flex justify-between mb-4">
                <h2 class="text-2xl font-bold">Manajemen Menu</h2>
                <a href="{{ route('admin.menus.create') }}" class="bg-green-600 text-white px-4 py-2 rounded">+ Tambah Menu</a>
            </div>
            <table class="w-full">
                <thead><tr><th>Judul</th><th>URL</th><th>Urutan</th><th>Aksi</th></tr></thead>
                <tbody>
                    @foreach($menus as $menu)
                    <tr class="border-b">
                        <td>{{ $menu->title }}</td>
                        <td>{{ $menu->url }}</td>
                        <td>{{ $menu->order }}</td>
                        <td>
                            <a href="{{ route('admin.menus.edit', $menu) }}" class="text-blue-600">Edit</a>
                            <form action="{{ route('admin.menus.destroy', $menu) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 ml-2" onclick="return confirm('Yakin hapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection