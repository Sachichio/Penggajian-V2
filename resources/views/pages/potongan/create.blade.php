@extends('layouts.app')

@section('title', 'Tambah Potongan')

@section('content')
<section class="page-heading">
    <div>
        <div class="heading-eyebrow">MANAJEMEN PAYROLL</div>
        <h1>Tambah Potongan Gaji</h1>
        <p>Tambahkan potongan untuk <strong>{{ $penggajian->karyawan->nama }}</strong> (NIK: {{ $penggajian->karyawan->nik }}).</p>
    </div>
    <a href="{{ route('potongan.index', $penggajian->id) }}" class="button secondary">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="19" y1="12" x2="5" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline>
        </svg>
        Kembali ke Daftar
    </a>
</section>

<div class="max-w-2xl mb-8">
    <div class="form-card">
        <form action="{{ route('potongan.store') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="penggajian_id" value="{{ $penggajian->id }}">

            <div>
                <label class="mb-1.5 block text-[11.5px] font-semibold text-[#44533c]">
                    Nama / Jenis Potongan <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    name="nama_potongan"
                    value="{{ old('nama_potongan') }}"
                    placeholder="Contoh: BPJS Ketenagakerjaan / Kasbon"
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
                    value="{{ old('nominal') }}"
                    placeholder="100000"
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
                    placeholder="Catatan tambahan mengenai pemotongan ini..."
                    class="w-full rounded-[8px] border border-[#d6e0ce] bg-[#fbfdfa] p-3 text-[12px] text-ink outline-none transition focus:border-forest focus:bg-white focus:ring-2 focus:ring-forest/15">{{ old('keterangan') }}</textarea>
                @error('keterangan')
                    <p class="text-red-600 text-[10.5px] mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6 flex items-center gap-3 border-t border-[#edf1e8] pt-5">
                <button type="submit" class="button primary">
                    Simpan Potongan
                </button>
                <a href="{{ route('potongan.index', $penggajian->id) }}" class="button secondary">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
