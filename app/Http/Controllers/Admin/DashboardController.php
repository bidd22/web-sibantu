<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use App\Models\Pengaduan;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPengajuan = Pengajuan::count();
        $pending = Pengajuan::where('status', 'pending')->count();
        $totalPengaduan = Pengaduan::count();
        $totalWarga = User::where('role', 'warga')->count();
        return view('admin.dashboard', compact('totalPengajuan', 'pending', 'totalPengaduan', 'totalWarga'));
    }
}