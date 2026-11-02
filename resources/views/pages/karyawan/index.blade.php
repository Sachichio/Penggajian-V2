@extends('layouts.app')

@section('title', 'Data Karyawan')

@section('content')
{{-- ========================================================= --}}
{{-- 1. HEADING HALAMAN (IDENTIK DASHBOARD GAJIKU)              --}}
{{-- ========================================================= --}}
<section class="page-heading">
    <div>
        <div class="heading-eyebrow">DATA MASTER</div>
        <h1>Data Karyawan</h1>
        <p>Kelola seluruh data karyawan, penugasan jabatan, dan status kepegawaian perusahaan.</p>
    </div>
    <a href="{{ route('karyawan.create') }}" class="button primary">
        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 5v14M5 12h14" />
        </svg>
        Tambah Karyawan
    </a>
</section>

{{-- Pesan Sukses / Notifikasi --}}
@if(session('success'))
<div class="mb-5 flex items-center gap-2.5 rounded-[8px] border border-[#d6e5cd] bg-[#f2f8ed] px-4 py-3 text-[11.5px] font-medium text-[#3b6b47]">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-forest shrink-0">
        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
        <polyline points="22 4 12 14.01 9 11.01"></polyline>
    </svg>
    <span>{{ session('success') }}</span>
</div>
@endif

{{-- ========================================================= --}}
{{-- 2. TABEL PANEL GAJIKU                                     --}}
{{-- ========================================================= --}}
<div class="panel table-panel mb-8">
    {{-- Table Heading --}}
    <div class="table-heading">
        <div>
            <h2>
                Daftar Karyawan
                <span class="count-badge">
                    {{ count($karyawans) }} karyawan
                </span>
            </h2>
            <p>Daftar seluruh karyawan aktif dan nonaktif yang terdaftar di workspace.</p>
        </div>
    </div>

    {{-- Table Toolbar Filter --}}
    <div class="table-toolbar">
        <label class="search-field">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="10.8" cy="10.8" r="7.3" />
                <path d="m16 16 5 5" />
            </svg>
            <input id="karyawan-search-input" onkeyup="filterKaryawanTable()" placeholder="Cari nama atau NIK karyawan..." />
        </label>

        <div class="table-filters" style="display: flex; gap: 8px;">
            <select id="karyawan-status-filter" onchange="filterKaryawanTable()">
                <option value="">Semua Status</option>
                <option value="Aktif">Aktif</option>
                <option value="Nonaktif">Nonaktif</option>
            </select>
        </div>
    </div>

    {{-- Table Scroll --}}
    <div class="table-scroll">
        <table id="karyawan-main-table">
            <thead>
                <tr>
                    <th style="width: 50px; text-align: center;">No</th>
                    <th>Karyawan</th>
                    <th>Jabatan</th>
                    <th style="text-align: center;">Jenis Kelamin</th>
                    <th style="text-align: center;">Status</th>
                    <th style="text-align: center; width: 120px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $palette = [
                        'bg-[#f9eee6] text-[#be9270]',
                        'bg-[#f0ebf8] text-[#9581b7]',
                        'bg-[#eaf0f8] text-[#6986ab]',
                        'bg-[#eaf1e6] text-[#668258]',
                        'bg-[#f6f1dd] text-[#b19b5c]',
                    ];
                @endphp
                @forelse($karyawans as $index => $item)
                @php
                    $init = strtoupper(substr($item->nama, 0, 2));
                    $colorClass = $palette[$index % count($palette)];
                @endphp
                <tr>
                    <td style="text-align: center; color: #9aa299; font-weight: 500;">
                        {{ $loop->iteration }}
                    </td>
                    <td>
                        <div class="employee-cell">
                            <span class="avatar {{ $colorClass }}">{{ $init }}</span>
                            <div>
                                <strong>{{ $item->nama }}</strong>
                                <small>NIK: {{ $item->nik }}</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span style="font-weight: 550; color: #3d4a3e;">
                            {{ $item->jabatan->nama_jabatan ?? '-' }}
                        </span>
                    </td>
                    <td style="text-align: center;">
                        <span style="color: #6a766c; font-size: 10.5px;">
                            {{ $item->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                        </span>
                    </td>
                    <td style="text-align: center;">
                        @if($item->status == 'Aktif')
                            <span class="status-badge">
                                <span class="status-check">✓</span>
                                Aktif
                            </span>
                        @else
                            <span class="status-badge-rose">
                                <span style="display:inline-block; width:5px; height:5px; border-radius:50%; background:#b94a48;"></span>
                                Nonaktif
                            </span>
                        @endif
                    </td>
                    <td>
                        <div class="flex items-center justify-center gap-1.5">
                            <a href="{{ route('karyawan.show', $item->id) }}" class="action-icon-btn" title="Detail Karyawan">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </a>
                            <a href="{{ route('karyawan.edit', $item->id) }}" class="action-icon-btn" title="Edit Data">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg>
                            </a>
                            <form action="{{ route('karyawan.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus data karyawan {{ $item->nama }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-icon-btn danger" title="Hapus Karyawan">
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
                    <td colspan="6" class="py-12 text-center text-[#8e988f]">
                        Belum ada data karyawan yang ditambahkan.
                    </td>
                </tr>
                @endforelse
                <tr id="karyawan-empty-row" style="display: none;">
                    <td colspan="6" class="py-12 text-center text-[#8e988f]">
                        Tidak ada data karyawan yang sesuai dengan filter pencarian.
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Table Footer --}}
    <div class="table-footer">
        <strong id="karyawan-count-info">Total {{ count($karyawans) }} data terdaftar</strong>
        <span>Menampilkan data karyawan</span>
    </div>
</div>

<script>
    function filterKaryawanTable() {
        const search = (document.getElementById('karyawan-search-input').value || '').toLowerCase();
        const status = (document.getElementById('karyawan-status-filter').value || '').toLowerCase();
        const table = document.getElementById('karyawan-main-table');
        const rows = table.querySelectorAll('tbody tr:not(#karyawan-empty-row)');
        const emptyRow = document.getElementById('karyawan-empty-row');
        let visibleCount = 0;

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            const statusBadge = row.querySelector('.status-badge, .status-badge-rose');
            const statusText = statusBadge ? statusBadge.textContent.toLowerCase() : '';

            const matchesSearch = text.includes(search);
            const matchesStatus = status === '' || statusText.includes(status);

            if (matchesSearch && matchesStatus) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        if (emptyRow) {
            emptyRow.style.display = visibleCount === 0 && rows.length > 0 ? '' : 'none';
        }

        const countInfo = document.getElementById('karyawan-count-info');
        if (countInfo) {
            countInfo.textContent = `Menampilkan ${visibleCount} dari {{ count($karyawans) }} karyawan`;
        }
    }
</script>
@endsection
