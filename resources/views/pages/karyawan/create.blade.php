@extends('layouts.app')

@section('title', 'Tambah Karyawan')

@section('content')
<section class="page-heading">
    <div>
        <div class="heading-eyebrow">DATA MASTER</div>
        <h1>Tambah Karyawan Baru</h1>
        <p>Tambahkan data karyawan baru ke dalam sistem pengelolaan payroll gajiku.</p>
    </div>
    <a href="{{ route('karyawan.index') }}" class="button secondary">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="19" y1="12" x2="5" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline>
        </svg>
        Kembali ke Daftar
    </a>
</section>

<div class="max-w-3xl mb-8">
    <div class="form-card">
        <form action="{{ route('karyawan.store') }}" method="POST">
            @csrf
            @include('pages.karyawan.partials.form')
        </form>
    </div>
</div>
@endsection
