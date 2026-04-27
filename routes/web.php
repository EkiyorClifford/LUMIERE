<?php

use Illuminate\Support\Facades\Route;

Route::prefix('/')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/shop', function () {
        return view('shop');
    });
    Route::get('/collections', function(){
        return view('collections');
    });
});

//when to use post and get:
//get: when you want to retrieve data from the server
//post: when you want to send data to the server

