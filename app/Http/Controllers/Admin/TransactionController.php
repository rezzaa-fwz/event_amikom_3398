<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index()
    {
        $query = Transaction::with('event');

        // Admin biasa cuma lihat transaksi dari event milik organization-nya sendiri.
        // Transaction tidak punya organization_id langsung, jadi kita filter lewat relasi event.
        if (! auth()->user()->isSuperAdmin()) {
            $organizationId = auth()->user()->organization_id;
            $query->whereHas('event', function ($q) use ($organizationId) {
                $q->where('organization_id', $organizationId);
            });
        }

        $transactions = $query->latest()->paginate(20);

        return view('admin.transactions.index', compact('transactions'));
    }
}