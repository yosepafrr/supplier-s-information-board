<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArsipController;
use App\Http\Controllers\ProsesController;
use App\Http\Controllers\PanggilanController;
use App\Livewire\PageRekapitulasi;

// MIDDLEWARE
// 🟢 Semua user bisa akses
Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });
});

// 🟠 User biasa
Route::middleware(['auth', 'role:supplier'])->group(function () {
    Route::get('/supply/user/reg', [ProsesController::class, 'registrasi'])->name('supply.user.user-reg');
});

// 🔵 Admin QC
Route::middleware(['auth', 'role:admin_qc,qc_manager,super_admin'])->group(function () {
    Route::get('/supply/admin/qc', [AdminController::class, 'qc'])->name('supply.admin.qc');
});

// 🟣 Admin PPIC
Route::middleware(['auth', 'role:admin_ppic,ppic_manager,super_admin'])->group(function () {
    Route::get('/supply/admin/ppic', [AdminController::class, 'ppic'])->name('supply.admin.ppic');
});


// 🟠 Admin QC and PPIC Can access Arsip and Monitor
Route::middleware(['auth', 'role:admin_ppic,admin_qc,super_admin,qc_manager,ppic_manager'])->group(function () {
    // Arsip routes
    Route::get('/arsip/ng', [ArsipController::class, 'arsipNg'])->name('arsip.ng');
    Route::get('/arsip/hold', [ArsipController::class, 'arsipHold'])->name('arsip.hold');
    Route::get('/supply/user/monitor', [ProsesController::class, 'monitor_user'])->name('supply.user.user-monitor');
});


// 🟠 Admin PPIC, Admin QC, Super Admin, and User can access monitor
Route::middleware(['auth', 'role:admin_ppic,admin_qc,super_admin,supplier,qc_manager,ppic_manager'])->group(function () {
    Route::get('/supply/user/monitor', [ProsesController::class, 'monitor_user'])->name('supply.user.user-monitor');
});

// 🟠 Super Admin
Route::middleware(['auth', 'role:super_admin'])->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
});

// MIDDLEWARE END


// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



// Supply routes
Route::post('/supply/user/submit', [ProsesController::class, 'submit'])->name('supply.user.submit');
Route::get('/monitor/check-update', [ProsesController::class, 'cekUpdateTerakhir']);


// Admin routes
Route::post('/supply/admin/qc/update-status', [AdminController::class, 'updateStatusOnQc'])->name('supply.admin.qc.updateStatus');
Route::post('/supply/admin/ppic/approve', [AdminController::class, 'approve'])->name('supply.admin.ppic.approve');
Route::post('/supply/admin/ppic/input-nsj', [AdminController::class, 'inputSuratJalan'])->name('supply.admin.ppic.input-nsj');




// Pemanggilan routes
Route::post('supply/admin/qc/panggilan/panggil', [ProsesController::class, 'panggil'])->name('admin.qc.panggilan.panggil');
Route::post('supply/admin/ppic/panggilan/panggil', [ProsesController::class, 'panggil'])->name('admin.ppic.panggilan.panggil');
Route::get('/monitor/check-panggilan', [ProsesController::class, 'cekPanggilanTerbaru']);


// Notification routes
Route::get('/admin/qc/check-update', [AdminController::class, 'checkUpdateQc']);
Route::get('/admin/ppic/check-update', [AdminController::class, 'checkUpdatePpic']);


// REKAPITULASI
// 🟠 Super Admin
Route::middleware(['auth', 'role:qc_manager,ppic_manager,super_admin'])->group(function () {
    Route::get('/rekapitulasi', [ProsesController::class, 'showRekapitulasi'])->name('rekapitulasi');
});
