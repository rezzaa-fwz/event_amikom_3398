<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;

class DashboardController extends Controller
{
    public function index(){
    // Ambil semua data event dari database
    $events = Event::paginate(10);

    // Kirim variabel $events ke view
    return view('admin.dashboard', compact('events'));
    }
}
