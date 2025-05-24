<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('client.Home.home');
});

Route::get('/room', function () {
    return view('client.room.index');
});
Route::get('/cart', function () {
    return view('client.cart.index');
});
Route::get('/room-detail', function () {
    return view('client.room.detail');
});

Route::get('checkout', function () {
    return view('client.checkout.index');
});


Route::get('product', function () {
    return view('client.product.index');
});

Route::get('product-detail', function () {
    return view('client.product.detail');
});
