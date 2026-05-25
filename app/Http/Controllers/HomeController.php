<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Partner;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $events = Event::with(['category', 'partner'])->latest()->take(6)->get();
        $partners = Partner::where('is_active', true)->orderBy('name')->get();
        return view('welcome', compact('events', 'partners'));
    }
}