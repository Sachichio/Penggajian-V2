@extends('layouts.app')

@section('title', 'Laporan Penggajian')

@section('content')

@php

$bulan = [
    1 => 'Januari',
    2 => 'Februari',
    3 => 'Maret',
    4 => 'April',
    5 => 'Mei',
    6 => 'Juni',
    7 => 'Juli',
    8 => 'Agustus',
    9 => 'September',
    10 => 'Oktober',
    11 => 'November',
    12 => 'Desember',
];

@endphp

<div class="p-6">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">

        <div>

            <h1 class="text-3xl font-bold text-slate-800">
                Laporan Penggajian
            </h1>

            <p class="text-slate-500 mt-2">
                Rekap penggajian seluruh karyawan berdasarkan periode.
            </p>

        </div>

    </div>


    <div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-slate-100">

                    <tr>

                        <th class="px-6 py-4 text-center">
                            No
                        </th>

                        <th class="px-6 py-4 text-left">
                            Periode
                        </th>

                        <th class="px-6 py-4 text-center">
                            Jumlah Karyawan
                        </th>

                        <th class="px-6 py-4 text-right">
                            Total Pendapatan
                        </th>

                        <th class="px-6 py-4 text-right">
                            Total Potongan
                        </th>

                        <th class="px-6 py-4 text-right">
                            Total THP
                        </th>

                        <th class="px-6 py-4 text-center">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-100">

                @forelse($laporans as $laporan)

                    <tr class="hover:bg-slate-50">

                        <td class="px-6 py-5 text-center font-semibold">

                            {{ $loop->iteration }}

                        </td>

                        <td class="px-6 py-5 font-semibold text-slate-800">

                            {{ $bulan[$laporan->bulan] ?? $laporan->bulan }}
                            {{ $laporan->tahun }}

                        </td>

                        <td class="px-6 py-5 text-center">

                            <span class="px-3 py-1 rounded-full bg-cyan-100 text-cyan-700 font-semibold">

                                {{ $laporan->jumlah_karyawan }} Orang

                            </span>

                        </td>

                        <td class="px-6 py-5 text-right font-semibold text-green-600">

                            Rp {{ number_format($laporan->total_pendapatan,0,',','.') }}

                        </td>

                        <td class="px-6 py-5 text-right font-semibold text-red-600">

                            Rp {{ number_format($laporan->total_potongan,0,',','.') }}

                        </td>

                        <td class="px-6 py-5 text-right">

                            <span class="font-bold text-blue-700">

                                Rp {{ number_format($laporan->total_thp,0,',','.') }}

                            </span>

                        </td>

                        <td class="px-6 py-5">

                            <div class="flex justify-center gap-2">

                                <a href="{{ route('laporan.show', [$laporan->bulan, $laporan->tahun]) }}"
                                   class="px-4 py-2 rounded-xl
                                          bg-cyan-600 hover:bg-cyan-700
                                          text-white text-sm font-semibold">

                                    Detail

                                </a>

                                <a href="{{ route('laporan.export', [$laporan->bulan, $laporan->tahun]) }}"
                                   class="px-4 py-2 rounded-xl
                                          bg-red-600 hover:bg-red-700
                                          text-white text-sm font-semibold">

                                    PDF

                                </a>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="7" class="py-16 text-center">

                            <div class="flex flex-col items-center">

                                <div class="text-6xl">

                                    📊

                                </div>

                                <h3 class="mt-4 text-xl font-bold">

                                    Belum Ada Laporan

                                </h3>

                                <p class="mt-2 text-slate-500">

                                    Laporan penggajian akan muncul setelah data penggajian tersedia.

                                </p>

                            </div>

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection