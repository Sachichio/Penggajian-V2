@extends('layouts.app')

@section('title', 'Kelola Potongan')

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
        <h1>Kelola Potongan Gaji</h1>
        <p>Rincian potongan untuk <strong>{{ $penggajian->karyawan->nama }}</strong> periode {{ $bln }} {{ $penggajian->tahun }}.</p>
    </div>
    <div class="flex items-center gap-2">
        <a href="{{ route('potongan.create', $penggajian->id) }}" class="button primary">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 5v14M5 12h14" />
            </svg>
            Tambah Potongan
        </a>
        <a href="{{ route('penggajian.show', $penggajian->id) }}" class="button secondary">
            ← Kembali
        </a>
    </div>
</section>

@if(session('success'))
<div class="mb-5 flex items-center gap-2.5 rounded-[8px] border border-[#d6e5cd] bg-[#f2f8ed] px-4 py-3 text-[11.5px] font-medium text-[#3b6b47]">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-forest shrink-0">
        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
        <polyline points="22 4 12 14.01 9 11.01"></polyline>
    </svg>
    <span>{{ session('success') }}</span>
</div>
@endif

<div class="panel table-panel mb-8">
    <div class="table-heading">
        <div>
            <h2>
                Daftar Potongan
                <span class="count-badge">{{ count($potongans) }} potongan</span>
            </h2>
            <p>Daftar potongan gaji yang dibebankan pada transaksi penggajian ini.</p>
        </div>
    </div>

    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th style="width: 45px; text-align: center;">No</th>
                    <th>Nama Potongan</th>
                    <th>Nominal Potongan</th>
                    <th>Keterangan</th>
                    <th style="text-align: center; width: 100px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($potongans as $item)
                <tr>
                    <td style="text-align: center; color: #9aa299; font-weight: 500;">{{ $loop->iteration }}</td>
                    <td>
                        <strong style="color: #2b382d;">{{ $item->jenis_potongan }}</strong>
                    </td>
                    <td style="color: #b94a48; font-weight: 600;">
                        - Rp {{ number_format($item->nominal, 0, ',', '.') }}
                    </td>
                    <td style="color: #7b8774;">{{ $item->keterangan ?? '-' }}</td>
                    <td>
                        <div class="flex items-center justify-center gap-1.5">
                            <a href="{{ route('potongan.edit', $item->id) }}" class="action-icon-btn" title="Edit Potongan">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg>
                            </a>
                            <form action="{{ route('potongan.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus potongan {{ $item->jenis_potongan }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-icon-btn danger" title="Hapus Potongan">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-12 text-center text-[#8e988f]">
                        Belum ada data potongan pada penggajian ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="table-footer">
        <strong>Total {{ count($potongans) }} potongan tercatat</strong>
        <span>Karyawan: {{ $penggajian->karyawan->nama }}</span>
    </div>
</div>
@endsection
