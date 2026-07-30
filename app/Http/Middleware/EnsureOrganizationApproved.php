<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureOrganizationApproved
{
    /**
     * Pastikan admin hanya bisa akses dashboard jika organisasinya sudah approved.
     * Superadmin dikecualikan dari pengecekan ini.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        // Superadmin selalu lolos
        if ($user && $user->isSuperAdmin()) {
            return $next($request);
        }

        // Admin yang punya organisasi dengan status pending → halaman tunggu
        if ($user && $user->organization && $user->organization->status === 'pending') {
            return redirect()->route('admin.org.pending');
        }

        // Admin dengan organisasi suspended → halaman ditangguhkan
        if ($user && $user->organization && $user->organization->status === 'suspended') {
            return redirect()->route('admin.org.suspended');
        }

        return $next($request);
    }
}
