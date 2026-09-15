<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Penggajian</title>

    <style>

        body{
            font-family: DejaVu Sans, sans-serif;
            font-size:12px;
            color:#333;
            margin:30px;
        }

        h1{
            text-align:center;
            color:#0f4c81;
            margin-bottom:5px;
        }

        .subtitle{
            text-align:center;
            color:#666;
            margin-bottom:25px;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        th{
            background:#0f4c81;
            color:white;
            border:1px solid #ccc;
            padding:8px;
        }

        td{
            border:1px solid #ccc;
            padding:8px;
        }

        .center{
            text-align:center;
        }

        .right{
            text-align:right;
        }

        .bold{
            font-weight:bold;
        }

        .summary{
            margin-top:25px;
            width:40%;
            margin-left:auto;
        }

        .summary td{
            border:1px solid #ccc;
            padding:8px;
        }

        .signature{
            margin-top:60px;
            width:100%;
        }

        .signature td{
            border:none;
            width:50%;
            text-align:center;
            vertical-align:top;
        }

        .footer{
            margin-top:40px;
            text-align:center;
            font-size:11px;
            color:#777;
            border-top:1px solid #ddd;
            padding-top:10px;
        }

    </style>

</head>

<body>

@php

$namaBulan = [
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

$totalPendapatan = $laporans->sum('total_pendapatan');
$totalPotongan = $laporans->sum('total_potongan');
$totalTHP = $laporans->sum('thp');

@endphp

<h1>LAPORAN PENGGAJIAN KARYAWAN</h1>

<p class="subtitle">

Periode
<strong>
{{ $namaBulan[$bulan] ?? $bulan }}
{{ $tahun }}
</strong>

</p>

<table>

    <thead>

        <tr>

            <th width="5%">No</th>

            <th width="18%">Nama</th>

            <th width="12%">NIK</th>

            <th width="18%">Jabatan</th>

            <th width="15%">Gaji Pokok</th>

            <th width="15%">Pendapatan</th>

            <th width="15%">Potongan</th>

            <th width="15%">THP</th>

        </tr>

    </thead>

    <tbody>

    @foreach($laporans as $laporan)

        <tr>

            <td class="center">

                {{ $loop->iteration }}

            </td>

            <td>

                {{ $laporan->karyawan->nama }}

            </td>

            <td>

                {{ $laporan->karyawan->nik }}

            </td>

            <td>

                {{ $laporan->karyawan->jabatan->nama_jabatan }}

            </td>

            <td class="right">

                Rp {{ number_format($laporan->gaji_pokok,0,',','.') }}

            </td>

            <td class="right">

                Rp {{ number_format($laporan->total_pendapatan,0,',','.') }}

            </td>

            <td class="right">

                Rp {{ number_format($laporan->total_potongan,0,',','.') }}

            </td>

            <td class="right bold">

                Rp {{ number_format($laporan->thp,0,',','.') }}

            </td>

        </tr>

    @endforeach

    </tbody>

</table>

<table class="summary">

    <tr>

        <td class="bold">

            Jumlah Karyawan

        </td>

        <td class="right">

            {{ $laporans->count() }}

        </td>

    </tr>

    <tr>

        <td class="bold">

            Total Pendapatan

        </td>

        <td class="right">

            Rp {{ number_format($totalPendapatan,0,',','.') }}

        </td>

    </tr>

    <tr>

        <td class="bold">

            Total Potongan

        </td>

        <td class="right">

            Rp {{ number_format($totalPotongan,0,',','.') }}

        </td>

    </tr>

    <tr>

        <td class="bold">

            Total THP

        </td>

        <td class="right bold">

            Rp {{ number_format($totalTHP,0,',','.') }}

        </td>

    </tr>

</table>

<table class="signature">

<tr>

    <td>

        Mengetahui,<br>
        Manager / Owner

        <br><br><br><br><br>

        _______________________

    </td>

    <td>

        Dicetak pada<br>

        {{ now()->format('d-m-Y') }}

        <br><br><br><br><br>

        Sistem Penggajian

    </td>

</tr>

</table>

<div class="footer">

    Dokumen ini dibuat secara otomatis oleh Sistem Penggajian Karyawan.<br>

    © {{ date('Y') }} PT. Sejahtera Bersama

</div>

</body>

</html>