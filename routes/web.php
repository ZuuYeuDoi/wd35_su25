<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/admin', function () {
    return view('admin.dashboard');
});

Route::get('/admin/rooms', function () {
    return view('admin.rooms.rooms');
});
Route::get('/admin/category/add', function () {
    return view('admin.category.addcategory');
});
Route::get('/admin/category', function () {
    return view('admin.category.listcategory');
});

Route::get('/admin/user', function () {
    return view('admin.user.user');
});
Route::get('/admin/user/add', function () {
    return view('admin.user.adduser');
});

Route::get('/admin/order', function () {
    return view('admin.order.order');
});

Route::get('/admin/order/detail', function () {
    return view('admin.order.orderdetail');
});


