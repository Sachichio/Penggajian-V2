@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
{{-- ========================================================= --}}
{{-- 1. HEADING HALAMAN (PERSIS GAMBAR 1)                      --}}
{{-- ========================================================= --}}
<section class="page-heading">
    <div>
        <div class="heading-eyebrow">WORKSPACE OVERVIEW</div>
        <h1>Semua lebih mudah, dalam satu dashboard.</h1>
        <p>Selamat datang kembali, Admin. Berikut ringkasan penggajian tim Anda.</p>
    </div>
    <a href="{{ route('penggajian.create') }}" class="button primary">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 5v14M5 12h14" />
        </svg>
        Buat Penggajian
    </a>
</section>

{{-- ========================================================= --}}
{{-- 2. 4 STAT CARDS (PERSIS GAMBAR 1)                         --}}
{{-- ========================================================= --}}
<section class="stats-grid">
    {{-- Card 1: Total Karyawan --}}
    <div class="stat-card">
        <div class="stat-top">
            <span>Total Karyawan</span>
            <span class="stat-icon green">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2m20 0v-2a4 4 0 0 0-3-3.87M16 3a4 4 0 0 1 0 8" />
                    <circle cx="9" cy="7" r="4" />
                </svg>
            </span>
        </div>
        <div class="stat-value">
            {{ $totalKaryawan }}
            <span>orang</span>
            <svg class="sparkline spark-0" width="92" height="36" viewBox="0 0 92 36" aria-hidden="true">
                <path d="M2 30 14 30 25 22 37 25 49 14 61 19 72 10 90 4" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
            </svg>
        </div>
        <div class="stat-bottom">
            <span class="trend-pill">
                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M5 16 17 4M5 4h12v12" />
                </svg>
                +2 karyawan
            </span>
            <span>dari bulan lalu</span>
        </div>
    </div>

    {{-- Card 2: Total Jabatan --}}
    <div class="stat-card">
        <div class="stat-top">
            <span>Total Jabatan</span>
            <span class="stat-icon blue">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="7" width="18" height="14" rx="2" />
                    <path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2M3 12a22 22 0 0 0 18 0M12 11v4" />
                </svg>
            </span>
        </div>
        <div class="stat-value">
            {{ $totalJabatan }}
            <span>jabatan</span>
            <svg class="sparkline spark-1" width="92" height="36" viewBox="0 0 92 36" aria-hidden="true">
                <path d="M2 30 14 23 25 26 37 14 49 19 61 10 72 12 90 3" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
            </svg>
        </div>
        <div class="stat-bottom">
            <span class="stat-indicator">
                <span class="small-dot"></span>
                Aktif
            </span>
            <span>di seluruh departemen</span>
        </div>
    </div>

    {{-- Card 3: Total Penggajian --}}
    <div class="stat-card">
        <div class="stat-top">
            <span>Total Penggajian</span>
            <span class="stat-icon purple">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 8V5a2 2 0 0 0-2-2L5 6a3 3 0 0 0 0 6h16v8H5a3 3 0 0 1-3-3V9m19 3V8H6" />
                    <path d="M17 15h4v3h-4z" />
                </svg>
            </span>
        </div>
        <div class="stat-value">
            {{ $totalPenggajian }}
            <span>transaksi</span>
            <svg class="sparkline spark-2" width="92" height="36" viewBox="0 0 92 36" aria-hidden="true">
                <path d="M2 30 14 30 25 22 37 25 49 14 61 19 72 10 90 4" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
            </svg>
        </div>
        <div class="stat-bottom">
            <span class="stat-indicator">
                <span class="small-dot"></span>
                100% selesai
            </span>
            <span>periode sebelumnya</span>
        </div>
    </div>

    {{-- Card 4: Total Pengguna --}}
    <div class="stat-card">
        <div class="stat-top">
            <span>Total Pengguna</span>
            <span class="stat-icon peach">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2m20 0v-2a4 4 0 0 0-3-3.87M16 3a4 4 0 0 1 0 8" />
                    <circle cx="9" cy="7" r="4" />
                </svg>
            </span>
        </div>
        <div class="stat-value">
            {{ $totalUser }}
            <span>pengguna</span>
            <svg class="sparkline spark-3" width="92" height="36" viewBox="0 0 92 36" aria-hidden="true">
                <path d="M2 30 14 23 25 26 37 14 49 19 61 10 72 12 90 3" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
            </svg>
        </div>
        <div class="stat-bottom">
            <span class="stat-indicator">
                <span class="small-dot"></span>
                2 akun aktif
            </span>
            <span>mengelola workspace</span>
        </div>
    </div>
