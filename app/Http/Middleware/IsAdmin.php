<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
public function handle(Request $request, Closure $next): Response
{
    // Cukup cek ini saja, karena urusan belum login sudah ditangani oleh 'auth' bawaan Laravel + redirectTo di bootstrap/app.php
    if (auth()->user()->role !== 'admin') {
        abort(403, 'Anda bukan Admin!'); 
    }

    return $next($request);
}
}
