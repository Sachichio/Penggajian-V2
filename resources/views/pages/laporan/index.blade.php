@extends('layouts.app')

@section('title', 'Laporan Penggajian')

@section('content')
@php
$namaBulan = [
    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
];
@endphp

<section class="page-heading">
    <div>
        <div class="heading-eyebrow">REKAPITULASI & AUDIT</div>
        <h1>Laporan Penggajian</h1>
        <p>Rekapitulasi total pengeluaran payroll seluruh karyawan berdasarkan periode bulanan.</p>
    </div>
</section>

{{-- Tabel Rekap Laporan per Periode --}}
<div class="panel table-panel mb-8">
    <div class="table-heading">
        <div>
            <h2>
                Rekapitulasi Periode Penggajian
                <span class="count-badge">{{ count($laporans ?? []) }} periode</span>
            </h2>
            <p>Daftar histori payroll yang telah dikelompokkan berdasarkan bulan dan tahun.</p>
        </div>
    </div>

    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th style="width: 45px; text-align: center;">No</th>
                    <th>Periode</th>
                    <th style="text-align: center;">Jumlah Karyawan</th>
                    <th>Total Pendapatan</th>
                    <th>Total Potongan</th>
                    <th>Total THP</th>
                    <th style="text-align: center; width: 140px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($laporans ?? [] as $item)
                @php
                    $bln = is_numeric($item->bulan) ? ($namaBulan[(int)$item->bulan] ?? $item->bulan) : $item->bulan;
                @endphp
                <tr>
                    <td style="text-align: center; color: #9aa299; font-weight: 500;">{{ $loop->iteration }}</td>
                    <td>
                        <div class="flex items-center gap-2.5">
                            <span class="grid h-7 w-7 place-items-center rounded-lg bg-[#eaf1e5] text-forest">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                            </span>
                            <strong style="color: #2b382d; font-size: 11.5px;">{{ $bln }} {{ $item->tahun }}</strong>
                        </div>
                    </td>
                    <td style="text-align: center;">
                        <span class="status-badge">
                            {{ $item->jumlah_karyawan }} Karyawan
                        </span>
                    </td>
                    <td style="color: #3d4a3e; font-weight: 550;">
                        Rp {{ number_format($item->total_pendapatan, 0, ',', '.') }}
                    </td>
                    <td style="color: #b94a48;">
                        - Rp {{ number_format($item->total_potongan, 0, ',', '.') }}
                    </td>
                    <td>
                        <strong class="salary">Rp {{ number_format($item->total_thp, 0, ',', '.') }}</strong>
                    </td>
                    <td>
                        <div class="flex items-center justify-center gap-1.5">
                            <a href="{{ route('laporan.show', [$item->bulan, $item->tahun]) }}" class="button primary" style="padding: 5px 10px; font-size: 10px;" title="Lihat Rincian Laporan">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                                <span>Detail</span>
                            </a>
                            <a href="{{ route('laporan.export', [$item->bulan, $item->tahun]) }}" class="button secondary" style="padding: 5px 10px; font-size: 10px;" title="Unduh Laporan PDF">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="7 10 12 15 17 10"></polyline>
                                    <line x1="12" y1="15" x2="12" y2="3"></line>
                                </svg>
                                <span>PDF</span>
                            </a>
                            <a href="{{ route('laporan.exportCsv', [$item->bulan, $item->tahun]) }}" class="button secondary" style="padding: 5px 10px; font-size: 10px; border-color: #cbd5e1; color: #334155;" title="Ekspor Data Mentah CSV (Excel)">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                    <line x1="16" y1="13" x2="8" y2="13"></line>
                                    <line x1="16" y1="17" x2="8" y2="17"></line>
                                    <polyline points="10 9 9 9 8 9"></polyline>
                                </svg>
                                <span>CSV</span>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="py-12 text-center text-[#8e988f]">
                        Belum ada histori laporan penggajian yang tercatat.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="table-footer">
        <strong>Total {{ count($laporans ?? []) }} periode tercatat</strong>
        <span>Audit keuangan resmi</span>
    </div>
</div>
@endsection
