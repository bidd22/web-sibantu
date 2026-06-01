<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BantuanProgram extends Model
{
    use HasFactory;

    protected $fillable = ['nama_program', 'deskripsi', 'kuota', 'deadline'];

    public function pengajuans()
    {
        return $this->hasMany(Pengajuan::class);
    }
}