<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/satuan', [SatuanController::class, 'search'])->name('satuan.search');
Route::get('/produk', [BarangController::class, 'search'])->name('produk.search');
Route::get('/user', [UserController::class, 'search'])->name('user.search');
Route::get('/penjualan', [PenjualanController::class, 'search'])->name('penjualan.search');
Route::get('/penjualan/produk', [PenjualanController::class, 'searchProduk'])->name('penjualan.searchProduk');
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/cart', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/change/', [CartController::class, 'change'])->name('cart.change');
    Route::post('/cart/change/{detail}', [CartController::class, 'change']);
    Route::delete('/cart', [CartController::class, 'delete'])->name('cart.delete');
    Route::delete('/cart/{detail}', [CartController::class, 'delete']);
    Route::delete('/cart/reset', [CartController::class, 'reset'])->name('cart.reset');
    Route::post('/penjualan/checkout', [PenjualanController::class, 'store'])->name('penjualan.checkout');
    Route::put('/user/change-password/{user}', [UserController::class, 'change_password'])->name('user.change_password');
});
