<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Backend\BarangController;
use App\Http\Controllers\Backend\ClientController;
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
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware('auth')->prefix('transaksi')->group(function () {
    Route::resource('/proyek', ProyekController::class);
    Route::resource('/pembelian', PembelianController::class)->only([
        'index', 'store', 'update', 'destroy'
    ]);
    Route::resource('/pemakaian', PemakaianController::class);
});

Route::get('/home', function () {
    if (auth()->check()) {
        return redirect()->route('client.index');
    } else {
        return redirect('/');
    };
});
