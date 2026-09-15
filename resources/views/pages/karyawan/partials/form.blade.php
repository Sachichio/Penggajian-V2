<div class="space-y-6">

    {{-- NIK --}}
    <div>

        <label class="block mb-2 font-semibold text-slate-700">
            NIK
        </label>

        <input
            type="text"
            name="nik"
            value="{{ old('nik', $karyawan->nik ?? '') }}"
            placeholder="CN-001"
            class="w-full rounded-xl border border-slate-300 px-4 py-3
                   focus:ring-2 focus:ring-cyan-300 focus:border-cyan-500 outline-none">

        @error('nik')
            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
        @enderror

    </div>

    {{-- Nama --}}
    <div>

        <label class="block mb-2 font-semibold text-slate-700">
            Nama Karyawan
        </label>

        <input
            type="text"
            name="nama"
            value="{{ old('nama', $karyawan->nama ?? '') }}"
            placeholder="Nama Karyawan"
            class="w-full rounded-xl border border-slate-300 px-4 py-3
                   focus:ring-2 focus:ring-cyan-300 focus:border-cyan-500 outline-none">

        @error('nama')
            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
        @enderror

    </div>

    {{-- Jabatan --}}
    <div>

        <label class="block mb-2 font-semibold text-slate-700">
            Jabatan
        </label>

        <select
            name="jabatan_id"
            class="w-full rounded-xl border border-slate-300 px-4 py-3
                   focus:ring-2 focus:ring-cyan-300 focus:border-cyan-500 outline-none">

            <option value="">
                -- Pilih Jabatan --
            </option>

            @foreach($jabatans as $jabatan)

                <option
                    value="{{ $jabatan->id }}"
                    {{ old('jabatan_id', $karyawan->jabatan_id ?? '') == $jabatan->id ? 'selected' : '' }}>

                    {{ $jabatan->nama_jabatan }}

                </option>

            @endforeach

        </select>

        @error('jabatan_id')
            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
        @enderror

    </div>

    {{-- Jenis Kelamin --}}
    <div>

        <label class="block mb-2 font-semibold text-slate-700">
            Jenis Kelamin
        </label>

        <select
            name="jenis_kelamin"
            class="w-full rounded-xl border border-slate-300 px-4 py-3
                   focus:ring-2 focus:ring-cyan-300 focus:border-cyan-500 outline-none">

            <option value="Laki-laki"
                {{ old('jenis_kelamin', $karyawan->jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : '' }}>
                Laki-laki
            </option>

            <option value="Perempuan"
                {{ old('jenis_kelamin', $karyawan->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>
                Perempuan
            </option>

        </select>

        @error('jenis_kelamin')
            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
        @enderror

    </div>

    {{-- Tanggal Masuk --}}
    <div>

        <label class="block mb-2 font-semibold text-slate-700">
            Tanggal Masuk
        </label>

        <input
            type="date"
            name="tanggal_masuk"
            value="{{ old('tanggal_masuk', $karyawan->tanggal_masuk ?? '') }}"
            class="w-full rounded-xl border border-slate-300 px-4 py-3
                   focus:ring-2 focus:ring-cyan-300 focus:border-cyan-500 outline-none">

        @error('tanggal_masuk')
            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
        @enderror

    </div>

    {{-- Status --}}
    <div>

        <label class="block mb-2 font-semibold text-slate-700">
            Status
        </label>

        <select
            name="status"
            class="w-full rounded-xl border border-slate-300 px-4 py-3
                   focus:ring-2 focus:ring-cyan-300 focus:border-cyan-500 outline-none">

            <option value="Aktif"
                {{ old('status', $karyawan->status ?? '') == 'Aktif' ? 'selected' : '' }}>
                Aktif
            </option>

            <option value="Nonaktif"
                {{ old('status', $karyawan->status ?? '') == 'Nonaktif' ? 'selected' : '' }}>
                Nonaktif
            </option>

        </select>

        @error('status')
            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
        @enderror

    </div>

    {{-- Tombol --}}
    <div class="pt-2">

        <button
            type="submit"
            class="bg-gradient-to-r from-cyan-600 to-blue-700
                   hover:from-cyan-700 hover:to-blue-800
                   text-white font-semibold
                   px-6 py-3 rounded-2xl transition">

            Simpan

        </button>

    </div>

</div>