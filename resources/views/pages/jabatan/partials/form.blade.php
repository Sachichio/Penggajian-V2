<div class="space-y-6">

    {{-- Nama Jabatan --}}
    <div>

        <label class="block mb-2 font-semibold text-slate-700">
            Nama Jabatan
        </label>

        <input
            type="text"
            name="nama_jabatan"
            value="{{ old('nama_jabatan', $jabatan->nama_jabatan ?? '') }}"
            placeholder="Contoh : Staff Accounting"
            class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 outline-none">

        @error('nama_jabatan')

            <p class="text-red-500 text-sm mt-2">
                {{ $message }}
            </p>

        @enderror

    </div>

    {{-- Gaji Pokok --}}
    <div>

        <label class="block mb-2 font-semibold text-slate-700">
            Gaji Pokok
        </label>

        <input
            type="number"
            name="gaji_pokok"
            value="{{ old('gaji_pokok', $jabatan->gaji_pokok ?? '') }}"
            placeholder="4500000"
            class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 outline-none">

        @error('gaji_pokok')

            <p class="text-red-500 text-sm mt-2">
                {{ $message }}
            </p>

        @enderror

    </div>

    {{-- Tunjangan --}}
    <div>

        <label class="block mb-2 font-semibold text-slate-700">
            Tunjangan
        </label>

        <input
            type="number"
            name="tunjangan"
            value="{{ old('tunjangan', $jabatan->tunjangan ?? '') }}"
            placeholder="500000"
            class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 outline-none">

        @error('tunjangan')

            <p class="text-red-500 text-sm mt-2">
                {{ $message }}
            </p>

        @enderror

    </div>

    {{-- Tombol --}}
    <div class="pt-4">

        <button
            type="submit"
            class="bg-gradient-to-r from-cyan-600 to-blue-700 hover:from-cyan-700 hover:to-blue-800 text-white font-semibold px-6 py-3 rounded-2xl transition">

            Simpan

        </button>

    </div>

</div>