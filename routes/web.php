<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\BantuanProgramController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\PengajuanAdminController;
use App\Http\Controllers\Admin\PengaduanAdminController;
use Illuminate\Support\Facades\Route;

// Halaman welcome (beranda publik)
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Auth routes (Breeze) - tidak perlu use lagi karena sudah di atas
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Dashboard (dengan role)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return view('dashboard');
    })->name('dashboard');

    // Fitur warga
    Route::get('/pengajuan/create', [PengajuanController::class, 'create'])->name('pengajuan.create');
    Route::post('/pengajuan', [PengajuanController::class, 'store'])->name('pengajuan.store');
    Route::get('/riwayat', [PengajuanController::class, 'riwayat'])->name('pengajuan.riwayat');
    
    Route::resource('pengaduan', PengaduanController::class)->except(['show', 'edit', 'update']);
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboard::class, 'index'])->name('dashboard');
    Route::resource('programs', BantuanProgramController::class);
    Route::get('pengajuans', [PengajuanAdminController::class, 'index'])->name('pengajuans.index');
    Route::patch('pengajuans/{pengajuan}', [PengajuanAdminController::class, 'update'])->name('pengajuans.update');
    Route::resource('pengaduans', PengaduanAdminController::class)->only(['index', 'update', 'destroy']);
    Route::resource('menus', MenuController::class);
});