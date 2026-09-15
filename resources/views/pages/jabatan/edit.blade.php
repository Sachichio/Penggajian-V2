@extends('layouts.app')

@section('title', 'Edit Jabatan')

@section('content')

<div class="max-w-3xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">

        <div>

            <h1 class="text-3xl font-bold text-slate-800">
                Edit Jabatan
            </h1>

            <p class="text-slate-500 mt-1">
                Perbarui informasi jabatan, gaji pokok, dan tunjangan.
            </p>

        </div>

        <a href="{{ route('jabatan.index') }}"
           class="inline-flex items-center px-5 py-3 rounded-2xl
                  bg-slate-700 hover:bg-slate-800
                  text-white font-semibold transition">

            ← Kembali

        </a>

    </div>

    {{-- Card Form --}}
    <div class="bg-white rounded-3xl shadow-xl border border-slate-100 p-8">

        <form action="{{ route('jabatan.update', $jabatan->id) }}"
              method="POST">

            @csrf
            @method('PUT')

            @include('pages.jabatan.partials.form')

        </form>

    </div>

</div>

@endsection