<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MahasiswaController;

Route::resource('mahasiswa', MahasiswaController::class);