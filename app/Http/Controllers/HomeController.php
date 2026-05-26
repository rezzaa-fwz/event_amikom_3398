<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Partner;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Tetap seperti semula
        $events = Event::with(['category', 'partner'])->latest()->take(6)->get();

        // Hapus query 'is_active' karena kolomnya tidak ada di database kamu
        $partners = Partner::orderBy('name')->get(); 

        return view('welcome', compact('events', 'partners'));
    }
}