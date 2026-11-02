<?php

namespace App\Models;

use App\Models\Potongan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Penggajian extends Model
{
    protected $fillable = [
        'karyawan_id',
        'bulan',
        'tahun',
        'jam_lembur',
        'gaji_pokok',
        'tunjangan',
        'total_lembur',
        'total_pendapatan',
        'total_potongan',
        'thp',
        'tanggal_gaji',
        'status_approval',
        'hari_kerja_efektif',
        'total_hadir',
        'total_sakit',
        'total_izin',
        'total_alpa',
    ];

    /**
     * Relasi ke Karyawan
     */
    public function karyawan(): BelongsTo
    {
        return $this->belongsTo(Karyawan::class);
    }

    /**
     * Relasi ke Potongan
     */
    public function potongans(): HasMany
    {
        return $this->hasMany(Potongan::class);
    }
}