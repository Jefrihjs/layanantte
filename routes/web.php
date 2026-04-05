<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminTteController;
use App\Http\Controllers\PublicTteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermohonanController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| ROUTE PUBLIK
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect('/layanan');
});

Route::get('/layanan', [PublicTteController::class, 'index'])->name('layanan.index');
Route::post('/layanan/check', [PublicTteController::class, 'checkNik'])->name('layanan.check');
Route::post('/layanan/store', [PublicTteController::class, 'store'])->name('layanan.store');

/*
|--------------------------------------------------------------------------
| ROUTE ADMIN (AUTH)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // --- FIX ERROR: DEFINE ROUTE VERIFIKASI ---
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('status', 'verification-link-sent');
    })->middleware('throttle:6,1')->name('verification.send');

    // --- PREFIX ADMIN ---
    Route::prefix('admin')->group(function () {

        /* DASHBOARD */
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/admin', [AdminTteController::class, 'index'])->name('admin.dashboard');

        /* MANAJEMEN USER (Hanya Super Admin) */
        Route::resource('users', UserController::class);
        Route::put('/users/{id}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');

        /* DATA PERMOHONAN */
        Route::get('/permohonan', [PermohonanController::class, 'index'])->name('permohonan.index');
        Route::get('/permohonan/export', [AdminTteController::class, 'export'])->name('permohonan.export');
        Route::get('/permohonan/{id}/detail', [AdminTteController::class, 'detail'])->name('permohonan.detail');
        Route::post('/permohonan/{id}/proses', [AdminTteController::class, 'proses'])->name('permohonan.proses');
        Route::get('/permohonan/{id}/edit', [AdminTteController::class, 'edit'])->name('permohonan.edit');
        Route::put('/permohonan/{id}', [AdminTteController::class, 'update'])->name('permohonan.update');
        Route::delete('/permohonan/{id}', [AdminTteController::class, 'destroy'])->name('permohonan.destroy');
        Route::get('/permohonan/{id}', [AdminTteController::class, 'show'])->name('permohonan.show');

        /* IMPORT */
        Route::post('/permohonan/import', [AdminTteController::class, 'import'])->name('permohonan.import');

        /* |--------------------------------------------------------------------------
        | PROFILE & ACCOUNT SECURITY (FIXED)
        |--------------------------------------------------------------------------
        */
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        
        // Route khusus untuk ganti password di profil agar tidak error
        Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    });
});

require __DIR__.'/auth.php';