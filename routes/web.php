<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Backend\BarangController;
use App\Http\Controllers\Backend\Cart\CartPemakaianController;
use App\Http\Controllers\Backend\Cart\CartPembelianController;
use App\Http\Controllers\Backend\Cart\CartProyekController;
use App\Http\Controllers\Backend\ClientController;
use App\Http\Controllers\Backend\JSON\ProyekController as JSONProyekController;
use App\Http\Controllers\Backend\LaporanPemakaianController;
use App\Http\Controllers\Backend\LaporanPembelianController;
use App\Http\Controllers\Backend\LaporanProyekController;
use App\Http\Controllers\Backend\PemakaianController;
use App\Http\Controllers\Backend\PembelianController;
use App\Http\Controllers\Backend\ProyekController;
use App\Http\Controllers\Backend\SuplierController;
use App\Http\Controllers\Backend\UserController;

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

Route::middleware('admin')->prefix('input')->group(function () {
    Route::resource('/client', ClientController::class)->only([
        'index', 'store', 'update', 'destroy'
    ]);
    Route::resource('/suplier', SuplierController::class)->only([
        'index', 'store', 'update', 'destroy'
    ]);
    Route::resource('/barang', BarangController::class)->only([
        'index', 'store', 'update', 'destroy'
    ]);

    // cetak
    Route::get('/barang/cetak', [BarangController::class, 'cetak']);
    Route::get('/suplier/cetak', [SuplierController::class, 'cetak']);

    // pencarian
    Route::get('/client/cari', [ClientController::class, 'cariPelanggan'])->name('client.cari');
    Route::get('/suplier/cari', [SuplierController::class, 'cariSuplier'])->name('suplier.cari');
    Route::get('/barang/cari', [BarangController::class, 'cariBarang'])->name('barang.cari');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware('admin')->prefix('transaksi')->group(function () {
    // invoice
    Route::get('/proyek/invoice/panjar/{id}', [ProyekController::class, 'invoicePanjar'])->name('proyek.invoicePanjar');
    Route::get('/proyek/invoice/lunas/{id}', [ProyekController::class, 'invoiceSisa'])->name('proyek.invoiceSisa');

    // pencarian
    Route::get('/proyek/cari', [ProyekController::class, 'cariProyek'])->name('proyek.cari');
    Route::get('/pemakaian/cari', [PemakaianController::class, 'cariPemakaian'])->name('pemakaian.cari');
    Route::get('/pembelian/cari', [PembelianController::class, 'cariPembelian'])->name('pembelian.cari');

    // cart
    Route::post('/cart/pembelian', [CartPembelianController::class, 'store'])->name('cartPembelian.store');
    Route::delete('/cart/pembelian/{id}', [CartPembelianController::class, 'destroy'])->name('cartPembelian.destroy');
    Route::post('/cart/proyek', [CartProyekController::class, 'store'])->name('cartProyek.store');
    Route::delete('/cart/proyek/{id}', [CartProyekController::class, 'destroy'])->name('cartProyek.destroy');
    Route::post('/cart/pemakaian', [CartPemakaianController::class, 'store'])->name('cartPemakaian.store');
    Route::delete('/cart/pemakaian/{id}', [CartPemakaianController::class, 'destroy'])->name('cartPemakaian.destroy');

    Route::resource('/proyek', ProyekController::class);
    Route::resource('/pembelian', PembelianController::class);
    Route::resource('/pemakaian', PemakaianController::class);
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

    Route::get('/use', [LaporanPemakaianController::class, 'index']);
    Route::get('/use/harian', [LaporanPemakaianController::class, 'harian']);
    Route::get('/use/harian/{tgl_pembelian}', [LaporanPemakaianController::class, 'cetakHarian']);
    Route::get('/use/mingguan', [LaporanPemakaianController::class, 'mingguan']);
    Route::get('/use/mingguan/{tgl_pembelian_awal}/{tgl_pembelian_akhir}', [LaporanPemakaianController::class, 'cetakMingguan']);
    Route::get('/use/bulanan', [LaporanPemakaianController::class, 'bulanan']);
    Route::get('/use/bulanan/{bln_pembelian}', [LaporanPemakaianController::class, 'cetakBulanan']);
    Route::get('/use/tahunan', [LaporanPemakaianController::class, 'tahunan']);
    Route::get('/use/tahunan/{thn_pembelian}', [LaporanPemakaianController::class, 'cetakTahunan']);
});

Route::middleware('admin')->prefix('akun')->group(function () {
    Route::get('/pengguna/cari', [UserController::class, 'cariPengguna'])->name('pengguna.cari');
    Route::resource('/pengguna', UserController::class);
});

Route::get('/home', function () {
    if (auth()->check() && (auth()->user()->role === 'admin')) {
        return redirect()->route('client.index');
    } elseif (auth()->check() && (auth()->user()->role === 'super-admin')) {
        return redirect('/laporan/buy');
    } else {
        return redirect('/');
    };
});
