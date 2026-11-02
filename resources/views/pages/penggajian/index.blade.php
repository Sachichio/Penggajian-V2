@extends('layouts.app')

@section('title', 'Data Penggajian')

@section('content')
<section class="page-heading">
    <div>
        <div class="heading-eyebrow">MANAJEMEN PAYROLL</div>
        <h1>Data Penggajian</h1>
        <p>Kelola seluruh transaksi penggajian, rincian tunjangan, dan rekapitulasi gaji karyawan.</p>
    </div>
    <a href="{{ route('penggajian.create') }}" class="button primary">
        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 5v14M5 12h14" />
        </svg>
        Buat Penggajian
    </a>
</section>

@if(session('success'))
<div class="mb-5 flex items-center gap-2.5 rounded-[8px] border border-[#d6e5cd] bg-[#f2f8ed] px-4 py-3 text-[11.5px] font-medium text-[#3b6b47]">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-forest shrink-0">
        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
        <polyline points="22 4 12 14.01 9 11.01"></polyline>
    </svg>
    <span>{{ session('success') }}</span>
</div>
@endif

<div class="panel table-panel mb-8">
    <div class="table-heading">
        <div>
            <h2>
                Daftar Penggajian
                <span class="count-badge">{{ count($penggajians) }} transaksi</span>
            </h2>
            <p>Histori transaksi pembayaran gaji yang telah diproses.</p>
        </div>
    </div>

    {{-- Table Toolbar Filter --}}
    <div class="table-toolbar">
        <label class="search-field">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="10.8" cy="10.8" r="7.3" />
                <path d="m16 16 5 5" />
            </svg>
            <input id="penggajian-search-input" onkeyup="filterPenggajianTable()" placeholder="Cari nama karyawan atau NIK..." />
        </label>

        <div class="table-filters">
            <select id="penggajian-month-filter" onchange="filterPenggajianTable()">
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
        <table id="penggajian-main-table">
            <thead>
                <tr>
                    <th style="width: 45px; text-align: center;">No</th>
                    <th>Karyawan</th>
                    <th>Jabatan</th>
                    <th>Periode</th>
                    <th>Take Home Pay</th>
                    <th>Tanggal Gaji</th>
                    <th style="text-align: center; width: 140px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $namaBulanIndo = [
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
                @forelse($penggajians as $index => $penggajian)
                @php
                    $nama = $penggajian->karyawan->nama ?? 'Karyawan';
                    $init = strtoupper(substr($nama, 0, 2));
                    $colorClass = $palette[$index % count($palette)];
                    $bulanNama = is_numeric($penggajian->bulan) ? ($namaBulanIndo[(int)$penggajian->bulan] ?? $penggajian->bulan) : $penggajian->bulan;
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
                                <small>NIK: {{ $penggajian->karyawan->nik ?? '-' }}</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span style="font-weight: 550; color: #3d4a3e;">
                            {{ $penggajian->karyawan->jabatan->nama_jabatan ?? '-' }}
                        </span>
                    </td>
                    <td>
                        <span style="color: #6a766c; font-size: 10.5px;">
                            {{ $bulanNama }} {{ $penggajian->tahun }}
                        </span>
                    </td>
                    <td>
                        <strong class="salary">Rp {{ number_format($penggajian->thp, 0, ',', '.') }}</strong>
                    </td>
                    <td>
                        <span style="color: #7b8774; font-size: 10.5px;">
                            {{ \Carbon\Carbon::parse($penggajian->tanggal_gaji)->translatedFormat('d F Y') }}
                        </span>
                    </td>
                    <td>
                        <div class="flex items-center justify-center gap-1.5">
                            <a href="{{ route('penggajian.show', $penggajian->id) }}" class="action-icon-btn" title="Detail Penggajian">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </a>
                            <a href="{{ route('slip-gaji.show', $penggajian->id) }}" class="action-icon-btn" title="Cetak Slip">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                </svg>
                            </a>
                            <a href="{{ route('potongan.index', $penggajian->id) }}" class="action-icon-btn" title="Kelola Potongan">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                            </a>
                            <form action="{{ route('penggajian.destroy', $penggajian->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus data penggajian ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-icon-btn danger" title="Hapus Data">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="py-12 text-center text-[#8e988f]">
                        Belum ada data transaksi penggajian.
                    </td>
                </tr>
                @endforelse
                <tr id="penggajian-empty-row" style="display: none;">
                    <td colspan="7" class="py-12 text-center text-[#8e988f]">
                        Tidak ada transaksi penggajian yang sesuai dengan pencarian atau filter bulan.
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="table-footer">
        <strong id="penggajian-count-info">Total {{ count($penggajians) }} transaksi terdata</strong>
        <span>Sistem penggajian digital</span>
    </div>
</div>

<script>
    function filterPenggajianTable() {
        const search = (document.getElementById('penggajian-search-input').value || '').toLowerCase();
        const month = (document.getElementById('penggajian-month-filter').value || '').toLowerCase();
        const table = document.getElementById('penggajian-main-table');
        const rows = table.querySelectorAll('tbody tr:not(#penggajian-empty-row)');
        const emptyRow = document.getElementById('penggajian-empty-row');
        let visibleCount = 0;

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            const matchesSearch = text.includes(search);
            const matchesMonth = month === '' || text.includes(month);

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

        const countInfo = document.getElementById('penggajian-count-info');
        if (countInfo) {
            countInfo.textContent = `Menampilkan ${visibleCount} dari {{ count($penggajians) }} transaksi`;
        }
    }
</script>
@endsection
