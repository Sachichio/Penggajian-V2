@extends('layouts.app')

@section('title', 'Detail Karyawan')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex items-center justify-between">

        <div>
            <h1 class="text-3xl font-bold text-slate-800">
                Detail Karyawan
            </h1>

            <p class="text-slate-500 mt-1">
                Informasi lengkap data karyawan
            </p>
        </div>

        <a href="{{ route('karyawan.index') }}"
           class="inline-flex items-center px-5 py-3 rounded-2xl
                  bg-slate-700 hover:bg-slate-800
                  text-white font-semibold transition">

            ← Kembali

        </a>

    </div>

    {{-- CARD --}}
    <div class="bg-white rounded-3xl shadow-xl p-8">

        {{-- PROFILE --}}
        <div class="flex items-center gap-5 mb-8">

            <div class="w-20 h-20 rounded-3xl
                        bg-gradient-to-br from-cyan-500 to-blue-600
                        flex items-center justify-center
                        text-white text-3xl font-bold">

                {{ strtoupper(substr($karyawan->nama, 0, 1)) }}

            </div>

            <div>

                <h2 class="text-2xl font-bold text-slate-800">
                    {{ $karyawan->nama }}
                </h2>

                <p class="text-slate-500">
                    {{ $karyawan->jabatan->nama_jabatan }}
                </p>

            </div>

        </div>

        {{-- DETAIL --}}
        <div class="grid md:grid-cols-2 gap-6">

            {{-- NIK --}}
            <div class="bg-slate-50 rounded-2xl p-5">

                <p class="text-sm text-slate-500 mb-1">
                    NIK
                </p>

                <h3 class="text-lg font-semibold text-slate-800">
                    {{ $karyawan->nik }}
                </h3>

            </div>

            {{-- Nama --}}
            <div class="bg-slate-50 rounded-2xl p-5">

                <p class="text-sm text-slate-500 mb-1">
                    Nama Karyawan
                </p>

                <h3 class="text-lg font-semibold text-slate-800">
                    {{ $karyawan->nama }}
                </h3>

            </div>

            {{-- Jabatan --}}
            <div class="bg-slate-50 rounded-2xl p-5">

                <p class="text-sm text-slate-500 mb-1">
                    Jabatan
                </p>

                <h3 class="text-lg font-semibold text-slate-800">
                    {{ $karyawan->jabatan->nama_jabatan }}
                </h3>

            </div>

            {{-- Jenis Kelamin --}}
            <div class="bg-slate-50 rounded-2xl p-5">

                <p class="text-sm text-slate-500 mb-1">
                    Jenis Kelamin
                </p>

                <h3 class="text-lg font-semibold text-slate-800">
                    {{ $karyawan->jenis_kelamin }}
                </h3>

            </div>

            {{-- Tanggal Masuk --}}
            <div class="bg-slate-50 rounded-2xl p-5">

                <p class="text-sm text-slate-500 mb-1">
                    Tanggal Masuk
                </p>

                <h3 class="text-lg font-semibold text-slate-800">
                    {{ \Carbon\Carbon::parse($karyawan->tanggal_masuk)->format('d M Y') }}
                </h3>

            </div>

            {{-- Status --}}
            <div class="bg-slate-50 rounded-2xl p-5">

                <p class="text-sm text-slate-500 mb-1">
                    Status
                </p>

                @if($karyawan->status == 'Aktif')

                    <span class="inline-flex px-4 py-2 rounded-full
                                 bg-green-100 text-green-700
                                 text-sm font-semibold">

                        Aktif

                    </span>

                @else

                    <span class="inline-flex px-4 py-2 rounded-full
                                 bg-red-100 text-red-700
                                 text-sm font-semibold">

                        Nonaktif

                    </span>

                @endif

            </div>

        </div>

    </div>

</div>

@endsection