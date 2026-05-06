<?php

use App\Http\Controllers\ProfileController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->role === 'dosen' 
            ? redirect()->route('dosen.dashboard') 
            : redirect()->route('mahasiswa.dashboard');
    }
    return redirect()->route('login');
});

Route::middleware(['auth', 'role:dosen'])->prefix('dosen')->group(function () {
    Route::get('/dashboard', function () { return view('dosen.dashboard'); })->name('dosen.dashboard');
    Route::get('/generate_qr', function () { return view('dosen.generate_qr'); });
    Route::get('/list_mahasiswa', function () { return view('dosen.list_mahasiswa'); });
    Route::get('/list_matakuliah', function () { return view('dosen.list_matakuliah'); });
    Route::get('/profile', function () { return view('dosen.profile'); });
});

Route::middleware(['auth', 'role:mahasiswa'])->prefix('mahasiswa')->group(function () {
    Route::get('/dashboard', function () { return view('mahasiswa.dashboard'); })->name('mahasiswa.dashboard');
    Route::get('/list_matakuliah', function () { return view('mahasiswa.list_matakuliah'); });
    Route::get('/profile', function () { return view('mahasiswa.profile'); });
    Route::get('/scan_qr', function () { return view('mahasiswa.scan_qr'); });
});
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
