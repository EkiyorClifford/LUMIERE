<?php

use Illuminate\Support\Facades\Route;

Route::prefix('/')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('home');

    Route::get('/shop/{category?}', function ($category = null) {
        return view('shop', ['category' => $category]);
    })->name('shop');
    Route::get('/collections', function(){
        return view('collections');
    })->name('collections');
    Route::get('/atelier', function(){
        return view('atelier');
    })->name('atelier');
    Route::get('/bespoke', function(){
        return view('bespoke');
    })->name('bespoke');
});


//create testing routes for my error pages
Route::get('/404', function () {
    return view('errors.404');
});
Route::get('/403', function () {
    return view('errors.403');
});
Route::get('/500', function () {
    return view('errors.500');
});
Route::get('/503', function () {
    return view('errors.503');
});
//when to use post and get:
//get: when you want to retrieve data from the server
//post: when you want to send data to the server

