<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jabatan;

class JabatanSeeder extends Seeder
{
    public function run(): void
    {
        Jabatan::insert([
            [
                'nama_jabatan' => 'Staff Accounting',
                'gaji_pokok' => 4500000,
                'tunjangan' => 0,
            ],
            [
                'nama_jabatan' => 'Staff Finance',
                'gaji_pokok' => 4500000,
                'tunjangan' => 0,
            ],
            [
                'nama_jabatan' => 'Manager F&A',
                'gaji_pokok' => 9000000,
                'tunjangan' => 500000,
            ],
            [
                'nama_jabatan' => 'SPV F&A',
                'gaji_pokok' => 6000000,
                'tunjangan' => 0,
            ],
            [
                'nama_jabatan' => 'Staff HRD',
                'gaji_pokok' => 4000000,
                'tunjangan' => 0,
            ],
            [
                'nama_jabatan' => 'Manager HRD',
                'gaji_pokok' => 9000000,
                'tunjangan' => 500000,
            ],
            [
                'nama_jabatan' => 'Sales',
                'gaji_pokok' => 3750000,
                'tunjangan' => 0,
            ],
            [
                'nama_jabatan' => 'SPV Sales',
                'gaji_pokok' => 4000000,
                'tunjangan' => 0,
            ],
        ]);
    }
}