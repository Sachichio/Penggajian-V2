<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Penggajian;

class PenggajianSeeder extends Seeder
{
    public function run(): void
    {
        Penggajian::create([
            'karyawan_id' => 1,
            'bulan' => 5,
            'tahun' => 2026,
            'jam_lembur' => 10,
            'gaji_pokok' => 4500000,
            'tunjangan' => 0,
            'total_lembur' => 250000,
            'total_pendapatan' => 4750000,
            'total_potongan' => 0,
            'thp' => 4750000,
            'tanggal_gaji' => '2026-05-31',
        ]);
    }
}