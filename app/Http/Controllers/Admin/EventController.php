<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Category;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Event::with(['category', 'partner', 'organization']);

        // Superadmin lihat semua event dari semua organization.
        // Admin biasa cuma lihat event milik organization-nya sendiri.
        if (! auth()->user()->isSuperAdmin()) {
            $query->where('organization_id', auth()->user()->organization_id);
        }

        // Search by title, location, or description
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $events = $query->latest()->paginate(10);
        $events->appends($request->except('page'));

        return view('admin.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $partners = Partner::orderBy('name')->get();
        return view('admin.events.create', compact('categories', 'partners'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Menerapkan validasi data request dari pengguna
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|numeric|min:1',
            'poster' => 'nullable|image|max:2048' // Maksimal 2MB
        ]);

        // Event otomatis jadi milik organization user yang sedang login
        $data['organization_id'] = auth()->user()->organization_id;

        if ($request->hasFile('poster')) {
            // Simpan ke direktori storage/app/public/posters
            $data['poster_path'] = $request->file('poster')->store('posters', 'public');
        }

        // Menyimpan data yang telah divalidasi ke dalam tabel menggunakan Model
        Event::create($data);

        return redirect()->route('admin.events.index')->with('success', 'Data Event berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        $this->authorizeOrganizationAccess($event);

        $categories = Category::orderBy('name')->get();
        $partners = Partner::orderBy('name')->get();
        return view('admin.events.edit', compact('event', 'categories', 'partners'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $this->authorizeOrganizationAccess($event);

        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|numeric|min:1',
            'poster' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('poster')) {
            // Hapus gambar lama jika sebelumnya sudah memiliki poster
            if ($event->poster_path) {
                Storage::disk('public')->delete($event->poster_path);
            }
            // Upload gambar baru
            $data['poster_path'] = $request->file('poster')->store('posters', 'public');
        }

        $event->update($data);
        return redirect()->route('admin.events.index')->with('success', 'Event berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $this->authorizeOrganizationAccess($event);

        if ($event->poster_path) {
            Storage::disk('public')->delete($event->poster_path);
        }
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Data event berhasil dihapus secara permanen.');
    }

    /**
     * Cegah admin satu organization mengedit/menghapus event milik organization lain
     * lewat manipulasi URL/ID secara manual. Superadmin dikecualikan dari pembatasan ini.
     */
    private function authorizeOrganizationAccess(Event $event): void
    {
        if (auth()->user()->isSuperAdmin()) {
            return;
        }

        if ($event->organization_id !== auth()->user()->organization_id) {
            abort(403, 'Anda tidak memiliki akses ke event ini.');
        }
    }
}