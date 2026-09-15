<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\Karyawan;
use App\Models\Penggajian;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        /**
         * =====================================
         * TOTAL DATA
         * =====================================
         */
        $totalJabatan = Jabatan::count();

        $totalKaryawan = Karyawan::count();

        $totalPenggajian = Penggajian::count();

        $totalUser = User::count();

        /**
         * =====================================
         * DATA PENGGAJIAN TERBARU
         * =====================================
         */
        $penggajianTerbaru = Penggajian::with('karyawan')
            ->latest()
            ->take(5)
            ->get();

        return view('pages.dashboard.index', compact(
            'totalJabatan',
            'totalKaryawan',
            'totalPenggajian',
            'totalUser',
            'penggajianTerbaru'
        ));
    }
}