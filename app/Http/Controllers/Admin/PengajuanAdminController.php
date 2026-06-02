<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use Illuminate\Http\Request;

class PengajuanAdminController extends Controller
{
    public function index()
    {
        $pengajuans = Pengajuan::with(['user', 'program'])->latest()->get();
        return view('admin.pengajuans.index', compact('pengajuans'));
    }

    public function update(Request $request, Pengajuan $pengajuan)
    {
        $request->validate([
            'status' => 'required|in:pending,disetujui,ditolak',
        ]);

        $newStatus = $request->status;
        $oldStatus = $pengajuan->status;
        $program = $pengajuan->program;

        $wasActive = in_array($oldStatus, ['pending', 'disetujui']);
        $isNowActive = in_array($newStatus, ['pending', 'disetujui']);

        if (!$wasActive && $isNowActive) {
            if ($program->kuota <= 0) {
                return redirect()->back()->with('error', 'Gagal memulihkan status! Kuota program bantuan ini sudah habis.');
            }
        }

        \Illuminate\Support\Facades\DB::transaction(function () use ($pengajuan, $program, $newStatus, $wasActive, $isNowActive) {
            // Jika memulihkan dari ditolak ke pending/disetujui, potong kuota lagi
            if (!$wasActive && $isNowActive) {
                $program->decrement('kuota');
            }
            // Jika menolak dari pending/disetujui, kembalikan kuota
            elseif ($wasActive && !$isNowActive) {
                $program->increment('kuota');
            }

            $pengajuan->update(['status' => $newStatus]);
        });

        return redirect()->back()->with('success', 'Status pengajuan berhasil diubah.');
    }
}