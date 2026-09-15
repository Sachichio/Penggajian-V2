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

    <div class="max-w-5xl mx-auto">

        {{-- Tombol --}}
        <div class="flex justify-between mb-6">

            <a href="{{ route('slip-gaji.index') }}"
                class="inline-flex items-center px-5 py-3 rounded-2xl
                       bg-slate-700 hover:bg-slate-800
                       text-white font-semibold transition">

                ← Kembali

            </a>

            <a href="{{ route('slip-gaji.export', $slipGaji->id) }}"
                class="inline-flex items-center px-5 py-3 rounded-2xl
                       bg-red-600 hover:bg-red-700
                       text-white font-semibold transition">

                Download PDF

            </a>

        </div>



        <div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">

            {{-- Header --}}
            <div class="bg-gradient-to-r from-cyan-600 to-blue-700 text-white p-8">

                <h1 class="text-3xl font-bold">

                    Slip Gaji Karyawan

                </h1>

                <p class="opacity-90 mt-2">

                    Periode
                    {{ $bulan[$slipGaji->bulan] ?? $slipGaji->bulan }}
                    {{ $slipGaji->tahun }}

                </p>

            </div>



            {{-- Informasi --}}
            <div class="grid md:grid-cols-2 gap-8 p-8">

                <div>

                    <p class="text-slate-500 text-sm">
                        Nama Karyawan
                    </p>

                    <p class="font-bold text-lg">

                        {{ $slipGaji->karyawan->nama }}

                    </p>

                </div>

                <div>

                    <p class="text-slate-500 text-sm">
                        NIK
                    </p>

                    <p class="font-bold">

                        {{ $slipGaji->karyawan->nik }}

                    </p>

                </div>

                <div>

                    <p class="text-slate-500 text-sm">
                        Jabatan
                    </p>

                    <p class="font-bold">

                        {{ $slipGaji->karyawan->jabatan->nama_jabatan }}

                    </p>

                </div>

                <div>

                    <p class="text-slate-500 text-sm">
                        Tanggal Gaji
                    </p>

                    <p class="font-bold">

                        {{ \Carbon\Carbon::parse($slipGaji->tanggal_gaji)->format('d-m-Y') }}

                    </p>

                </div>

            </div>



            {{-- Pendapatan --}}
            <div class="px-8 pb-8">

                <h2 class="text-xl font-bold text-cyan-700 border-b pb-3 mb-5">

                    Pendapatan

                </h2>

                <div class="space-y-4">

                    <div class="flex justify-between">

                        <span>Gaji Pokok</span>

                        <strong>
                            Rp {{ number_format($slipGaji->gaji_pokok,0,',','.') }}
                        </strong>

                    </div>

                    <div class="flex justify-between">

                        <span>Tunjangan</span>

                        <strong>
                            Rp {{ number_format($slipGaji->tunjangan,0,',','.') }}
                        </strong>

                    </div>

                    <div class="flex justify-between">

                        <span>Lembur</span>

                        <strong>
                            Rp {{ number_format($slipGaji->total_lembur,0,',','.') }}
                        </strong>

                    </div>

                </div>

                <hr class="my-5">

                <div class="flex justify-between text-lg font-bold">

                    <span>Total Pendapatan</span>

                    <span class="text-green-600">

                        Rp {{ number_format($slipGaji->total_pendapatan,0,',','.') }}

                    </span>

                </div>

            </div>



            {{-- Potongan --}}
            <div class="px-8 pb-8">

                <h2 class="text-xl font-bold text-red-600 border-b pb-3 mb-5">

                    Potongan

                </h2>

                @forelse($slipGaji->potongans as $potongan)

                    <div class="flex justify-between mb-3">

                        <span>

                            {{ $potongan->jenis_potongan }}

                        </span>

                        <span>

                            Rp {{ number_format($potongan->nominal,0,',','.') }}

                        </span>

                    </div>

                @empty

                    <p class="text-slate-400">

                        Tidak ada potongan.

                    </p>

                @endforelse

                <hr class="my-5">

                <div class="flex justify-between text-lg font-bold">

                    <span>Total Potongan</span>

                    <span class="text-red-600">

                        Rp {{ number_format($slipGaji->total_potongan,0,',','.') }}

                    </span>

                </div>

            </div>



            {{-- THP --}}
            <div class="bg-slate-50 border-t p-8">

                <div class="flex justify-between items-center">

                    <div>

                        <p class="text-slate-500">

                            Take Home Pay

                        </p>

                        <h2 class="text-3xl font-bold text-blue-700 mt-2">

                            Rp {{ number_format($slipGaji->thp,0,',','.') }}

                        </h2>

                    </div>

                    <div>

                        <span class="px-5 py-2 rounded-full bg-green-100 text-green-700 font-semibold">

                            SUDAH DIHITUNG

                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection