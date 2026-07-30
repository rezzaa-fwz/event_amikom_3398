<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrganizationProfileController extends Controller
{
    /**
     * Tampilkan form edit profil organisasi yang sedang login.
     */
    public function edit()
    {
        $organization = auth()->user()->organization;

        if (! $organization) {
            abort(404, 'Organisasi tidak ditemukan.');
        }

        return view('admin.org-profile', compact('organization'));
    }

    /**
     * Simpan perubahan profil organisasi.
     */
    public function update(Request $request)
    {
        $organization = auth()->user()->organization;

        if (! $organization) {
            abort(404, 'Organisasi tidak ditemukan.');
        }

        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'logo'        => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            // Hapus logo lama
            if ($organization->logo_path) {
                Storage::disk('public')->delete($organization->logo_path);
            }
            $data['logo_path'] = $request->file('logo')->store('logos', 'public');
        }

        unset($data['logo']); // Jangan simpan field 'logo' ke DB
        $organization->update($data);

        return back()->with('success', 'Profil organisasi berhasil diperbarui.');
    }
}
