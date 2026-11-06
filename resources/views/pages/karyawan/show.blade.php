@extends('layouts.app')

@section('title', 'Detail Karyawan')

@section('content')
<section class="page-heading">
    <div>
        <div class="heading-eyebrow">DATA MASTER</div>
        <h1>Detail Karyawan</h1>
        <p>Informasi profil lengkap dan rekapitulasi data kepegawaian.</p>
    </div>
    <div class="flex items-center gap-2">
        <a href="{{ route('karyawan.edit', $karyawan->id) }}" class="button primary">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
            </svg>
            Edit Profil
        </a>
        <a href="{{ route('karyawan.index') }}" class="button secondary">
            ← Kembali
        </a>
    </div>
</section>

<div class="max-w-4xl mb-8">
    <div class="form-card">
        {{-- Banner & Avatar --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-5 border-b border-[#edf1e8] pb-6">
            <span class="avatar bg-[#eaf1e6] text-[#668258] text-xl font-bold w-16 h-16 rounded-2xl flex items-center justify-center shrink-0 border border-[#d6e5cd]">
                {{ strtoupper(substr($karyawan->nama, 0, 2)) }}
            </span>
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-3">
                    <h2 class="text-xl font-bold text-ink truncate font-display">{{ $karyawan->nama }}</h2>
                    @if($karyawan->status == 'Aktif')
                        <span class="status-badge">
                            <span class="status-check">✓</span>
                            Aktif
                        </span>
                    @else
                        <span class="status-badge-rose">Nonaktif</span>
                    @endif
                </div>
                <p class="text-[12px] text-[#6e7b70] mt-1">
                    {{ $karyawan->jabatan->nama_jabatan ?? 'Belum Ditugaskan' }} <span class="text-[#cbd5c7]">·</span> NIK: <strong class="text-ink">{{ $karyawan->nik }}</strong>
                </p>
            </div>
        </div>

        {{-- Detail Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-6">
            <div class="rounded-lg border border-[#edf1e8] bg-[#fbfdfa] p-4">
                <p class="text-[10px] font-semibold uppercase tracking-wider text-[#8b998a]">Struktur Jabatan</p>
                <p class="text-[14px] font-bold text-ink mt-1 font-display">{{ $karyawan->jabatan->nama_jabatan ?? '-' }}</p>
                <p class="text-[11px] text-[#7d8b7e] mt-1">Gaji Pokok: Rp {{ number_format($karyawan->jabatan->gaji_pokok ?? 0, 0, ',', '.') }}</p>
                <p class="text-[11px] text-[#7d8b7e]">Tunjangan: Rp {{ number_format($karyawan->jabatan->tunjangan ?? 0, 0, ',', '.') }}</p>
            </div>

            <div class="rounded-lg border border-[#edf1e8] bg-[#fbfdfa] p-4">
                <p class="text-[10px] font-semibold uppercase tracking-wider text-[#8b998a]">Informasi Personal</p>
                <p class="text-[12px] text-ink mt-1">Jenis Kelamin: <strong class="text-[#3c4a3d]">{{ in_array($karyawan->jenis_kelamin, ['L', 'Laki-laki']) ? 'Laki-laki' : 'Perempuan' }}</strong></p>
                <p class="text-[12px] text-ink mt-1">Tanggal Bergabung: <strong class="text-[#3c4a3d]">{{ \Carbon\Carbon::parse($karyawan->tanggal_masuk)->translatedFormat('d F Y') }}</strong></p>
                <p class="text-[12px] text-ink mt-1">Masa Kerja: <strong class="text-[#3c4a3d]">{{ \Carbon\Carbon::parse($karyawan->tanggal_masuk)->diffForHumans(null, true) }}</strong></p>
            </div>
        </div>
    </div>
</div>
@endsection
