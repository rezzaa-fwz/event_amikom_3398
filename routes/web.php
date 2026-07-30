<?php

use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\EventController as PublicEventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use Illuminate\Http\Request;

Route::get('/', [HomeController::class,'index'])->name('home');
Route::get('/kontak', function () { return view('contact'); })->name('contact');
Route::get('/profil', function () { return view('profile'); })->name('profil');
Route::get('/katalog', function () { return view('catalog'); })->name('katalog');
Route::get('/bantuan', function () { return view('bantuan'); })->name('bantuan');
Route::post('/events/{event}/review', [\App\Http\Controllers\ReviewController::class, 'store'])->name('events.review.store'); // Route untuk menyimpan review dari user
Route::get('/events/{event}', [\App\Http\Controllers\EventController::class, 'show'])->name('events.show');
Route::get('/checkout', [PublicEventController::class, 'checkout']);
Route::get('/ticket', [TicketController::class, 'show'])->name('ticket');
Route::get('/my-ticket', [TicketController::class, 'show']);
Route::get('/checkout/{event}', [App\Http\Controllers\CheckoutController::class, 'create'])->name('checkout.create')->middleware('auth');
Route::post('/checkout/{event}', [App\Http\Controllers\CheckoutController::class, 'store'])->name('checkout.store')->middleware('auth');
Route::get('/payment/{order_id}', [\App\Http\Controllers\CheckoutController::class, 'payment'])->name('checkout.payment');
Route::get('/success/{order_id}', [\App\Http\Controllers\CheckoutController::class, 'success'])->name('checkout.success');
Route::post('/midtrans/callback', [\App\Http\Controllers\MidtransWebhookController::class, 'handle']);
Route::get('/daftar-organisasi', [\App\Http\Controllers\OrganizationRegistrationController::class, 'create'])->name('organizations.register');
Route::post('/daftar-organisasi', [\App\Http\Controllers\OrganizationRegistrationController::class, 'store'])->name('organizations.store');
Route::get('/auth/google/redirect', [\App\Http\Controllers\Auth\GoogleController::class, 'redirect'])->name('auth.google.redirect');
Route::get('/auth/google/callback', [\App\Http\Controllers\Auth\GoogleController::class, 'callback'])->name('auth.google.callback');

Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.post');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('auth/google/redirect', [\App\Http\Controllers\Auth\GoogleController::class, 'adminRedirect'])->name('auth.google.redirect');

    // Halaman informatif (pending / suspended) — tidak butuh org.approved
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('pending', fn () => view('admin.pending'))->name('org.pending');
        Route::get('suspended', fn () => view('admin.suspended'))->name('org.suspended');
    });

    // Semua route dashboard — wajib approved
    Route::middleware(['auth', 'admin', 'org.approved'])->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('events', EventController::class);
        Route::resource('partners', PartnerController::class);
        Route::resource('categories', CategoriesController::class)->names(['index' => 'categories']);
        Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');

        // Profil organisasi sendiri (semua admin tenant)
        Route::get('org-profile', [\App\Http\Controllers\Admin\OrganizationProfileController::class, 'edit'])->name('org.profile');
        Route::put('org-profile', [\App\Http\Controllers\Admin\OrganizationProfileController::class, 'update'])->name('org.profile.update');

        // Kelola organisasi lain (superadmin only)
        Route::get('organizations', [\App\Http\Controllers\Admin\OrganizationController::class, 'index'])->name('organizations.index');
        Route::get('organizations/{organization}', [\App\Http\Controllers\Admin\OrganizationController::class, 'show'])->name('organizations.show');
        Route::post('organizations/{organization}/approve', [\App\Http\Controllers\Admin\OrganizationController::class, 'approve'])->name('organizations.approve');
        Route::post('organizations/{organization}/suspend', [\App\Http\Controllers\Admin\OrganizationController::class, 'suspend'])->name('organizations.suspend');
    });
});

// === Route bawaan Breeze untuk user biasa ===
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';