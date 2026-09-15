@extends('layouts.app')

@section('title', 'Slip Gaji')

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
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

        <div>

            <h1 class="text-3xl font-bold text-slate-800">
                Slip Gaji
            </h1>

            <p class="text-slate-500 mt-2">
                Daftar slip gaji seluruh karyawan.
            </p>

        </div>

    </div>



    {{-- Card --}}
    <div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-slate-100">

                    <tr>

                        <th class="p-4 text-center font-bold text-slate-700">
                            No
                        </th>

                        <th class="p-4 text-left font-bold text-slate-700">
                            Nama Karyawan
                        </th>

                        <th class="p-4 text-left font-bold text-slate-700">
                            Jabatan
                        </th>

                        <th class="p-4 text-center font-bold text-slate-700">
                            Periode
                        </th>

                        <th class="p-4 text-right font-bold text-slate-700">
                            THP
                        </th>

                        <th class="p-4 text-center font-bold text-slate-700">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($slipGajis as $index => $slip)

                        <tr class="border-t hover:bg-slate-50 transition">

                            <td class="p-4 text-center">

                                {{ $index + 1 }}

                            </td>

                            <td class="p-4">

                                <div class="font-semibold text-slate-800">

                                    {{ $slip->karyawan->nama }}

                                </div>

                                <div class="text-sm text-slate-500">

                                    {{ $slip->karyawan->nik }}

                                </div>

                            </td>

                            <td class="p-4">

                                {{ $slip->karyawan->jabatan->nama_jabatan }}

                            </td>

                            <td class="p-4 text-center">

                                {{ $bulan[$slip->bulan] ?? $slip->bulan }}
                                {{ $slip->tahun }}

                            </td>

                            <td class="p-4 text-right font-bold text-green-600">

                                Rp {{ number_format($slip->thp,0,',','.') }}

                            </td>

                            <td class="p-4">

                                <div class="flex justify-center gap-2">

                                    <a
                                        href="{{ route('slip-gaji.show', $slip->id) }}"
                                        class="px-4 py-2 rounded-xl
                                               bg-blue-600 hover:bg-blue-700
                                               text-white text-sm font-semibold transition">

                                        Detail

                                    </a>

                                    <a
                                        href="{{ route('slip-gaji.export', $slip->id) }}"
                                        class="px-4 py-2 rounded-xl
                                               bg-red-600 hover:bg-red-700
                                               text-white text-sm font-semibold transition">

                                        PDF

                                    </a>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6"
                                class="py-16 text-center">

                                <div class="flex flex-col items-center">

                                    <div class="text-6xl mb-4">

                                        💰

                                    </div>

                                    <h2 class="text-xl font-bold text-slate-700">

                                        Belum Ada Slip Gaji

                                    </h2>

                                    <p class="text-slate-500 mt-2">

                                        Silakan buat data penggajian terlebih dahulu.

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