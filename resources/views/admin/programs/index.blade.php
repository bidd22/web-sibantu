@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <div class="flex justify-between mb-4">
                <h2 class="text-2xl font-bold">Program Bantuan</h2>
                <a href="{{ route('admin.programs.create') }}" class="bg-green-600 text-white px-4 py-2 rounded">+ Tambah Program</a>
            </div>
            <table class="min-w-full border">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-2">Nama</th><th>Deskripsi</th><th>Kuota</th><th>Deadline</th><th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($programs as $p)
                    <tr class="border-b">
                        <td class="p-2">{{ $p->nama_program }}</td>
                        <td>{{ Str::limit($p->deskripsi, 50) }}</td>
                        <td>{{ $p->kuota }}</td>
                        <td>{{ $p->deadline }}</td>
                        <td>
                            <a href="{{ route('admin.programs.edit', $p) }}" class="text-blue-600">Edit</a>
                            <form action="{{ route('admin.programs.destroy', $p) }}" method="POST" class="inline">
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