@extends('layouts.app')

@section('title', 'Tambah Penggajian')

@section('content')

<div class="p-6">

    <div class="bg-white rounded-3xl shadow-xl p-8 border border-slate-100">


        {{-- HEADER --}}
        <div class="mb-6">

            <a href="{{ route('penggajian.index') }}"
               class="inline-flex items-center px-5 py-3 rounded-2xl
                      bg-slate-700 hover:bg-slate-800
                      text-white font-semibold transition">

                ← Kembali

            </a>

        </div>


        {{-- TITLE --}}
        <div class="mb-8">

            <h1 class="text-3xl font-bold text-slate-800">
                Tambah Penggajian Karyawan
            </h1>

            <p class="text-slate-500 mt-2">
                Input data penggajian karyawan
            </p>

        </div>



        {{-- FORM --}}
        <form action="{{ route('penggajian.store') }}"
              method="POST">

            @csrf


            @include('pages.penggajian.partials.form')


        </form>


    </div>

</div>

@endsection