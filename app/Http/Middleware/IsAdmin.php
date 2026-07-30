<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if (! in_array($user->role, ['admin', 'superadmin'])) {
            abort(403, 'Anda bukan Admin!');
        }

        // Superadmin tidak terikat organization, jadi dilewati dari pengecekan status.
        if ($user->role === 'admin') {
            $organization = $user->organization;

            if (! $organization || $organization->status !== 'approved') {
                auth()->logout();
                return redirect()->route('admin.login')
                    ->with('error', 'Organization Anda belum disetujui atau sedang ditangguhkan oleh Superadmin.');
            }
        }

        return $next($request);
    }
}