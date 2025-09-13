<?php

use App\Livewire\LogisticPurchase;
use App\Livewire\LogisticDashboard;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Auth\LoginController;

// Halaman Login
Route::get('/logistik/login', [LoginController::class, 'showLoginForm'])->name('logistic.login');
Route::post('/logistik/login', [LoginController::class, 'login'])->name('logistic.login.post');
Route::post('/logistik/logout', [LoginController::class, 'logout'])->name('logistic.logout');

// Halaman Dashboard (utama setelah login)
Route::middleware(['auth:logistik'])->prefix('logistik')->group(function () {
    Route::get('/', LogisticDashboard::class)->name('logistic.dashboard');
    Route::get('/pembelian', LogisticPurchase::class)->name('logistic.purchase');
    Route::get('/history', fn() => '<h1 class="p-10 text-2xl">Halaman History</h1>')->name('logistic.history');
    Route::get('/statistik', fn() => '<h1 class="p-10 text-2xl">Halaman Statistik</h1>')->name('logistic.stats');
});

// Rute untuk halaman coming soon
Route::get('/coming-soon', [PageController::class, 'comingSoon'])->name('coming.soon');

// Redirect root ke dashboard logistik
Route::get('/', fn() => redirect()->route('logistic.dashboard'));
