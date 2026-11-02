<div class="space-y-5">
    {{-- Grid 2 Kolom --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        {{-- NIK --}}
        <div>
            <label class="mb-1.5 block text-[11.5px] font-semibold text-[#44533c]">
                NIK (Nomor Induk Karyawan) <span class="text-red-500">*</span>
            </label>
            <input
                type="text"
                name="nik"
                value="{{ old('nik', $karyawan->nik ?? '') }}"
                placeholder="Misal: CN-001"
                required
                class="h-[42px] w-full rounded-[8px] border border-[#d6e0ce] bg-[#fbfdfa] px-3 text-[12px] text-ink outline-none transition focus:border-forest focus:bg-white focus:ring-2 focus:ring-forest/15">
            @error('nik')
                <p class="text-red-600 text-[10.5px] mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Nama Karyawan --}}
        <div>
            <label class="mb-1.5 block text-[11.5px] font-semibold text-[#44533c]">
                Nama Lengkap Karyawan <span class="text-red-500">*</span>
            </label>
            <input
                type="text"
                name="nama"
                value="{{ old('nama', $karyawan->nama ?? '') }}"
                placeholder="Nama lengkap sesuai identitas"
                required
                class="h-[42px] w-full rounded-[8px] border border-[#d6e0ce] bg-[#fbfdfa] px-3 text-[12px] text-ink outline-none transition focus:border-forest focus:bg-white focus:ring-2 focus:ring-forest/15">
            @error('nama')
                <p class="text-red-600 text-[10.5px] mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    {{-- Grid 2 Kolom: Jabatan & Jenis Kelamin --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        {{-- Jabatan --}}
        <div>
            <label class="mb-1.5 block text-[11.5px] font-semibold text-[#44533c]">
                Jabatan / Posisi <span class="text-red-500">*</span>
            </label>
            <select
                name="jabatan_id"
                required
                class="h-[42px] w-full rounded-[8px] border border-[#d6e0ce] bg-[#fbfdfa] px-3 text-[12px] text-ink outline-none transition focus:border-forest focus:bg-white focus:ring-2 focus:ring-forest/15">
                <option value="">-- Pilih Jabatan --</option>
                @foreach($jabatans as $jabatan)
                    <option value="{{ $jabatan->id }}"
                        {{ old('jabatan_id', $karyawan->jabatan_id ?? '') == $jabatan->id ? 'selected' : '' }}>
                        {{ $jabatan->nama_jabatan }}
                    </option>
                @endforeach
            </select>
            @error('jabatan_id')
                <p class="text-red-600 text-[10.5px] mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Jenis Kelamin --}}
        <div>
            <label class="mb-1.5 block text-[11.5px] font-semibold text-[#44533c]">
                Jenis Kelamin <span class="text-red-500">*</span>
            </label>
            <select
                name="jenis_kelamin"
                required
                class="h-[42px] w-full rounded-[8px] border border-[#d6e0ce] bg-[#fbfdfa] px-3 text-[12px] text-ink outline-none transition focus:border-forest focus:bg-white focus:ring-2 focus:ring-forest/15">
                <option value="">-- Pilih Jenis Kelamin --</option>
                <option value="L" {{ old('jenis_kelamin', $karyawan->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ old('jenis_kelamin', $karyawan->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>
            @error('jenis_kelamin')
                <p class="text-red-600 text-[10.5px] mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    {{-- Tanggal Masuk & Status --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div>
            <label class="mb-1.5 block text-[11.5px] font-semibold text-[#44533c]">
                Tanggal Masuk Kerja <span class="text-red-500">*</span>
            </label>
            <input
                type="date"
                name="tanggal_masuk"
                value="{{ old('tanggal_masuk', $karyawan->tanggal_masuk ?? date('Y-m-d')) }}"
                required
                class="h-[42px] w-full rounded-[8px] border border-[#d6e0ce] bg-[#fbfdfa] px-3 text-[12px] text-ink outline-none transition focus:border-forest focus:bg-white focus:ring-2 focus:ring-forest/15">
            @error('tanggal_masuk')
                <p class="text-red-600 text-[10.5px] mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="mb-1.5 block text-[11.5px] font-semibold text-[#44533c]">
                Status Kepegawaian <span class="text-red-500">*</span>
            </label>
            <select
                name="status"
                required
                class="h-[42px] w-full rounded-[8px] border border-[#d6e0ce] bg-[#fbfdfa] px-3 text-[12px] text-ink outline-none transition focus:border-forest focus:bg-white focus:ring-2 focus:ring-forest/15">
                <option value="Aktif" {{ old('status', $karyawan->status ?? 'Aktif') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="Nonaktif" {{ old('status', $karyawan->status ?? '') == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>
            @error('status')
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
            Simpan Data Karyawan
        </button>
        <a href="{{ route('karyawan.index') }}" class="button secondary">
            Batal
        </a>
    </div>
</div>
