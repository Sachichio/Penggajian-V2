<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory;

    protected $fillable = [
        'karyawan_id',
        'tanggal',
        'jam_masuk',
        'jam_pulang',
        'status',
        'jam_lembur',
        'latitude',
        'longitude',
        'jarak_meter',
        'catatan',
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}
