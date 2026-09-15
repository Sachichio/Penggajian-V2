@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="space-y-8">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <div>

            <h1 class="text-3xl font-bold text-slate-800">
                Dashboard
            </h1>

            <p class="text-slate-500 mt-1">
                Selamat datang di Sistem Penggajian Karyawan
            </p>

        </div>

        <div class="bg-white rounded-2xl px-5 py-3 shadow border">

            <p class="text-sm text-slate-500">
                Login Sebagai
            </p>

            <p class="font-bold text-ocean">
                {{ auth()->user()->name }}
            </p>

        </div>

    </div>

    {{-- CARD --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

        {{-- TOTAL KARYAWAN --}}
        <div class="bg-white rounded-3xl shadow border p-6">

            <div class="flex justify-between items-center">

                <div>

                    <p class="text-slate-500 text-sm">
                        Total Karyawan
                    </p>

                    <h2 class="text-4xl font-bold mt-2">
                        {{ $totalKaryawan }}
                    </h2>

                </div>

                <div class="w-16 h-16 rounded-2xl bg-blue-100 flex items-center justify-center text-3xl">

                    👨‍💼

                </div>

            </div>

        </div>

        {{-- TOTAL JABATAN --}}
        <div class="bg-white rounded-3xl shadow border p-6">

            <div class="flex justify-between items-center">

                <div>

                    <p class="text-slate-500 text-sm">
                        Total Jabatan
                    </p>

                    <h2 class="text-4xl font-bold mt-2">
                        {{ $totalJabatan }}
                    </h2>

                </div>

                <div class="w-16 h-16 rounded-2xl bg-green-100 flex items-center justify-center text-3xl">

                    🏢

                </div>

            </div>

        </div>

        {{-- TOTAL PENGGAJIAN --}}
        <div class="bg-white rounded-3xl shadow border p-6">

            <div class="flex justify-between items-center">

                <div>

                    <p class="text-slate-500 text-sm">
                        Total Penggajian
                    </p>

                    <h2 class="text-4xl font-bold mt-2">
                        {{ $totalPenggajian }}
                    </h2>

                </div>

                <div class="w-16 h-16 rounded-2xl bg-yellow-100 flex items-center justify-center text-3xl">

                    💰

                </div>

            </div>

        </div>

        {{-- TOTAL USER --}}
        <div class="bg-white rounded-3xl shadow border p-6">

            <div class="flex justify-between items-center">

                <div>

                    <p class="text-slate-500 text-sm">
                        Total User
                    </p>

                    <h2 class="text-4xl font-bold mt-2">
                        {{ $totalUser }}
                    </h2>

                </div>

                <div class="w-16 h-16 rounded-2xl bg-purple-100 flex items-center justify-center text-3xl">

                    👤

                </div>

            </div>

        </div>

    </div>

    {{-- TABEL --}}
    <div class="bg-white rounded-3xl shadow border overflow-hidden">

        <div class="p-6 border-b">

            <h2 class="text-xl font-bold text-slate-800">

                Penggajian Terbaru

            </h2>

            <p class="text-sm text-slate-500 mt-1">

                Data penggajian yang baru ditambahkan

            </p>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-slate-50">

                    <tr>

                        <th class="text-left p-4">Nama</th>
                        <th class="text-left p-4">Bulan</th>
                        <th class="text-left p-4">Tahun</th>
                        <th class="text-left p-4">THP</th>
                        <th class="text-left p-4">Tanggal Gaji</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($penggajianTerbaru as $item)

                        <tr class="border-t hover:bg-slate-50">

                            <td class="p-4 font-semibold">

                                {{ $item->karyawan->nama }}

                            </td>

                            <td class="p-4">

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

                                {{ $bulan[$item->bulan] }}

                            </td>

                            <td class="p-4">

                                {{ $item->tahun }}

                            </td>

                            <td class="p-4 font-semibold text-green-600">

                                Rp {{ number_format($item->thp,0,',','.') }}

                            </td>

                            <td class="p-4">

                                {{ \Carbon\Carbon::parse($item->tanggal_gaji)->format('d-m-Y') }}

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5" class="text-center p-6 text-slate-400">

                                Belum ada data penggajian.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection