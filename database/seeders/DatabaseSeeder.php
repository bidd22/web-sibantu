<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\BantuanProgram;
use App\Models\Menu;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin SIBANTU',
            'email' => 'admin@sibantu.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'phone' => '08123456789',
            'address' => 'Kantor Pusat SIBANTU',

            'name' => 'Admin SIBANTU',
            'email' => 'admin@sibantu.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'phone' => '08123452090',
            'address' => 'SIBANTU Office',
    
        ]);

        // Contoh warga
        User::create([
            'name' => 'Warga Test',
            'email' => 'warga@example.com',
            'password' => Hash::make('11223344'),
            'role' => 'warga',
        ]);

        // Program bantuan
        BantuanProgram::create([
            'nama_program' => 'Paket Sembako',
            'deskripsi' => 'Bantuan sembako bulanan untuk 100 KK kurang mampu.',
            'kuota' => 100,
            'deadline' => '2026-12-31', // diubah dari 2025
        ]);
        BantuanProgram::create([
            'nama_program' => 'Beasiswa Anak Sekolah',
            'deskripsi' => 'Beasiswa Rp 500.000/bulan untuk 50 siswa.',
            'kuota' => 50,
            'deadline' => '2026-10-01',
        ]);
        BantuanProgram::create([
            'nama_program' => 'Pelatihan Kerja Online',
            'deskripsi' => 'Pelatihan keterampilan digital gratis.',
            'kuota' => 200,
            'deadline' => '2026-12-01',
        ]);

        // Menu default
        $menus = [
            ['title' => 'Beranda', 'url' => '/dashboard', 'order' => 1],
            ['title' => 'Ajukan Bantuan', 'url' => '/pengajuan/create', 'order' => 2],
            ['title' => 'Lacak Status', 'url' => '/riwayat', 'order' => 3],
            ['title' => 'Pengaduan', 'url' => '/pengaduan', 'order' => 4],
        ];
        foreach ($menus as $menu) {
            Menu::create($menu);
        }
    }
}