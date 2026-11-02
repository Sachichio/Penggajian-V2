@extends('layouts.app')

@section('title', 'Edit Penggajian')

@section('content')
<section class="page-heading">
    <div>
        <div class="heading-eyebrow">MANAJEMEN PAYROLL</div>
        <h1>Edit Transaksi Penggajian</h1>
        <p>Perbarui rincian jam lembur, periode, atau tanggal penggajian.</p>
    </div>
    <a href="{{ route('penggajian.index') }}" class="button secondary">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="19" y1="12" x2="5" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline>
        </svg>
        Kembali ke Daftar
    </a>
</section>

<div class="max-w-4xl mb-8">
    <div class="form-card">
        <form action="{{ route('penggajian.update', $penggajian->id) }}" method="POST">
            @csrf
            @method('PUT')
            @include('pages.penggajian.partials.form')
        </form>
    </div>
</div>
@endsection
