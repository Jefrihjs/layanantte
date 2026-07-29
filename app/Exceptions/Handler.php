<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException; // Tambahkan ini

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        // Tambahkan blok kode ini untuk menangani error akses URL langsung
        $this->renderable(function (MethodNotAllowedHttpException $e, $request) {
            // Jika request tersebut mengharapkan balasan JSON (dari AJAX/Fetch)
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Metode tidak diizinkan.'], 405);
            }

            // Jika dibuka langsung di browser, arahkan kembali ke halaman sebelumnya
            // atau ke halaman utama jika tidak ada halaman sebelumnya
            return redirect()->back()->with('error', 'Akses langsung ke halaman ini tidak diizinkan.');
        });
    }
}