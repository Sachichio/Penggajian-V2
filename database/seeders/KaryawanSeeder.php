<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Karyawan;

class KaryawanSeeder extends Seeder
{
    public function run(): void
    {
        Karyawan::insert([

            [
                'nik' => 'CN-001',
                'nama' => 'DONO',
                'jabatan_id' => 1,
                'jenis_kelamin' => 'Laki-laki',
                'tanggal_masuk' => '2022-01-10',
                'status' => 'Aktif',
            ],

            [
                'nik' => 'CN-002',
                'nama' => 'KASINO',
                'jabatan_id' => 2,
                'jenis_kelamin' => 'Laki-laki',
                'tanggal_masuk' => '2022-02-10',
                'status' => 'Aktif',
            ],

            [
                'nik' => 'CN-003',
                'nama' => 'INDRO',
                'jabatan_id' => 3,
                'jenis_kelamin' => 'Laki-laki',
                'tanggal_masuk' => '2021-03-01',
                'status' => 'Aktif',
            ],

            [
                'nik' => 'CN-004',
                'nama' => 'EIKICHI ONIZUKA',
                'jabatan_id' => 4,
                'jenis_kelamin' => 'Laki-laki',
                'tanggal_masuk' => '2021-04-01',
                'status' => 'Aktif',
            ],

            [
                'nik' => 'CN-005',
                'nama' => 'DADAN DANIRA',
                'jabatan_id' => 5,
                'jenis_kelamin' => 'Laki-laki',
                'tanggal_masuk' => '2023-01-01',
                'status' => 'Aktif',
            ],

            [
                'nik' => 'CN-006',
                'nama' => 'HATAKE KAKASHI',
                'jabatan_id' => 5,
                'jenis_kelamin' => 'Laki-laki',
                'tanggal_masuk' => '2023-02-01',
                'status' => 'Aktif',
            ],

            [
                'nik' => 'CN-007',
                'nama' => 'NOBI NOBITA',
                'jabatan_id' => 6,
                'jenis_kelamin' => 'Laki-laki',
                'tanggal_masuk' => '2020-01-01',
                'status' => 'Aktif',
            ],

            [
                'nik' => 'CN-008',
                'nama' => 'DINAR AMALA',
                'jabatan_id' => 7,
                'jenis_kelamin' => 'Perempuan',
                'tanggal_masuk' => '2023-03-01',
                'status' => 'Aktif',
            ],

            [
                'nik' => 'CN-009',
                'nama' => 'GODA TAKESHI',
                'jabatan_id' => 7,
                'jenis_kelamin' => 'Laki-laki',
                'tanggal_masuk' => '2023-03-15',
                'status' => 'Aktif',
            ],

            [
                'nik' => 'CN-010',
                'nama' => 'NILA SADANI',
                'jabatan_id' => 8,
                'jenis_kelamin' => 'Perempuan',
                'tanggal_masuk' => '2022-07-01',
                'status' => 'Aktif',
            ],

        ]);
    }
}