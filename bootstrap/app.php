<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\IsAdmin;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
    
        // Daftarkan alias middleware kamu di sini
        $middleware->alias([
            'admin' => IsAdmin::class,
        ]);

        // Ini yang kita tambahkan di langkah sebelumnya (jika ada)
        $middleware->redirectTo('admin/login'); 
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
