<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Slip Gaji - {{ $slipGaji->karyawan->nama }}</title>
    <style>
        @page {
            margin: 28px 32px;
        }
        body {
            font-family: DejaVu Sans, Helvetica, Arial, sans-serif;
            font-size: 11px;
            color: #2b3330;
            line-height: 1.45;
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
        /* Header Kop Dokumen */
        .header-table td {
            vertical-align: middle;
        }
        .brand-logo {
            font-size: 24px;
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
            font-size: 10px;
            color: #6c756f;
            margin-top: 1px;
        }
        .doc-badge {
            text-align: right;
        }
        .badge-status {
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
            font-size: 10px;
            color: #6c756f;
            margin-top: 4px;
        }
        .header-divider {
            border: none;
            border-top: 2px solid #326447;
            margin: 14px 0 16px;
        }
        /* Judul Dokumen */
        .title-section {
            text-align: center;
            margin-bottom: 16px;
        }
        .title-section h2 {
            font-size: 16px;
            font-weight: bold;
            color: #222d26;
            letter-spacing: 0.5px;
        }
        .title-section p {
            font-size: 11px;
            color: #556259;
            margin-top: 3px;
        }
        /* Informasi Biodata */
        .info-panel {
            background: #fbfdfa;
            border: 1px solid #e5eae3;
            margin-bottom: 16px;
        }
        .info-table td {
            padding: 6px 12px;
            font-size: 11px;
        }
        .info-label {
            color: #6c756f;
            font-weight: bold;
            width: 18%;
        }
        .info-val {
            color: #222d26;
            font-weight: normal;
        }
        /* Header Seksi */
        .section-header {
            background: #326447;
            color: #ffffff;
            font-size: 10px;
            font-weight: bold;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            padding: 6px 10px;
            margin-top: 12px;
        }
        /* Tabel Komponen */
        .detail-table {
            border: 1px solid #e5eae3;
            border-top: none;
            margin-bottom: 4px;
        }
        .detail-table td {
            padding: 7px 10px;
            border-bottom: 1px solid #edf1e8;
            font-size: 11px;
            color: #3b453e;
        }
        .detail-table tr:last-child td {
            border-bottom: none;
        }
        .detail-table tr.total-row td {
            background: #f7f9f7;
            font-weight: bold;
            color: #222d26;
            border-top: 1px solid #d8e2d6;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .text-green {
            color: #326447;
            font-weight: bold;
        }
        .text-rose {
            color: #c24137;
            font-weight: bold;
        }
        /* Kotak THP */
        .thp-card {
            margin-top: 18px;
            border: 2px solid #326447;
            background: #f2f7f2;
            padding: 12px 16px;
        }
        .thp-label {
            font-size: 11px;
            font-weight: bold;
            color: #222d26;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .thp-sub {
            font-size: 9px;
            color: #6c756f;
            margin-top: 2px;
        }
        .thp-amount {
            font-size: 20px;
            font-weight: bold;
            color: #326447;
            text-align: right;
            letter-spacing: -0.5px;
        }
        /* Tanda Tangan */
        .sign-table {
            margin-top: 40px;
            page-break-inside: avoid;
        }
        .sign-table td {
            text-align: center;
            font-size: 10.5px;
            color: #3b453e;
            vertical-align: top;
            width: 50%;
        }
        .sign-space {
            height: 52px;
        }
        .sign-name {
            font-weight: bold;
            color: #222d26;
            text-decoration: underline;
        }
        .sign-role {
            font-size: 9.5px;
            color: #6c756f;
            margin-top: 2px;
        }
        /* Footer */
        .footer-note {
            margin-top: 36px;
            border-top: 1px solid #e5eae3;
            padding-top: 8px;
            font-size: 9px;
            color: #889487;
            text-align: center;
            line-height: 1.4;
        }
    </style>
</head>
<body>
@php
$bulanList = [
    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
];
$blnNama = is_numeric($slipGaji->bulan) ? ($bulanList[(int)$slipGaji->bulan] ?? $slipGaji->bulan) : $slipGaji->bulan;
$companySetting = \App\Models\CompanySetting::getSettings();
@endphp

    {{-- KOP DOKUMEN --}}
    <table class="header-table">
        <tr>
            <td width="60%">
                <div class="brand-logo">gajiku<span class="brand-dot">.</span></div>
                <div class="company-name">{{ $companySetting->nama_perusahaan ?? 'PT. Sejahtera Bersama' }}</div>
                <div class="company-address">{{ $companySetting->alamat ?? 'Sistem Penggajian & Tata Kelola Kompensasi Karyawan' }}</div>
            </td>
            <td width="40%" class="doc-badge">
                <span class="badge-status">LUNAS / DITERBITKAN</span>
                <div class="doc-meta">No. Ref: PAY-{{ $slipGaji->tahun }}-{{ str_pad($slipGaji->bulan, 2, '0', STR_PAD_LEFT) }}-{{ str_pad($slipGaji->id, 4, '0', STR_PAD_LEFT) }}</div>
            </td>
        </tr>
    </table>

    <div class="header-divider"></div>

    {{-- JUDUL SLIP --}}
    <div class="title-section">
        <h2>SLIP GAJI KARYAWAN</h2>
        <p>Periode Pembayaran: <strong>{{ $blnNama }} {{ $slipGaji->tahun }}</strong></p>
    </div>

    {{-- INFORMASI KARYAWAN --}}
    <div class="info-panel">
        <table class="info-table">
            <tr>
                <td class="info-label">Nama Pegawai</td>
                <td class="info-val">: <strong>{{ $slipGaji->karyawan->nama }}</strong></td>
                <td class="info-label">Jabatan</td>
                <td class="info-val">: {{ $slipGaji->karyawan->jabatan->nama_jabatan ?? '-' }}</td>
            </tr>
            <tr>
                <td class="info-label">NIK</td>
                <td class="info-val">: {{ $slipGaji->karyawan->nik }}</td>
                <td class="info-label">Tanggal Gaji</td>
                <td class="info-val">: {{ \Carbon\Carbon::parse($slipGaji->tanggal_gaji)->translatedFormat('d F Y') }}</td>
            </tr>
        </table>
    </div>

    {{-- SEKSI PENDAPATAN --}}
    <div class="section-header">A. RINCIAN PENDAPATAN (EARNINGS)</div>
    <table class="detail-table">
        <tr>
            <td width="70%">Gaji Pokok</td>
            <td width="30%" class="text-right">Rp {{ number_format($slipGaji->gaji_pokok, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Tunjangan Jabatan & Operasional</td>
            <td class="text-right">Rp {{ number_format($slipGaji->tunjangan, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Kompensasi Lembur</td>
            <td class="text-right">Rp {{ number_format($slipGaji->total_lembur, 0, ',', '.') }}</td>
        </tr>
        <tr class="total-row">
            <td><strong>TOTAL PENDAPATAN KOTOR (GROSS)</strong></td>
            <td class="text-right text-green">Rp {{ number_format($slipGaji->total_pendapatan, 0, ',', '.') }}</td>
        </tr>
    </table>

    {{-- SEKSI POTONGAN --}}
    <div class="section-header">B. RINCIAN POTONGAN (DEDUCTIONS)</div>
    <table class="detail-table">
        @forelse($slipGaji->potongans as $potongan)
        <tr>
            <td width="70%">{{ $potongan->jenis_potongan }}</td>
            <td width="30%" class="text-right text-rose">Rp {{ number_format($potongan->nominal, 0, ',', '.') }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="2" class="text-center" style="color: #889487; font-style: italic; padding: 9px;">Tidak ada potongan pada periode ini.</td>
        </tr>
        @endforelse
        <tr class="total-row">
            <td><strong>TOTAL POTONGAN</strong></td>
            <td class="text-right text-rose">Rp {{ number_format($slipGaji->total_potongan, 0, ',', '.') }}</td>
        </tr>
    </table>

    {{-- KOTAK TAKE HOME PAY (THP) --}}
    <div class="thp-card">
        <table>
            <tr>
                <td width="55%">
                    <div class="thp-label">GAJI BERSIH (TAKE HOME PAY)</div>
                    <div class="thp-sub">Total penerimaan setelah penambahan tunjangan dan pengurangan potongan</div>
                </td>
                <td width="45%" class="thp-amount">
                    Rp {{ number_format($slipGaji->thp, 0, ',', '.') }}
                </td>
            </tr>
        </table>
    </div>

    {{-- TANDA TANGAN --}}
    <table class="sign-table">
        <tr>
            <td>
                Mengetahui & Menyetujui,
                <div class="sign-space"></div>
                <div class="sign-name">HRD & Finance Dept.</div>
                <div class="sign-role">{{ $companySetting->nama_perusahaan ?? 'PT. Sejahtera Bersama' }}</div>
            </td>
            <td>
                Diterima oleh,
                <div class="sign-space"></div>
                <div class="sign-name">{{ $slipGaji->karyawan->nama }}</div>
                <div class="sign-role">Karyawan Penerima</div>
            </td>
        </tr>
    </table>

    {{-- FOOTER --}}
    <div class="footer-note">
        Dokumen ini diterbitkan secara sah dan otomatis oleh platform <strong>gajiku.</strong><br>
        Harap menjaga kerahasiaan informasi dokumen slip gaji ini. © {{ date('Y') }} {{ $companySetting->nama_perusahaan ?? 'PT. Sejahtera Bersama' }}.
    </div>
</body>
</html>
