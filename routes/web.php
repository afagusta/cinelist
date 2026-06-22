<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MovieController; 
use App\Http\Controllers\WatchlistController; 
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Route Katalog Film
    Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
    
    // Tambahan Route Halaman Detail Film
    Route::get('/movies/detail/{id}/{type?}', [MovieController::class, 'show'])->name('movies.show');

    // Route Watchlist (CRUD)
    Route::get('/watchlists', [WatchlistController::class, 'index'])->name('watchlists.index');
    Route::post('/watchlists', [WatchlistController::class, 'store'])->name('watchlists.store');
    Route::delete('/watchlists/{watchlist}', [WatchlistController::class, 'destroy'])->name('watchlists.destroy');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
});

require __DIR__.'/auth.php';