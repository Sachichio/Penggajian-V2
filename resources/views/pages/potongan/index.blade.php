@extends('layouts.app')

@section('title', 'Kelola Potongan')

@section('content')

<div class="space-y-6">

    {{-- Tombol Kembali --}}
    <div>

        <a href="{{ route('penggajian.show', $penggajian->id) }}"
            class="inline-flex items-center px-5 py-3 rounded-2xl
                   bg-slate-700 hover:bg-slate-800
                   text-white font-semibold transition">

            ← Kembali

        </a>

    </div>



    {{-- Header --}}
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">

        <h1 class="text-2xl font-bold text-slate-800">

            Kelola Potongan

        </h1>

        <div class="mt-5 grid md:grid-cols-2 gap-5">

            <div>

                <p class="text-sm text-slate-500">
                    Karyawan
                </p>

                <p class="font-semibold text-slate-800">

                    {{ $penggajian->karyawan->nama }}

                </p>

            </div>

            <div>

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

                    {{ $bulan[$penggajian->bulan] }}
                    {{ $penggajian->tahun }}

                </p>

            </div>

        </div>

    </div>



    {{-- Tombol Tambah --}}
    <div class="flex justify-end">

        <a href="{{ route('potongan.create', $penggajian->id) }}"
            class="inline-flex items-center
                   px-5 py-3
                   rounded-2xl
                   bg-cyan-600
                   hover:bg-cyan-700
                   text-white
                   font-semibold">

            + Tambah Potongan

        </a>

    </div>



    {{-- Tabel --}}
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">

        <table class="w-full">

            <thead class="bg-slate-50">

                <tr>

                    <th class="text-left p-4">
                        Jenis Potongan
                    </th>

                    <th class="text-left p-4">
                        Nominal
                    </th>

                    <th class="text-center p-4">
                        Aksi
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($penggajian->potongans as $potongan)

                    <tr class="border-t">

                        <td class="p-4">

                            {{ $potongan->jenis_potongan }}

                        </td>

                        <td class="p-4">

                            Rp {{ number_format($potongan->nominal,0,',','.') }}

                        </td>

                        <td class="text-center p-4">

                            <div class="flex justify-center gap-2">

                                <a
                                    href="{{ route('potongan.edit', $potongan->id) }}"
                                    class="bg-yellow-500 hover:bg-yellow-600
                                        text-white
                                        px-3 py-2
                                        rounded-xl
                                        transition">

                                    Edit

                                </a>

                            <form
                                action="{{ route('potongan.destroy', $potongan->id) }}"
                                method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus potongan ini?')"
                                class="inline">

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="bg-red-500 hover:bg-red-600
                                        text-white
                                        px-3 py-2
                                        rounded-xl
                                        transition">

                                    Hapus

                                </button>

                            </form>
                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="3"
                            class="text-center text-slate-400 py-10">

                            Belum ada data potongan.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>



    {{-- Total --}}
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">

        <div class="flex justify-between items-center">

            <h2 class="text-lg font-bold">

                Total Potongan

            </h2>

            <h2 class="text-2xl font-bold text-red-600">

                Rp
                {{ number_format($penggajian->potongans->sum('nominal'),0,',','.') }}

            </h2>

        </div>

    </div>

</div>

@endsection