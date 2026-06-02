<?php

namespace App\Http\Controllers;

use App\Models\BantuanProgram;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengajuanController extends Controller
{
    public function create()
{
    $programs = BantuanProgram::where('deadline', '>=', now())->get();
    return view('pengajuan.create', compact('programs'));
}

    public function store(Request $request)
{
    $request->validate([
        'program_id' => 'required|exists:bantuan_programs,id',
        'alasan' => 'required|min:10',
    ]);

    $program = BantuanProgram::findOrFail($request->program_id);
    if ($program->kuota <= 0) {
        return redirect()->back()->with('error', 'Maaf, kuota program bantuan ini sudah habis. Silakan pilih program lain.')->withInput();
    }

    \Illuminate\Support\Facades\DB::transaction(function () use ($request, $program) {
        // Kurangi kuota secara langsung saat warga mengajukan
        $program->decrement('kuota');

        Pengajuan::create([
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'program_id' => $request->program_id,
            'alasan' => $request->alasan,
            'status' => 'pending',
        ]);
    });

    return redirect()->to(route('dashboard') . '#riwayat')->with('success', 'Pengajuan bantuan berhasil dikirim! Silakan pantau status pengajuan Anda.');
}

    public function riwayat()
    {
        $pengajuans = Pengajuan::where('user_id', Auth::id())->with('program')->get();
        return view('pengajuan.riwayat', compact('pengajuans'));
    }
}