<?php

use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\TransactionsController; // Perhatikan nama file Anda TransactionsController atau TransactionController sesuai modul
use App\Http\Controllers\EventController as PublicEventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController; 
use Illuminate\Http\Request;

// ==========================================================
// ROUTE HALAMAN PUBLIK / USER BIASA
// ==========================================================
Route::get('/', [HomeController::class,'index']);
Route::get('/kontak', function () { return view('contact'); });
Route::get('/profil', function () { return view('profil'); });
Route::get('/katalog', function () { return view('catalog'); });
Route::get('/bantuan', function () { return view('bantuan'); });
Route::get('/event-detail/{id?}', [PublicEventController::class, 'show']);
Route::get('/checkout', [PublicEventController::class, 'checkout']);
Route::get('/ticket', [TicketController::class, 'show']);



Route::prefix('admin')->name('admin.')->group(function () {
    
   
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');     
    Route::post('login', [AuthController::class, 'login'])->name('login.post');     
    Route::post('logout', [AuthController::class, 'logout'])->name('logout'); 

   
    Route::middleware(['auth', 'admin'])->group(function () {         
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');         
        Route::resource('events', EventController::class);         
        Route::get('transactions', [TransactionsController::class, 'index'])->name('transactions.index');     
        
        // Tambahan route projek Anda (Ikut dimasukkan ke sini agar aman)
        Route::resource('partners', PartnerController::class);
        Route::resource('categories', CategoriesController::class)->names(['index' => 'categories']); 
    }); 
});