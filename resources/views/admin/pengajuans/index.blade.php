@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-2xl font-bold mb-4">Daftar Pengajuan Bantuan</h2>
            <table class="w-full">
                <thead><tr><th>Pemohon</th><th>Program</th><th>Alasan</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                    @foreach($pengajuans as $p)
                    <tr class="border-b">
                        <td>{{ $p->user->name }}</td>
                        <td>{{ $p->program->nama_program }}</td>
                        <td>{{ Str::limit($p->alasan, 50) }}</td>
                        <td>{{ $p->status }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.pengajuans.update', $p) }}">
                                @csrf @method('PATCH')
                                <select name="status" onchange="this.form.submit()" class="text-sm rounded">
                                    <option value="pending" {{ $p->status=='pending'?'selected':'' }}>Pending</option>
                                    <option value="disetujui" {{ $p->status=='disetujui'?'selected':'' }}>Disetujui</option>
                                    <option value="ditolak" {{ $p->status=='ditolak'?'selected':'' }}>Ditolak</option>
                                </select>
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