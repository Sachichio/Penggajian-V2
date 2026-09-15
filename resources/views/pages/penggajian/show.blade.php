@extends('layouts.app')

@section('title', 'Detail Penggajian')

@section('content')

<div class="space-y-6">


    {{-- BUTTON --}}
    <div>

        <a href="{{ route('penggajian.index') }}"
           class="inline-flex items-center px-5 py-3 rounded-2xl
                  bg-slate-700 hover:bg-slate-800
                  text-white font-semibold transition">

            ← Kembali

        </a>

    </div>



    {{-- HEADER --}}
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">


        <h1 class="text-2xl font-bold text-slate-800">

            Detail Penggajian

        </h1>


        <p class="text-slate-500 mt-2">

            Informasi lengkap data penggajian karyawan

        </p>


    </div>




    {{-- DATA KARYAWAN --}}
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">


        <h2 class="text-lg font-bold text-slate-800 mb-5">

            Data Karyawan

        </h2>



        <div class="grid md:grid-cols-2 gap-5">


            {{-- NIK --}}
            <div class="bg-slate-50 rounded-2xl p-4">

                <p class="text-sm text-slate-500">
                    NIK
                </p>

                <p class="font-semibold text-slate-800">

                    {{ $penggajian->karyawan->nik }}

                </p>

            </div>



            {{-- Nama --}}
            <div class="bg-slate-50 rounded-2xl p-4">

                <p class="text-sm text-slate-500">
                    Nama Karyawan
                </p>

                <p class="font-semibold text-slate-800">

                    {{ $penggajian->karyawan->nama }}

                </p>

            </div>




            {{-- Jabatan --}}
            <div class="bg-slate-50 rounded-2xl p-4">

                <p class="text-sm text-slate-500">
                    Jabatan
                </p>

                <p class="font-semibold text-slate-800">

                    {{ $penggajian->karyawan->jabatan->nama_jabatan ?? '-' }}

                </p>

            </div>



            {{-- Periode --}}
            <div class="bg-slate-50 rounded-2xl p-4">

                <p class="text-sm text-slate-500">
                    Periode
                </p>

                <p class="font-semibold text-slate-800">

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

                    {{ $bulan[$penggajian->bulan] }} {{ $penggajian->tahun }}

                </p>

            </div>


        </div>


    </div>





    {{-- DETAIL GAJI --}}
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">


        <h2 class="text-lg font-bold text-slate-800 mb-5">

            Detail Penghasilan

        </h2>



        <div class="grid md:grid-cols-2 gap-5">



            {{-- Gaji Pokok --}}
            <div class="bg-slate-50 rounded-2xl p-4">

                <p class="text-sm text-slate-500">
                    Gaji Pokok
                </p>

                <p class="font-semibold text-slate-800">

                    Rp {{ number_format($penggajian->gaji_pokok,0,',','.') }}

                </p>

            </div>



            {{-- Tunjangan --}}
            <div class="bg-slate-50 rounded-2xl p-4">

                <p class="text-sm text-slate-500">
                    Tunjangan
                </p>

                <p class="font-semibold text-slate-800">

                    Rp {{ number_format($penggajian->tunjangan,0,',','.') }}

                </p>

            </div>




            {{-- Jam Lembur --}}
            <div class="bg-slate-50 rounded-2xl p-4">

                <p class="text-sm text-slate-500">
                    Jam Lembur
                </p>

                <p class="font-semibold text-slate-800">

                    {{ $penggajian->jam_lembur }} Jam

                </p>

            </div>




            {{-- Total Lembur --}}
            <div class="bg-slate-50 rounded-2xl p-4">

                <p class="text-sm text-slate-500">
                    Total Lembur
                </p>

                <p class="font-semibold text-slate-800">

                    Rp {{ number_format($penggajian->total_lembur,0,',','.') }}

                </p>

            </div>




            {{-- Total Pendapatan --}}
            <div class="bg-slate-50 rounded-2xl p-4">

                <p class="text-sm text-slate-500">
                    Total Pendapatan
                </p>

                <p class="font-semibold text-slate-800">

                    Rp {{ number_format($penggajian->total_pendapatan,0,',','.') }}

                </p>

            </div>




            {{-- Total Potongan --}}
            <div class="bg-slate-50 rounded-2xl p-4">

                <p class="text-sm text-slate-500">
                    Total Potongan
                </p>

                <p class="font-semibold text-slate-800">

                    Rp {{ number_format($penggajian->total_potongan,0,',','.') }}

                </p>

            </div>


        </div>


    </div>





    {{-- THP --}}
    <div class="bg-gradient-to-r from-cyan-600 to-blue-700
                rounded-3xl p-6 text-white">


        <p class="text-sm opacity-80">
            Take Home Pay (THP)
        </p>


        <h2 class="text-3xl font-bold mt-2">

            Rp {{ number_format($penggajian->thp,0,',','.') }}

        </h2>


        <p class="mt-3 opacity-80">

            Tanggal Gaji:
            {{ \Carbon\Carbon::parse($penggajian->tanggal_gaji)->format('d M Y') }}

        </p>


    </div>

    <a href="{{ route('potongan.index', $penggajian->id) }}"
        class="inline-flex items-center px-6 py-3 mt-5 rounded-2xl
                bg-red-600 hover:bg-red-700
                text-white font-semibold">

            + Kelola Potongan

    </a>


</div>


@endsection