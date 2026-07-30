<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrganizationRegistrationController extends Controller
{
    public function create()
    {
        return view('organization-register');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'organization_name' => 'required|string|max:255',
            'admin_name' => 'required|string|max:255',
            'admin_email' => 'required|email|unique:users,email',
            'admin_password' => 'required|string|min:8|confirmed',
        ]);

        // 1. Buat akun admin untuk organization ini
        $user = User::create([
            'name' => $data['admin_name'],
            'email' => $data['admin_email'],
            'password' => bcrypt($data['admin_password']),
            'role' => 'admin',
        ]);

        // 2. Buat organization, status default "pending" sampai di-approve superadmin
        $organization = Organization::create([
            'name' => $data['organization_name'],
            'slug' => Str::slug($data['organization_name']) . '-' . Str::random(4),
            'owner_user_id' => $user->id,
            'status' => 'pending',
        ]);

        // 3. Sambungkan user ke organization yang baru dibuat
        $user->update(['organization_id' => $organization->id]);

        return redirect()->route('organizations.register')
            ->with('success', 'Pendaftaran berhasil! Akun kepanitiaan Anda akan aktif setelah disetujui oleh Superadmin.');
    }
}