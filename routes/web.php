<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminTteController;
use App\Http\Controllers\PublicTteController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

//
// ===== ROUTE PUBLIK =====
//

Route::get('/permohonan', [PublicTteController::class, 'index'])
    ->name('tte.index');

Route::post('/check-nik', [PublicTteController::class, 'checkNik'])
    ->name('tte.check');

Route::post('/store', [PublicTteController::class, 'store'])
    ->name('tte.store');

// Redirect root ke halaman publik
Route::get('/', function () {
    return redirect('/permohonan');
});

//
// ===== ROUTE ADMIN =====
//
Route::get('/dashboard', function () {
    return redirect()->route('admin.permohonan');
})->middleware(['auth'])->name('dashboard');


Route::middleware(['auth'])->group(function () {

    Route::get('/admin/permohonan', [AdminTteController::class, 'index'])
        ->name('admin.permohonan');

    Route::get('/admin/permohonan/export', [AdminTteController::class, 'export'])
        ->name('admin.permohonan.export');
    
    Route::get('/admin/permohonan/{id}', [AdminTteController::class, 'show'])
    ->name('admin.permohonan.show');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
        
    Route::post('/admin/permohonan/{id}/proses', [AdminTteController::class, 'proses'])
    ->name('admin.permohonan.proses');

});

require __DIR__.'/auth.php';
