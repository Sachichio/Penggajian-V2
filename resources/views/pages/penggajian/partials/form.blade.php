<link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">

<div class="space-y-5">
    {{-- Grid: Karyawan, Bulan, Tahun --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
        {{-- Karyawan --}}
        <div>
            <label class="mb-1.5 block text-[11.5px] font-semibold text-[#44533c]">
                Karyawan <span class="text-red-500">*</span>
            </label>
            <select
                id="karyawan_id"
                name="karyawan_id"
                required
                class="w-full">
                <option value="">Pilih Karyawan...</option>
                @foreach($karyawans as $karyawan)
                    <option
                        value="{{ $karyawan->id }}"
                        {{ old('karyawan_id', $penggajian->karyawan_id ?? '') == $karyawan->id ? 'selected' : '' }}>
                        {{ $karyawan->nik }} - {{ $karyawan->nama }}
                    </option>
                @endforeach
            </select>
            @error('karyawan_id')
                <p class="text-red-600 text-[10.5px] mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Bulan --}}
        <div>
            <label class="mb-1.5 block text-[11.5px] font-semibold text-[#44533c]">
                Bulan Penggajian <span class="text-red-500">*</span>
            </label>
            <select
                name="bulan"
                required
                class="h-[42px] w-full rounded-[8px] border border-[#d6e0ce] bg-[#fbfdfa] px-3 text-[12px] text-ink outline-none transition focus:border-forest focus:bg-white focus:ring-2 focus:ring-forest/15">
                @php
                    $bulanList = [
                        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
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
                <p class="text-red-600 text-[10.5px] mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tahun --}}
        <div>
            <label class="mb-1.5 block text-[11.5px] font-semibold text-[#44533c]">
                Tahun <span class="text-red-500">*</span>
            </label>
            <input
                type="number"
                name="tahun"
                value="{{ old('tahun', $penggajian->tahun ?? date('Y')) }}"
                required
                class="h-[42px] w-full rounded-[8px] border border-[#d6e0ce] bg-[#fbfdfa] px-3 text-[12px] text-ink outline-none transition focus:border-forest focus:bg-white focus:ring-2 focus:ring-forest/15">
            @error('tahun')
                <p class="text-red-600 text-[10.5px] mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    {{-- Grid: Tanggal Gaji & Jam Lembur --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div>
            <label class="mb-1.5 block text-[11.5px] font-semibold text-[#44533c]">
                Tanggal Pembayaran Gaji <span class="text-red-500">*</span>
            </label>
            <input
                type="date"
                name="tanggal_gaji"
                value="{{ old('tanggal_gaji', $penggajian->tanggal_gaji ?? date('Y-m-d')) }}"
                required
                class="h-[42px] w-full rounded-[8px] border border-[#d6e0ce] bg-[#fbfdfa] px-3 text-[12px] text-ink outline-none transition focus:border-forest focus:bg-white focus:ring-2 focus:ring-forest/15">
            @error('tanggal_gaji')
                <p class="text-red-600 text-[10.5px] mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="mb-1.5 block text-[11.5px] font-semibold text-[#44533c]">
                Jam Lembur (Tarif: Rp 25.000 / jam) <span class="text-red-500">*</span>
            </label>
            <input
                id="jam_lembur"
                type="number"
                name="jam_lembur"
                min="0"
                value="{{ old('jam_lembur', $penggajian->jam_lembur ?? 0) }}"
                required
                class="h-[42px] w-full rounded-[8px] border border-[#d6e0ce] bg-[#fbfdfa] px-3 text-[12px] text-ink outline-none transition focus:border-forest focus:bg-white focus:ring-2 focus:ring-forest/15">
            @error('jam_lembur')
                <p class="text-red-600 text-[10.5px] mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    {{-- Rincian Otomatis --}}
    <div class="rounded-lg border border-[#e5eae3] bg-[#fbfdfa] p-4 mt-2">
        <p class="text-[11px] font-bold uppercase tracking-wider text-forest mb-3">Rincian Kompensasi Otomatis</p>
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-3 text-[11.5px]">
            <div>
                <label class="text-[#8e988f] block mb-1">Gaji Pokok</label>
                <input id="gaji_pokok" type="number" name="gaji_pokok" readonly value="{{ old('gaji_pokok', $penggajian->gaji_pokok ?? 0) }}" class="h-[36px] w-full rounded-[6px] border border-[#e5eae3] bg-white px-2.5 font-semibold text-[#2b382d] outline-none">
            </div>
            <div>
                <label class="text-[#8e988f] block mb-1">Tunjangan</label>
                <input id="tunjangan" type="number" name="tunjangan" readonly value="{{ old('tunjangan', $penggajian->tunjangan ?? 0) }}" class="h-[36px] w-full rounded-[6px] border border-[#e5eae3] bg-white px-2.5 font-semibold text-[#2b382d] outline-none">
            </div>
            <div>
                <label class="text-[#8e988f] block mb-1">Total Uang Lembur</label>
                <input id="total_lembur" type="number" name="total_lembur" readonly value="{{ old('total_lembur', $penggajian->total_lembur ?? 0) }}" class="h-[36px] w-full rounded-[6px] border border-[#e5eae3] bg-white px-2.5 font-semibold text-forest outline-none">
            </div>
            <div>
                <label class="text-[#8e988f] block mb-1">Total Pendapatan</label>
                <input id="total_pendapatan" type="number" name="total_pendapatan" readonly value="{{ old('total_pendapatan', $penggajian->total_pendapatan ?? 0) }}" class="h-[36px] w-full rounded-[6px] border border-[#d6e5cd] bg-[#f5f9f0] px-2.5 font-bold text-[#2a593d] outline-none">
            </div>
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
            Simpan Transaksi Penggajian
        </button>
        <a href="{{ route('penggajian.index') }}" class="button secondary">
            Batal
        </a>
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
        placeholder: "Cari nama atau NIK karyawan...",
    });

    const karyawan = document.getElementById('karyawan_id');
    const jamLembur = document.getElementById('jam_lembur');
    const gajiPokok = document.getElementById('gaji_pokok');
    const tunjangan = document.getElementById('tunjangan');
    const totalLembur = document.getElementById('total_lembur');
    const totalPendapatan = document.getElementById('total_pendapatan');

    const TARIF_LEMBUR = 25000;

    function hitungGaji() {
        let gp = parseFloat(gajiPokok.value) || 0;
        let tj = parseFloat(tunjangan.value) || 0;
        let jam = parseFloat(jamLembur.value) || 0;

        let lembur = jam * TARIF_LEMBUR;
        totalLembur.value = lembur;

        let pendapatan = gp + tj + lembur;
        totalPendapatan.value = pendapatan;
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
                gajiPokok.value = data.gaji_pokok || 0;
                tunjangan.value = data.tunjangan || 0;
                
                // Ambil info absensi otomatis (Fase 3 Attendance Integration)
                const bulanVal = document.querySelector('select[name="bulan"]').value;
                const tahunVal = document.querySelector('input[name="tahun"]').value;
                if (bulanVal && tahunVal) {
                    fetch(`/api/karyawan/${this.value}/attendance-summary?bulan=${bulanVal}&tahun=${tahunVal}`)
                        .then(r => r.json())
                        .then(att => {
                            if (att.jam_lembur !== undefined) {
                                jamLembur.value = att.jam_lembur;
                            }
                            hitungGaji();
                        })
                        .catch(() => hitungGaji());
                } else {
                    hitungGaji();
                }
            })
            .catch(() => {
                hitungGaji();
            });
    });

    jamLembur.addEventListener('input', hitungGaji);
});
</script>
