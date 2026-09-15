@extends('layouts.app')

@section('title', 'Data Penggajian')

@section('content')

<div class="p-6">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

        <div>
            <h1 class="text-3xl font-bold text-slate-800">
                Data Penggajian
            </h1>

            <p class="text-slate-500 mt-1">
                Kelola data penggajian karyawan
            </p>
        </div>

        <a href="{{ route('penggajian.create') }}"
           class="inline-flex items-center justify-center
                  bg-gradient-to-r from-cyan-600 to-blue-700
                  hover:from-cyan-700 hover:to-blue-800
                  text-white font-semibold
                  px-5 py-3 rounded-2xl
                  shadow-lg shadow-cyan-500/20
                  transition duration-200">

            + Tambah Penggajian

        </a>

    </div>

    {{-- Pesan Sukses --}}
    @if(session('success'))

        <div class="mb-6 bg-green-100 border border-green-300 text-green-700 px-5 py-4 rounded-2xl">

            {{ session('success') }}

        </div>

    @endif

    {{-- CARD TABLE --}}
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-100">

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-slate-100 text-slate-700">

                    <tr>

                        <th class="px-6 py-4 text-left font-bold">
                            No
                        </th>

                        <th class="px-6 py-4 text-left font-bold">
                            NIK
                        </th>

                        <th class="px-6 py-4 text-left font-bold">
                            Nama Karyawan
                        </th>

                        <th class="px-6 py-4 text-left font-bold">
                            Jabatan
                        </th>

                        <th class="px-6 py-4 text-left font-bold">
                            Periode
                        </th>

                        <th class="px-6 py-4 text-right font-bold">
                            THP
                        </th>

                        <th class="px-6 py-4 text-left font-bold">
                            Tanggal Gaji
                        </th>

                        <th class="px-6 py-4 text-center font-bold">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse($penggajians as $penggajian)

                    <tr class="hover:bg-slate-50 transition">

                        {{-- NO --}}
                        <td class="px-6 py-4 font-semibold text-slate-600">

                            {{ $loop->iteration }}

                        </td>

                        {{-- NIK --}}
                        <td class="px-6 py-4">

                            {{ $penggajian->karyawan->nik }}

                        </td>

                        {{-- NAMA --}}
                        <td class="px-6 py-4">

                            <div class="font-semibold text-slate-800">

                                {{ $penggajian->karyawan->nama }}

                            </div>

                        </td>

                        {{-- JABATAN --}}
                        <td class="px-6 py-4 text-slate-600">

                            {{ $penggajian->karyawan->jabatan->nama_jabatan }}

                        </td>

                        {{-- PERIODE --}}
                        <td class="px-6 py-4 text-slate-600">

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

                        </td>

                        {{-- THP --}}
                        <td class="px-6 py-4 text-right font-semibold text-green-700">

                            Rp {{ number_format($penggajian->thp,0,',','.') }}

                        </td>

                        {{-- TANGGAL --}}
                        <td class="px-6 py-4 text-slate-600">

                            {{ \Carbon\Carbon::parse($penggajian->tanggal_gaji)->format('d-m-Y') }}

                        </td>

                        {{-- AKSI --}}
                        <td class="px-6 py-4">

                            <div class="flex justify-center gap-2">

                                {{-- DETAIL --}}
                                <a href="{{ route('penggajian.show',$penggajian->id) }}"
                                   class="px-4 py-2 rounded-xl
                                          bg-cyan-500 hover:bg-cyan-600
                                          text-white text-sm font-semibold
                                          transition">

                                    Detail

                                </a>

                                {{-- EDIT --}}
                                <a href="{{ route('penggajian.edit',$penggajian->id) }}"
                                   class="px-4 py-2 rounded-xl
                                          bg-amber-400 hover:bg-amber-500
                                          text-white text-sm font-semibold
                                          transition">

                                    Edit

                                </a>

                                {{-- DELETE --}}
                                <form action="{{ route('penggajian.destroy',$penggajian->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus data ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="px-4 py-2 rounded-xl
                                                   bg-red-500 hover:bg-red-600
                                                   text-white text-sm font-semibold
                                                   transition">

                                        Hapus

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="8"
                            class="px-6 py-14 text-center">

                            <div class="flex flex-col items-center">

                                <div class="text-5xl mb-3">

                                    💰

                                </div>

                                <h3 class="text-lg font-bold text-slate-700 mb-1">

                                    Belum Ada Data Penggajian

                                </h3>

                                <p class="text-slate-500 text-sm">

                                    Silakan tambahkan data penggajian terlebih dahulu.

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