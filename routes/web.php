<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\AboutController;
use App\Http\Controllers\User\BookingController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\ServiceController as UserServiceController;

use App\Http\Controllers\Payment\PaymentController;

use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\RoomTypeController;
use App\Http\Controllers\Admin\BookingRoomController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\AmenitieController;
use App\Http\Controllers\Admin\BillController;
use App\Http\Controllers\Admin\CartController as AdminCartController;
use App\Http\Controllers\Admin\InforController;

// ---------------- PUBLIC ROUTES ----------------
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/room', [HomeController::class, 'indexRoom'])->name('room.indexRoom');
Route::get('/room-type/{id}', [HomeController::class, 'showRoomType'])->name('room_type.detail');
Route::get('/check-available-room', [HomeController::class, 'checkAvailableRoom'])->name('room_type.check_availability');
Route::get('/room-detail', fn() => view('client.room.detail'));
Route::get('/about', [AboutController::class, 'index'])->name('about');

Route::get('/services', [UserServiceController::class, 'index'])->name('services.list');
Route::get('/service/detail', [UserServiceController::class, 'detail'])->name('services.detail');
Route::get('/service', [UserServiceController::class, 'indexFood'])->name('services.indexFood');
Route::get('/service-detail/{id}', [UserServiceController::class, 'showClient'])->name('services.showClient');

// ---------------- AUTH ROUTES ----------------
Route::get('/login', fn() => view('auth.login'))->name('login');
Route::get('/register', fn() => view('auth.register'))->name('register');
Auth::routes(['verify' => true]);

// ---------------- USER ROUTES ----------------
Route::middleware(['auth', 'checkRole:3'])->group(function () {
    Route::get('/profile', [UserController::class, 'showProfile'])->name('user.profile');
    Route::post('/profile/update', [UserController::class, 'updateProfile'])->name('user.profile.update');

    Route::controller(BookingController::class)->group(function () {
        Route::post('/booking', 'index')->name('booking.index');
        Route::get('/booking/checkout', 'showCheckoutPage')->name('booking.checkout.view');
        Route::post('/booking/checkout', 'checkout')->name('booking.checkout');
        Route::post('/booking/store', 'store')->name('booking.store');
    });

    Route::controller(CartController::class)->group(function () {
        Route::get('/cart', 'index')->name('cart.index');
        Route::post('/cart/add', 'addService')->name('cart.addCart');
        Route::post('/cart/remove/{id}', 'remove')->name('cart.remove');
        Route::post('/cart/update', 'update')->name('cart.update');
        Route::post('/cart/order', 'order')->name('cart.orderUser');
    });

    Route::get('/account/room', fn() => view('client.account.roomDetail'));
});

// ---------------- STAFF + ADMIN (Quản lý) ROUTES ----------------
Route::prefix('admin')->middleware(['auth', 'checkRole:1,2'])->group(function () {
    Route::get('/', fn() => view('admin.dashboard'))->name('admin.dashboard');
    Route::get('/info', fn() => view('admin.infoHotel'))->name('admin.infoHotel');

    Route::controller(RoomController::class)->group(function () {
        Route::get('rooms', 'index')->name('room.index');
        Route::get('rooms/map', 'map')->name('room.map');
        Route::get('rooms/add', 'create')->middleware('checkRole:1')->name('room.create');
        Route::post('rooms/store', 'store')->middleware('checkRole:1')->name('room.store');
        Route::get('rooms/show/{id}', 'show')->name('room.show');
        Route::get('rooms/edit/{id}', 'edit')->middleware('checkRole:1')->name('room.edit');
        Route::put('rooms/update/{id}', 'update')->middleware('checkRole:1')->name('room.update');
        Route::delete('rooms/delete/{id}', 'destroy')->middleware('checkRole:1')->name('room.destroy');
        Route::delete('rooms/image/delete/{id}', 'deleteImage')->middleware('checkRole:1')->name('room.image.delete');
        Route::get('rooms/trash', 'trash')->middleware('checkRole:1')->name('room.trash');
        Route::patch('rooms/restore/{id}', 'restore')->middleware('checkRole:1')->name('room.restore');
        Route::delete('rooms/forceDelete/{id}', 'forceDelete')->middleware('checkRole:1')->name('room.forceDelete');
    });

    Route::controller(BookingRoomController::class)->group(function () {
        Route::get('room_order', 'index')->name('room_order.index');
        Route::get('room_order/{id}/show', 'show')->name('room_order.show');
        Route::put('room_order/{id}/cancel', 'cancel')->name('room_order.cancel');
        Route::get('room_order/{id}/extend-day', 'showExtendDay')->name('room_order.extend_day');
        Route::post('room_order/{id}/extend-day', 'handleExtendDay')->name('room_order.extend_day.handle');
        Route::get('room_order/{id}/extend-hour', 'showExtendHour')->name('room_order.extend_hour');
        Route::post('room_order/{id}/extend-hour', 'handleExtendHour')->name('room_order.extend_hour.handle');
    });

    Route::controller(BillController::class)->group(function () {
        Route::get('bills', 'index')->name('bills.index');
        Route::get('bills/{id}/temporary', 'temporary')->name('bills.temporary');
        Route::put('bills/{id}/confirm', 'confirmPayment')->name('bills.confirm');
        Route::get('bills/{id}/final', 'final')->name('bills.final');
        Route::get('bills/{id}/show', 'show')->name('bills.show');
    });
});

