@extends('layouts.app')

@section('title', 'Slip Gaji')

@section('content')
@php
$namaBulan = [
    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
];
$palette = [
    'bg-[#f9eee6] text-[#be9270]',
    'bg-[#f0ebf8] text-[#9581b7]',
    'bg-[#eaf0f8] text-[#6986ab]',
    'bg-[#eaf1e6] text-[#668258]',
    'bg-[#f6f1dd] text-[#b19b5c]',
];
@endphp

<section class="page-heading">
    <div>
        <div class="heading-eyebrow">DOKUMEN PAYROLL</div>
        <h1>Slip Gaji Karyawan</h1>
        <p>Daftar dan cetak dokumen slip gaji digital karyawan per periode pembayaran.</p>
    </div>
</section>

<div class="panel table-panel mb-8">
    <div class="table-heading">
        <div>
            <h2>
                Dokumen Slip Gaji
                <span class="count-badge">{{ count($slipGajis) }} dokumen</span>
            </h2>
            <p>Klik tombol aksi untuk melihat atau mengunduh PDF slip gaji resmi.</p>
        </div>
    </div>

    {{-- Table Toolbar Filter --}}
    <div class="table-toolbar">
        <label class="search-field">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="10.8" cy="10.8" r="7.3" />
                <path d="m16 16 5 5" />
            </svg>
            <input id="slip-search-input" oninput="filterSlipTable()" placeholder="Cari nama karyawan atau NIK..." />
        </label>

        <div class="table-filters">
            <select id="slip-month-filter" onchange="filterSlipTable()">
                <option value="">Semua Bulan</option>
                <option value="Januari">Januari</option>
                <option value="Februari">Februari</option>
                <option value="Maret">Maret</option>
                <option value="April">April</option>
                <option value="Mei">Mei</option>
                <option value="Juni">Juni</option>
                <option value="Juli">Juli</option>
                <option value="Agustus">Agustus</option>
                <option value="September">September</option>
                <option value="Oktober">Oktober</option>
                <option value="November">November</option>
                <option value="Desember">Desember</option>
            </select>
        </div>
    </div>

    <div class="table-scroll">
        <table id="slip-main-table">
            <thead>
                <tr>
                    <th style="width: 45px; text-align: center;">No</th>
                    <th>Karyawan</th>
                    <th>Jabatan</th>
                    <th>Periode</th>
                    <th>Gaji Bersih (THP)</th>
                    <th>Tanggal Dibayar</th>
                    <th style="text-align: center; width: 140px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($slipGajis as $index => $item)
                @php
                    $nama = $item->karyawan->nama ?? 'Karyawan';
                    $init = strtoupper(substr($nama, 0, 2));
                    $colorClass = $palette[$index % count($palette)];
                    $bln = is_numeric($item->bulan) ? ($namaBulan[(int)$item->bulan] ?? $item->bulan) : $item->bulan;
                @endphp
                <tr>
                    <td style="text-align: center; color: #9aa299; font-weight: 500;">
                        {{ $loop->iteration }}
                    </td>
                    <td>
                        <div class="employee-cell">
                            <span class="avatar {{ $colorClass }}">{{ $init }}</span>
                            <div>
                                <strong>{{ $nama }}</strong>
                                <small>NIK: {{ $item->karyawan->nik ?? '-' }}</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span style="font-weight: 550; color: #3d4a3e;">
                            {{ $item->karyawan->jabatan->nama_jabatan ?? '-' }}
                        </span>
                    </td>
                    <td>
                        <span style="color: #6a766c; font-size: 10.5px;">
                            {{ $bln }} {{ $item->tahun }}
                        </span>
                    </td>
                    <td>
                        <strong class="salary">Rp {{ number_format($item->thp, 0, ',', '.') }}</strong>
                    </td>
                    <td>
                        <span class="status-badge">
                            <span class="status-check">✓</span>
                            {{ \Carbon\Carbon::parse($item->tanggal_gaji)->translatedFormat('d F Y') }}
                        </span>
                    </td>
                    <td>
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('slip-gaji.show', $item->id) }}" class="button primary" style="padding: 5px 10px; font-size: 10px;" title="Lihat Slip Gaji">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                                <span>Lihat</span>
                            </a>
                            <a href="{{ route('slip-gaji.export', $item->id) }}" class="button secondary" style="padding: 5px 10px; font-size: 10px;" title="Unduh Dokumen PDF">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="7 10 12 15 17 10"></polyline>
                                    <line x1="12" y1="15" x2="12" y2="3"></line>
                                </svg>
                                <span>PDF</span>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="py-12 text-center text-[#8e988f]">
                        Belum ada dokumen slip gaji yang diproses.
                    </td>
                </tr>
                @endforelse
                <tr id="slip-empty-row" style="display: none;">
                    <td colspan="7" class="py-12 text-center text-[#8e988f]">
                        Tidak ada dokumen slip gaji yang sesuai dengan pencarian atau filter bulan.
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="table-footer">
        <strong id="slip-count-info">Total {{ count($slipGajis) }} slip terdata</strong>
        <span>Dokumen terverifikasi sistem</span>
    </div>
</div>

<script>
    function filterSlipTable() {
        const search = (document.getElementById('slip-search-input').value || '').toLowerCase();
        const month = (document.getElementById('slip-month-filter').value || '').toLowerCase();
        const table = document.getElementById('slip-main-table');
        const rows = table.querySelectorAll('tbody tr:not(#slip-empty-row)');
        const emptyRow = document.getElementById('slip-empty-row');
        let visibleCount = 0;

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            const matchesSearch = text.includes(search);
            const periodeCell = row.children[3] ? row.children[3].textContent.toLowerCase() : '';
            const matchesMonth = month === '' || periodeCell.includes(month);

            if (matchesSearch && matchesMonth) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        if (emptyRow) {
            emptyRow.style.display = visibleCount === 0 && rows.length > 0 ? '' : 'none';
        }

        const countInfo = document.getElementById('slip-count-info');
        if (countInfo) {
            countInfo.textContent = `Menampilkan ${visibleCount} dari {{ count($slipGajis) }} slip gaji`;
        }
    }
</script>
@endsection
