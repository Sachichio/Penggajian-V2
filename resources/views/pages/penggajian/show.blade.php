@extends('layouts.app')

@section('title', 'Detail Penggajian')

@section('content')
@php
$bulanList = [
    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
];
$bln = is_numeric($penggajian->bulan) ? ($bulanList[(int)$penggajian->bulan] ?? $penggajian->bulan) : $penggajian->bulan;
@endphp

<section class="page-heading">
    <div>
        <div class="heading-eyebrow">MANAJEMEN PAYROLL</div>
        <h1>Detail Penggajian</h1>
        <p>Rincian lengkap perhitungan gaji karyawan periode <strong>{{ $bln }} {{ $penggajian->tahun }}</strong>.</p>
    </div>
    <div class="flex items-center gap-2">
        @if(auth()->user() && auth()->user()->role === 'owner' && ($penggajian->status_approval ?? 'pending') === 'pending')
            <form action="{{ route('penggajian.approve', $penggajian->id) }}" method="POST">
                @csrf
                <button type="submit" class="button primary" style="background: #2563eb; border-color: #2563eb;">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 6L9 17l-5-5"></path>
                    </svg>
                    ACC Payroll (Owner)
                </button>
            </form>
        @endif
        <a href="{{ route('slip-gaji.show', $penggajian->id) }}" class="button primary">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
            </svg>
            Lihat Slip Gaji
        </a>
        <a href="{{ route('potongan.index', $penggajian->id) }}" class="button secondary">
            Kelola Potongan
        </a>
        <a href="{{ route('penggajian.index') }}" class="button secondary">
            ← Kembali
        </a>
    </div>
</section>

<div class="max-w-4xl space-y-6 mb-8">
    {{-- Card Identitas Karyawan --}}
    <div class="form-card">
        <div class="flex items-center justify-between border-b border-[#edf1e8] pb-4 mb-4">
            <h2 class="text-[13px] font-bold text-ink uppercase tracking-wider font-display">Data Karyawan & Periode</h2>
            <div class="flex items-center gap-2">
                @if(($penggajian->status_approval ?? 'pending') === 'approved')
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800 border border-green-200">
                        ✓ Disetujui Owner
                    </span>
                @else
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 border border-amber-200">
                        ⏳ Menunggu Approval Owner
                    </span>
                @endif
                <span class="status-badge">
                    <span class="status-check">✓</span>
                    {{ \Carbon\Carbon::parse($penggajian->tanggal_gaji)->translatedFormat('d F Y') }}
                </span>
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 text-[12px]">
            <div>
                <span class="text-[#8e988f] block text-[10.5px]">NIK:</span>
                <strong class="text-ink mt-0.5 block">{{ $penggajian->karyawan->nik ?? '-' }}</strong>
            </div>
            <div>
                <span class="text-[#8e988f] block text-[10.5px]">Nama Lengkap:</span>
                <strong class="text-ink mt-0.5 block">{{ $penggajian->karyawan->nama ?? '-' }}</strong>
            </div>
            <div>
                <span class="text-[#8e988f] block text-[10.5px]">Jabatan:</span>
                <strong class="text-ink mt-0.5 block">{{ $penggajian->karyawan->jabatan->nama_jabatan ?? '-' }}</strong>
            </div>
            <div>
                <span class="text-[#8e988f] block text-[10.5px]">Periode Penggajian:</span>
                <strong class="text-ink mt-0.5 block">{{ $bln }} {{ $penggajian->tahun }}</strong>
            </div>
        </div>
    </div>

    {{-- Card Rincian Penghasilan --}}
    <div class="form-card">
        <h2 class="text-[13px] font-bold text-ink uppercase tracking-wider font-display border-b border-[#edf1e8] pb-4 mb-5">Komponen Pendapatan & Potongan</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-[12px]">
            <div class="space-y-3">
                <div class="flex justify-between py-1.5 border-b border-dashed border-[#edf1e8]">
                    <span class="text-[#6c786e]">Gaji Pokok</span>
                    <span class="font-semibold text-ink">Rp {{ number_format($penggajian->gaji_pokok, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between py-1.5 border-b border-dashed border-[#edf1e8]">
                    <span class="text-[#6c786e]">Tunjangan</span>
                    <span class="font-semibold text-ink">Rp {{ number_format($penggajian->tunjangan, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between py-1.5 border-b border-dashed border-[#edf1e8]">
                    <span class="text-[#6c786e]">Jam Lembur ({{ $penggajian->jam_lembur }} Jam)</span>
                    <span class="font-semibold text-ink">Rp {{ number_format($penggajian->total_lembur, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between py-2 border-t border-[#edf1e8] text-forest font-bold">
                    <span>Total Pendapatan Kotor</span>
                    <span>Rp {{ number_format($penggajian->total_pendapatan, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="space-y-3">
                <div class="flex justify-between py-1.5 border-b border-dashed border-[#edf1e8]">
                    <span class="text-[#6c786e]">Total Potongan Terdata</span>
                    <span class="font-semibold text-red-600">- Rp {{ number_format($penggajian->total_potongan, 0, ',', '.') }}</span>
                </div>
                <div class="rounded-lg bg-[#fbfdf9] border border-[#eef3ea] p-3 text-[11px] text-[#71816e]">
                    Potongan dapat dikelola secara spesifik melalui menu potongan gaji.
                </div>
            </div>
        </div>
    </div>

    {{-- Take Home Pay Card --}}
    <div class="rounded-[10px] bg-[#f5f9f0] border border-[#dbe6d1] p-5 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div>
            <p class="text-[10px] font-bold uppercase tracking-wider text-[#637d57]">Gaji Bersih Diterima</p>
            <p class="text-[12px] text-[#7d9373]">Take Home Pay (THP) — Siap Dibayarkan</p>
        </div>
        <p class="text-3xl font-extrabold text-[#2a593d] font-display">
            Rp {{ number_format($penggajian->thp, 0, ',', '.') }}
        </p>
    </div>
</div>
@endsection
