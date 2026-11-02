@extends('layouts.app')

@section('title', 'Tambah Jabatan')

@section('content')
<section class="page-heading">
    <div>
        <div class="heading-eyebrow">STRUKTUR ORGANISASI</div>
        <h1>Tambah Jabatan Baru</h1>
        <p>Tambahkan struktur jabatan dan besaran kompensasi standar ke dalam sistem.</p>
    </div>
    <a href="{{ route('jabatan.index') }}" class="button secondary">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="19" y1="12" x2="5" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline>
        </svg>
        Kembali ke Daftar
    </a>
</section>

<div class="max-w-2xl mb-8">
    <div class="form-card">
        <form action="{{ route('jabatan.store') }}" method="POST">
            @csrf
            @include('pages.jabatan.partials.form')
        </form>
    </div>
</div>
@endsection
