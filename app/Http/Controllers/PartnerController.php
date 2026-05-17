<?php

namespace App\Http\Controllers;
use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function index()
    {
        $partners = Partner::all(); 
        return view('admin.partners.index', compact('partners')); 
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo_url' => 'required|string',
        ]);
        Partner::create([
            'name' => $request->name,
            'logo_url' => $request->logo_url,
        ]);
        return redirect()->route('admin.partners.index')->with('success', 'Partner baru berhasil ditambahkan!');
    }
}
