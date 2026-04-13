<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PresensiController;

Route::resource('mahasiswa', MahasiswaController::class);


Route::get('/qr', [PresensiController::class, 'qr']);
Route::get('/absen', [PresensiController::class, 'form']);
Route::post('/absen', [PresensiController::class, 'store']);