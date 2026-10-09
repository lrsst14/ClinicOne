<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
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
