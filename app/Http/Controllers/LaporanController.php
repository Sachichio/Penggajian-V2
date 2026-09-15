<?php

namespace App\Http\Controllers;

use App\Models\Penggajian;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    /**
     * Menampilkan daftar laporan penggajian per periode.
     */
    public function index()
    {
        $laporans = Penggajian::select(
                'bulan',
                'tahun'
            )
            ->selectRaw('COUNT(*) as jumlah_karyawan')
            ->selectRaw('SUM(total_pendapatan) as total_pendapatan')
            ->selectRaw('SUM(total_potongan) as total_potongan')
            ->selectRaw('SUM(thp) as total_thp')
            ->groupBy('bulan', 'tahun')
            ->orderByDesc('tahun')
            ->orderByDesc('bulan')
            ->get();

        return view(
            'pages.laporan.index',
            compact('laporans')
        );
    }

    /**
     * Menampilkan detail laporan penggajian berdasarkan periode.
     */
    public function show($bulan, $tahun)
    {
        $laporans = Penggajian::with([
                'karyawan.jabatan',
                'potongans',
            ])
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->orderBy('id')
            ->get();

        return view(
            'pages.laporan.show',
            compact(
                'laporans',
                'bulan',
                'tahun'
            )
        );
    }

    /**
     * Export laporan penggajian per periode ke PDF.
     */
    public function exportPdf($bulan, $tahun)
    {
        $laporans = Penggajian::with([
                'karyawan.jabatan',
                'potongans',
            ])
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->orderBy('id')
            ->get();

        $pdf = Pdf::loadView(
            'pages.laporan.export',
            compact(
                'laporans',
                'bulan',
                'tahun'
            )
        )->setPaper('A4', 'landscape');

        return $pdf->download(
            'Laporan-Penggajian-' .
            str_pad($bulan, 2, '0', STR_PAD_LEFT) .
            '-' .
            $tahun .
            '.pdf'
        );
    }
}