</section>

{{-- ========================================================= --}}
{{-- 3. TABEL PENGGAJIAN TERBARU (PERSIS GAMBAR 2)             --}}
{{-- ========================================================= --}}
<section class="panel table-panel">
    {{-- Table Heading --}}
    <div class="table-heading">
        <div>
            <h2>
                Penggajian Terbaru
                <span class="count-badge">
                    {{ count($penggajianTerbaru) ?: 5 }} transaksi
                </span>
            </h2>
            <p>Daftar penggajian yang baru saja ditambahkan.</p>
        </div>
        <a href="{{ route('laporan.index') }}" class="button secondary export-button">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 3v12m-5-5 5 5 5-5M4 16v5h16v-5" />
            </svg>
            Ekspor Data
        </a>
    </div>

    {{-- Table Toolbar Filter --}}
    <div class="table-toolbar">
        <label class="search-field">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="10.8" cy="10.8" r="7.3" />
                <path d="m16 16 5 5" />
            </svg>
            <input id="payroll-search-input" onkeyup="filterTableRows()" placeholder="Cari nama karyawan..." />
            <span>⌘K</span>
        </label>

        <div class="table-filters">
            <select id="month-select-filter" onchange="filterTableRows()">
                <option value="">Semua bulan</option>
                <option value="Juli">Juli</option>
                <option value="Mei">Mei</option>
                <option value="Juni">Juni</option>
                <option value="Agustus">Agustus</option>
            </select>
        </div>
    </div>

    {{-- Table Scroll Area --}}
    <div class="table-scroll">
        <table id="payroll-main-table">
            <thead>
                <tr>
                    <th class="checkbox-cell">
                        <input type="checkbox" aria-label="Pilih semua data" />
                    </th>
                    <th>
                        Nama Karyawan
                        <svg class="inline-block ml-1 opacity-60" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m7 15 5 5 5-5M7 9l5-5 5 5" />
                        </svg>
                    </th>
                    <th>Periode</th>
                    <th>Take Home Pay</th>
                    <th>Tanggal Gaji</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @php
                    // Data referensi demo persis Gambar 2 jika belum ada transaksi di DB
                    $defaultRows = [
                        [
                            'name' => 'Nila Sadani',
                            'position' => 'Staff Administrasi',
                            'month' => 'Juli 2026',
                            'salary' => 'Rp 3.950.000',
                            'date' => '31 Juli 2026',
                            'initials' => 'NS',
                            'color' => 'bg-[#f9eee6] text-[#be9270]'
                        ],
                        [
                            'name' => 'Indro',
                            'position' => 'Manager Operasional',
                            'month' => 'Juli 2026',
                            'salary' => 'Rp 9.350.000',
                            'date' => '31 Juli 2026',
                            'initials' => 'IN',
                            'color' => 'bg-[#f0ebf8] text-[#9581b7]'
                        ],
                        [
                            'name' => 'Dinar Amala',
                            'position' => 'Staff Keuangan',
                            'month' => 'Mei 2026',
                            'salary' => 'Rp 3.675.000',
                            'date' => '31 Mei 2026',
                            'initials' => 'DA',
                            'color' => 'bg-[#eaf0f8] text-[#6986ab]'
                        ],
                        [
                            'name' => 'Nobi Nobita',
                            'position' => 'Manager HRD',
                            'month' => 'Juli 2026',
                            'salary' => 'Rp 9.350.000',
                            'date' => '31 Juli 2026',
                            'initials' => 'NN',
                            'color' => 'bg-[#eaf1e6] text-[#668258]'
                        ],
                        [
                            'name' => 'Dono',
                            'position' => 'Staff Operasional',
                            'month' => 'Mei 2026',
                            'salary' => 'Rp 4.550.000',
                            'date' => '31 Mei 2026',
                            'initials' => 'DO',
                            'color' => 'bg-[#f6f1dd] text-[#b19b5c]'
                        ],
                    ];

                    $hasRealData = count($penggajianTerbaru) > 0;
                    $palette = [
                        'bg-[#f9eee6] text-[#be9270]',
                        'bg-[#f0ebf8] text-[#9581b7]',
                        'bg-[#eaf0f8] text-[#6986ab]',
                        'bg-[#eaf1e6] text-[#668258]',
                        'bg-[#f6f1dd] text-[#b19b5c]',
                    ];
                @endphp

                @if($hasRealData)
                    @foreach($penggajianTerbaru as $index => $item)
                    @php
                        $nama = $item->karyawan->nama ?? 'Karyawan';
                        $jabatan = $item->karyawan->jabatan->nama_jabatan ?? 'Staff';
                        $init = strtoupper(substr($nama, 0, 2));
                        $colorClass = $palette[$index % count($palette)];
                        $bulanNama = is_numeric($item->bulan) ? ($namaBulanIndo[(int)$item->bulan] ?? 'Juli') : $item->bulan;
                        $periode = $bulanNama . ' ' . $item->tahun;
                        $thpFormatted = 'Rp ' . number_format($item->thp, 0, ',', '.');
                        $tgl = \Carbon\Carbon::parse($item->tanggal_gaji)->translatedFormat('d F Y');
                    @endphp
                    <tr>
                        <td class="checkbox-cell">
                            <input type="checkbox" />
                        </td>
                        <td>
                            <div class="employee-cell">
                                <span class="avatar {{ $colorClass }}">{{ $init }}</span>
                                <div>
                                    <strong>{{ $nama }}</strong>
                                    <small>{{ $jabatan }}</small>
                                </div>
                            </div>
                        </td>
                        <td class="periode-cell">{{ $periode }}</td>
                        <td class="salary">{{ $thpFormatted }}</td>
                        <td>{{ $tgl }}</td>
                        <td>
                            <span class="status-badge">
                                <span class="status-check">✓</span>
                                Dibayarkan
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('slip-gaji.show', $item->id) }}" class="row-more" title="Detail Slip Gaji">
                                •••
                            </a>
                        </td>
                    </tr>
                    @endforeach
                @else
                    @foreach($defaultRows as $row)
                    <tr>
                        <td class="checkbox-cell">
                            <input type="checkbox" />
                        </td>
                        <td>
                            <div class="employee-cell">
                                <span class="avatar {{ $row['color'] }}">{{ $row['initials'] }}</span>
                                <div>
                                    <strong>{{ $row['name'] }}</strong>
                                    <small>{{ $row['position'] }}</small>
                                </div>
                            </div>
                        </td>
                        <td class="periode-cell">{{ $row['month'] }}</td>
                        <td class="salary">{{ $row['salary'] }}</td>
                        <td>{{ $row['date'] }}</td>
                        <td>
                            <span class="status-badge">
                                <span class="status-check">✓</span>
                                Dibayarkan
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('penggajian.index') }}" class="row-more" title="Aksi">
                                •••
                            </a>
                        </td>
                    </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

    {{-- Table Footer --}}
    <div class="table-footer">
        <strong>Menampilkan 1–5 dari {{ $hasRealData ? $totalDataTersedia : '5' }} data</strong>
        <a href="{{ route('penggajian.index') }}">
            Lihat semua penggajian
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m9 5 7 7-7 7" />
            </svg>
        </a>
    </div>
