@extends('layouts.app')

@section('title', 'Data Karyawan')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <div>

            <h1 class="text-3xl font-bold text-slate-800">
                Data Karyawan
            </h1>

            <p class="text-slate-500 mt-1">
                Kelola seluruh data karyawan perusahaan
            </p>

        </div>

        <a href="{{ route('karyawan.create') }}"
           class="inline-flex items-center justify-center
                  px-5 py-3 rounded-2xl
                  bg-gradient-to-r from-cyan-500 to-blue-600
                  hover:shadow-lg hover:shadow-cyan-500/30
                  text-white font-semibold transition">

            + Tambah Karyawan

        </a>

    </div>

    {{-- Alert --}}
    @if(session('success'))

        <div class="bg-green-100 border border-green-300 text-green-700 px-5 py-3 rounded-xl">

            {{ session('success') }}

        </div>

    @endif

    {{-- TABLE --}}
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-100">

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-slate-100">

                    <tr class="text-slate-700">

                        <th class="px-6 py-4 text-left font-semibold">
                            No
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Karyawan
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Jabatan
                        </th>

                        <th class="px-6 py-4 text-center font-semibold">
                            Jenis Kelamin
                        </th>

                        <th class="px-6 py-4 text-center font-semibold">
                            Status
                        </th>

                        <th class="px-6 py-4 text-center font-semibold">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse($karyawans as $item)

                        <tr class="hover:bg-slate-50 transition">

                            {{-- No --}}
                            <td class="px-6 py-5">

                                {{ $loop->iteration }}

                            </td>

                            {{-- Nama --}}
                            <td class="px-6 py-5">

                                <div class="flex items-center gap-4">

                                    <div class="w-11 h-11 rounded-2xl
                                                bg-gradient-to-br from-cyan-500 to-blue-600
                                                flex items-center justify-center
                                                text-white font-bold">

                                        {{ strtoupper(substr($item->nama,0,1)) }}

                                    </div>

                                    <div>

                                        <h3 class="font-semibold text-slate-800">

                                            {{ $item->nama }}

                                        </h3>

                                        <p class="text-sm text-slate-400">

                                            {{ $item->nik }}

                                        </p>

                                    </div>

                                </div>

                            </td>

                            {{-- Jabatan --}}
                            <td class="px-6 py-5 text-slate-600">

                                {{ $item->jabatan->nama_jabatan ?? '-' }}

                            </td>

                            {{-- Jenis Kelamin --}}
                            <td class="px-6 py-5 text-center">

                                {{ $item->jenis_kelamin }}

                            </td>

                            {{-- Status --}}
                            <td class="px-6 py-5 text-center">

                                @if($item->status == 'Aktif')

                                    <span class="px-4 py-2 rounded-full bg-green-100 text-green-700 text-sm font-semibold">

                                        Aktif

                                    </span>

                                @else

                                    <span class="px-4 py-2 rounded-full bg-red-100 text-red-700 text-sm font-semibold">

                                        Nonaktif

                                    </span>

                                @endif

                            </td>

                            {{-- Aksi --}}
                            <td class="px-6 py-5">

                                <div class="flex justify-center gap-2">

                                    <a href="{{ route('karyawan.show',$item->id) }}"
                                       class="px-4 py-2 rounded-xl bg-cyan-500 hover:bg-cyan-600 text-white text-sm">

                                        Detail

                                    </a>

                                    <a href="{{ route('karyawan.edit',$item->id) }}"
                                       class="px-4 py-2 rounded-xl bg-amber-400 hover:bg-amber-500 text-white text-sm">

                                        Edit

                                    </a>

                                    <form action="{{ route('karyawan.destroy',$item->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus data karyawan ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            class="px-4 py-2 rounded-xl bg-red-500 hover:bg-red-600 text-white text-sm">

                                            Hapus

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6" class="py-16 text-center">

                                <div class="text-5xl mb-4">

                                    👨‍💼

                                </div>

                                <h3 class="text-lg font-bold text-slate-700">

                                    Belum Ada Data Karyawan

                                </h3>

                                <p class="text-slate-500 mt-2">

                                    Silakan tambahkan data karyawan terlebih dahulu.

                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection