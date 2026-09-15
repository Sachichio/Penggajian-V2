<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Potongan extends Model
{
    protected $fillable = [
        'penggajian_id',
        'jenis_potongan',
        'nominal',
        'keterangan',
    ];

    /**
     * Relasi ke Penggajian
     */
    public function penggajian(): BelongsTo
    {
        return $this->belongsTo(Penggajian::class);
    }
}