// ---------------- ADMIN ONLY ROUTES ----------------
Route::prefix('admin')->middleware(['auth', 'checkRole:1'])->group(function () {
    Route::controller(RoomTypeController::class)->group(function () {
        Route::get('room_types', 'index')->name('room_types.index');
        Route::get('room_types/add', 'create')->name('room_types.create');
        Route::post('room_types/store', 'store')->name('room_types.store');
        Route::get('room_types/show/{id}', 'show')->name('room_types.show');
        Route::get('room_types/edit/{id}', 'edit')->name('room_types.edit');
        Route::put('room_types/update/{id}', 'update')->name('room_types.update');
        Route::delete('room_types/delete/{id}', 'destroy')->name('room_types.destroy');
        Route::delete('room_types/image/{id}/delete', 'deleteImage')->name('room_types.image.delete');
    });

    Route::controller(ServiceController::class)->group(function () {
        Route::get('services', 'index')->name('services.index');
        Route::get('services/add', 'create')->name('services.create');
        Route::post('services/store', 'store')->name('services.store');
        Route::get('services/show/{id}', 'show')->name('services.show');
        Route::get('services/edit/{id}', 'edit')->name('services.edit');
        Route::put('services/update/{id}', 'update')->name('services.update');
        Route::delete('services/delete/{id}', 'destroy')->name('services.destroy');
        Route::get('services/trash', 'trash')->name('services.trash');
        Route::post('services/{id}/restore', 'restore')->name('services.restore');
        Route::delete('services/{id}/force-delete', 'forceDelete')->name('services.forceDelete');
        Route::post('services/upload', 'uploadImage')->name('services.upload');
    });

    Route::controller(AmenitieController::class)->group(function () {
        Route::get('amenities', 'index')->name('amenitie.index');
        Route::get('amenities/add', 'create')->name('amenitie.create');
        Route::post('amenities', 'store')->name('amenitie.store');
        Route::get('amenities/{id}/edit', 'edit')->name('amenitie.edit');
        Route::put('amenities/{id}', 'update')->name('amenitie.update');
        Route::delete('amenities/{id}', 'destroy')->name('amenitie.destroy');
        Route::get('amenities/trash', 'trash')->name('amenitie.trash');
        Route::put('amenities/{id}/restore', 'restore')->name('amenitie.restore');
        Route::delete('amenities/{id}/force-delete', 'forceDelete')->name('amenitie.forceDelete');
    });

    Route::get('/users', fn() => view('admin.custommers.users-list'))->name('admin.users');
    Route::get('/add-user', fn() => view('admin.custommers.add-user'))->name('admin.users.add');
    Route::get('/staffs', fn() => view('admin.custommers.staffs-list'))->name('admin.staffs');
    Route::get('/add-staff', fn() => view('admin.custommers.add-staff'))->name('admin.staffs.add');
    Route::get('/comments', fn() => view('admin.comments'))->name('admin.comments');
    Route::get('/holiday/order', fn() => view('admin.holiday.order.order'));
    Route::get('/holiday/order/detail', fn() => view('admin.holiday.order.orderdetail'));
    Route::get('/holiday/category', fn() => view('admin.holiday.category.listcategory'));
    Route::get('/holiday/category/add', fn() => view('admin.holiday.category.addcategory'));
    Route::get('/holiday/holidays', fn() => view('admin.holiday.holidays.listholidays'));
    Route::get('/holiday/holidays/add', fn() => view('admin.holiday.holidays.addholidays'));
});

// ---------------- PAYMENT ROUTES ----------------
Route::post('/payment', [PaymentController::class, 'createPayment'])->name('payment.create');
Route::get('/payment/return', [PaymentController::class, 'paymentReturn'])->name('payment.return');

// ---------------- MISC / ERROR / STATIC ----------------
Route::view('/admin/lock-screen', 'admin.lock-screen');
Route::view('/admin/media-gallery', 'admin.media-gallery');
Route::view('/404', 'errors.404');
Route::view('/505', 'errors.505');
