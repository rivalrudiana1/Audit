<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TpuController;

Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Semua User Login
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::controller(AuditController::class)->group(function () {
        Route::get('/audit', 'index');
        Route::post('/audit/generate', 'generate');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->group(function () {

    Route::resource('users', UserController::class);

    Route::resource('tpus', TpuController::class);
});

/*
|--------------------------------------------------------------------------
| Admin + Kepala TPU
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::controller(UploadController::class)->group(function () {
        Route::get('/upload', 'index');
        Route::post('/upload', 'store');
    });

});

require __DIR__.'/auth.php';