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
}