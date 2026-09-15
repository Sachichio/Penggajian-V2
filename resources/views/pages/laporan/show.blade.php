@extends('layouts.app')

@section('title', 'Detail Laporan Penggajian')

@section('content')

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

@endphp

<div class="p-6">

    <div class="max-w-7xl mx-auto">

        {{-- Header --}}
        <div class="flex justify-between items-center mb-8">

            <div>

                <h1 class="text-3xl font-bold text-slate-800">

                    Detail Laporan Penggajian

                </h1>

                <p class="text-slate-500 mt-2">

                    Periode
                    {{ $namaBulan[$bulan] }}
                    {{ $tahun }}

                </p>

            </div>

            <div class="flex gap-3">

                <a href="{{ route('laporan.index') }}"
                    class="px-5 py-3 rounded-xl bg-slate-700 text-white hover:bg-slate-800">

                    ← Kembali

                </a>

                <a href="{{ route('laporan.export', [$bulan,$tahun]) }}"
                    class="px-5 py-3 rounded-xl bg-red-600 text-white hover:bg-red-700">

                    Download PDF

                </a>

            </div>

        </div>


        {{-- Ringkasan --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-8">

            <div class="bg-white rounded-2xl shadow p-6">

                <p class="text-slate-500 text-sm">

                    Jumlah Karyawan

                </p>

                <h2 class="text-3xl font-bold text-cyan-700 mt-2">

                    {{ $laporans->count() }}

                </h2>

            </div>

            <div class="bg-white rounded-2xl shadow p-6">

                <p class="text-slate-500 text-sm">

                    Total Pendapatan

                </p>

                <h2 class="text-2xl font-bold text-green-600 mt-2">

                    Rp {{ number_format($laporans->sum('total_pendapatan'),0,',','.') }}

                </h2>

            </div>

            <div class="bg-white rounded-2xl shadow p-6">

                <p class="text-slate-500 text-sm">

                    Total Potongan

                </p>

                <h2 class="text-2xl font-bold text-red-600 mt-2">

                    Rp {{ number_format($laporans->sum('total_potongan'),0,',','.') }}

                </h2>

            </div>

            <div class="bg-white rounded-2xl shadow p-6">

                <p class="text-slate-500 text-sm">

                    Total THP

                </p>

                <h2 class="text-2xl font-bold text-blue-700 mt-2">

                    Rp {{ number_format($laporans->sum('thp'),0,',','.') }}

                </h2>

            </div>

        </div>



        {{-- Tabel --}}
        <div class="bg-white rounded-3xl shadow overflow-hidden">

            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-slate-100">

                        <tr>

                            <th class="px-6 py-4 text-center">

                                No

                            </th>

                            <th class="px-6 py-4 text-left">

                                Nama

                            </th>

                            <th class="px-6 py-4 text-left">

                                Jabatan

                            </th>

                            <th class="px-6 py-4 text-right">

                                Pendapatan

                            </th>

                            <th class="px-6 py-4 text-right">

                                Potongan

                            </th>

                            <th class="px-6 py-4 text-right">

                                THP

                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y">

                    @foreach($laporans as $laporan)

                        <tr class="hover:bg-slate-50">

                            <td class="px-6 py-4 text-center">

                                {{ $loop->iteration }}

                            </td>

                            <td class="px-6 py-4">

                                <div class="font-semibold">

                                    {{ $laporan->karyawan->nama }}

                                </div>

                                <div class="text-sm text-slate-500">

                                    {{ $laporan->karyawan->nik }}

                                </div>

                            </td>

                            <td class="px-6 py-4">

                                {{ $laporan->karyawan->jabatan->nama_jabatan }}

                            </td>

                            <td class="px-6 py-4 text-right text-green-600 font-semibold">

                                Rp {{ number_format($laporan->total_pendapatan,0,',','.') }}

                            </td>

                            <td class="px-6 py-4 text-right text-red-600 font-semibold">

                                Rp {{ number_format($laporan->total_potongan,0,',','.') }}

                            </td>

                            <td class="px-6 py-4 text-right text-blue-700 font-bold">

                                Rp {{ number_format($laporan->thp,0,',','.') }}

                            </td>

                        </tr>

                    @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection