<?php

use App\Http\Controllers\Backend\SubcategoryController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->prefix('admin')->group(function () {
	Route::name('backend.')->group(function () {
		Route::resource('categories', CategoryController::class);
	    Route::resource('subcategories', SubcategoryController::class);
	    Route::resource('products', ProductController::class);
	});

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/products/{product:slug}', [HomeController::class, 'show'])->name('home.products.show');


require __DIR__.'/auth.php';
