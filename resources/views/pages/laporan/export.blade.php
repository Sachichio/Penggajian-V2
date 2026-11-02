<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penggajian - {{ $bulan }}-{{ $tahun }}</title>
    <style>
        @page {
            margin: 24px 28px;
        }
        body {
            font-family: DejaVu Sans, Helvetica, Arial, sans-serif;
            font-size: 10px;
            color: #2b3330;
            line-height: 1.4;
            margin: 0;
            padding: 0;
            background: #ffffff;
        }
        h1, h2, h3, p {
            margin: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        /* Kop Dokumen */
        .header-table {
            margin-bottom: 12px;
        }
        .header-table td {
            vertical-align: middle;
        }
        .brand-logo {
            font-size: 22px;
            font-weight: bold;
            color: #222d26;
            letter-spacing: -0.5px;
        }
        .brand-dot {
            color: #326447;
        }
        .company-name {
            font-size: 11px;
            font-weight: bold;
            color: #326447;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 2px;
        }
        .company-address {
            font-size: 9.5px;
            color: #6c756f;
            margin-top: 1px;
        }
        .doc-badge {
            text-align: right;
        }
        .badge-period {
            display: inline-block;
            background: #eaf1e8;
            border: 1px solid #d4e2d2;
            color: #326447;
            font-size: 9px;
            font-weight: bold;
            letter-spacing: 0.5px;
            padding: 4px 10px;
            text-transform: uppercase;
        }
        .doc-meta {
            font-size: 9px;
            color: #6c756f;
            margin-top: 3px;
        }
        .header-divider {
            border: none;
            border-top: 2px solid #326447;
            margin: 8px 0 14px;
        }
        /* Judul Laporan */
        .title-section {
            text-align: center;
            margin-bottom: 14px;
        }
        .title-section h2 {
            font-size: 15px;
            font-weight: bold;
            color: #222d26;
            letter-spacing: 0.5px;
        }
        .title-section p {
            font-size: 10px;
            color: #556259;
            margin-top: 2px;
        }
        /* Tabel Data Utama */
        .report-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
        }
        .report-table th {
            background: #326447;
            color: #ffffff;
            font-size: 9.5px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: 1px solid #29533a;
            padding: 7px 6px;
            text-align: left;
        }
        .report-table th.center, .report-table td.center {
            text-align: center;
        }
        .report-table th.right, .report-table td.right {
            text-align: right;
        }
        .report-table td {
            border: 1px solid #e5eae3;
            padding: 6px;
            font-size: 9.5px;
            color: #3b453e;
        }
        .report-table tbody tr:nth-child(even) {
            background: #fbfdfa;
        }
        .report-table td.thp-cell {
            color: #326447;
            font-weight: bold;
        }
        .report-table td.deduction-cell {
            color: #c24137;
        }
        /* Baris Total */
        .report-table tfoot tr td {
            background: #eaf1e8;
            border-top: 2px solid #326447;
            border-bottom: 2px solid #326447;
            font-weight: bold;
            color: #222d26;
            font-size: 10px;
            padding: 7px 6px;
        }
        /* Layout Bawah: Ringkasan & Tanda Tangan */
        .bottom-section {
            width: 100%;
            margin-top: 8px;
            page-break-inside: avoid;
        }
        .summary-card {
            border: 1px solid #d4e2d2;
            background: #fbfdfa;
            width: 100%;
        }
        .summary-card th {
            background: #326447;
            color: #ffffff;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            padding: 5px 8px;
            text-align: left;
        }
        .summary-card td {
            padding: 5px 8px;
            font-size: 9.5px;
            border-bottom: 1px solid #edf1e8;
        }
        .summary-card tr:last-child td {
            border-bottom: none;
            background: #f2f7f2;
            font-weight: bold;
            color: #326447;
        }
        /* Tanda Tangan */
        .sign-table td {
            text-align: center;
            font-size: 10px;
            color: #3b453e;
            vertical-align: top;
            width: 50%;
        }
        .sign-space {
            height: 44px;
        }
        .sign-name {
            font-weight: bold;
            color: #222d26;
            text-decoration: underline;
        }
        .sign-role {
            font-size: 9px;
            color: #6c756f;
            margin-top: 2px;
        }
        /* Footer */
        .footer-note {
            margin-top: 20px;
            border-top: 1px solid #e5eae3;
            padding-top: 6px;
            font-size: 8.5px;
            color: #889487;
            text-align: center;
        }
    </style>
</head>
<body>
@php
$namaBulan = [
    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
];
$blnNama = is_numeric($bulan) ? ($namaBulan[(int)$bulan] ?? $bulan) : $bulan;

