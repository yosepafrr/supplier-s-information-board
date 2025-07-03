<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProsesController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [ProsesController::class, 'dashboard'])->name('supply.dashboard');
Route::get('/supply/user/reg', [ProsesController::class, 'registrasi'])->name('supply.user.user-reg');
Route::get('/supply/user/monitor', [ProsesController::class, 'monitor_user'])->name('supply.user.user-monitor');
Route::get('/supply/user/test', [ProsesController::class, 'test'])->name('supply.user.user-test');
Route::post('/supply/user/submit', [ProsesController::class, 'submit'])->name('supply.user.submit');
Route::get('/monitor/check-update', [ProsesController::class, 'cekUpdateTerakhir']);


// Admin routes
Route::get('/supply/admin/qc', [AdminController::class, 'qc'])->name('supply.admin.qc');
Route::get('/supply/admin/ppic', [AdminController::class, 'ppic'])->name('supply.admin.ppic');
Route::post('/supply/admin/qc/update-status', [AdminController::class, 'updateStatusOnQc'])->name('supply.admin.qc.updateStatus');
Route::post('/supply/admin/ppic/approve', [AdminController::class, 'approve'])->name('supply.admin.ppic.approve');
Route::post('/supply/admin/ppic/input-nsj', [AdminController::class, 'inputSuratJalan'])->name('supply.admin.ppic.input-nsj');
