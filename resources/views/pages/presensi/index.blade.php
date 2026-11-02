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
            <a href="{{ route('kiosk.index') }}" target="_blank" class="inline-flex items-center gap-2 rounded-xl bg-forest-700 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-forest-800 transition-all">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
                Buka Terminal Absensi (Kiosk)
            </a>
        </div>
    </div>

    <!-- Alert Success / Error -->
    @if(session('success'))
        <div class="rounded-xl bg-forest-50 p-4 border border-forest-200 text-sm text-forest-800 font-medium">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="rounded-xl bg-red-50 p-4 border border-red-200 text-sm text-red-800 font-medium">
            {{ session('error') }}
        </div>
    @endif

    <!-- Section 1: Pengajuan Izin Menunggu Persetujuan -->
    <div class="bg-white rounded-2xl shadow-sm border border-neutral-100 overflow-hidden">
        <div class="p-6 border-b border-neutral-100 flex items-center justify-between">
            <div>
                <h2 class="text-base font-bold text-neutral-900 font-manrope">Pengajuan Izin / Cuti Menunggu Approval</h2>
                <p class="text-xs text-neutral-500">Permohonan izin atau cuti yang diajukan oleh karyawan melalui kiosk.</p>
            </div>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">
                {{ $pengajuans->where('status', 'pending')->count() }} Permohonan Pending
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="border-b border-neutral-100 bg-neutral-50/50 text-xs font-semibold uppercase tracking-wider text-neutral-500">
                        <th class="py-3 px-6">Karyawan</th>
                        <th class="py-3 px-6">Tipe</th>
                        <th class="py-3 px-6">Rentang Waktu</th>
                        <th class="py-3 px-6">Alasan</th>
                        <th class="py-3 px-6">Status</th>
                        <th class="py-3 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100 text-neutral-700">
                    @forelse($pengajuans as $pengajuan)
                        <tr class="hover:bg-neutral-50/50 transition-colors">
                            <td class="py-4 px-6 font-medium text-neutral-900">
                                <div>{{ $pengajuan->karyawan->nama ?? 'Tidak Diketahui' }}</div>
                                <div class="text-xs text-neutral-400 font-mono">{{ $pengajuan->karyawan->nik ?? '-' }} (Sisa Cuti: {{ $pengajuan->karyawan->sisa_cuti ?? 0 }} hari)</div>
                            </td>
                            <td class="py-4 px-6">
                                @if($pengajuan->tipe === 'cuti')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">Cuti Tahunan</span>
                                @elseif($pengajuan->tipe === 'sakit')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">Sakit</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-neutral-100 text-neutral-700 border border-neutral-200">Izin</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-xs text-neutral-600">
                                <span class="font-medium text-neutral-900">{{ \Carbon\Carbon::parse($pengajuan->tanggal_mulai)->translatedFormat('d M Y') }}</span>
                                s/d
                                <span class="font-medium text-neutral-900">{{ \Carbon\Carbon::parse($pengajuan->tanggal_selesai)->translatedFormat('d M Y') }}</span>
                            </td>
                            <td class="py-4 px-6 text-xs text-neutral-600 max-w-xs truncate" title="{{ $pengajuan->alasan }}">
                                {{ $pengajuan->alasan }}
                            </td>
                            <td class="py-4 px-6">
                                @if($pengajuan->status === 'approved')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">Disetujui</span>
                                @elseif($pengajuan->status === 'rejected')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">Ditolak</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">Pending</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right">
                                @if($pengajuan->status === 'pending')
                                    <div class="inline-flex gap-2">
                                        <form action="{{ route('presensi.approveIzin', $pengajuan->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="px-3 py-1 bg-forest-700 hover:bg-forest-800 text-white rounded-lg text-xs font-semibold shadow-sm transition-all">
                                                Setujui
                                            </button>
                                        </form>
                                        <form action="{{ route('presensi.rejectIzin', $pengajuan->id) }}" method="POST">
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
                </tbody>
            </table>
        </div>
    </div>

    <!-- Section 2: Log Presensi Harian -->
    <div class="bg-white rounded-2xl shadow-sm border border-neutral-100 overflow-hidden">
        <div class="p-6 border-b border-neutral-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-base font-bold text-neutral-900 font-manrope">Log Presensi Harian</h2>
                <p class="text-xs text-neutral-500">Rekap kehadiran, waktu check-in, check-out, serta keterlambatan.</p>
            </div>
            
            <!-- Filter Tanggal -->
            <form method="GET" action="{{ route('presensi.index') }}" class="flex items-center gap-2">
                <input type="date" name="tanggal" value="{{ $tanggal }}" class="rounded-xl border border-neutral-300 px-3 py-1.5 text-sm focus:border-forest-600 focus:outline-none focus:ring-1 focus:ring-forest-600">
                <button type="submit" class="rounded-xl bg-neutral-900 px-3.5 py-1.5 text-xs font-semibold text-white hover:bg-neutral-800 transition-all">
                    Filter
                </button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="border-b border-neutral-100 bg-neutral-50/50 text-xs font-semibold uppercase tracking-wider text-neutral-500">
                        <th class="py-3 px-6">Karyawan</th>
                        <th class="py-3 px-6">Status Kehadiran</th>
                        <th class="py-3 px-6">Check In</th>
                        <th class="py-3 px-6">Check Out</th>
                        <th class="py-3 px-6">Keterlambatan</th>
                        <th class="py-3 px-6">Lembur</th>
                        <th class="py-3 px-6">Catatan / Lokasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100 text-neutral-700">
                    @forelse($presensis as $presensi)
                        <tr class="hover:bg-neutral-50/50 transition-colors">
                            <td class="py-4 px-6 font-medium text-neutral-900">
                                <div>{{ $presensi->karyawan->nama ?? 'Tidak Diketahui' }}</div>
                                <div class="text-xs text-neutral-400 font-mono">{{ $presensi->karyawan->nik ?? '-' }}</div>
                            </td>
                            <td class="py-4 px-6">
                                @if($presensi->status === 'hadir')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800">Hadir</span>
                                @elseif($presensi->status === 'terlambat')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">Terlambat</span>
                                @elseif($presensi->status === 'sakit')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">Sakit</span>
                                @elseif($presensi->status === 'cuti')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-purple-100 text-purple-800">Cuti</span>
                                @elseif($presensi->status === 'izin')
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
                                @if($presensi->terlambat_menit > 0)
                                    <span class="text-red-600 font-semibold">{{ $presensi->terlambat_menit }} Menit</span>
                                @else
                                    <span class="text-neutral-400">Tepat Waktu</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-xs text-neutral-600">
                                @if($presensi->lembur_menit > 0)
                                    <span class="text-forest-700 font-semibold">{{ round($presensi->lembur_menit / 60, 1) }} Jam</span>
                                @else
                                    <span class="text-neutral-400">-</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-xs text-neutral-500">
                                {{ $presensi->catatan ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-sm text-neutral-400">
                                Belum ada catatan presensi untuk tanggal {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($presensis->hasPages())
            <div class="p-4 border-t border-neutral-100">
                {{ $presensis->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
