<?php

use App\Livewire\LogisticPurchase;
use App\Livewire\LogisticDashboard;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
// Halaman Login
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Proses Login
Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login.post');

// Logout
Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// Halaman Dashboard (utama setelah login)
Route::middleware(['auth'])->group(function () {
    Route::get('/logistik', LogisticDashboard::class)->name('logistic.dashboard');
    Route::get('/logistik/pembelian', LogisticPurchase::class)->name('logistic.purchase');
    Route::get('/logistik/history', function () {
        return '<h1 class="p-10 text-2xl">Halaman History</h1>'; // Ganti nanti
    })->name('logistic.history');
    Route::get('/logistik/statistik', function () {
        return '<h1 class="p-10 text-2xl">Halaman Statistik</h1>'; // Ganti nanti
    })->name('logistic.stats');
});
// Rute untuk halaman coming soon
Route::get('/coming-soon', [PageController::class, 'comingSoon'])->name('coming.soon');
// Redirect root ke login
Route::get('/', function () {
    return redirect()->route('login');
});
