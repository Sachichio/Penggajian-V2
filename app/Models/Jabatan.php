<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jabatan extends Model
{
    protected $fillable = [
        'nama_jabatan',
        'gaji_pokok',
        'tunjangan',
    ];

    /**
     * Relasi ke Karyawan
     */
    public function karyawans(): HasMany
    {
        return $this->hasMany(Karyawan::class);
    }
}