<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Dosen\QRController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MatakuliahController;
use App\Http\Controllers\Mahasiswa;
use App\Http\Controllers\Dosen;

Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->role === 'dosen'
            ? redirect()->route('dosen.dashboard')
            : redirect()->route('mahasiswa.dashboard');
    }
    return redirect()->route('login');
});

Route::middleware(['auth', 'role:dosen'])->prefix('dosen')->group(function () {
    Route::get('/dashboard', [Dosen\DashboardController::class, 'index'])->name('dosen.dashboard');
    Route::get('/list_mahasiswa', [MahasiswaController::class, 'dosenIndex'])->name('dosen.mahasiswa.index');
    Route::post('/list_mahasiswa', [MahasiswaController::class, 'store'])->name('dosen.mahasiswa.store');
    Route::put('/list_mahasiswa/{mahasiswa}', [MahasiswaController::class, 'update'])->name('dosen.mahasiswa.update');
    Route::delete('/list_mahasiswa/{mahasiswa}', [MahasiswaController::class, 'destroy'])->name('dosen.mahasiswa.destroy');

    Route::get('/list_matakuliah', [MatakuliahController::class, 'dosenIndex'])->name('dosen.matakuliah.index');
    Route::post('/list_matakuliah', [MatakuliahController::class, 'store'])->name('dosen.matakuliah.store');
    Route::put('/list_matakuliah/{matakuliah}', [MatakuliahController::class, 'update'])->name('dosen.matakuliah.update');
    Route::delete('/list_matakuliah/{matakuliah}', [MatakuliahController::class, 'destroy'])->name('dosen.matakuliah.destroy');

    Route::get('/profile', [Dosen\ProfileController::class, 'show'])->name('dosen.profile');
    Route::put('/profile', [Dosen\ProfileController::class, 'update'])->name('dosen.profile.update');
    Route::put('/profile/password', [Dosen\ProfileController::class, 'updatePassword'])->name('dosen.profile.password');

    Route::get('/generate_qr', [QRController::class, 'index']);
    Route::get('/generate_qr/presensis', [QRController::class, 'presensis']);
    Route::post('/generate_qr/process', [QRController::class, 'store']);

    Route::get('/izin_mahasiswa', [Dosen\IzinController::class, 'index'])->name('dosen.izin.index');
    Route::patch('/izin_mahasiswa/{izin}/approve', [Dosen\IzinController::class, 'approve'])->name('dosen.izin.approve');
    Route::patch('/izin_mahasiswa/{izin}/reject', [Dosen\IzinController::class, 'reject'])->name('dosen.izin.reject');
});

Route::middleware(['auth', 'role:mahasiswa'])->prefix('mahasiswa')->group(function () {

    Route::get('/profile', [Mahasiswa\ProfileController::class, 'show'])->name('mahasiswa.profile');
    Route::get('/dashboard', [Mahasiswa\DashboardController::class, 'index'])->name('mahasiswa.dashboard');
    Route::get('/list_matakuliah', [MatakuliahController::class, 'mahasiswaIndex'])->name('mahasiswa.matakuliah.index');

    Route::get('/izin', [Mahasiswa\IzinController::class, 'index'])->name('mahasiswa.izin.index');
    Route::post('/izin', [Mahasiswa\IzinController::class, 'store'])->name('mahasiswa.izin.store');
    Route::delete('/izin/{izin}', [Mahasiswa\IzinController::class, 'destroy'])->name('mahasiswa.izin.destroy');

    Route::get('/scan_qr', function () {return view('mahasiswa.scan_qr');});
    Route::get('/scan/{token}', [Mahasiswa\ScanQRController::class, 'scan']);
    Route::post('/scan/process', [Mahasiswa\ScanQRController::class, 'process']);

    // PUBLIC API
    Route::get('/list_matakuliah/api',[MatakuliahController::class, 'apiMahasiswaIndex']);
    Route::get('/dashboard/api',[Mahasiswa\DashboardController::class, 'apiDashboard']);
    Route::get('/izin/api',[Mahasiswa\IzinController::class, 'apiIndex']);
    Route::post('/izin/api',[Mahasiswa\IzinController::class, 'apiStore']);
    Route::delete('/izin/api/{izin}',[Mahasiswa\IzinController::class, 'apiDestroy']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
