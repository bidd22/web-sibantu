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
        $pengajuan->update(['status' => $request->status]);
        return redirect()->back()->with('success', 'Status pengajuan diubah.');
    }
}