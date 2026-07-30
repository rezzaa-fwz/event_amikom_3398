<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Review;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReviewController extends Controller
{
    public function store(Request $request, Event $event)
    {
        if (! auth()->check()) {
            return back()->with('error', 'Silakan login terlebih dahulu untuk memberi ulasan.');
        }

        $user = auth()->user();

        // 1. Pastikan user pernah membeli tiket event ini dan transaksinya sukses.
        $hasPurchased = Transaction::where('event_id', $event->id)
            ->where(function ($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->orWhere('customer_email', $user->email);
            })
            ->whereIn('status', ['success', 'settlement'])
            ->exists();

        if (! $hasPurchased) {
            return back()->with('error', 'Anda belum membeli tiket event ini atau transaksi Anda belum lunas.');
        }

        // 2. Pastikan event sudah diselenggarakan (waktu event sudah lewat/sudah berlangsung)
        $eventDate = Carbon::parse($event->date);
        if (now()->lt($eventDate)) {
            return back()->with('error', 'Ulasan hanya dapat diberikan setelah Anda mengikuti event (acara telah berlangsung).');
        }

        // 3. Cegah review ganda
        $alreadyReviewed = Review::where('user_id', $user->id)
            ->where('event_id', $event->id)
            ->exists();

        if ($alreadyReviewed) {
            return back()->with('error', 'Anda sudah pernah memberikan ulasan untuk event ini.');
        }

        // 4. Validasi input
        $data = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        Review::create([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'rating' => $data['rating'],
            'comment' => $data['comment'] ?? null,
        ]);

        return back()->with('success', 'Terima kasih! Ulasan Anda berhasil dikirim.');
    }
}