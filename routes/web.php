<?php

use App\Http\Controllers\DoctorAccessController;
use App\Http\Controllers\RegistrationChartController;
use Illuminate\Support\Facades\Route;

Route::middleware('web')->group(function () {
    Route::get('/', [DoctorAccessController::class, 'showLoginForm'])->name('home');
    Route::get('/dokter', [DoctorAccessController::class, 'showLoginForm'])->name('dokter.login');
    Route::post('/dokter/login', [DoctorAccessController::class, 'login'])->name('dokter.login.submit');
    Route::get('/dokter/dashboard', [DoctorAccessController::class, 'dashboard'])->name('dokter.dashboard');
    Route::get('/dokter/janji', [DoctorAccessController::class, 'kelolaJanji'])->name('dokter.janji');
    Route::get('/dokter/jadwal', [DoctorAccessController::class, 'pengaturanJadwal'])->name('dokter.jadwal');
    Route::get('/dokter/profil', [DoctorAccessController::class, 'profilDokter'])->name('dokter.profil');
    Route::post('/dokter/logout', [DoctorAccessController::class, 'logout'])->name('dokter.logout');
});

Route::prefix('pasien')->name('pasien.')->group(function () {
    Route::view('/login', 'pasien.login')->name('login');
    Route::view('/daftar', 'pasien.daftar')->name('daftar');
    Route::view('/dashboard', 'pasien.dashboard')->name('dashboard');
    Route::view('/pendaftaran', 'pasien.pendaftaran')->name('pendaftaran');
    Route::view('/jadwal-dokter', 'pasien.jadwal-dokter')->name('jadwal');
    Route::view('/riwayat', 'pasien.riwayat')->name('riwayat');
    Route::view('/profil-dokter', 'pasien.profil-dokter')->name('profil-dokter');
});

Route::get('/dashboard/registration-chart', RegistrationChartController::class)
    ->name('dashboard.registration-chart');
