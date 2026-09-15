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
     * Penggajian
     */
    Route::resource('penggajian', PenggajianController::class);

    Route::get(
        '/potongan/{penggajian}',
        [PotonganController::class, 'index']
    )->name('potongan.index');

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
        });
});