$totalGajiPokok   = $laporans->sum('gaji_pokok');
$totalPendapatan  = $laporans->sum('total_pendapatan');
$totalPotongan    = $laporans->sum('total_potongan');
$totalTHP         = $laporans->sum('thp');
@endphp

    {{-- KOP REKAPITULASI --}}
    <table class="header-table">
        <tr>
            <td width="65%">
                <div class="brand-logo">gajiku<span class="brand-dot">.</span></div>
                <div class="company-name">PT. Sejahtera Bersama</div>
                <div class="company-address">Laporan Rekapitulasi Beban Penggajian & Tata Kelola Kompensasi</div>
            </td>
            <td width="35%" class="doc-badge">
                <span class="badge-period">PERIODE: {{ strtoupper($blnNama) }} {{ $tahun }}</span>
                <div class="doc-meta">Tanggal Cetak: {{ now()->translatedFormat('d F Y H:i') }} WIB</div>
            </td>
        </tr>
    </table>

    <div class="header-divider"></div>

    {{-- JUDUL LAPORAN --}}
    <div class="title-section">
        <h2>LAPORAN REKAPITULASI PENGGAJIAN KARYAWAN</h2>
        <p>Distribusi gaji bulan <strong>{{ $blnNama }} {{ $tahun }}</strong> untuk total <strong>{{ $laporans->count() }} orang karyawan</strong></p>
    </div>

    {{-- TABEL UTAMA LAPORAN --}}
    <table class="report-table">
        <thead>
            <tr>
                <th width="4%" class="center">No</th>
                <th width="17%">Nama Karyawan</th>
                <th width="11%">NIK</th>
                <th width="15%">Jabatan</th>
                <th width="13%" class="right">Gaji Pokok</th>
                <th width="13%" class="right">Total Kotor</th>
                <th width="13%" class="right">Total Potongan</th>
                <th width="14%" class="right">Take Home Pay</th>
            </tr>
        </thead>
        <tbody>
            @forelse($laporans as $laporan)
            <tr>
                <td class="center">{{ $loop->iteration }}</td>
                <td><strong>{{ $laporan->karyawan->nama }}</strong></td>
                <td>{{ $laporan->karyawan->nik }}</td>
                <td>{{ $laporan->karyawan->jabatan->nama_jabatan ?? '-' }}</td>
                <td class="right">Rp {{ number_format($laporan->gaji_pokok, 0, ',', '.') }}</td>
                <td class="right">Rp {{ number_format($laporan->total_pendapatan, 0, ',', '.') }}</td>
                <td class="right deduction-cell">Rp {{ number_format($laporan->total_potongan, 0, ',', '.') }}</td>
                <td class="right thp-cell">Rp {{ number_format($laporan->thp, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="center" style="padding: 16px; color: #889487;">Tidak ada data penggajian yang tercatat pada periode ini.</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="right">TOTAL AKUMULASI PERIODE INI :</td>
                <td class="right">Rp {{ number_format($totalGajiPokok, 0, ',', '.') }}</td>
                <td class="right">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                <td class="right" style="color: #c24137;">Rp {{ number_format($totalPotongan, 0, ',', '.') }}</td>
                <td class="right" style="color: #326447;">Rp {{ number_format($totalTHP, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    {{-- RINGKASAN & TANDA TANGAN (SEJAJAR 2 KOLOM) --}}
    <table class="bottom-section">
        <tr>
            {{-- Kolom Kiri: Tabel Ringkasan Eksekutif --}}
            <td width="42%" style="vertical-align: top;">
                <table class="summary-card">
                    <thead>
                        <tr>
                            <th colspan="2">RINGKASAN EKSEKUTIF PAYROLL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Jumlah Karyawan Terdaftar</td>
                            <td class="right"><strong>{{ $laporans->count() }} Orang</strong></td>
                        </tr>
                        <tr>
                            <td>Total Gaji Pokok</td>
                            <td class="right">Rp {{ number_format($totalGajiPokok, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Total Pendapatan Kotor (Gross)</td>
                            <td class="right">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Total Potongan Terkumpul</td>
                            <td class="right" style="color: #c24137;">Rp {{ number_format($totalPotongan, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Total Beban Bersih (THP)</strong></td>
                            <td class="right"><strong>Rp {{ number_format($totalTHP, 0, ',', '.') }}</strong></td>
                        </tr>
                    </tbody>
                </table>
            </td>

            <td width="8%"></td>

            {{-- Kolom Kanan: Tanda Tangan Pengesahan --}}
            <td width="50%" style="vertical-align: top;">
                <table class="sign-table">
                    <tr>
                        <td>
                            Dibuat Oleh,<br>
                            Petugas Penggajian
                            <div class="sign-space"></div>
                            <div class="sign-name">{{ auth()->user()->name ?? 'Admin Payroll' }}</div>
                            <div class="sign-role">Finance & Compensation Staff</div>
                        </td>
                        <td>
                            Disetujui Oleh,<br>
                            Pimpinan Perusahaan
                            <div class="sign-space"></div>
                            <div class="sign-name">Direksi / General Manager</div>
                            <div class="sign-role">PT. Sejahtera Bersama</div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    {{-- FOOTER --}}
    <div class="footer-note">
        Laporan rekapitulasi ini dicetak secara otomatis melalui sistem <strong>gajiku.</strong> Dokumen resmi yang mengikat tata kelola keuangan perusahaan. © {{ date('Y') }} PT. Sejahtera Bersama.
    </div>
</body>
</html>