</section>

{{-- ========================================================= --}}
{{-- 4. FOOTER HALAMAN (PERSIS GAMBAR 2)                       --}}
{{-- ========================================================= --}}
<footer class="main-footer">
    <span>© 2026 PT. Sejahtera Bersama</span>
    <span>
        <span><i></i> Sistem berjalan normal</span>
        <span class="footer-separator">•</span>
        <span>Made simple with <strong>gajiku.</strong></span>
    </span>
</footer>

<script>
    function filterTableRows() {
        const searchInput = (document.getElementById('payroll-search-input').value || '').toLowerCase();
        const monthSelect = (document.getElementById('month-select-filter').value || '').toLowerCase();
        const table = document.getElementById('payroll-main-table');
        const rows = table.querySelectorAll('tbody tr');

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            const periodeText = row.querySelector('.periode-cell') ? row.querySelector('.periode-cell').textContent.toLowerCase() : '';
            
            const matchesSearch = text.includes(searchInput);
            const matchesMonth = monthSelect === '' || periodeText.includes(monthSelect);

            if (matchesSearch && matchesMonth) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Shortcut ⌘K / Ctrl+K fokus ke pencarian
    document.addEventListener('keydown', function(e) {
        if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
            e.preventDefault();
            const input = document.getElementById('payroll-search-input');
            if (input) input.focus();
        }
    });
</script>
@endsection
