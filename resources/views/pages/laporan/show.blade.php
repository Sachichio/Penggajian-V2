@extends('layouts.app')

@section('title', 'Detail Laporan Penggajian')

@section('content')
@php
$namaBulan = [
    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
];
$bln = is_numeric($bulan) ? ($namaBulan[(int)$bulan] ?? $bulan) : $bulan;

$totalGajiPokok = 0;
$totalTunjangan = 0;
$totalLembur = 0;
$totalPendapatan = 0;
$totalPotongan = 0;
$totalTHP = 0;

foreach($laporans as $row) {
    $totalGajiPokok += $row->gaji_pokok;
    $totalTunjangan += $row->tunjangan;
    $totalLembur += $row->total_lembur ?? 0;
    $totalPendapatan += $row->total_pendapatan;
    $totalPotongan += $row->total_potongan;
    $totalTHP += $row->thp;
}
@endphp

<section class="page-heading">
    <div>
        <div class="heading-eyebrow">REKAPITULASI & AUDIT</div>
        <h1>Detail Laporan Penggajian</h1>
        <p>Rekapitulasi beban penggajian seluruh karyawan periode <strong>{{ $bln }} {{ $tahun }}</strong>.</p>
    </div>
    <div class="flex items-center gap-2">
        <a href="{{ route('laporan.export', [$bulan, $tahun]) }}" class="button primary">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                <polyline points="7 10 12 15 17 10"></polyline>
                <line x1="12" y1="15" x2="12" y2="3"></line>
            </svg>
            Unduh Laporan PDF
        </a>
        <a href="{{ route('laporan.index') }}" class="button secondary">
            ← Kembali
        </a>
    </div>
</section>

{{-- 4 Stat Cards Ringkasan Periode --}}
<section class="stats-grid mb-6">
    <div class="stat-card">
        <div class="stat-top">
            <span>Jumlah Karyawan</span>
            <span class="stat-icon green">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2m20 0v-2a4 4 0 0 0-3-3.87M16 3a4 4 0 0 1 0 8" />
                    <circle cx="9" cy="7" r="4" />
                </svg>
            </span>
        </div>
        <div class="stat-value">
            {{ count($laporans) }} <span>orang</span>
        </div>
        <div class="stat-bottom">
            <span>Karyawan menerima gaji periode ini</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-top">
            <span>Total Pendapatan Kotor</span>
            <span class="stat-icon blue">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                    <line x1="2" y1="10" x2="22" y2="10"></line>
                </svg>
            </span>
        </div>
        <div class="stat-value" style="font-size: 20px;">
            Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
        </div>
        <div class="stat-bottom">
            <span>Gaji Pokok + Tunjangan + Lembur</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-top">
            <span>Total Pemotongan</span>
            <span class="stat-icon peach">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="8" y1="12" x2="16" y2="12"></line>
                </svg>
            </span>
        </div>
        <div class="stat-value" style="font-size: 20px; color: #b94a48;">
            - Rp {{ number_format($totalPotongan, 0, ',', '.') }}
        </div>
        <div class="stat-bottom">
            <span>Akumulasi potongan karyawan</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-top">
            <span>Total Pengeluaran Bersih</span>
            <span class="stat-icon purple">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M20 8V5a2 2 0 0 0-2-2L5 6a3 3 0 0 0 0 6h16v8H5a3 3 0 0 1-3-3V9m19 3V8H6" />
                    <path d="M17 15h4v3h-4z" />
                </svg>
            </span>
        </div>
        <div class="stat-value" style="font-size: 20px; color: #326447;">
            Rp {{ number_format($totalTHP, 0, ',', '.') }}
        </div>
        <div class="stat-bottom">
            <span class="trend-pill">100% lunas</span>
            <span>Take Home Pay</span>
        </div>
    </div>
</section>

{{-- Tabel Detail Karyawan --}}
<div class="panel table-panel mb-8">
    <div class="table-heading">
        <div>
            <h2>
                Rincian Payroll Karyawan
                <span class="count-badge">{{ count($laporans) }} karyawan</span>
            </h2>
            <p>Daftar rincian gaji pokok, tunjangan, potongan, dan THP masing-masing karyawan.</p>
        </div>
    </div>

    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th style="width: 45px; text-align: center;">No</th>
                    <th>Karyawan</th>
                    <th>Jabatan</th>
                    <th>Gaji Pokok</th>
                    <th>Tunjangan</th>
                    <th>Total Potongan</th>
                    <th>Take Home Pay</th>
                </tr>
            </thead>
            <tbody>
                @forelse($laporans as $item)
                <tr>
                    <td style="text-align: center; color: #9aa299;">{{ $loop->iteration }}</td>
                    <td>
                        <strong style="color: #2b382d;">{{ $item->karyawan->nama ?? '-' }}</strong>
                        <small style="display:block; color: #8a968b;">NIK: {{ $item->karyawan->nik ?? '-' }}</small>
                    </td>
                    <td>{{ $item->karyawan->jabatan->nama_jabatan ?? '-' }}</td>
                    <td>Rp {{ number_format($item->gaji_pokok, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($item->tunjangan, 0, ',', '.') }}</td>
                    <td style="color: #b94a48;">- Rp {{ number_format($item->total_potongan, 0, ',', '.') }}</td>
                    <td><strong class="salary">Rp {{ number_format($item->thp, 0, ',', '.') }}</strong></td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="py-12 text-center text-[#8e988f]">
                        Tidak ada data rincian gaji pada periode ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
            @if(count($laporans) > 0)
            <tfoot style="background: #f8faf6; font-weight: bold; border-top: 2px solid #e5eae3;">
                <tr>
                    <td colspan="3" style="text-align: right; padding: 12px; color: #44533c;">TOTAL KESELURUHAN:</td>
                    <td style="padding: 12px; color: #2b382d;">Rp {{ number_format($totalGajiPokok, 0, ',', '.') }}</td>
                    <td style="padding: 12px; color: #2b382d;">Rp {{ number_format($totalTunjangan, 0, ',', '.') }}</td>
                    <td style="padding: 12px; color: #b94a48;">- Rp {{ number_format($totalPotongan, 0, ',', '.') }}</td>
                    <td style="padding: 12px; color: #326447; font-size: 11.5px;">Rp {{ number_format($totalTHP, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>

    <div class="table-footer">
        <strong>Periode {{ $bln }} {{ $tahun }}</strong>
        <span>Laporan siap audit</span>
    </div>
</div>
@endsection
