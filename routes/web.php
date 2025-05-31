<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


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


Route::get('/product', function () {
    return view('client.product.index');
});

Route::get('/product-detail', function () {
    return view('client.product.detail');
});
Route::get('/service', function () {
    return view('client.service.index');
});



Route::get('/admin', function () {
    return view('admin.dashboard');
});
Route::get('/admin/info', function () {
    return view('admin.infoHotel');
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
Route::get('/admin/users', function () {
    return view('admin.custommers.users-list');
});
Route::get('/admin/add-user', function () {
    return view('admin.custommers.add-user');
});
Route::get('/admin/staffs', function () {
    return view('admin.custommers.staffs-list');
});
Route::get('/admin/add-staff', function () {
    return view('admin.custommers.add-staff');
});
Route::get('/admin/comments', function () {
    return view('admin.comments');
});
Route::get('/admin/profile', function () {
    return view('admin.custommers.staff-profile');
});
Route::get('/admin/lock-screen', function () {
    return view('admin.lock-screen');
});
Route::get('/admin/media-gallery', function () {
    return view('admin.media-gallery');
});
Route::get('/404', function () {
    return view('errors.404');
});
Route::get('/505', function () {
    return view('errors.505');
});

Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/register', function () {
    return view('auth.register');
});

Route::get('/account', function () {
    return view('client.account.account');
});


Route::get('/account/room', function () {
    return view('client.account.roomDetail');
});

Auth::routes(['verify' => true]);

Route::get('/', [HomeController::class, 'index']);
