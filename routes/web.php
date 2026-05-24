<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\AuditController;

// 1. Halaman Utama / Dashboard
Route::get('/', [DashboardController::class, 'index']);


// 2. Fitur Upload
Route::controller(UploadController::class)->group(function () {
    Route::get('/upload', 'index');
    Route::post('/upload', 'store');
});


// 3. Fitur Audit
Route::controller(AuditController::class)->group(function () {
    Route::get('/audit', 'index');
    Route::post('/audit/generate', 'generate');
});
