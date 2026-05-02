<?php

use App\Http\Controllers\AtelierController;
use App\Http\Controllers\ConciergeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/collections', [ProductController::class, 'collections'])->name('collections');
Route::get('/shop', [ProductController::class, 'index'])->name('shop');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');
Route::get('/atelier', [AtelierController::class, 'index'])->name('atelier');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::get('/size-guide', function () {
    return view('size-guide');
})->name('size-guide');
Route::get('/faq', function () {
    return view('FAQ');
})->name('faq');
Route::get('/shipping', function () {
    return view('SHIPPING');
})->name('shipping');
Route::get('/sur-mesure', function () {
    return view('sur-mesure');
})->name('sur-mesure');
Route::get('/bespoke', function () {
    return view('bespoke');
})->name('bespoke');

// Blog/Journal routes
Route::get('/journal', [PostController::class, 'index'])->name('journal');
Route::get('/journal/{slug}', [PostController::class, 'show'])->name('post.show');
Route::get('/journal/category/{slug}', [PostController::class, 'category'])->name('post.category');

Route::post('/atelier-request', [AtelierController::class, 'store'])->name('atelier.request');
Route::post('/concierge-request', [ConciergeController::class, 'store'])->name('concierge.request');
Route::post('/newsletter', [NewsletterController::class, 'store'])->name('newsletter');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
