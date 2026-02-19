<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminTteController;
use App\Http\Controllers\PublicTteController;

/*
|--------------------------------------------------------------------------
| WEB ROUTES
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| ROUTE PUBLIK
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('tte.index');
});

// Halaman input NIK
Route::get('/permohonan', [PublicTteController::class, 'index'])
    ->name('tte.index');

// Redirect jika ada yang buka /check-nik via GET (hindari 419)
Route::get('/check-nik', function () {
    return redirect()->route('tte.index');
});

// Proses cek NIK (POST only)
Route::post('/check-nik', [PublicTteController::class, 'checkNik'])
    ->name('tte.check');

// Simpan permohonan
Route::post('/store', [PublicTteController::class, 'store'])
    ->name('tte.store');


/*
|--------------------------------------------------------------------------
| ROUTE ADMIN (AUTH)
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return redirect()->route('admin.permohonan');
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth'])->group(function () {

    Route::get('/admin', [AdminTteController::class, 'index'])
    ->name('admin.dashboard');

    Route::get('/admin/permohonan', [AdminTteController::class, 'index'])
        ->name('admin.permohonan');

    Route::get('/admin/permohonan/export', [AdminTteController::class, 'export'])
        ->name('admin.permohonan.export');

    Route::get('/admin/permohonan/{id}', [AdminTteController::class, 'show'])
        ->name('admin.permohonan.show');

    Route::post('/admin/permohonan/{id}/proses', [AdminTteController::class, 'proses'])
        ->name('admin.permohonan.proses');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__.'/auth.php';
