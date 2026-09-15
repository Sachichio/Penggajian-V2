<link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">

<div class="space-y-6">

    {{-- Karyawan --}}
    <div>

        <label class="block mb-2 font-semibold text-slate-700">
            Karyawan
        </label>

        <select
            id="karyawan_id"
            name="karyawan_id"
            placeholder="Cari nama atau NIK karyawan..."
            class="w-full">

            <option value="">Cari Karyawan...</option>

            @foreach($karyawans as $karyawan)

                <option
                    value="{{ $karyawan->id }}"
                    {{ old('karyawan_id', $penggajian->karyawan_id ?? '') == $karyawan->id ? 'selected' : '' }}>

                    {{ $karyawan->nik }} - {{ $karyawan->nama }}

                </option>

            @endforeach

        </select>

        @error('karyawan_id')
            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
        @enderror

    </div>


    {{-- Bulan --}}
    <div>

        <label class="block mb-2 font-semibold text-slate-700">
            Bulan
        </label>

        <select
            name="bulan"
            class="w-full rounded-xl border border-slate-300 px-4 py-3
                focus:ring-2 focus:ring-cyan-300 focus:border-cyan-500 outline-none">

            @php
                $bulanList = [
                    1 => 'Januari',
                    2 => 'Februari',
                    3 => 'Maret',
                    4 => 'April',
                    5 => 'Mei',
                    6 => 'Juni',
                    7 => 'Juli',
                    8 => 'Agustus',
                    9 => 'September',
                    10 => 'Oktober',
                    11 => 'November',
                    12 => 'Desember',
                ];
            @endphp

            @foreach($bulanList as $angka => $nama)

                <option
                    value="{{ $angka }}"
                    {{ old('bulan', $penggajian->bulan ?? date('n')) == $angka ? 'selected' : '' }}>

                    {{ $nama }}

                </option>

            @endforeach

        </select>

        @error('bulan')
            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
        @enderror

    </div>

    {{-- Tahun --}}
    <div>

        <label class="block mb-2 font-semibold text-slate-700">
            Tahun
        </label>

        <input
            type="number"
            name="tahun"
            value="{{ old('tahun', $penggajian->tahun ?? date('Y')) }}"
            class="w-full rounded-xl border border-slate-300 px-4 py-3
                   focus:ring-2 focus:ring-cyan-300 focus:border-cyan-500 outline-none">

        @error('tahun')
            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
        @enderror

    </div>

    {{-- Jam Lembur --}}
    <div>

        <label class="block mb-2 font-semibold text-slate-700">
            Jam Lembur
        </label>

        <input
            id="jam_lembur"
            type="number"
            name="jam_lembur"
            value="{{ old('jam_lembur', $penggajian->jam_lembur ?? 0) }}"
            class="w-full rounded-xl border border-slate-300 px-4 py-3
                   focus:ring-2 focus:ring-cyan-300 focus:border-cyan-500 outline-none">

        @error('jam_lembur')
            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
        @enderror

    </div>

    {{-- Gaji Pokok --}}
    <div>

        <label class="block mb-2 font-semibold text-slate-700">
            Gaji Pokok
        </label>

        <input
            id="gaji_pokok"
            type="number"
            name="gaji_pokok"
            readonly
            value="{{ old('gaji_pokok', $penggajian->gaji_pokok ?? 0) }}"
            class="w-full rounded-xl border border-slate-300 px-4 py-3
                   focus:ring-2 focus:ring-cyan-300 focus:border-cyan-500 outline-none">

        @error('gaji_pokok')
            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
        @enderror

    </div>

    {{-- Tunjangan --}}
    <div>

        <label class="block mb-2 font-semibold text-slate-700">
            Tunjangan
        </label>

        <input
            id="tunjangan"
            type="number"
            name="tunjangan"
            readonly
            value="{{ old('tunjangan', $penggajian->tunjangan ?? 0) }}"
            class="w-full rounded-xl border border-slate-300 px-4 py-3
                   focus:ring-2 focus:ring-cyan-300 focus:border-cyan-500 outline-none">

        @error('tunjangan')
            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
        @enderror

    </div>

    {{-- Total Lembur --}}
    <div>

        <label class="block mb-2 font-semibold text-slate-700">
            Total Lembur
        </label>

        <input
            id="total_lembur"
            type="number"
            name="total_lembur"
            readonly
            value="{{ old('total_lembur', $penggajian->total_lembur ?? 0) }}"
            class="w-full rounded-xl border border-slate-300 px-4 py-3
                   focus:ring-2 focus:ring-cyan-300 focus:border-cyan-500 outline-none">

        @error('total_lembur')
            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
        @enderror

    </div>

    {{-- Total Pendapatan --}}
    <div>

        <label class="block mb-2 font-semibold text-slate-700">
            Total Pendapatan
        </label>

        <input
            id="total_pendapatan"
            type="number"
            name="total_pendapatan"
            readonly
            value="{{ old('total_pendapatan', $penggajian->total_pendapatan ?? 0) }}"
            class="w-full rounded-xl border border-slate-300 px-4 py-3
                   focus:ring-2 focus:ring-cyan-300 focus:border-cyan-500 outline-none">

        @error('total_pendapatan')
            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
        @enderror

    </div>


    {{-- Tanggal Gaji --}}
    <div>

        <label class="block mb-2 font-semibold text-slate-700">
            Tanggal Gaji
        </label>

        <input
            type="date"
            name="tanggal_gaji"
            value="{{ old('tanggal_gaji', $penggajian->tanggal_gaji ?? '') }}"
            class="w-full rounded-xl border border-slate-300 px-4 py-3
                   focus:ring-2 focus:ring-cyan-300 focus:border-cyan-500 outline-none">

        @error('tanggal_gaji')
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

<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

<script>

document.addEventListener('DOMContentLoaded', function () {

    new TomSelect("#karyawan_id", {
        create: false,
        sortField: {
            field: "text",
            direction: "asc"
        },
        maxOptions: 200,
        placeholder: "Cari nama atau NIK...",
    });

    const karyawan = document.getElementById('karyawan_id');
    const jamLembur = document.getElementById('jam_lembur');

    const gajiPokok = document.getElementById('gaji_pokok');
    const tunjangan = document.getElementById('tunjangan');
    const totalLembur = document.getElementById('total_lembur');
    const totalPendapatan = document.getElementById('total_pendapatan');
    const totalPotongan = document.getElementById('total_potongan');
    const thp = document.getElementById('thp');

    const TARIF_LEMBUR = 25000;

    function hitungGaji() {

        let gp = parseFloat(gajiPokok.value) || 0;
        let tj = parseFloat(tunjangan.value) || 0;
        let jam = parseFloat(jamLembur.value) || 0;

        let lembur = jam * TARIF_LEMBUR;

        totalLembur.value = lembur;

        let pendapatan = gp + tj + lembur;

        totalPendapatan.value = pendapatan;

        let potongan = parseFloat(totalPotongan.value) || 0;

        thp.value = pendapatan - potongan;

    }

    karyawan.addEventListener('change', function () {

        if (!this.value) {

            gajiPokok.value = 0;
            tunjangan.value = 0;

            hitungGaji();

            return;
        }

        fetch('/penggajian/get-karyawan/' + this.value)

            .then(res => res.json())

            .then(data => {

                gajiPokok.value = data.gaji_pokok;
                tunjangan.value = data.tunjangan;

                hitungGaji();

            });

    });

    jamLembur.addEventListener('input', hitungGaji);
    
});

</script>