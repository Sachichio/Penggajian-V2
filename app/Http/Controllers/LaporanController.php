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
        $query = Penggajian::select(
                'bulan',
                'tahun'
            )
            ->selectRaw('COUNT(*) as jumlah_karyawan')
            ->selectRaw('SUM(total_pendapatan) as total_pendapatan')
            ->selectRaw('SUM(total_potongan) as total_potongan')
            ->selectRaw('SUM(thp) as total_thp')
            ->groupBy('bulan', 'tahun')
            ->orderByDesc('tahun')
            ->orderByDesc('bulan');

        // Pembatasan Kuota Akun Demo (Maksimal 10 Rekap Periode Laporan)
        if (auth()->check() && auth()->user()->isDemo()) {
            $query->limit(10);
        }

        $laporans = $query->get();

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
        $query = Penggajian::with([
                'karyawan.jabatan',
                'potongans',
            ])
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->orderBy('id');

        // Pembatasan Kuota Akun Demo (Maksimal 10 Rincian Payroll)
        if (auth()->check() && auth()->user()->isDemo()) {
            $query->limit(10);
        }

        $laporans = $query->get();

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
        $query = Penggajian::with([
                'karyawan.jabatan',
                'potongans',
            ])
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->orderBy('id');

        // Pembatasan Kuota Akun Demo (Maksimal 10 Ekspor PDF)
        if (auth()->check() && auth()->user()->isDemo()) {
            $query->limit(10);
        }

        $laporans = $query->get();

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

    /**
     * Export laporan penggajian per periode ke CSV (Excel Compatible).
     */
    public function exportCsv($bulan, $tahun)
    {
        $query = Penggajian::with([
                'karyawan.jabatan',
                'potongans',
            ])
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->orderBy('id');

        // Pembatasan Kuota Akun Demo (Maksimal 10 Ekspor CSV)
        if (auth()->check() && auth()->user()->isDemo()) {
            $query->limit(10);
        }

        $laporans = $query->get();

        $filename = 'Laporan-Penggajian-' . str_pad($bulan, 2, '0', STR_PAD_LEFT) . '-' . $tahun . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($laporans) {
            $file = fopen('php://output', 'w');
            
            // UTF-8 BOM untuk kompatibilitas Excel
            fputs($file, "\xEF\xBB\xBF");

            // Header Kolom
            fputcsv($file, [
                'No',
                'Nama Karyawan',
                'NIK',
                'Jabatan',
                'Periode Bulan',
                'Tahun',
                'Gaji Pokok',
                'Tunjangan',
                'Total Lembur',
                'Total Pendapatan (Gross)',
                'Total Potongan',
                'Take Home Pay (Net)',
                'Tanggal Pembayaran'
            ]);

            foreach ($laporans as $index => $row) {
                fputcsv($file, [
                    $index + 1,
                    $row->karyawan->nama ?? '-',
                    $row->karyawan->nik ?? '-',
                    $row->karyawan->jabatan->nama_jabatan ?? '-',
                    $row->bulan,
                    $row->tahun,
                    $row->gaji_pokok,
                    $row->tunjangan,
                    $row->total_lembur,
                    $row->total_pendapatan,
                    $row->total_potongan,
                    $row->thp,
                    $row->tanggal_gaji,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}