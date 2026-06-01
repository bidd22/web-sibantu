@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-2xl font-bold mb-4">Daftar Pengaduan</h2>
            <table class="w-full">
                <thead><tr><th>Pengirim</th><th>Judul</th><th>Isi</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                    @foreach($pengaduans as $p)
                    <tr class="border-b">
                        <td>{{ $p->user->name }}</td>
                        <td>{{ $p->judul }}</td>
                        <td>{{ Str::limit($p->isi, 50) }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.pengaduans.update', $p) }}" class="inline">
                                @csrf @method('PATCH')
                                <select name="status" onchange="this.form.submit()" class="text-sm rounded">
                                    <option value="diterima" {{ $p->status=='diterima'?'selected':'' }}>Diterima</option>
                                    <option value="proses" {{ $p->status=='proses'?'selected':'' }}>Proses</option>
                                    <option value="selesai" {{ $p->status=='selesai'?'selected':'' }}>Selesai</option>
                                </select>
                            </form>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('admin.pengaduans.destroy', $p) }}" class="inline" onsubmit="return confirm('Hapus pengaduan?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600">Hapus</button>
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