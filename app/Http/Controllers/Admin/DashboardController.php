<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Transaction;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $isSuperAdmin = auth()->user()->isSuperAdmin();
        $organizationId = auth()->user()->organization_id;

        // Query dasar transaksi & event, discope per organization kecuali superadmin
        $transactionQuery = Transaction::query();
        $eventQuery = Event::query();

        if (! $isSuperAdmin) {
            $transactionQuery->whereHas('event', function ($q) use ($organizationId) {
                $q->where('organization_id', $organizationId);
            });
            $eventQuery->where('organization_id', $organizationId);
        }

        // 1. Menjumlahkan semua nominal total_price dari kolom Transaksi Lunas
        $totalRevenue = (clone $transactionQuery)
            ->whereIn('status', ['settlement', 'success'])
            ->sum('total_price');

        // 2. Menghitung Berapa orang tamu yang tiketnya sudah Lunas
        $ticketsSold = (clone $transactionQuery)
            ->whereIn('status', ['settlement', 'success'])
            ->count();

        // 3. Menghitung Jumlah Acara Mendatang yang aktif diselenggarakan
        $activeEvents = (clone $eventQuery)->where('date', '>=', now())->count();

        // 4. Menghitung Transaksi Ngadat (Status belum dibayar pelanggan / Expired)
        $pendingOrders = (clone $transactionQuery)->where('status', 'pending')->count();

        // 5. Menyertakan 5 daftar riwayat pesanan (History) paling mutakhir di panel
        $recentTransactions = (clone $transactionQuery)->with('event')->latest()->take(5)->get();

        // 6. Data grafik: Pertumbuhan Event & Tren Pendapatan, 6 bulan terakhir
        $months = collect(range(5, 0))->map(fn ($i) => now()->startOfMonth()->subMonths($i));

        $eventGrowth = $months->map(function (Carbon $month) use ($eventQuery) {
            return [
                'label' => $month->translatedFormat('M Y'),
                'count' => (clone $eventQuery)
                    ->whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->count(),
            ];
        });

        $revenueTrend = $months->map(function (Carbon $month) use ($transactionQuery) {
            return [
                'label' => $month->translatedFormat('M Y'),
                'total' => (clone $transactionQuery)
                    ->whereIn('status', ['settlement', 'success'])
                    ->whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->sum('total_price'),
            ];
        });

        return view('admin.dashboard', compact(
            'totalRevenue',
            'ticketsSold',
            'activeEvents',
            'pendingOrders',
            'recentTransactions',
            'eventGrowth',
            'revenueTrend'
        ));
    }
}