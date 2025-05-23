<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/admin', function () {
    return view('admin.dashboard');
});
//booking phong
Route::get('/admin/bookingrooms/rooms/servicer', function () {
    return view('admin.bookingrooms.rooms.servicerooms');
});
Route::get('/admin/bookingrooms/rooms/servicer/add', function () {
    return view('admin.bookingrooms.rooms.addservicerooms');
});
Route::get('/admin/bookingrooms/rooms', function () {
    return view('admin.bookingrooms.rooms.rooms');
});
Route::get('/admin/bookingrooms/category/add', function () {
    return view('admin.bookingrooms.category.addcategory');
});
Route::get('/admin/bookingrooms/category', function () {
    return view('admin.bookingrooms.category.listcategory');
});

Route::get('/admin/bookingrooms/user', function () {
    return view('admin.bookingrooms.user.user');
});
Route::get('/admin/bookingrooms/user/add', function () {
    return view('admin.bookingrooms.user.adduser');
});

Route::get('/admin/bookingrooms/order', function () {
    return view('admin.bookingrooms.order.order');
});

Route::get('/admin/bookingrooms/order/detail', function () {
    return view('admin.bookingrooms.order.orderdetail');
});


//booking su kien
Route::get('/admin/holiday/order/detail', function () {
    return view('admin.holiday.order.orderdetail');
});
Route::get('/admin/holiday/category/add', function () {
    return view('admin.holiday.category.addcategory');
});
Route::get('/admin/holiday/category', function () {
    return view('admin.holiday.category.listcategory');
});
Route::get('/admin/holiday/order/detail', function () {
    return view('admin.holiday.order.orderdetail');
});
Route::get('/admin/holiday/order', function () {
    return view('admin.holiday.order.order');
});
Route::get('/admin/holiday/holidays', function () {
    return view('admin.holiday.holidays.listholidays');
});
Route::get('/admin/holiday/holidays/add', function () {
    return view('admin.holiday.holidays.addholidays');
});
