<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PartnerController extends Controller
{
    public function index(Request $request)
    {
        $query = Partner::query();
        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }
        $partners = $query->latest()->paginate(10);
        return view('admin.partners.index', compact('partners'));
    }

    public function create() { return view('admin.partners.create'); }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Tambahkan 'required' di sini
    ]);

    if ($request->hasFile('logo')) {
        $logo_url = $request->file('logo')->store('partners', 'public');
        
        Partner::create([
            'name' => $request->name,
            'logo_url' => $logo_url // Sekarang ini tidak akan null karena sudah divalidasi
        ]);

        return redirect()->route('admin.partners.index')->with('success', 'Partner berhasil ditambahkan.');
    }
    
    // Jika flow gagal masuk ke hasFile (jarang terjadi jika divalidasi)
    return back()->withErrors(['logo' => 'Logo wajib diunggah.']);
}

    public function edit(Partner $partner) { return view('admin.partners.edit', compact('partner')); }

    public function update(Request $request, Partner $partner)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            if ($partner->logo_url) {
                Storage::disk('public')->delete($partner->logo_url);
            }
            $partner->logo_url = $request->file('logo')->store('partners', 'public');
        }

        $partner->name = $request->name;
        $partner->save();

        return redirect()->route('admin.partners.index')->with('success', 'Partner diperbarui.');
    }

    public function destroy(Partner $partner)
    {
        if ($partner->logo_url) {
            Storage::disk('public')->delete($partner->logo_url);
        }
        $partner->delete();
        return redirect()->route('admin.partners.index')->with('success', 'Partner dihapus.');
    }
}