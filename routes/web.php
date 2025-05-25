<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/admin', function () {
    return view('admin.dashboard');
});
Route::get('/admin/info', function () {
    return view('admin.infoHotel');
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

