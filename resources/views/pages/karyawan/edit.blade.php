@extends('layouts.app')

@section('title', 'Edit Karyawan')

@section('content')

<div class="max-w-3xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">

        <div>

            <h1 class="text-3xl font-bold text-slate-800">
                Edit Karyawan
            </h1>

            <p class="text-slate-500 mt-1">
                Perbarui informasi data karyawan.
            </p>

        </div>

        <a href="{{ route('karyawan.index') }}"
           class="inline-flex items-center px-5 py-3 rounded-2xl
                  bg-slate-700 hover:bg-slate-800
                  text-white font-semibold transition">

            ← Kembali

        </a>

    </div>

    {{-- Card Form --}}
    <div class="bg-white rounded-3xl shadow-xl border border-slate-100 p-8">

        <form action="{{ route('karyawan.update', $karyawan->id) }}"
              method="POST">

            @csrf
            @method('PUT')

            @include('pages.karyawan.partials.form')

        </form>

    </div>

</div>

@endsection