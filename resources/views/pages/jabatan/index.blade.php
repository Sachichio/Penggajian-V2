@extends('layouts.app')

@section('title', 'Data Jabatan')

@section('content')
<section class="page-heading">
    <div>
        <div class="heading-eyebrow">STRUKTUR ORGANISASI</div>
        <h1>Data Jabatan</h1>
        <p>Kelola data jabatan beserta standar gaji pokok dan tunjangan karyawan.</p>
    </div>
    <a href="{{ route('jabatan.create') }}" class="button primary">
        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 5v14M5 12h14" />
        </svg>
        Tambah Jabatan
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

@if(session('error'))
<div class="mb-5 flex items-center gap-2.5 rounded-[8px] border border-red-200 bg-red-50/80 px-4 py-3 text-[11.5px] font-medium text-red-700">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red-600 shrink-0">
        <circle cx="12" cy="12" r="10"></circle>
        <line x1="12" y1="8" x2="12" y2="12"></line>
        <line x1="12" y1="16" x2="12.01" y2="16"></line>
    </svg>
    <span>{{ session('error') }}</span>
</div>
@endif

<div class="panel table-panel mb-8">
    <div class="table-heading">
        <div>
            <h2>
                Daftar Jabatan
                <span class="count-badge">{{ count($jabatans) }} jabatan</span>
            </h2>
            <p>Struktur posisi dan besaran kompensasi standar perusahaan.</p>
        </div>
    </div>

    {{-- Table Toolbar Filter --}}
    <div class="table-toolbar">
        <label class="search-field">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="10.8" cy="10.8" r="7.3" />
                <path d="m16 16 5 5" />
            </svg>
            <input id="jabatan-search-input" oninput="filterJabatanTable()" placeholder="Cari nama jabatan..." />
        </label>
    </div>

    <div class="table-scroll">
        <table id="jabatan-main-table">
            <thead>
                <tr>
                    <th style="width: 50px; text-align: center;">No</th>
                    <th>Nama Jabatan</th>
                    <th>Gaji Pokok</th>
                    <th>Tunjangan</th>
                    <th>Total Kompensasi</th>
                    <th style="text-align: center; width: 100px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jabatans as $item)
                @php
                    $total = ($item->gaji_pokok ?? 0) + ($item->tunjangan ?? 0);
                @endphp
                <tr>
                    <td style="text-align: center; color: #9aa299; font-weight: 500;">
                        {{ $loop->iteration }}
                    </td>
                    <td>
                        <div class="flex items-center gap-2.5">
                            <span class="grid h-7 w-7 place-items-center rounded-lg bg-[#eaf0f8] text-[#6986ab]">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <rect x="3" y="7" width="18" height="14" rx="2" />
                                    <path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2M3 12a22 22 0 0 0 18 0M12 11v4" />
                                </svg>
                            </span>
                            <strong style="color: #2b382d; font-size: 11.5px;">{{ $item->nama_jabatan }}</strong>
                        </div>
                    </td>
                    <td style="font-weight: 600; color: #435345;">
                        Rp {{ number_format($item->gaji_pokok, 0, ',', '.') }}
                    </td>
                    <td style="color: #6a786d;">
                        Rp {{ number_format($item->tunjangan, 0, ',', '.') }}
                    </td>
                    <td style="font-weight: 700; color: #326447;">
                        Rp {{ number_format($total, 0, ',', '.') }}
                    </td>
                    <td>
                        <div class="flex items-center justify-center gap-1.5">
                            <a href="{{ route('jabatan.edit', $item->id) }}" class="action-icon-btn" title="Edit Jabatan">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg>
                            </a>
                            <form action="{{ route('jabatan.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus jabatan {{ $item->nama_jabatan }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-icon-btn danger" title="Hapus Jabatan">
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
                        Belum ada data jabatan yang ditambahkan.
                    </td>
                </tr>
                @endforelse
                <tr id="jabatan-empty-row" style="display: none;">
                    <td colspan="6" class="py-12 text-center text-[#8e988f]">
                        Tidak ada data jabatan yang sesuai dengan pencarian.
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="table-footer">
        <strong id="jabatan-count-info">Total {{ count($jabatans) }} jabatan terdaftar</strong>
        <span>Kompensasi resmi perusahaan</span>
    </div>
</div>

<script>
    function filterJabatanTable() {
        const search = (document.getElementById('jabatan-search-input').value || '').toLowerCase();
        const table = document.getElementById('jabatan-main-table');
        const rows = table.querySelectorAll('tbody tr:not(#jabatan-empty-row)');
        const emptyRow = document.getElementById('jabatan-empty-row');
        let visibleCount = 0;

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            if (text.includes(search)) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        if (emptyRow) {
            emptyRow.style.display = visibleCount === 0 && rows.length > 0 ? '' : 'none';
        }

        const countInfo = document.getElementById('jabatan-count-info');
        if (countInfo) {
            countInfo.textContent = `Menampilkan ${visibleCount} dari {{ count($jabatans) }} jabatan`;
        }
    }
</script>
@endsection
