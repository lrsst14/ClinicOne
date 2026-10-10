<?php

use App\Http\Controllers\DoctorAccessController;
use App\Http\Controllers\DoctorAppointmentController;
use App\Http\Controllers\DoctorProfileController;
use App\Http\Controllers\PatientAppointmentController;
use App\Http\Controllers\PatientLoginController;
use App\Http\Controllers\PatientRegistrationController;
use App\Http\Controllers\RegistrationChartController;
use Illuminate\Support\Facades\Route;

Route::middleware('web')->group(function () {
    Route::view('/', 'welcome')->name('home');
    Route::get('/dokter/login', [DoctorAccessController::class, 'showLoginForm'])->name('dokter.login');
    Route::redirect('/dokter', '/dokter/login')->name('dokter.legacy-login');
    Route::post('/dokter/login', [DoctorAccessController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('dokter.login.submit');
    Route::get('/dokter/dashboard', [DoctorAccessController::class, 'dashboard'])->name('dokter.dashboard');
    Route::get('/dokter/janji', [DoctorAppointmentController::class, 'index'])->name('dokter.janji');
    Route::patch('/dokter/janji/{appointment}', [DoctorAppointmentController::class, 'update'])
        ->name('dokter.janji.status');
    Route::get('/dokter/jadwal', [DoctorAccessController::class, 'pengaturanJadwal'])->name('dokter.jadwal');
    Route::get('/dokter/profil', [DoctorProfileController::class, 'show'])->name('dokter.profil');
    Route::post('/dokter/profil', [DoctorProfileController::class, 'update'])->name('dokter.profil.update');
    Route::post('/dokter/profil/kode-akses', [DoctorProfileController::class, 'updateAccessCode'])->name('dokter.profil.access-code');
    Route::get('/dokter/profil/foto', [DoctorProfileController::class, 'photo'])->name('dokter.profil.photo');
    Route::post('/dokter/logout', [DoctorAccessController::class, 'logout'])->name('dokter.logout');
});

Route::prefix('pasien')->name('pasien.')->group(function () {
    Route::get('/login', [PatientLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [PatientLoginController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('login.submit');
    Route::view('/daftar', 'pasien.daftar')->name('daftar');
    Route::post('/daftar', PatientRegistrationController::class)->name('register');

    Route::middleware('auth')->group(function () {
        Route::view('/dashboard', 'pasien.dashboard')->name('dashboard');
        Route::get('/pendaftaran', [PatientAppointmentController::class, 'index'])->name('pendaftaran');
        Route::post('/janji', [PatientAppointmentController::class, 'store'])
            ->middleware('throttle:10,1')
            ->name('janji.store');
        Route::delete('/janji/{appointment}', [PatientAppointmentController::class, 'destroy'])->name('janji.cancel');
        Route::view('/jadwal-dokter', 'pasien.jadwal-dokter')->name('jadwal');
        Route::view('/riwayat', 'pasien.riwayat')->name('riwayat');
        Route::get('/profil-dokter', [DoctorProfileController::class, 'showForPatients'])->name('profil-dokter');
        Route::post('/logout', [PatientLoginController::class, 'logout'])->name('logout');
    });
});

Route::get('/dashboard/registration-chart', RegistrationChartController::class)
    ->name('dashboard.registration-chart');
