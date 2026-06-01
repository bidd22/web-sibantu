@extends('layouts.app')
@section('content')
<div class="py-12"><div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4">Edit Program Bantuan</h2>
    <form method="POST" action="{{ route('admin.programs.update', $program) }}">
        @csrf @method('PUT')
        <div class="mb-4"><label>Nama Program</label><input type="text" name="nama_program" value="{{ old('nama_program', $program->nama_program) }}" class="w-full rounded border-gray-300" required></div>
        <div class="mb-4"><label>Deskripsi</label><textarea name="deskripsi" rows="3" class="w-full rounded border-gray-300" required>{{ old('deskripsi', $program->deskripsi) }}</textarea></div>
        <div class="mb-4"><label>Kuota</label><input type="number" name="kuota" value="{{ old('kuota', $program->kuota) }}" class="w-full rounded border-gray-300" required></div>
        <div class="mb-4"><label>Deadline</label><input type="date" name="deadline" value="{{ old('deadline', $program->deadline) }}" class="w-full rounded border-gray-300" required></div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
    </form>
</div></div>
@endsection