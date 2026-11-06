<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanySetting extends Model
{
    protected $fillable = [
        'nama_perusahaan',
        'email_perusahaan',
        'telepon',
        'alamat',
        'npwp',
        'logo',
        'latitude',
        'longitude',
        'radius_meter',
    ];

    /**
     * Singleton instance helper
     */
    public static function getSettings(): self
    {
        return static::firstOrCreate(
            ['id' => 1],
            [
                'nama_perusahaan' => 'PT. Sejahtera Bersama',
                'email_perusahaan' => 'info@sejahtera.co.id',
                'telepon' => '(021) 555-0192',
                'alamat' => 'Jl. Jenderal Sudirman Kav. 21, Karet Semanggi, Setiabudi, Jakarta Selatan 12930',
                'npwp' => '01.234.567.8-012.000',
                'latitude' => '-6.2088',
                'longitude' => '106.8456',
                'radius_meter' => 100,
            ]
        );
    }
}
