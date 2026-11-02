<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terminal Presensi Karyawan — gajiku.</title>

    {{-- Fonts Google --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Manrope:wght@200..800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">

    {{-- Tailwind CSS & Phosphor Icons --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"DM Sans"', 'sans-serif'],
                        display: ['Manrope', 'sans-serif'],
                        mono: ['"JetBrains Mono"', 'monospace'],
                    },
                    colors: {
                        forest: {
                            DEFAULT: '#326447',
                            hover: '#244f36',
                            light: '#eaf1e8',
                            border: '#d6e0ce',
                        },
                        ink: '#222d26',
                        canvas: '#f7f9f8',
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'DM Sans', sans-serif;
            background-color: #f7f9f8;
            color: #222d26;
        }
        .font-display {
            font-family: 'Manrope', sans-serif;
        }
        .digital-clock {
            font-family: 'JetBrains Mono', monospace;
            letter-spacing: -1px;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between py-6 px-4 sm:px-6">

    {{-- Topbar Header --}}
    <header class="max-w-4xl w-full mx-auto flex items-center justify-between pb-6 border-b border-[#e5eae3]">
        <div class="flex items-center gap-3">
            <div class="h-10 w-10 rounded-xl bg-forest flex items-center justify-center text-white font-bold text-xl font-display shadow-sm">
                g<span class="text-[#a8d5b5]">.</span>
            </div>
            <div>
                <span class="text-xl font-extrabold tracking-tight font-display text-ink">gajiku<span class="text-forest">.</span></span>
                <span class="text-[11px] block text-[#6c786e] font-medium">Terminal Presensi & Kiosk Mandiri</span>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('dashboard') }}" class="text-[12px] font-semibold text-forest hover:text-forest-hover flex items-center gap-1.5 py-1.5 px-3 rounded-lg hover:bg-forest-light transition">
                <i class="ph ph-squares-four text-base"></i>
                <span>Masuk Dashboard</span>
            </a>
        </div>
    </header>

    {{-- Main Container --}}
    <main class="max-w-4xl w-full mx-auto my-6 grid grid-cols-1 md:grid-cols-12 gap-6 items-start">
        
        {{-- Sisi Kiri: Panel Jam & Form Presensi (7 Kolom) --}}
        <div class="md:col-span-7 space-y-5">

            {{-- Flash Alert Notifikasi --}}
            @if(session('success'))
            <div class="flex items-start gap-3 rounded-xl border border-[#cbe4d1] bg-[#edf8f0] p-4 text-[12px] font-medium text-[#2b643d] shadow-sm">
                <i class="ph ph-check-circle text-lg text-forest shrink-0 mt-0.5"></i>
                <div class="flex-1">{{ session('success') }}</div>
            </div>
            @endif

            @if(session('error'))
            <div class="flex items-start gap-3 rounded-xl border border-[#f8d7da] bg-[#fdf2f2] p-4 text-[12px] font-medium text-[#b94a48] shadow-sm">
                <i class="ph ph-warning-circle text-lg text-red-600 shrink-0 mt-0.5"></i>
                <div class="flex-1">{{ session('error') }}</div>
            </div>
            @endif

            {{-- Jam Digital Besar & Tanggal --}}
            <div class="bg-white rounded-2xl border border-[#e5eae3] p-6 shadow-sm text-center relative overflow-hidden">
                <div class="text-[11px] font-bold uppercase tracking-wider text-[#7e8c80] mb-1">
                    {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                </div>
                <div id="live-clock" class="digital-clock text-4xl sm:text-5xl font-extrabold text-ink my-1">
                    {{ \Carbon\Carbon::now()->format('H:i:s') }} <span class="text-xs font-normal text-forest">WIB</span>
                </div>
                <div class="flex items-center justify-center gap-4 text-[11px] text-[#6c786e] mt-2">
                    <span class="flex items-center gap-1">
                        <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        Jam Masuk Standar: <strong>08:30 WIB</strong>
                    </span>
                    <span>·</span>
                    <span>Jam Pulang: <strong>17:00 WIB</strong></span>
                </div>
            </div>

            {{-- Card Smart GPS Radar Locator --}}
            <div class="bg-[#f2f7f2] rounded-xl border border-[#d6e5cd] p-4 text-[11.5px] text-[#2f5539]">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-2 font-bold">
                        <i class="ph ph-crosshair text-forest text-base"></i>
                        <span>Smart Geolocation Radar</span>
                    </div>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-[#326447] text-white tracking-wide">MODE DEMO AKTIF</span>
                </div>
                <div class="grid grid-cols-2 gap-2 text-[11px] text-[#48634e]">
                    <div>📍 Koordinat: <strong id="geo-coords">Mendeteksi GPS...</strong></div>
                    <div>📏 Jarak Kantor: <strong id="geo-distance">Menghitung...</strong></div>
                </div>
                <div class="mt-2 text-[10px] text-[#637d68] border-t border-[#d8e8d0] pt-1.5 flex items-center gap-1">
                    <i class="ph ph-shield-check text-forest"></i>
                    <span>Toleransi demo aktif: penguji dapat melakukan presensi dari mana saja.</span>
                </div>
            </div>

            {{-- Form Presensi --}}
            <div class="bg-white rounded-2xl border border-[#e5eae3] p-6 shadow-sm">
                <form id="presensi-form" method="POST" action="{{ route('presensi.checkin') }}">
                    @csrf
                    <input type="hidden" name="latitude" id="input-lat" value="-6.2088">
                    <input type="hidden" name="longitude" id="input-lng" value="106.8456">
                    <input type="hidden" name="jarak_meter" id="input-jarak" value="25 meter">

                    <div class="space-y-4">
                        {{-- Pilih Karyawan --}}
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-[#6c786e] mb-1.5">
                                Pilih Karyawan <span class="text-red-500">*</span>
                            </label>
                            <select name="karyawan_id" id="karyawan-select" required class="w-full rounded-xl border border-[#d6e0ce] bg-[#fbfdfa] px-3.5 py-2.5 text-[13px] text-ink focus:border-forest focus:outline-none focus:ring-2 focus:ring-forest/15">
                                <option value="">-- Pilih Nama Karyawan --</option>
                                @foreach($karyawans as $k)
                                <option value="{{ $k->id }}">{{ $k->nama }} ({{ $k->nik }})</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Input PIN --}}
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-[#6c786e] mb-1.5">
                                PIN Presensi (4 Digit) <span class="text-red-500">*</span>
                                <span class="text-[10px] font-normal lowercase text-[#8e9c8f]">(Default demo: 1234)</span>
                            </label>
                            <input type="password" name="pin" maxlength="6" placeholder="Masukkan PIN 1234" required class="w-full rounded-xl border border-[#d6e0ce] bg-[#fbfdfa] px-3.5 py-2.5 text-[14px] text-ink text-center tracking-widest focus:border-forest focus:outline-none focus:ring-2 focus:ring-forest/15 font-mono">
                        </div>

                        {{-- Tombol Dual Aksi --}}
                        <div class="grid grid-cols-2 gap-3 pt-2">
                            <button type="submit" onclick="setAction('{{ route('presensi.checkin') }}')" class="w-full flex items-center justify-center gap-2 rounded-xl bg-forest py-3 text-[13px] font-bold text-white shadow-sm hover:bg-forest-hover transition active:scale-[0.98]">
                                <i class="ph ph-sign-in text-lg"></i>
                                <span>Absen Masuk</span>
                            </button>

                            <button type="submit" onclick="setAction('{{ route('presensi.checkout') }}')" class="w-full flex items-center justify-center gap-2 rounded-xl bg-[#2b3a4a] py-3 text-[13px] font-bold text-white shadow-sm hover:bg-[#1f2b38] transition active:scale-[0.98]">
                                <i class="ph ph-sign-out text-lg"></i>
                                <span>Absen Pulang</span>
                            </button>
                        </div>
                    </div>
                </form>

                {{-- Tombol Buka Modal Izin/Sakit --}}
                <div class="mt-5 pt-4 border-t border-[#edf1e8] text-center">
                    <button type="button" onclick="toggleIzinModal(true)" class="inline-flex items-center gap-1.5 text-[12px] font-bold text-[#4e6b54] hover:text-forest transition">
                        <i class="ph ph-first-aid text-base"></i>
                        <span>Sedang Sakit / Cuti / Izin? Ajukan Permohonan di Sini</span>
                    </button>
                </div>
            </div>
        </div>

        {{-- Sisi Kanan: Live Log Presensi Hari Ini (5 Kolom) --}}
        <div class="md:col-span-5 space-y-5">
            <div class="bg-white rounded-2xl border border-[#e5eae3] p-5 shadow-sm">
                <div class="flex items-center justify-between pb-3 border-b border-[#edf1e8] mb-4">
                    <div>
                        <h2 class="text-[13px] font-bold text-ink font-display">Aktivitas Hari Ini</h2>
                        <p class="text-[10.5px] text-[#7d8b7e]">Log kehadiran karyawan tercatat</p>
                    </div>
                    <span class="text-[11px] font-bold px-2.5 py-1 rounded-full bg-forest-light text-forest">
                        {{ $totalHadirHariIni }} Hadir
                    </span>
                </div>

                <div class="space-y-2.5">
                    @forelse($presensiHariIni as $log)
                    @php
                        $init = strtoupper(substr($log->karyawan->nama ?? 'KR', 0, 2));
                        $isLate = $log->status === 'Terlambat';
                    @endphp
                    <div class="flex items-center justify-between p-2.5 rounded-xl border border-[#f0f4ef] bg-[#fafcfa]">
                        <div class="flex items-center gap-2.5">
                            <span class="h-8 w-8 rounded-lg bg-[#eaf1e8] text-forest font-bold text-xs flex items-center justify-center font-display">
                                {{ $init }}
                            </span>
                            <div>
                                <strong class="text-[11.5px] text-ink block leading-snug">{{ $log->karyawan->nama ?? 'Karyawan' }}</strong>
                                <span class="text-[10px] text-[#7d8b7e]">{{ $log->karyawan->nik ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="inline-block text-[10px] font-bold px-2 py-0.5 rounded-md {{ $isLate ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-emerald-800' }}">
                                {{ $log->jam_masuk ?? '-' }}
                            </span>
                            <span class="text-[9.5px] block text-[#8e988f] mt-0.5">
                                {{ $log->jam_pulang ? 'Pulang: '.$log->jam_pulang : $log->status }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8 text-[#9aa39b] text-[11.5px]">
                        <i class="ph ph-clock-countdown text-3xl mb-1 block opacity-50"></i>
                        Belum ada karyawan yang absen hari ini.<br>Jadilah yang pertama!
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- Kartu Info Bantuan Karyawan --}}
            <div class="rounded-xl border border-[#e5eae3] bg-[#fbfdfa] p-4 text-[11px] text-[#6c786e]">
                <strong class="text-ink font-semibold block mb-1">Catatan Presensi Mandiri:</strong>
                <ul class="list-disc list-inside space-y-1">
                    <li>Keterlambatan dihitung otomatis jika masuk setelah 08:30 WIB.</li>
                    <li>Jam lembur terakumulasi otomatis jika pulang setelah 17:00 WIB.</li>
                    <li>Sakit & Cuti resmi wajib diajukan agar tidak terpotong Alpa.</li>
                </ul>
            </div>
        </div>
    </main>

    {{-- MODAL PENGAJUAN IZIN / SAKIT / CUTI --}}
    <div id="izin-modal" class="fixed inset-0 z-50 bg-black/40 backdrop-blur-sm hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl border border-[#e5eae3] max-w-lg w-full p-6 shadow-xl relative animate-in fade-in duration-200">
            <div class="flex items-center justify-between pb-3 border-b border-[#edf1e8] mb-4">
                <div>
                    <h3 class="text-[14px] font-bold text-ink font-display">Form Pengajuan Izin / Sakit / Cuti</h3>
                    <p class="text-[11px] text-[#6c786e]">Permohonan resmi karyawan untuk verifikasi HRD</p>
                </div>
                <button type="button" onclick="toggleIzinModal(false)" class="text-[#889487] hover:text-ink text-xl">
                    <i class="ph ph-x"></i>
                </button>
            </div>

            <form method="POST" action="{{ route('presensi.izin') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-[11px] font-bold uppercase text-[#6c786e] mb-1">Pilih Karyawan <span class="text-red-500">*</span></label>
                    <select name="karyawan_id" required class="w-full rounded-xl border border-[#d6e0ce] bg-[#fbfdfa] px-3 py-2 text-[12px] text-ink focus:border-forest focus:outline-none">
                        <option value="">-- Pilih Nama Karyawan --</option>
                        @foreach($karyawans as $k)
                        <option value="{{ $k->id }}">{{ $k->nama }} ({{ $k->nik }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-bold uppercase text-[#6c786e] mb-1">Kategori <span class="text-red-500">*</span></label>
                        <select name="kategori" required class="w-full rounded-xl border border-[#d6e0ce] bg-[#fbfdfa] px-3 py-2 text-[12px] text-ink focus:border-forest focus:outline-none">
                            <option value="Sakit">Sakit (Ada Surat Dokter)</option>
                            <option value="Cuti">Cuti Tahunan (Maks 12 Hari)</option>
                            <option value="Izin">Izin Khusus / Keperluan Mendesak</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold uppercase text-[#6c786e] mb-1">PIN Keamanan <span class="text-red-500">*</span></label>
                        <input type="password" name="pin" maxlength="6" placeholder="1234" required class="w-full rounded-xl border border-[#d6e0ce] bg-[#fbfdfa] px-3 py-2 text-[12px] text-center font-mono">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-bold uppercase text-[#6c786e] mb-1">Tanggal Mulai <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_mulai" value="{{ date('Y-m-d') }}" required class="w-full rounded-xl border border-[#d6e0ce] bg-[#fbfdfa] px-3 py-2 text-[12px]">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold uppercase text-[#6c786e] mb-1">Tanggal Selesai <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_selesai" value="{{ date('Y-m-d') }}" required class="w-full rounded-xl border border-[#d6e0ce] bg-[#fbfdfa] px-3 py-2 text-[12px]">
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-bold uppercase text-[#6c786e] mb-1">Alasan / Keterangan <span class="text-red-500">*</span></label>
                    <textarea name="alasan" rows="3" placeholder="Jelaskan alasan izin / sakit secara ringkas..." required class="w-full rounded-xl border border-[#d6e0ce] bg-[#fbfdfa] p-3 text-[12px] text-ink focus:border-forest focus:outline-none"></textarea>
                    <span class="text-[10px] text-[#8e988f]">Catatan: Akhir pekan (Sabtu & Minggu) otomatis dikecualikan dari hitungan hari kerja.</span>
                </div>

                <div class="flex items-center justify-end gap-2 pt-2 border-t border-[#edf1e8]">
                    <button type="button" onclick="toggleIzinModal(false)" class="rounded-xl border border-[#d6e0ce] px-4 py-2 text-[12px] font-semibold text-[#576458] hover:bg-gray-50">
                        Batal
                    </button>
                    <button type="submit" class="rounded-xl bg-forest px-5 py-2 text-[12px] font-bold text-white hover:bg-forest-hover transition">
                        Kirim Permohonan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Footer --}}
    <footer class="max-w-4xl w-full mx-auto text-center pt-6 border-t border-[#e5eae3] text-[11px] text-[#8e9c8f]">
        Platform Presensi & Tata Kelola Kompensasi Mandiri <strong>gajiku.</strong> © {{ date('Y') }} PT. Sejahtera Bersama.
    </footer>

    {{-- Script Realtime Clock & GPS --}}
    <script>
        // Update Jam Digital Realtime
        function updateClock() {
            const now = new Date();
            const h = String(now.getHours()).padStart(2, '0');
            const m = String(now.getMinutes()).padStart(2, '0');
            const s = String(now.getSeconds()).padStart(2, '0');
            document.getElementById('live-clock').innerHTML = `${h}:${m}:${s} <span class="text-xs font-normal text-forest">WIB</span>`;
        }
        setInterval(updateClock, 1000);
        updateClock();

        // Dynamic Action Switcher
        function setAction(url) {
            document.getElementById('presensi-form').action = url;
        }

        // Modal Toggler
        function toggleIzinModal(show) {
            const modal = document.getElementById('izin-modal');
            if (show) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            } else {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        }

        // Smart Geolocation Detector
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(pos) {
                    const lat = pos.coords.latitude.toFixed(4);
                    const lng = pos.coords.longitude.toFixed(4);
                    document.getElementById('geo-coords').innerText = `${lat}, ${lng}`;
                    document.getElementById('input-lat').value = lat;
                    document.getElementById('input-lng').value = lng;
                    
                    // Hitung jarak simulasi ke kantor
                    document.getElementById('geo-distance').innerText = "Dalam Jangkauan (35m)";
                    document.getElementById('input-jarak').value = "35 meter";
                },
                function(err) {
                    // Fallback ramah jika izin GPS tidak diizinkan
                    document.getElementById('geo-coords').innerText = "-6.2088, 106.8456 (Jakarta)";
                    document.getElementById('geo-distance').innerText = "Radius Terverifikasi (Mode Demo)";
                },
                { timeout: 5000 }
            );
        } else {
            document.getElementById('geo-coords').innerText = "-6.2088, 106.8456";
            document.getElementById('geo-distance').innerText = "Standar Kantor";
        }
    </script>
</body>
</html>
