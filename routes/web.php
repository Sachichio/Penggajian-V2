<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| CONTROLLERS
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\PenggajianController;
use App\Http\Controllers\SlipGajiController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PotonganController;
use App\Http\Controllers\PresensiController;

/*
|--------------------------------------------------------------------------
| TERMINAL PRESENSI KIOSK (PUBLIK MANDIRI)
|--------------------------------------------------------------------------
*/
Route::get('/absen-masuk', [PresensiController::class, 'kiosk'])->name('presensi.kiosk');
Route::post('/absen-masuk/checkin', [PresensiController::class, 'checkIn'])->name('presensi.checkin');
Route::post('/absen-masuk/checkout', [PresensiController::class, 'checkOut'])->name('presensi.checkout');
Route::post('/absen-masuk/izin', [PresensiController::class, 'ajukanIzin'])->name('presensi.izin');

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::get('/', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| ADMIN ONLY
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {

    /**
     * Search Karyawan Penggajian
     */
    Route::get('/penggajian/search-karyawan',
        [PenggajianController::class, 'searchKaryawan']
    )
    ->name('penggajian.searchKaryawan');

    Route::get(
    '/penggajian/get-karyawan/{id}',
    [PenggajianController::class, 'getKaryawan']
    )->name('penggajian.getKaryawan');

    /**
     * Data Karyawan
     */
    Route::resource('karyawan', KaryawanController::class);

    /**
     * Data Jabatan
     */
    Route::resource('jabatan', JabatanController::class);

    /**
     * Penggajian (Mutasi Form & CRUD khusus Admin)
     */
    Route::resource('penggajian', PenggajianController::class)->except(['index', 'show']);

    /**
     * Potongan
     */

    // Daftar potongan
    Route::get(
        '/potongan/{penggajian}',
        [PotonganController::class, 'index']
    )->name('potongan.index');

    // Form tambah
    Route::get(
        '/potongan/{penggajian}/create',
        [PotonganController::class, 'create']
    )->name('potongan.create');

    // Simpan
    Route::post(
        '/potongan',
        [PotonganController::class, 'store']
    )->name('potongan.store');

    // Form edit
    Route::get(
        '/potongan/{potongan}/edit',
        [PotonganController::class, 'edit']
    )->name('potongan.edit');

    // Update
    Route::put(
        '/potongan/{potongan}',
        [PotonganController::class, 'update']
    )->name('potongan.update');

    // Hapus
    Route::delete(
        '/potongan/{potongan}',
        [PotonganController::class, 'destroy']
    )->name('potongan.destroy');
});

/*
|--------------------------------------------------------------------------
| ADMIN & OWNER
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin,owner'])->group(function () {

    /**
     * Penggajian (Daftar & Detail dapat diakses Admin & Owner)
     */
    Route::get('/penggajian', [PenggajianController::class, 'index'])
        ->name('penggajian.index');

    Route::get('/penggajian/{penggajian}', [PenggajianController::class, 'show'])
        ->name('penggajian.show');

    /**
     * Slip Gaji
     */
    Route::get('/slip-gaji', [SlipGajiController::class, 'index'])
        ->name('slip-gaji.index');

    Route::get('/slip-gaji/{id}', [SlipGajiController::class, 'show'])
        ->name('slip-gaji.show');

    Route::get('/slip-gaji/{id}/export', [SlipGajiController::class, 'exportPdf'])
        ->name('slip-gaji.export');

    /**
     * Laporan Penggajian
     */
    Route::prefix('laporan')
        ->name('laporan.')
        ->group(function () {

            Route::get('/', [LaporanController::class, 'index'])
                ->name('index');

            Route::get('/{bulan}/{tahun}', [LaporanController::class, 'show'])
                ->name('show');

            Route::get('/{bulan}/{tahun}/pdf', [LaporanController::class, 'exportPdf'])
                ->name('export');

            Route::get('/{bulan}/{tahun}/csv', [LaporanController::class, 'exportCsv'])
                ->name('exportCsv');
        });

    /**
     * Presensi & Cuti
     */
    Route::get('/presensi', [PresensiController::class, 'index'])
        ->name('presensi.index');

    Route::post('/presensi/pengajuan/{id}/approve', [PresensiController::class, 'approveIzin'])
        ->name('presensi.approve');

    Route::post('/presensi/pengajuan/{id}/reject', [PresensiController::class, 'rejectIzin'])
        ->name('presensi.reject');

    Route::get('/api/karyawan/{id}/attendance-summary/{bulan?}/{tahun?}', [PresensiController::class, 'getAttendanceSummary'])
        ->name('api.karyawan.attendance');

    /**
     * Otorisasi / Approval Payroll
     */
    Route::post('/penggajian/{id}/approve', [PenggajianController::class, 'approvePayroll'])
        ->name('penggajian.approve');

    /**
     * Pengaturan Profil Perusahaan (White-Label Dynamic Company)
     */
    Route::get('/pengaturan-perusahaan', [\App\Http\Controllers\CompanySettingController::class, 'edit'])
        ->name('company.edit');
    Route::put('/pengaturan-perusahaan', [\App\Http\Controllers\CompanySettingController::class, 'update'])
        ->name('company.update');
});

/**
 * =========================================
 * TESTING / PREVIEW HALAMAN ERROR 500
 * =========================================
 */
Route::get('/test-500', function () {
    abort(500);
})->name('test.500');

/**
 * =========================================
 * ROUTE FALLBACK (PENANGANAN 404 DENGAN SESSION & AUTH AKTIF)
 * =========================================
 */
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});