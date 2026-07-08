<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\KdsController;
use App\Http\Controllers\PackageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// ==========================================
// Route bawaan Breeze (Profile)
// ==========================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ==========================================
// SEMUA HALAMAN
// ==========================================
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', ProductController::class);
    Route::resource('packages', PackageController::class);
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export/excel', [ReportController::class, 'exportExcel'])->name('reports.export.excel');
    Route::get('/reports/export/pdf', [ReportController::class, 'exportPdf'])->name('reports.export.pdf');

    // Shift Management
    Route::get('/shift', [ShiftController::class, 'index'])->name('shift.index');
    Route::post('/shift/open', [ShiftController::class, 'open'])->name('shift.open');
    Route::post('/shift/close', [ShiftController::class, 'close'])->name('shift.close');

    // POS
    Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
    Route::post('/pos/checkout', [PosController::class, 'checkout'])->name('pos.checkout');

    // Kitchen Display System
    Route::get('/kds', [KdsController::class, 'index'])->name('kds.index');
    Route::patch('/kds/{transaction}/status', [KdsController::class, 'updateStatus'])->name('kds.status.update');
});

require __DIR__.'/auth.php';
