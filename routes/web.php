<?php

use App\Http\Controllers\RegistrationChartController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard/registration-chart', RegistrationChartController::class)
    ->name('dashboard.registration-chart');
