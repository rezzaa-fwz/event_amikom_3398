@php
    $avgRating = $event->averageRating();
    $reviews = $event->reviews()->with('user')->latest()->get();
@endphp

<div class="max-w-5xl mx-auto px-6 py-16 border-t border-slate-100">
    <div class="flex items-center gap-3 mb-8">
        <h2 class="text-2xl font-extrabold">Ulasan Peserta</h2>
        @if ($avgRating)
            <div class="flex items-center gap-1 px-3 py-1 bg-amber-50 rounded-full">
                <span class="text-amber-500 font-bold">★ {{ number_format($avgRating, 1) }}</span>
                <span class="text-slate-400 text-sm">({{ $reviews->count() }} ulasan)</span>
            </div>
        @endif
    </div>

    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-6 text-sm font-bold">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-6 text-sm font-bold">{{ session('error') }}</div>
    @endif

    {{-- Form beri ulasan --}}
    @auth
        <form action="{{ route('events.review.store', $event) }}" method="POST" class="bg-slate-50 rounded-2xl p-6 mb-10">
            @csrf
            <p class="font-bold mb-3">Beri ulasan untuk event ini</p>
            <div class="flex gap-2 mb-4">
                @for ($i = 1; $i <= 5; $i++)
                    <label class="cursor-pointer text-2xl">
                        <input type="radio" name="rating" value="{{ $i }}" class="hidden peer" required>
                        <span class="text-slate-300 peer-checked:text-amber-400">★</span>
                    </label>
                @endfor
            </div>
            <textarea name="comment" rows="3" placeholder="Bagikan pengalaman Anda di event ini (opsional)"
                class="w-full px-4 py-3 border border-slate-200 rounded-xl mb-3 focus:ring-2 focus:ring-indigo-500 outline-none"></textarea>
            <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition">
                Kirim Ulasan
            </button>
            <p class="text-xs text-slate-400 mt-2">Ulasan hanya bisa diberikan oleh peserta yang tiketnya sudah lunas, minimal 1 hari setelah event selesai.</p>
        </form>
    @else
        <p class="text-slate-500 mb-10">
            <a href="{{ route('login') }}" class="text-indigo-600 font-bold underline">Login</a> untuk memberi ulasan event ini.
        </p>
    @endauth

    {{-- Daftar ulasan --}}
    <div class="space-y-6">
        @forelse ($reviews as $review)
            <div class="border-b border-slate-100 pb-6">
                <div class="flex items-center justify-between mb-2">
                    <p class="font-bold">{{ $review->user->name }}</p>
                    <span class="text-amber-500 font-bold">{{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}</span>
                </div>
                @if ($review->comment)
                    <p class="text-slate-600">{{ $review->comment }}</p>
                @endif
                <p class="text-xs text-slate-400 mt-2">{{ $review->created_at->translatedFormat('d M Y') }}</p>
            </div>
        @empty
            <p class="text-slate-400">Belum ada ulasan untuk event ini.</p>
        @endforelse
    </div>
</div>