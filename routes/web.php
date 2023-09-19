<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Backend\BarangController;
use App\Http\Controllers\Backend\ClientController;
use App\Http\Controllers\Backend\LaporanPembelianController;
use App\Http\Controllers\Backend\LaporanProyekController;
use App\Http\Controllers\Backend\PemakaianController;
use App\Http\Controllers\Backend\PembelianController;
use App\Http\Controllers\Backend\ProyekController;
use App\Http\Controllers\Backend\SuplierController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate');
});

Route::middleware('auth')->prefix('input')->group(function () {
    Route::resource('/client', ClientController::class)->only([
        'index', 'store', 'update', 'destroy'
    ]);
    Route::resource('/suplier', SuplierController::class)->only([
        'index', 'store', 'update', 'destroy'
    ]);
    Route::resource('/barang', BarangController::class)->only([
        'index', 'store', 'update', 'destroy'
    ]);
    Route::get('/barang/cetak', [BarangController::class, 'cetak']);
    Route::get('/suplier/cetak', [SuplierController::class, 'cetak']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware('auth')->prefix('transaksi')->group(function () {
    Route::resource('/proyek', ProyekController::class);
    Route::resource('/pembelian', PembelianController::class)->only([
        'index', 'store', 'update', 'destroy'
    ]);
    Route::resource('/pemakaian', PemakaianController::class)->only([
        'index', 'store', 'update', 'destroy'
    ]);
});

Route::middleware('auth')->prefix('laporan')->group(function () {
    Route::get('/buy', [LaporanPembelianController::class, 'index']);
    Route::get('/buy/harian', [LaporanPembelianController::class, 'harian']);
    Route::get('/buy/harian/{tgl_pembelian}', [LaporanPembelianController::class, 'cetakHarian']);
    Route::get('/buy/mingguan', [LaporanPembelianController::class, 'mingguan']);
    Route::get('/buy/mingguan/{tgl_pembelian_awal}/{tgl_pembelian_akhir}', [LaporanPembelianController::class, 'cetakMingguan']);
    Route::get('/buy/bulanan', [LaporanPembelianController::class, 'bulanan']);
    Route::get('/buy/bulanan/{bln_pembelian}', [LaporanPembelianController::class, 'cetakBulanan']);
    Route::get('/buy/tahunan', [LaporanPembelianController::class, 'tahunan']);
    Route::get('/buy/tahunan/{thn_pembelian}', [LaporanPembelianController::class, 'cetakTahunan']);

    Route::get('/project', [LaporanProyekController::class, 'index']);
    Route::get('/project/bulanan', [LaporanProyekController::class, 'bulanan']);
    Route::get('/project/bulanan/{bln_proyek}', [LaporanProyekController::class, 'cetakBulanan']);
    Route::get('/project/tahunan', [LaporanProyekController::class, 'tahunan']);
    Route::get('/project/tahunan/{thn_proyek}', [LaporanProyekController::class, 'cetakTahunan']);
});

Route::get('/home', function () {
    if (auth()->check()) {
        return redirect()->route('client.index');
    } else {
        return redirect('/');
    };
});
