<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengaduanController extends Controller
{
    public function index()
    {
        $pengaduans = Pengaduan::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('pengaduan.index', compact('pengaduans'));
    }

    public function create()
    {
        return view('pengaduan.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'judul' => 'required|min:5',
        'isi' => 'required|min:15',
    ]);

    Pengaduan::create([
        'user_id' => Auth::id(),
        'judul' => $request->judul,
        'isi' => $request->isi,
        'status' => 'diterima',
    ]);

    return redirect()->to(route('dashboard') . '#pengaduan')->with('success', 'Pengaduan berhasil dikirim! Kami akan segera menindaklanjuti.');
}
}