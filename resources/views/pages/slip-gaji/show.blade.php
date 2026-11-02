@extends('layouts.app')

@section('title', 'Slip Gaji Digital')

@section('content')
@php
$namaBulan = [
    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
];
$bln = is_numeric($slipGaji->bulan) ? ($namaBulan[(int)$slipGaji->bulan] ?? $slipGaji->bulan) : $slipGaji->bulan;
@endphp

<section class="page-heading">
    <div>
        <div class="heading-eyebrow">DOKUMEN PAYROLL</div>
        <h1>Slip Gaji Digital</h1>
        <p>Pratinjau resmi rincian penghasilan dan potongan karyawan periode {{ $bln }} {{ $slipGaji->tahun }}.</p>
    </div>
    <div class="flex items-center gap-2">
        <a href="{{ route('slip-gaji.export', $slipGaji->id) }}" class="button primary">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                <polyline points="7 10 12 15 17 10"></polyline>
                <line x1="12" y1="15" x2="12" y2="3"></line>
            </svg>
            Unduh PDF Resmi
        </a>
        <a href="{{ route('slip-gaji.index') }}" class="button secondary">
            ← Kembali
        </a>
    </div>
</section>

{{-- Dokumen Slip Card --}}
<div class="max-w-3xl mb-8">
    <div class="form-card p-8 relative overflow-hidden">
        {{-- Header Slip --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-[#edf1e8] pb-6">
            <div class="flex items-center gap-3">
                <span class="inline-flex select-none items-center gap-2 font-display text-[24px] font-extrabold leading-none tracking-[-0.055em] text-ink">
                    <span class="inline-flex -rotate-[9deg] items-end gap-[3px] leading-none">
                        <span class="w-[6px] h-[15px] rounded-[2px] bg-[#336b4b]"></span>
                        <span class="w-[6px] h-[22px] rounded-[2px] bg-[#5b8760]"></span>
                        <span class="w-[6px] h-[18px] rounded-[2px] bg-[#a3bd8b]"></span>
                    </span>
                    <span>gajiku<span class="text-forest">.</span></span>
                </span>
                <span class="text-[12px] text-[#8e988f] font-medium border-l border-[#e5eae3] pl-3">
                    PT. Sejahtera Bersama
                </span>
            </div>
            <div class="text-left sm:text-right">
                <span class="status-badge text-[10px]">
                    <span class="status-check">✓</span>
                    Lunas / Dibayarkan
                </span>
                <p class="text-[11px] text-[#8e988f] mt-1.5">No: <strong>SLIP-{{ str_pad($slipGaji->id, 5, '0', STR_PAD_LEFT) }}</strong></p>
            </div>
        </div>

        {{-- Info Karyawan --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 py-5 border-b border-[#edf1e8] text-[12px]">
            <div>
                <p class="text-[#8e988f] text-[10.5px]">Penerima:</p>
                <p class="font-bold text-ink text-[13px] mt-0.5">{{ $slipGaji->karyawan->nama ?? '-' }}</p>
                <p class="text-[#6c786e] mt-0.5">NIK: {{ $slipGaji->karyawan->nik ?? '-' }}</p>
            </div>
            <div class="sm:text-right">
                <p class="text-[#8e988f] text-[10.5px]">Posisi & Periode:</p>
                <p class="font-bold text-ink text-[13px] mt-0.5">{{ $slipGaji->karyawan->jabatan->nama_jabatan ?? '-' }}</p>
                <p class="text-[#6c786e] mt-0.5">{{ $bln }} {{ $slipGaji->tahun }} · Dibayar: {{ \Carbon\Carbon::parse($slipGaji->tanggal_gaji)->translatedFormat('d F Y') }}</p>
            </div>
        </div>

        {{-- Rincian Penghasilan & Potongan --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 py-6 border-b border-[#edf1e8]">
            {{-- Penghasilan --}}
            <div>
                <h3 class="text-[11.5px] font-bold text-forest uppercase tracking-wider mb-3">Penghasilan</h3>
                <div class="space-y-2 text-[12px]">
                    <div class="flex justify-between py-1 border-b border-dashed border-[#edf1e8]">
                        <span class="text-[#6c786e]">Gaji Pokok</span>
                        <span class="font-semibold text-ink">Rp {{ number_format($slipGaji->gaji_pokok, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-dashed border-[#edf1e8]">
                        <span class="text-[#6c786e]">Tunjangan</span>
                        <span class="font-semibold text-ink">Rp {{ number_format($slipGaji->tunjangan, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            {{-- Potongan --}}
            <div>
                <h3 class="text-[11.5px] font-bold text-[#b94a48] uppercase tracking-wider mb-3">Potongan</h3>
                <div class="space-y-2 text-[12px]">
                    <div class="flex justify-between py-1 border-b border-dashed border-[#edf1e8]">
                        <span class="text-[#6c786e]">Total Potongan</span>
                        <span class="font-semibold text-red-600">- Rp {{ number_format($slipGaji->total_potongan ?? 0, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Take Home Pay Total --}}
        <div class="mt-6 rounded-[8px] bg-[#f5f9f0] border border-[#dbe6d1] p-4 flex flex-col sm:flex-row items-center justify-between gap-3">
            <div>
                <p class="text-[10px] font-bold uppercase tracking-wider text-[#637d57]">Gaji Bersih Diterima</p>
                <p class="text-[11.5px] text-[#7d9373]">Take Home Pay (THP)</p>
            </div>
            <p class="text-2xl font-extrabold text-[#2a593d] font-display">
                Rp {{ number_format($slipGaji->thp, 0, ',', '.') }}
            </p>
        </div>

        {{-- Footer Pengesahan --}}
        <div class="mt-8 pt-6 border-t border-[#edf1e8] flex justify-between items-end text-[11px] text-[#8e988f]">
            <div>
                <p>Dokumen ini dibuat otomatis oleh sistem <strong>gajiku.</strong></p>
                <p>Sah tanpa tanda tangan basah.</p>
            </div>
            <div class="text-right">
                <p>PT. Sejahtera Bersama</p>
                <p class="text-forest font-semibold mt-0.5">Finance & HR Department</p>
            </div>
        </div>
    </div>
</div>
@endsection
