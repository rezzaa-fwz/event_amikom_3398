<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\Transaction;

class OrganizationController extends Controller
{
    private function checkSuperAdmin(): void
    {
        if (! auth()->user()->isSuperAdmin()) {
            abort(403, 'Hanya Superadmin yang bisa mengelola organization.');
        }
    }

    public function index()
    {
        $this->checkSuperAdmin();

        $query = Organization::withCount('events')->with('owner');

        // Filter berdasarkan status (jika ada)
        $status = request('status', 'all');
        if ($status !== 'all' && in_array($status, ['pending', 'approved', 'suspended'])) {
            $query->where('status', $status);
        }

        $organizations = $query->latest()->paginate(15)->withQueryString();

        // Tambahkan statistik revenue & tiket per-org
        $organizations->each(function ($org) {
            $eventIds = $org->events()->pluck('id');
            $org->total_revenue = Transaction::whereIn('event_id', $eventIds)
                ->whereIn('status', ['settlement', 'success'])
                ->sum('total_price');
            $org->tickets_sold = Transaction::whereIn('event_id', $eventIds)
                ->whereIn('status', ['settlement', 'success'])
                ->count();
        });

        return view('admin.organizations.index', compact('organizations'));
    }

    public function show(Organization $organization)
    {
        $this->checkSuperAdmin();

        $organization->load('owner', 'events.category');

        $eventIds = $organization->events->pluck('id');

        $stats = [
            'total_revenue'   => Transaction::whereIn('event_id', $eventIds)->whereIn('status', ['settlement', 'success'])->sum('total_price'),
            'tickets_sold'    => Transaction::whereIn('event_id', $eventIds)->whereIn('status', ['settlement', 'success'])->count(),
            'active_events'   => $organization->events()->where('date', '>=', now())->count(),
            'pending_orders'  => Transaction::whereIn('event_id', $eventIds)->where('status', 'pending')->count(),
            'total_events'    => $organization->events_count ?? $organization->events()->count(),
        ];

        $recentTransactions = Transaction::whereIn('event_id', $eventIds)
            ->with('event')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.organizations.show', compact('organization', 'stats', 'recentTransactions'));
    }

    public function approve(Organization $organization)
    {
        $this->checkSuperAdmin();
        $organization->update(['status' => 'approved']);
        return back()->with('success', "Organisasi \"{$organization->name}\" berhasil disetujui.");
    }

    public function suspend(Organization $organization)
    {
        $this->checkSuperAdmin();
        $organization->update(['status' => 'suspended']);
        return back()->with('success', "Organisasi \"{$organization->name}\" telah ditangguhkan.");
    }
}