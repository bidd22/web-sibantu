<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use Illuminate\Http\Request;

class PengaduanAdminController extends Controller
{
    public function index()
    {
        $pengaduans = Pengaduan::with('user')->latest()->get();
        return view('admin.pengaduans.index', compact('pengaduans'));
    }

    public function update(Request $request, Pengaduan $pengaduan)
    {
        $request->validate([
            'status' => 'required|in:diterima,proses,selesai',
        ]);
        $pengaduan->update(['status' => $request->status]);
        return redirect()->back()->with('success', 'Status pengaduan diubah.');
    }

    public function destroy(Pengaduan $pengaduan)
    {
        $pengaduan->delete();
        return redirect()->back()->with('success', 'Pengaduan dihapus.');
    }
}