<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Role-based Route Groups
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/reports', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports');
        Route::resource('users', \App\Http\Controllers\UserController::class)->except(['create', 'edit', 'show']);
        Route::get('/settings', [\App\Http\Controllers\SettingsController::class, 'index'])->name('settings.index');
        Route::post('/settings', [\App\Http\Controllers\SettingsController::class, 'update'])->name('settings.update');
    });

    Route::middleware('role:petugas')->prefix('petugas')->name('petugas.')->group(function () {
        // Petugas specific routes (Circulation etc.)
    });

    Route::middleware('role:peminjam')->prefix('peminjam')->name('peminjam.')->group(function () {
        Route::get('/catalog', [\App\Http\Controllers\BorrowerCatalogController::class, 'catalog'])->name('catalog');
        Route::get('/books/{book}', [\App\Http\Controllers\BorrowerCatalogController::class, 'showBook'])->name('books.show');
        Route::get('/wishlist', [\App\Http\Controllers\BorrowerCatalogController::class, 'wishlist'])->name('wishlist');
        Route::post('/wishlist/toggle', [\App\Http\Controllers\BorrowerCatalogController::class, 'toggleWishlist'])->name('wishlist.toggle');
        Route::get('/profile', [\App\Http\Controllers\BorrowerCatalogController::class, 'profile'])->name('profile');
        Route::post('/profile/update', [\App\Http\Controllers\BorrowerCatalogController::class, 'updateProfile'])->name('profile.update');
        Route::get('/fines', [\App\Http\Controllers\BorrowerCatalogController::class, 'fines'])->name('fines');
        Route::post('/fines/{borrowing}/pay', [\App\Http\Controllers\BorrowerCatalogController::class, 'payFine'])->name('fines.pay');
        Route::get('/history', [\App\Http\Controllers\BorrowerCatalogController::class, 'history'])->name('history');
        Route::post('/borrow', [\App\Http\Controllers\BorrowerCatalogController::class, 'reserveBook'])->name('borrow');
        Route::post('/review', [\App\Http\Controllers\BorrowerCatalogController::class, 'storeReview'])->name('review.store');
    });

    // Core Operations for Admin and Petugas
    Route::middleware('role:admin,petugas')->group(function () {
        Route::resource('categories', \App\Http\Controllers\CategoryController::class);
        Route::resource('books', \App\Http\Controllers\BookController::class);
        Route::resource('borrowings', \App\Http\Controllers\BorrowingController::class)->only(['index', 'create', 'store']);
        Route::post('borrowings/{borrowing}/return', [\App\Http\Controllers\BorrowingController::class, 'returnBook'])->name('borrowings.return');
        Route::get('/management/fines', [\App\Http\Controllers\FineManagementController::class, 'index'])->name('fines.index');
        Route::post('/management/fines/{borrowing}/verify', [\App\Http\Controllers\FineManagementController::class, 'verifyPayment'])->name('fines.verify');
    });
});

require __DIR__.'/auth.php';

Route::get('/lang/{locale}', function (string $locale) {
    if (in_array($locale, ['en', 'id'])) {
        session()->put('locale', $locale);
    }
    return back();
})->name('locale.switch');
