@extends('layouts.app')

@section('title', 'Data Presensi & Perizinan - gajiku.')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-neutral-900 font-manrope">Presensi & Pengajuan Izin</h1>
            <p class="mt-1 text-sm text-neutral-500">Monitor presensi harian karyawan dan kelola persetujuan izin, sakit, serta cuti.</p>
        </div>
        <div class="mt-4 sm:mt-0 flex gap-3">
            <a href="{{ route('presensi.kiosk') }}" target="_blank" class="inline-flex items-center gap-2 rounded-xl bg-forest px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-forest-hover transition-all">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
                Buka Terminal Absensi (Kiosk)
            </a>
        </div>
    </div>

    <!-- Alert Success / Error -->
    @if(session('success'))
        <div class="rounded-xl bg-[#edf8f0] p-4 border border-[#cbe4d1] text-sm text-[#2b643d] font-medium">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="rounded-xl bg-[#fdf2f2] p-4 border border-[#f8d7da] text-sm text-[#b94a48] font-medium">
            {{ session('error') }}
        </div>
    @endif

    <!-- 4 Ringkasan Statistik Presensi Hari Ini -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white border border-[#e5eae3] rounded-xl p-4 shadow-sm">
            <span class="text-xs text-neutral-500 block">Total Karyawan Aktif</span>
            <span class="text-2xl font-bold text-neutral-900 font-manrope mt-1 block">{{ $totalKaryawan }} Orang</span>
        </div>
        <div class="bg-white border border-[#e5eae3] rounded-xl p-4 shadow-sm">
            <span class="text-xs text-neutral-500 block">Hadir Hari Ini</span>
            <span class="text-2xl font-bold text-emerald-700 font-manrope mt-1 block">{{ $totalHadir }} Orang</span>
        </div>
        <div class="bg-white border border-[#e5eae3] rounded-xl p-4 shadow-sm">
            <span class="text-xs text-neutral-500 block">Terlambat</span>
            <span class="text-2xl font-bold text-amber-600 font-manrope mt-1 block">{{ $totalTerlambat }} Orang</span>
        </div>
        <div class="bg-white border border-[#e5eae3] rounded-xl p-4 shadow-sm">
            <span class="text-xs text-neutral-500 block">Izin / Sakit / Cuti</span>
            <span class="text-2xl font-bold text-blue-700 font-manrope mt-1 block">{{ $totalIzinSakit }} Orang</span>
        </div>
    </div>

    <!-- Section 1: Pengajuan Izin Menunggu Persetujuan -->
    <div class="bg-white rounded-2xl shadow-sm border border-neutral-100 overflow-hidden">
        <div class="p-6 border-b border-neutral-100 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2.5">
                    <h2 class="text-base font-bold text-neutral-900 font-manrope">Pengajuan Izin / Cuti Menunggu Approval</h2>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">
                        {{ $pendingApprovalCount ?? 0 }} Permohonan Menunggu
                    </span>
                </div>
                <p class="text-xs text-neutral-500 mt-0.5">Permohonan izin atau cuti yang diajukan oleh karyawan melalui kiosk.</p>
            </div>
            
            <!-- Toolbar Filter Permohonan Izin -->
            <div class="flex flex-wrap items-center gap-2.5">
                <div class="relative">
                    <input type="text" id="izin-search-input" oninput="filterIzinTable()" placeholder="Cari nama karyawan..." class="rounded-xl border border-neutral-300 pl-8 pr-3 py-1.5 text-xs focus:border-forest focus:outline-none focus:ring-1 focus:ring-forest w-44">
                    <svg class="w-3.5 h-3.5 text-neutral-400 absolute left-2.5 top-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <select id="izin-kategori-filter" onchange="filterIzinTable()" class="rounded-xl border border-neutral-300 px-3 py-1.5 text-xs text-neutral-700 focus:border-forest focus:outline-none focus:ring-1 focus:ring-forest bg-white">
                    <option value="">Semua Kategori</option>
                    <option value="Cuti">Cuti Tahunan</option>
                    <option value="Sakit">Sakit</option>
                    <option value="Izin">Izin</option>
                </select>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table id="pengajuan-izin-table" class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="border-b border-neutral-100 bg-neutral-50/50 text-xs font-semibold uppercase tracking-wider text-neutral-500">
                        <th class="py-3 px-6">Karyawan</th>
                        <th class="py-3 px-6">Kategori</th>
                        <th class="py-3 px-6">Rentang Waktu</th>
                        <th class="py-3 px-6">Alasan</th>
                        <th class="py-3 px-6">Status</th>
                        <th class="py-3 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100 text-neutral-700">
                    @forelse($pengajuanIzins as $pengajuan)
                        <tr class="hover:bg-neutral-50/50 transition-colors">
                            <td class="py-4 px-6 font-medium text-neutral-900">
                                <div>{{ $pengajuan->karyawan->nama ?? 'Tidak Diketahui' }}</div>
                                <div class="text-xs text-neutral-400 font-mono">{{ $pengajuan->karyawan->nik ?? '-' }} (Sisa Cuti: {{ $pengajuan->karyawan->sisa_cuti ?? 0 }} hari)</div>
                            </td>
                            <td class="py-4 px-6">
                                @if($pengajuan->kategori === 'Cuti')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">Cuti Tahunan</span>
                                @elseif($pengajuan->kategori === 'Sakit')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">Sakit</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-neutral-100 text-neutral-700 border border-neutral-200">Izin</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-xs text-neutral-600">
                                <span class="font-medium text-neutral-900">{{ \Carbon\Carbon::parse($pengajuan->tanggal_mulai)->translatedFormat('d M Y') }}</span>
                                s/d
                                <span class="font-medium text-neutral-900">{{ \Carbon\Carbon::parse($pengajuan->tanggal_selesai)->translatedFormat('d M Y') }}</span>
                                <span class="block text-[11px] text-neutral-400 mt-0.5">({{ $pengajuan->jumlah_hari }} Hari Kerja)</span>
                            </td>
                            <td class="py-4 px-6 text-xs text-neutral-600 max-w-xs truncate" title="{{ $pengajuan->alasan }}">
                                {{ $pengajuan->alasan }}
                            </td>
                            <td class="py-4 px-6">
                                @if($pengajuan->status === 'Disetujui')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800">Disetujui</span>
                                @elseif($pengajuan->status === 'Ditolak')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800">Ditolak</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">Menunggu</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right">
                                @if($pengajuan->status === 'Menunggu')
                                    <div class="inline-flex gap-2">
                                        <form action="{{ route('presensi.approve', $pengajuan->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="px-3 py-1 bg-forest hover:bg-forest-hover text-white rounded-lg text-xs font-semibold shadow-sm transition-all">
                                                Setujui
                                            </button>
                                        </form>
                                        <form action="{{ route('presensi.reject', $pengajuan->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded-lg text-xs font-semibold shadow-sm transition-all">
                                                Tolak
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-xs text-neutral-400">Selesai</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-sm text-neutral-400">
                                Tidak ada pengajuan izin / cuti saat ini.
                            </td>
                        </tr>
                    @endforelse
                    <tr id="izin-empty-row" style="display: none;">
                        <td colspan="6" class="py-8 text-center text-sm text-neutral-400">
                            Tidak ada pengajuan izin yang sesuai dengan kriteria filter.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        @if($pengajuanIzins->hasPages())
            <div class="p-4 border-t border-neutral-100">
                {{ $pengajuanIzins->links() }}
            </div>
        @endif
    </div>

    <!-- Section 2: Log Presensi Harian -->
    <div class="bg-white rounded-2xl shadow-sm border border-neutral-100 overflow-hidden">
        <div class="p-6 border-b border-neutral-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-base font-bold text-neutral-900 font-manrope">Log Presensi Harian</h2>
                <p class="text-xs text-neutral-500">Rekap kehadiran, waktu check-in, check-out, serta keterlambatan.</p>
            </div>
            
            <!-- Filter Tanggal & Pencarian -->
            <div class="flex flex-wrap items-center gap-3">
                <div class="relative">
                    <input type="text" id="presensi-search-input" oninput="filterPresensiTable()" placeholder="Cari nama atau NIK..." class="rounded-xl border border-neutral-300 pl-8 pr-3 py-1.5 text-xs focus:border-forest focus:outline-none focus:ring-1 focus:ring-forest w-48">
                    <svg class="w-3.5 h-3.5 text-neutral-400 absolute left-2.5 top-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <form method="GET" action="{{ route('presensi.index') }}" class="flex items-center gap-2">
                    <input type="date" name="tanggal" value="{{ $tanggalPilih }}" class="rounded-xl border border-neutral-300 px-3 py-1.5 text-xs focus:border-forest focus:outline-none focus:ring-1 focus:ring-forest">
                    <button type="submit" class="rounded-xl bg-neutral-900 px-3.5 py-1.5 text-xs font-semibold text-white hover:bg-neutral-800 transition-all">
                        Filter
                    </button>
                </form>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table id="presensi-main-table" class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="border-b border-neutral-100 bg-neutral-50/50 text-xs font-semibold uppercase tracking-wider text-neutral-500">
                        <th class="py-3 px-6">Karyawan</th>
                        <th class="py-3 px-6">Status Kehadiran</th>
                        <th class="py-3 px-6">Check In</th>
                        <th class="py-3 px-6">Check Out</th>
                        <th class="py-3 px-6">Jam Lembur</th>
                        <th class="py-3 px-6">Jarak Lokasi</th>
                        <th class="py-3 px-6">Catatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100 text-neutral-700">
                    @forelse($presensis as $presensi)
                        <tr class="hover:bg-neutral-50/50 transition-colors">
                            <td class="py-4 px-6 font-medium text-neutral-900">
                                <div>{{ $presensi->karyawan->nama ?? 'Tidak Diketahui' }}</div>
                                <div class="text-xs text-neutral-400 font-mono">{{ $presensi->karyawan->nik ?? '-' }} · {{ $presensi->karyawan->jabatan->nama_jabatan ?? '-' }}</div>
                            </td>
                            <td class="py-4 px-6">
                                @if(in_array($presensi->status, ['Hadir', 'hadir']))
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800">Hadir</span>
                                @elseif(in_array($presensi->status, ['Terlambat', 'terlambat']))
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">Terlambat</span>
                                @elseif(in_array($presensi->status, ['Sakit', 'sakit']))
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">Sakit</span>
                                @elseif(in_array($presensi->status, ['Cuti', 'cuti']))
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-purple-100 text-purple-800">Cuti</span>
                                @elseif(in_array($presensi->status, ['Izin', 'izin']))
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-neutral-200 text-neutral-800">Izin</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800">Alpa</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-xs font-mono font-medium text-neutral-900">
                                {{ $presensi->jam_masuk ? \Carbon\Carbon::parse($presensi->jam_masuk)->format('H:i:s') : '-' }}
                            </td>
                            <td class="py-4 px-6 text-xs font-mono font-medium text-neutral-900">
                                {{ $presensi->jam_pulang ? \Carbon\Carbon::parse($presensi->jam_pulang)->format('H:i:s') : '-' }}
                            </td>
                            <td class="py-4 px-6 text-xs text-neutral-600">
                                @if(($presensi->jam_lembur ?? 0) > 0)
                                    <span class="text-forest font-semibold">{{ $presensi->jam_lembur }} Jam</span>
                                @else
                                    <span class="text-neutral-400">-</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-xs text-neutral-600">
                                {{ $presensi->jarak_meter ?? 'Dalam radius' }}
                            </td>
                            <td class="py-4 px-6 text-xs text-neutral-500">
                                {{ $presensi->catatan ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-sm text-neutral-400">
                                Belum ada catatan presensi untuk tanggal {{ \Carbon\Carbon::parse($tanggalPilih)->translatedFormat('d F Y') }}.
                            </td>
                        </tr>
                    @endforelse
                    <tr id="presensi-empty-row" style="display: none;">
                        <td colspan="7" class="py-8 text-center text-sm text-neutral-400">
                            Tidak ada karyawan yang sesuai dengan kata kunci pencarian.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function filterIzinTable() {
        const search = (document.getElementById('izin-search-input').value || '').toLowerCase();
        const kategori = (document.getElementById('izin-kategori-filter').value || '').toLowerCase();
        const table = document.getElementById('pengajuan-izin-table');
        if (!table) return;
        const rows = table.querySelectorAll('tbody tr:not(#izin-empty-row)');
        const emptyRow = document.getElementById('izin-empty-row');
        let visibleCount = 0;

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            const kategoriCell = row.children[1] ? row.children[1].textContent.toLowerCase() : '';

            const matchesSearch = text.includes(search);
            const matchesKategori = kategori === '' || kategoriCell.includes(kategori);

            if (matchesSearch && matchesKategori) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        if (emptyRow) {
            emptyRow.style.display = visibleCount === 0 && rows.length > 0 ? '' : 'none';
        }
    }

    function filterPresensiTable() {
        const search = (document.getElementById('presensi-search-input').value || '').toLowerCase();
        const table = document.getElementById('presensi-main-table');
        const rows = table.querySelectorAll('tbody tr:not(#presensi-empty-row)');
        const emptyRow = document.getElementById('presensi-empty-row');
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
    }
</script>
@endsection
