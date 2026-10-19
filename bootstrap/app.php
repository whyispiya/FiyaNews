<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // 🛠️ TAMBAHKAN BARIS INI UNTUK MENJINAKKAN REDIRECT LAUTAN AUTH
        $middleware->redirectTo(
            guests: '/login',      // Kalau belum login diusir ke /login
            users: '/'             // TAPI KALAU SUDAH LOGIN, LEMPAR KE ARTIKEL UTAMA (/)
        );
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();