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
        
        $recentPengajuans = Pengajuan::with(['user', 'program'])->latest()->take(3)->get();
        $recentPengaduans = Pengaduan::with('user')->latest()->take(3)->get();

        return view('admin.dashboard', compact(
            'totalPengajuan', 
            'pending', 
            'totalPengaduan', 
            'totalWarga',
            'recentPengajuans',
            'recentPengaduans'
        ));
    }
}