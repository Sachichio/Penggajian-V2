@extends('layouts.app')

@section('title', 'Edit Potongan')

@section('content')
<section class="page-heading">
    <div>
        <div class="heading-eyebrow">MANAJEMEN PAYROLL</div>
        <h1>Edit Potongan Gaji</h1>
        <p>Perbarui rincian potongan untuk <strong>{{ $potongan->penggajian->karyawan->nama }}</strong>.</p>
    </div>
    <a href="{{ route('potongan.index', $potongan->penggajian_id) }}" class="button secondary">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="19" y1="12" x2="5" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline>
        </svg>
        Kembali ke Daftar
    </a>
</section>

<div class="max-w-2xl mb-8">
    <div class="form-card">
        <form action="{{ route('potongan.update', $potongan->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="mb-1.5 block text-[11.5px] font-semibold text-[#44533c]">
                    Nama / Jenis Potongan <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    name="nama_potongan"
                    value="{{ old('nama_potongan', $potongan->nama_potongan) }}"
                    required
                    class="h-[42px] w-full rounded-[8px] border border-[#d6e0ce] bg-[#fbfdfa] px-3 text-[12px] text-ink outline-none transition focus:border-forest focus:bg-white focus:ring-2 focus:ring-forest/15">
                @error('nama_potongan')
                    <p class="text-red-600 text-[10.5px] mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-1.5 block text-[11.5px] font-semibold text-[#44533c]">
                    Nominal Potongan (Rp) <span class="text-red-500">*</span>
                </label>
                <input
                    type="number"
                    name="nominal"
                    value="{{ old('nominal', $potongan->nominal) }}"
                    required
                    class="h-[42px] w-full rounded-[8px] border border-[#d6e0ce] bg-[#fbfdfa] px-3 text-[12px] text-ink outline-none transition focus:border-forest focus:bg-white focus:ring-2 focus:ring-forest/15">
                @error('nominal')
                    <p class="text-red-600 text-[10.5px] mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-1.5 block text-[11.5px] font-semibold text-[#44533c]">
                    Keterangan (Opsional)
                </label>
                <textarea
                    name="keterangan"
                    rows="3"
                    class="w-full rounded-[8px] border border-[#d6e0ce] bg-[#fbfdfa] p-3 text-[12px] text-ink outline-none transition focus:border-forest focus:bg-white focus:ring-2 focus:ring-forest/15">{{ old('keterangan', $potongan->keterangan) }}</textarea>
                @error('keterangan')
                    <p class="text-red-600 text-[10.5px] mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6 flex items-center gap-3 border-t border-[#edf1e8] pt-5">
                <button type="submit" class="button primary">
                    Perbarui Potongan
                </button>
                <a href="{{ route('potongan.index', $potongan->penggajian_id) }}" class="button secondary">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
