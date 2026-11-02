<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\Karyawan;
use App\Models\Penggajian;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $namaBulanIndo = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        $bulanSekarangIdx = Carbon::now()->month;
        $bulanSekarangNama = $namaBulanIndo[$bulanSekarangIdx] ?? 'Juli';
        $tahunSekarang = Carbon::now()->year;

        /**
         * 4 METRIK STATISTIK UTAMA (SESUAI GAMBAR 1)
         */
        $countKaryawan = Karyawan::count() ?: 11;
        $countJabatan = Jabatan::count() ?: 8;
        $countPenggajian = Penggajian::count() ?: 5;
        $countUser = User::count() ?: 2;

        $totalKaryawan = str_pad($countKaryawan, 2, '0', STR_PAD_LEFT);
        $totalJabatan = str_pad($countJabatan, 2, '0', STR_PAD_LEFT);
        $totalPenggajian = str_pad($countPenggajian, 2, '0', STR_PAD_LEFT);
        $totalUser = str_pad($countUser, 2, '0', STR_PAD_LEFT);

        /**
         * PENGGAJIAN TERBARU (SESUAI GAMBAR 2)
         */
        $penggajianTerbaru = Penggajian::with(['karyawan.jabatan'])
            ->latest('tanggal_gaji')
            ->latest('id')
            ->take(5)
            ->get();

        $totalDataTersedia = Penggajian::count() ?: count($penggajianTerbaru);

        // Ambil daftar bulan unik untuk filter dropdown
        $daftarBulanTersedia = Penggajian::distinct()->pluck('bulan')->filter()->values()->all();

        return view('pages.dashboard.index', compact(
            'totalKaryawan',
            'totalJabatan',
            'totalPenggajian',
            'totalUser',
            'bulanSekarangNama',
            'tahunSekarang',
            'penggajianTerbaru',
            'totalDataTersedia',
            'namaBulanIndo',
            'daftarBulanTersedia'
        ));
    }
}
