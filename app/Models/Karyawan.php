<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Karyawan extends Model
{
    protected $fillable = [
        'nik',
        'nama',
        'jabatan_id',
        'jenis_kelamin',
        'tanggal_masuk',
        'status',
        'pin',
        'sisa_cuti',
    ];

    /**
     * Relasi ke Jabatan
     */
    public function jabatan(): BelongsTo
    {
        return $this->belongsTo(Jabatan::class);
    }

    /**
     * Relasi ke Penggajian
     */
    public function penggajians(): HasMany
    {
        return $this->hasMany(Penggajian::class);
    }

    /**
     * Relasi ke Presensi
     */
    public function presensis(): HasMany
    {
        return $this->hasMany(Presensi::class);
    }

    /**
     * Relasi ke Pengajuan Izin
     */
    public function pengajuanIzins(): HasMany
    {
        return $this->hasMany(PengajuanIzin::class);
    }
}