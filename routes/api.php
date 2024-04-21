<?php

use App\Http\Controllers\BarangController;
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
