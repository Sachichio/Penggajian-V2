<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Slip Gaji</title>

    <style>

        body{
            font-family: DejaVu Sans, sans-serif;
            font-size:13px;
            color:#333;
            margin:35px;
            line-height:1.5;
        }

        h1,h2,h3{
            margin:0;
        }

        hr{
            border:none;
            border-top:1px solid #999;
            margin:15px 0 20px;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        .company-name{
            font-size:22px;
            font-weight:bold;
            color:#0f4c81;
        }

        .company-address{
            font-size:11px;
            color:#666;
        }

        .title{
            text-align:center;
            margin-top:15px;
            margin-bottom:25px;
        }

        .title h2{
            font-size:20px;
            color:#0f4c81;
        }

        .title p{
            margin-top:4px;
            color:#666;
        }

        .info td{
            padding:6px 0;
        }

        .section-title{
            background:#0f4c81;
            color:white;
            padding:8px 12px;
            font-weight:bold;
            margin-top:20px;
        }

        .detail{
            border:1px solid #cfcfcf;
            border-top:none;
        }

        .detail td{
            padding:10px 12px;
            border-bottom:1px solid #eee;
        }

        .detail tr:last-child td{
            border-bottom:none;
        }

        .right{
            text-align:right;
        }

        .bold{
            font-weight:bold;
        }

        .green{
            color:#16a34a;
            font-weight:bold;
        }

        .red{
            color:#dc2626;
            font-weight:bold;
        }

        .thp-box{

            margin-top:25px;
            border:2px solid #2563eb;
            background:#eef6ff;
            padding:15px;

        }

        .thp-title{
            font-size:16px;
            font-weight:bold;
        }

        .thp-value{
            font-size:24px;
            color:#2563eb;
            font-weight:bold;
            text-align:right;
        }

        .signature{

            margin-top:70px;

        }

        .signature td{

            text-align:center;

        }

        .footer{

            margin-top:60px;
            text-align:center;
            color:#777;
            font-size:11px;
            border-top:1px solid #ddd;
            padding-top:10px;

        }

    </style>

</head>

<body>

@php

$bulan = [
    1=>'Januari',
    2=>'Februari',
    3=>'Maret',
    4=>'April',
    5=>'Mei',
    6=>'Juni',
    7=>'Juli',
    8=>'Agustus',
    9=>'September',
    10=>'Oktober',
    11=>'November',
    12=>'Desember',
];

@endphp


{{-- ================= HEADER ================= --}}

<table>

<tr>

<td>

<div class="company-name">

PENGGAJIAN KARYAWAN

</div>

<div class="company-address">

PT. Sejahtera Bersama<br>
Perusahaan Dagang Mainan

</div>

</td>

</tr>

</table>

<hr>


<div class="title">

<h2>SLIP GAJI KARYAWAN</h2>

<p>

Periode
{{ $bulan[$slipGaji->bulan] ?? $slipGaji->bulan }}
{{ $slipGaji->tahun }}

</p>

</div>


{{-- ================= INFO ================= --}}

<table class="info">

<tr>

<td width="20%"><strong>Nama</strong></td>
<td width="30%">: {{ $slipGaji->karyawan->nama }}</td>

<td width="20%"><strong>Jabatan</strong></td>
<td>: {{ $slipGaji->karyawan->jabatan->nama_jabatan }}</td>

</tr>

<tr>

<td><strong>NIK</strong></td>
<td>: {{ $slipGaji->karyawan->nik }}</td>

<td><strong>Tanggal Gaji</strong></td>
<td>: {{ \Carbon\Carbon::parse($slipGaji->tanggal_gaji)->format('d-m-Y') }}</td>

</tr>

</table>


{{-- ================= PENDAPATAN ================= --}}

<div class="section-title">

PENDAPATAN

</div>

<table class="detail">

<tr>

<td>Gaji Pokok</td>

<td class="right">

Rp {{ number_format($slipGaji->gaji_pokok,0,',','.') }}

</td>

</tr>

<tr>

<td>Tunjangan</td>

<td class="right">

Rp {{ number_format($slipGaji->tunjangan,0,',','.') }}

</td>

</tr>

<tr>

<td>Lembur</td>

<td class="right">

Rp {{ number_format($slipGaji->total_lembur,0,',','.') }}

</td>

</tr>

<tr>

<td class="bold">

Total Pendapatan

</td>

<td class="right green">

Rp {{ number_format($slipGaji->total_pendapatan,0,',','.') }}

</td>

</tr>

</table>


{{-- ================= POTONGAN ================= --}}

<div class="section-title">

POTONGAN

</div>

<table class="detail">

@forelse($slipGaji->potongans as $potongan)

<tr>

<td>

{{ $potongan->jenis_potongan }}

</td>

<td class="right">

Rp {{ number_format($potongan->nominal,0,',','.') }}

</td>

</tr>

@empty

<tr>

<td colspan="2" align="center">

Tidak ada potongan.

</td>

</tr>

@endforelse

<tr>

<td class="bold">

Total Potongan

</td>

<td class="right red">

Rp {{ number_format($slipGaji->total_potongan,0,',','.') }}

</td>

</tr>

</table>


{{-- ================= THP ================= --}}

<div class="thp-box">

<table>

<tr>

<td class="thp-title">

Take Home Pay

</td>

<td class="thp-value">

Rp {{ number_format($slipGaji->thp,0,',','.') }}

</td>

</tr>

</table>

</div>


{{-- ================= TANDA TANGAN ================= --}}

<table class="signature">

<tr>

<td>

Mengetahui,

<br><br><br><br><br>

_____________________

<br>

HRD

</td>

<td>

Diterima Oleh,

<br><br><br><br><br>

_____________________

<br>

{{ $slipGaji->karyawan->nama }}

</td>

</tr>

</table>


{{-- ================= FOOTER ================= --}}

<div class="footer">

Dokumen ini dicetak secara otomatis oleh Sistem Penggajian Karyawan.<br>

© {{ date('Y') }} PT. Sejahtera Bersama

</div>

</body>
</html>