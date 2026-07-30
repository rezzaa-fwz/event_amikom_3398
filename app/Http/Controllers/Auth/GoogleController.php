<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    // Tombol Google di halaman /login (user biasa)
    public function redirect()
    {
        session(['google_intent' => 'user']);
        return Socialite::driver('google')->redirect();
    }

    // Tombol Google di halaman /admin/login
    public function adminRedirect()
    {
        session(['google_intent' => 'admin']);
        return Socialite::driver('google')->redirect();
    }

    // Callback ini dipakai bersama oleh dua alur di atas, dibedakan lewat session 'google_intent'
    public function callback()
    {
        $intent = session()->pull('google_intent', 'user');

        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            $loginRoute = $intent === 'admin' ? 'admin.login' : 'login';
            return redirect()->route($loginRoute)
                ->with('error', 'Login dengan Google gagal. Silakan coba lagi.');
        }

        if ($intent === 'admin') {
            return $this->handleAdminLogin($googleUser);
        }

        return $this->handleUserLogin($googleUser);
    }

    private function handleUserLogin($googleUser)
    {
        // 1. Cari user berdasarkan provider_id (pernah login Google sebelumnya)
        $user = User::where('provider', 'google')
                    ->where('provider_id', $googleUser->getId())
                    ->first();

        // 2. Kalau belum ada, cari berdasarkan email (punya akun manual sebelumnya)
        if (! $user) {
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                $user->update([
                    'provider' => 'google',
                    'provider_id' => $googleUser->getId(),
                ]);
            }
        }

        // 3. Kalau belum ada sama sekali, buat akun user baru
        if (! $user) {
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'provider' => 'google',
                'provider_id' => $googleUser->getId(),
                'password' => null,
                'role' => 'user',
            ]);
        }

        Auth::login($user);

        return redirect()->intended('/');
    }

    private function handleAdminLogin($googleUser)
    {
        // Cari user berdasarkan email — TIDAK membuat akun baru sama sekali di alur admin
        $user = User::where('email', $googleUser->getEmail())->first();

        if (! $user || ! in_array($user->role, ['admin', 'superadmin'])) {
            return redirect()->route('admin.login')
                ->with('error', 'Akun Google ini belum terdaftar sebagai Admin. Hubungi Superadmin untuk mendapatkan akses.');
        }

        // Superadmin tidak terikat organization, dilewati dari cek status approval
        if ($user->role === 'admin') {
            $organization = $user->organization;

            if (! $organization || $organization->status !== 'approved') {
                return redirect()->route('admin.login')
                    ->with('error', 'Organization Anda belum disetujui atau sedang ditangguhkan oleh Superadmin.');
            }
        }

        // Sambungkan info provider Google ke akun admin ini (opsional, biar konsisten)
        if ($user->provider !== 'google') {
            $user->update([
                'provider' => 'google',
                'provider_id' => $googleUser->getId(),
            ]);
        }

        Auth::login($user);

        return redirect()->route('admin.dashboard');
    }
}