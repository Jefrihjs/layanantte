<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminTteController;
use App\Http\Controllers\PublicTteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermohonanController;

/*
|--------------------------------------------------------------------------
| ROUTE PUBLIK
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect('/layanan');
});

Route::get('/layanan', [PublicTteController::class, 'index'])
    ->name('layanan.index');

Route::post('/layanan/check', [PublicTteController::class, 'checkNik'])
    ->name('layanan.check');

Route::post('/layanan/store', [PublicTteController::class, 'store'])
    ->name('layanan.store');

/*
|--------------------------------------------------------------------------
| ROUTE ADMIN (AUTH)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->middleware(['auth'])
    ->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD (Monitoring Only)
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | DATA PERMOHONAN (Operasional)
    |--------------------------------------------------------------------------
    */
    Route::get('/permohonan', [PermohonanController::class, 'index'])
        ->name('permohonan.index');

    Route::get('/permohonan/export', [AdminTteController::class, 'export'])
        ->name('permohonan.export');

    Route::get('/permohonan/{id}', [AdminTteController::class, 'show'])
        ->name('permohonan.show');

    Route::post('/permohonan/{id}/proses', [AdminTteController::class, 'proses'])
        ->name('permohonan.proses');


    /*
    |--------------------------------------------------------------------------
    | IMPORT (Opsional)
    |--------------------------------------------------------------------------
    */
    Route::post('/permohonan/import', [AdminTteController::class, 'import'])
        ->name('permohonan.import');


    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__.'/auth.php';
