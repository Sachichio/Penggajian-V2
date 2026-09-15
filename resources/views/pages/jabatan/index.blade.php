@extends('layouts.app')

@section('title', 'Data Jabatan')

@section('content')

<div class="p-6">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

        <div>

            <h1 class="text-3xl font-bold text-slate-800">
                Data Jabatan
            </h1>

            <p class="text-slate-500 mt-1">
                Kelola data jabatan beserta gaji pokok dan tunjangan karyawan.
            </p>

        </div>

        <a href="{{ route('jabatan.create') }}"
           class="inline-flex items-center justify-center
                  bg-gradient-to-r from-cyan-600 to-blue-700
                  hover:from-cyan-700 hover:to-blue-800
                  text-white font-semibold
                  px-5 py-3 rounded-2xl
                  shadow-lg shadow-cyan-500/20
                  transition">

            + Tambah Jabatan

        </a>

    </div>

    {{-- ALERT --}}
    @if(session('success'))

        <div class="mb-5 rounded-xl bg-green-100 border border-green-300 text-green-700 px-5 py-3">

            {{ session('success') }}

        </div>

    @endif

    {{-- TABLE --}}
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-100">

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-slate-100">

                    <tr>

                        <th class="px-6 py-4 text-left font-bold">
                            No
                        </th>

                        <th class="px-6 py-4 text-left font-bold">
                            Nama Jabatan
                        </th>

                        <th class="px-6 py-4 text-right font-bold">
                            Gaji Pokok
                        </th>

                        <th class="px-6 py-4 text-right font-bold">
                            Tunjangan
                        </th>

                        <th class="px-6 py-4 text-center font-bold">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse($jabatans as $item)

                        <tr class="hover:bg-slate-50">

                            <td class="px-6 py-4">

                                {{ $loop->iteration }}

                            </td>

                            <td class="px-6 py-4 font-semibold text-slate-700">

                                {{ $item->nama_jabatan }}

                            </td>

                            <td class="px-6 py-4 text-right">

                                Rp {{ number_format($item->gaji_pokok,0,',','.') }}

                            </td>

                            <td class="px-6 py-4 text-right">

                                Rp {{ number_format($item->tunjangan,0,',','.') }}

                            </td>

                            <td class="px-6 py-4">

                                <div class="flex justify-center gap-2">

                                    <a href="{{ route('jabatan.edit',$item->id) }}"
                                       class="px-4 py-2 bg-amber-400 hover:bg-amber-500 rounded-xl text-white text-sm">

                                        Edit

                                    </a>

                                    <form
                                        action="{{ route('jabatan.destroy',$item->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus jabatan ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            class="px-4 py-2 bg-red-500 hover:bg-red-600 rounded-xl text-white text-sm">

                                            Hapus

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5" class="text-center py-16">

                                <div class="text-5xl mb-3">

                                    🏢

                                </div>

                                <h3 class="text-lg font-bold text-slate-700">

                                    Belum Ada Data Jabatan

                                </h3>

                                <p class="text-slate-500 mt-2">

                                    Silakan tambahkan data jabatan terlebih dahulu.

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