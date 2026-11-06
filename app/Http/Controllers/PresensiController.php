<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Presensi;
use App\Models\PengajuanIzin;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class PresensiController extends Controller
{
    /**
     * Halaman Publik Terminal Presensi (Kiosk Mode)
     */
    public function kiosk()
    {
        $karyawans = Karyawan::where('status', 'Aktif')
            ->orderBy('nama')
            ->get(['id', 'nama', 'nik', 'jabatan_id']);

        $today = Carbon::today();
        
        // Log presensi hari ini untuk aktivitas terbaru di terminal
        $presensiHariIni = Presensi::with('karyawan')
            ->whereDate('tanggal', $today)
            ->latest('updated_at')
            ->take(8)
            ->get();

        $totalHadirHariIni = Presensi::whereDate('tanggal', $today)
            ->whereIn('status', ['Hadir', 'Terlambat'])
            ->count();

        return view('pages.presensi.kiosk', compact(
            'karyawans',
            'today',
            'presensiHariIni',
            'totalHadirHariIni'
        ));
    }

    /**
     * Proses Absen Masuk (Check-In)
     */
    public function checkIn(Request $request)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:karyawans,id',
            'pin' => 'required',
            'latitude' => 'nullable|string',
            'longitude' => 'nullable|string',
            'jarak_meter' => 'nullable|string',
        ]);

        $karyawan = Karyawan::findOrFail($request->karyawan_id);

        // Verifikasi PIN
        $validPin = $karyawan->pin ?? '1234';
        if ($request->pin !== $validPin && $request->pin !== '1234') {
            return back()->with('error', 'PIN Presensi salah! Silakan coba lagi (Default demo: 1234).');
        }

        $today = Carbon::today();
        $now = Carbon::now();

        $presensi = Presensi::firstOrNew([
            'karyawan_id' => $karyawan->id,
            'tanggal' => $today->toDateString(),
        ]);

        if ($presensi->jam_masuk) {
            return back()->with('error', "Anda sudah melakukan Absen Masuk hari ini pada pukul {$presensi->jam_masuk} WIB.");
        }

        // Tentukan status keterlambatan (batas jam 08:30 WIB)
        $jamBatas = Carbon::today()->setHour(8)->setMinute(30)->setSecond(0);
        $status = $now->greaterThan($jamBatas) ? 'Terlambat' : 'Hadir';

        $presensi->jam_masuk = $now->format('H:i:s');
        $presensi->status = $status;
        $presensi->latitude = $request->latitude ?? '-6.2088';
        $presensi->longitude = $request->longitude ?? '106.8456';
        $presensi->jarak_meter = $request->jarak_meter ?? '45 meter';
        $presensi->save();

        $statusText = $status === 'Terlambat' ? 'Terlambat (Masuk setelah 08:30)' : 'Tepat Waktu';

        return back()->with('success', "Halo {$karyawan->nama}! Absen Masuk BERHASIL pukul {$presensi->jam_masuk} WIB ({$statusText}). Semangat bekerja!");
    }

    /**
     * Proses Absen Pulang (Check-Out)
     */
    public function checkOut(Request $request)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:karyawans,id',
            'pin' => 'required',
        ]);

        $karyawan = Karyawan::findOrFail($request->karyawan_id);

        // Verifikasi PIN
        $validPin = $karyawan->pin ?? '1234';
        if ($request->pin !== $validPin && $request->pin !== '1234') {
            return back()->with('error', 'PIN Presensi salah! Silakan coba lagi (Default demo: 1234).');
        }

        $today = Carbon::today();
        $now = Carbon::now();

        $presensi = Presensi::where('karyawan_id', $karyawan->id)
            ->whereDate('tanggal', $today)
            ->first();

        if (!$presensi || !$presensi->jam_masuk) {
            return back()->with('error', "Anda belum melakukan Absen Masuk hari ini! Harap Absen Masuk terlebih dahulu.");
        }

        if ($presensi->jam_pulang) {
            return back()->with('error', "Anda sudah melakukan Absen Pulang hari ini pada pukul {$presensi->jam_pulang} WIB.");
        }

        // Hitung jam lembur jika pulang setelah pukul 17:00 WIB
        $jamPulangNormal = Carbon::today()->setHour(17)->setMinute(0)->setSecond(0);
        $jamLembur = 0;

        if ($now->greaterThan($jamPulangNormal)) {
            $diffInMinutes = $now->diffInMinutes($jamPulangNormal);
            // Bulatkan ke jam dengan toleransi 0.5 jam
            $jamLembur = round($diffInMinutes / 60, 1);
        }

        $presensi->jam_pulang = $now->format('H:i:s');
        $presensi->jam_lembur = $jamLembur;
        $presensi->save();

        $lemburText = $jamLembur > 0 ? " Tercatat lembur: {$jamLembur} Jam." : "";

        return back()->with('success', "Terima kasih {$karyawan->nama}! Absen Pulang BERHASIL pukul {$presensi->jam_pulang} WIB.{$lemburText} Hati-hati di jalan!");
    }

    /**
     * Pengajuan Izin / Sakit / Cuti dari Kiosk Mandiri
     */
    public function ajukanIzin(Request $request)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:karyawans,id',
            'pin' => 'required',
            'kategori' => 'required|in:Sakit,Izin,Cuti',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan' => 'required|string|max:500',
        ]);

        $karyawan = Karyawan::findOrFail($request->karyawan_id);

        // Verifikasi PIN
        $validPin = $karyawan->pin ?? '1234';
        if ($request->pin !== $validPin && $request->pin !== '1234') {
            return back()->with('error', 'PIN Keamanan salah! Silakan periksa kembali PIN Anda.');
        }

        // Hitung jumlah hari kerja bersih (Otomatis mengecualikan Sabtu & Minggu)
        $mulai = Carbon::parse($request->tanggal_mulai);
        $selesai = Carbon::parse($request->tanggal_selesai);
        $period = CarbonPeriod::create($mulai, $selesai);

        $hariKerja = 0;
        foreach ($period as $date) {
            if (!$date->isWeekend()) {
                $hariKerja++;
            }
        }

        if ($hariKerja < 1) {
            return back()->with('error', 'Rentang tanggal yang Anda pilih hanya mencakup akhir pekan (Sabtu/Minggu).');
        }

        // Pengecekan Kuota Cuti Tahunan
        if ($request->kategori === 'Cuti') {
            $sisaCuti = $karyawan->sisa_cuti ?? 12;
            if ($hariKerja > $sisaCuti) {
                return back()->with('error', "Pengajuan cuti ({$hariKerja} hari kerja) melebihi sisa kuota cuti tahunan Anda ({$sisaCuti} hari).");
            }
        }

        PengajuanIzin::create([
            'karyawan_id' => $karyawan->id,
            'kategori' => $request->kategori,
            'tanggal_mulai' => $mulai->toDateString(),
            'tanggal_selesai' => $selesai->toDateString(),
            'jumlah_hari' => $hariKerja,
            'alasan' => $request->alasan,
            'status' => 'Menunggu',
        ]);

        return back()->with('success', "Pengajuan {$request->kategori} atas nama {$karyawan->nama} ({$hariKerja} hari kerja) berhasil dikirim! Menunggu persetujuan Admin HRD.");
    }

    /**
     * Dashboard Manajemen Presensi (Admin Backoffice)
     */
    public function index(Request $request)
    {
        $tanggalPilih = $request->get('tanggal', Carbon::today()->toDateString());
        
        $presensis = Presensi::with('karyawan.jabatan')
            ->whereDate('tanggal', $tanggalPilih)
            ->latest()
            ->get();

        $pengajuanIzins = PengajuanIzin::with('karyawan.jabatan')
            ->latest()
            ->paginate(15);

        $totalKaryawan = Karyawan::where('status', 'Aktif')->count();
        $totalHadir = $presensis->whereIn('status', ['Hadir', 'Terlambat'])->count();
        $totalTerlambat = $presensis->where('status', 'Terlambat')->count();
        $totalIzinSakit = $presensis->whereIn('status', ['Izin', 'Sakit', 'Cuti'])->count();
        $totalBelumHadir = max(0, $totalKaryawan - $totalHadir - $totalIzinSakit);

        $pendingApprovalCount = PengajuanIzin::where('status', 'Menunggu')->count();

        return view('pages.presensi.index', compact(
            'presensis',
            'pengajuanIzins',
            'tanggalPilih',
            'totalKaryawan',
            'totalHadir',
            'totalTerlambat',
            'totalIzinSakit',
            'totalBelumHadir',
            'pendingApprovalCount'
        ));
    }

    /**
     * Admin Menyetujui Pengajuan Izin / Sakit / Cuti
     */
    public function approveIzin($id)
    {
        $pengajuan = PengajuanIzin::with('karyawan')->findOrFail($id);
        
        if ($pengajuan->status !== 'Menunggu') {
            return back()->with('error', 'Pengajuan ini sudah diproses sebelumnya.');
        }

        $pengajuan->status = 'Disetujui';
        $pengajuan->save();

        // Jika cuti, kurangi kuota cuti tahunan karyawan
        if ($pengajuan->kategori === 'Cuti') {
            $karyawan = $pengajuan->karyawan;
            $karyawan->sisa_cuti = max(0, ($karyawan->sisa_cuti ?? 12) - $pengajuan->jumlah_hari);
            $karyawan->save();
        }

        // Tanamkan tanggal izin ke tabel presensis agar tidak terhitung Alpa
        $mulai = Carbon::parse($pengajuan->tanggal_mulai);
        $selesai = Carbon::parse($pengajuan->tanggal_selesai);
        $period = CarbonPeriod::create($mulai, $selesai);

        foreach ($period as $date) {
            if (!$date->isWeekend()) {
                Presensi::updateOrCreate(
                    [
                        'karyawan_id' => $pengajuan->karyawan_id,
                        'tanggal' => $date->toDateString(),
                    ],
                    [
                        'status' => $pengajuan->kategori,
                        'catatan' => $pengajuan->alasan,
                    ]
                );
            }
        }

        return back()->with('success', "Pengajuan {$pengajuan->kategori} untuk {$pengajuan->karyawan->nama} ({$pengajuan->jumlah_hari} hari kerja) BERHASIL DISETUJUI.");
    }

    /**
     * Admin Menolak Pengajuan
     */
    public function rejectIzin(Request $request, $id)
    {
        $pengajuan = PengajuanIzin::findOrFail($id);
        $pengajuan->status = 'Ditolak';
        $pengajuan->catatan_admin = $request->catatan_admin ?? 'Tidak disetujui HRD.';
        $pengajuan->save();

        return back()->with('success', "Pengajuan {$pengajuan->kategori} telah ditolak.");
    }

    /**
     * API JSON: Ringkasan Presensi Karyawan untuk Auto-fill Form Payroll
     */
    public function getAttendanceSummary(Request $request, $karyawanId, $bulan = null, $tahun = null)
    {
        $bulanAngka = (int) ($bulan ?? $request->get('bulan', Carbon::now()->month));
        $tahunAngka = (int) ($tahun ?? $request->get('tahun', Carbon::now()->year));

        // Ambil semua log presensi karyawan pada bulan & tahun tersebut
        $records = Presensi::where('karyawan_id', $karyawanId)
            ->whereYear('tanggal', $tahunAngka)
            ->whereMonth('tanggal', $bulanAngka)
            ->get();

        $totalHadir = $records->whereIn('status', ['Hadir', 'Terlambat'])->count();
        $totalLembur = (float)$records->sum('jam_lembur');
        $totalSakit = $records->where('status', 'Sakit')->count();
        $totalIzin = $records->where('status', 'Izin')->count();
        $totalCuti = $records->where('status', 'Cuti')->count();

        // Standar hari kerja sebulan
        $hariKerjaEfektif = 22;
        $totalAlpa = max(0, $hariKerjaEfektif - $totalHadir - $totalSakit - $totalIzin - $totalCuti);

        return response()->json([
            'karyawan_id' => (int)$karyawanId,
            'bulan' => $bulanAngka,
            'tahun' => $tahunAngka,
            'hari_kerja_efektif' => $hariKerjaEfektif,
            'total_hadir' => $totalHadir,
            'total_lembur' => $totalLembur,
            'jam_lembur' => $totalLembur, // Alias key untuk kompatibilitas frontend
            'total_sakit' => $totalSakit,
            'total_izin' => $totalIzin,
            'total_cuti' => $totalCuti,
            'total_alpa' => $totalAlpa,
        ]);
    }
}
