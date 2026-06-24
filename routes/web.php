<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MovieController; 
use App\Http\Controllers\WatchlistController; 
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReviewController; 
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// --- ROUTE DASHBOARD DIUBAH KE MOVIECONTROLLER ---
Route::get('/dashboard', [MovieController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
    
    Route::get('/movies/detail/{id}/{type?}', [MovieController::class, 'show'])->name('movies.show');

    Route::get('/watchlists', [WatchlistController::class, 'index'])->name('watchlists.index');
    Route::post('/watchlists', [WatchlistController::class, 'store'])->name('watchlists.store');
    Route::delete('/watchlists/{watchlist}', [WatchlistController::class, 'destroy'])->name('watchlists.destroy');

    // Route Review / Ulasan Lokal
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    
    // --- TAMBAHAN: Route untuk Admin menghapus user ---
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
});

require __DIR__.'/auth.php';