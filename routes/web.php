<?php

use App\Http\Controllers\ProfileController;
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

    // Role-based Route Groups
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        // Admin specific routes (User management, reports)
        Route::get('/reports', function () { return 'Admin Reports Placeholder'; })->name('reports');
    });

    Route::middleware('role:petugas')->prefix('petugas')->name('petugas.')->group(function () {
        // Petugas specific routes (Book CRUD, Circulation)
        Route::get('/books', function () { return 'Petugas Books Placeholder'; })->name('books');
    });

    Route::middleware('role:peminjam')->prefix('peminjam')->name('peminjam.')->group(function () {
        // Peminjam specific routes (Catalog, History)
        Route::get('/catalog', function () { return 'Peminjam Catalog Placeholder'; })->name('catalog');
    });
});

require __DIR__.'/auth.php';

Route::get('/lang/{locale}', function (string $locale) {
    if (in_array($locale, ['en', 'id'])) {
        session()->put('locale', $locale);
    }
    return back();
})->name('locale.switch');
