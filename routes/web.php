<?php

use App\Http\Controllers\ProsesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [ProsesController::class, 'dashboard'])->name('supply.dashboard');
Route::get('/supply/user/reg', [ProsesController::class, 'registrasi'])->name('supply.user.user-reg');
Route::get('/supply/user/monitor', [ProsesController::class, 'monitor_user'])->name('supply.user.user-monitor');
Route::get('/supply/user/test', [ProsesController::class, 'test'])->name('supply.user.user-test');
Route::post('/supply/user/submit', [ProsesController::class, 'submit'])->name('supply.user.submit');
Route::get('/monitor/check-update', [ProsesController::class, 'cekUpdateTerakhir']);
