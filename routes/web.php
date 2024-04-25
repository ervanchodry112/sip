<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'login_attempt'])->name('login.attempt');
});

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'dashboard'])->name('home');

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/bukti-transaksi/{penjualan}', [PenjualanController::class, 'bukti_transaksi'])->name('penjualan.bukti-transaksi');

    Route::resources([
        'produk'    => BarangController::class,
        'satuan'    => SatuanController::class,
        'user'      => UserController::class,
        'penjualan' => PenjualanController::class,
    ]);
});
