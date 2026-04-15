<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventController extends Controller
{
    public function show($id){
        return view('event-detail');
    }
    public function checkout($id){
        return view('checkout');
    }
}
