<?php

namespace App\Http\Controllers;

use App\Models\Penggajian;
use Barryvdh\DomPDF\Facade\Pdf;

class SlipGajiController extends Controller
{
    /**
     * Tampilkan seluruh slip gaji
     */
    public function index()
    {
        $query = Penggajian::with([
            'karyawan.jabatan',
            'potongans',
        ])
        ->latest();

        // Pembatasan Kuota Akun Demo (Maksimal 20 Slip Gaji)
        if (auth()->check() && auth()->user()->isDemo()) {
            $query->limit(20);
        }

        $slipGajis = $query->get();

        return view(
            'pages.slip-gaji.index',
            compact('slipGajis')
        );
    }

    /**
     * Detail slip gaji
     */
    public function show($id)
    {
        $slipGaji = Penggajian::with([
            'karyawan.jabatan',
            'potongans',
        ])->findOrFail($id);

        return view(
            'pages.slip-gaji.show',
            compact('slipGaji')
        );
    }

    /**
     * Export Slip Gaji ke PDF
     */
    public function exportPdf($id)
    {
        $slipGaji = Penggajian::with([
            'karyawan.jabatan',
            'potongans',
        ])->findOrFail($id);

        $pdf = Pdf::loadView(
            'pages.slip-gaji.export',
            compact('slipGaji')
        );

        return $pdf->download(
            'Slip-Gaji-' .
            $slipGaji->karyawan->nama .
            '-' .
            $slipGaji->bulan .
            '-' .
            $slipGaji->tahun .
            '.pdf'
        );
    }
}