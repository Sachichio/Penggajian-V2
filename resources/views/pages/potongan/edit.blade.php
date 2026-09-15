@extends('layouts.app')

@section('title', 'Edit Potongan')

@section('content')

<div class="p-6">

    <div class="bg-white rounded-3xl shadow-xl border border-slate-100 p-8">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-8">

            <div>

                <h1 class="text-3xl font-bold text-slate-800">
                    Edit Potongan
                </h1>

                <p class="text-slate-500 mt-2">
                    Perbarui data potongan penggajian karyawan.
                </p>

            </div>

            <a href="{{ route('potongan.index', $potongan->penggajian_id) }}"
               class="px-5 py-3 rounded-xl bg-slate-700 hover:bg-slate-800 text-white font-semibold transition">

                ← Kembali

            </a>

        </div>


        {{-- Informasi Penggajian --}}
        <div class="grid md:grid-cols-3 gap-6 mb-8">

            <div class="bg-slate-50 rounded-2xl p-5">

                <p class="text-sm text-slate-500">
                    Nama Karyawan
                </p>

                <p class="text-lg font-bold text-slate-800 mt-1">

                    {{ $potongan->penggajian->karyawan->nama }}

                </p>

            </div>

            <div class="bg-slate-50 rounded-2xl p-5">

                <p class="text-sm text-slate-500">
                    NIK
                </p>

                <p class="text-lg font-bold text-slate-800 mt-1">

                    {{ $potongan->penggajian->karyawan->nik }}

                </p>

            </div>

            <div class="bg-slate-50 rounded-2xl p-5">

                <p class="text-sm text-slate-500">
                    Periode
                </p>

                <p class="text-lg font-bold text-slate-800 mt-1">

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

                    {{ $bulan[$potongan->penggajian->bulan] }}
                    {{ $potongan->penggajian->tahun }}

                </p>

            </div>

        </div>


        {{-- Form --}}
        <form action="{{ route('potongan.update', $potongan->id) }}" method="POST">

            @csrf
            @method('PUT')

            {{-- Jenis Potongan --}}
            <div class="mb-6">

                <label class="block mb-2 font-semibold text-slate-700">

                    Jenis Potongan

                </label>

                <select
                    name="jenis_potongan"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3
                           focus:ring-2 focus:ring-red-300 focus:border-red-500 outline-none">

                    <option value="">-- Pilih Jenis Potongan --</option>

                    <option value="BPJS Kesehatan"
                        {{ old('jenis_potongan', $potongan->jenis_potongan) == 'BPJS Kesehatan' ? 'selected' : '' }}>
                        BPJS Kesehatan
                    </option>

                    <option value="BPJS Ketenagakerjaan"
                        {{ old('jenis_potongan', $potongan->jenis_potongan) == 'BPJS Ketenagakerjaan' ? 'selected' : '' }}>
                        BPJS Ketenagakerjaan
                    </option>

                    <option value="PPh 21"
                        {{ old('jenis_potongan', $potongan->jenis_potongan) == 'PPh 21' ? 'selected' : '' }}>
                        PPh 21
                    </option>

                    <option value="Kas Karyawan"
                        {{ old('jenis_potongan', $potongan->jenis_potongan) == 'Kas Karyawan' ? 'selected' : '' }}>
                        Kas Karyawan
                    </option>

                    <option value="Pinjaman"
                        {{ old('jenis_potongan', $potongan->jenis_potongan) == 'Pinjaman' ? 'selected' : '' }}>
                        Pinjaman
                    </option>

                    <option value="Denda"
                        {{ old('jenis_potongan', $potongan->jenis_potongan) == 'Denda' ? 'selected' : '' }}>
                        Denda
                    </option>

                    <option value="Lainnya"
                        {{ old('jenis_potongan', $potongan->jenis_potongan) == 'Lainnya' ? 'selected' : '' }}>
                        Lainnya
                    </option>

                </select>

                @error('jenis_potongan')
                    <p class="text-red-500 text-sm mt-2">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Nominal --}}
            <div class="mb-6">

                <label class="block mb-2 font-semibold text-slate-700">

                    Nominal Potongan

                </label>

                <input
                    type="number"
                    name="nominal"
                    value="{{ old('nominal', $potongan->nominal) }}"
                    min="0"
                    placeholder="Masukkan nominal"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3
                           focus:ring-2 focus:ring-red-300 focus:border-red-500 outline-none">

                @error('nominal')
                    <p class="text-red-500 text-sm mt-2">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Keterangan --}}
            <div class="mb-8">

                <label class="block mb-2 font-semibold text-slate-700">

                    Keterangan

                </label>

                <textarea
                    name="keterangan"
                    rows="4"
                    placeholder="Opsional"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3
                           focus:ring-2 focus:ring-red-300 focus:border-red-500 outline-none">{{ old('keterangan', $potongan->keterangan) }}</textarea>

            </div>


            {{-- Tombol --}}
            <button
                type="submit"
                class="bg-gradient-to-r from-yellow-500 to-orange-600
                       hover:from-yellow-600 hover:to-orange-700
                       text-white font-semibold
                       px-8 py-3 rounded-2xl transition">

                Update Potongan

            </button>

        </form>

    </div>

</div>

@endsection