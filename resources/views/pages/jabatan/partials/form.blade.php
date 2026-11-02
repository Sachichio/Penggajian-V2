<div class="space-y-5">
    {{-- Nama Jabatan --}}
    <div>
        <label class="mb-1.5 block text-[11.5px] font-semibold text-[#44533c]">
            Nama Jabatan / Posisi <span class="text-red-500">*</span>
        </label>
        <input
            type="text"
            name="nama_jabatan"
            value="{{ old('nama_jabatan', $jabatan->nama_jabatan ?? '') }}"
            placeholder="Contoh: Staff Accounting"
            required
            class="h-[42px] w-full rounded-[8px] border border-[#d6e0ce] bg-[#fbfdfa] px-3 text-[12px] text-ink outline-none transition focus:border-forest focus:bg-white focus:ring-2 focus:ring-forest/15">
        @error('nama_jabatan')
            <p class="text-red-600 text-[10.5px] mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Grid Gaji Pokok & Tunjangan --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="mb-1.5 block text-[11.5px] font-semibold text-[#44533c]">
                Gaji Pokok (Rp) <span class="text-red-500">*</span>
            </label>
            <input
                type="number"
                name="gaji_pokok"
                value="{{ old('gaji_pokok', $jabatan->gaji_pokok ?? '') }}"
                placeholder="4500000"
                required
                class="h-[42px] w-full rounded-[8px] border border-[#d6e0ce] bg-[#fbfdfa] px-3 text-[12px] text-ink outline-none transition focus:border-forest focus:bg-white focus:ring-2 focus:ring-forest/15">
            @error('gaji_pokok')
                <p class="text-red-600 text-[10.5px] mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="mb-1.5 block text-[11.5px] font-semibold text-[#44533c]">
                Tunjangan Tetap (Rp) <span class="text-red-500">*</span>
            </label>
            <input
                type="number"
                name="tunjangan"
                value="{{ old('tunjangan', $jabatan->tunjangan ?? '') }}"
                placeholder="500000"
                required
                class="h-[42px] w-full rounded-[8px] border border-[#d6e0ce] bg-[#fbfdfa] px-3 text-[12px] text-ink outline-none transition focus:border-forest focus:bg-white focus:ring-2 focus:ring-forest/15">
            @error('tunjangan')
                <p class="text-red-600 text-[10.5px] mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    {{-- Tombol Aksi --}}
    <div class="mt-6 flex items-center gap-3 border-t border-[#edf1e8] pt-5">
        <button type="submit" class="button primary">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                <polyline points="17 21 17 13 7 13 7 21"></polyline>
                <polyline points="7 3 7 8 15 8"></polyline>
            </svg>
            Simpan Data Jabatan
        </button>
        <a href="{{ route('jabatan.index') }}" class="button secondary">
            Batal
        </a>
    </div>
</div>
