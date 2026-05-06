<?php

namespace App\Http\Controllers;

use App\Models\Event;     // Cukup satu kali
use App\Models\Category;  // Cukup satu kali
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        
        // Logika filter kategori
        $events = Event::with('category')
            ->when($request->category, function ($query) use ($request) {
                return $query->whereHas('category', function ($q) use ($request) {
                    $q->where('slug', $request->category);
                });
            })
            ->get();

        return view('welcome', compact('categories', 'events'));
    }
}