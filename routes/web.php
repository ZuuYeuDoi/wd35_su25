<?php

use App\Http\Controllers\Admin\BillController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Payment\PaymentController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\User\BookingController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\AmenitieController;
use App\Http\Controllers\Admin\RoomTypeController;
use App\Http\Controllers\Admin\BookingRoomController;
use App\Http\Controllers\Admin\CartController as AdminCartController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\InforController;
use App\Http\Controllers\User\ServiceController as UserServiceController;

// Route::get('/check-available-room', [HomeController::class, 'checkAvailableRoom'])->name('room_type.check_availability');



Route::prefix('/')->group(callback: function () {
    Route::controller(HomeController::class)->group(function () {
        Route::get('', 'index')->name('room.index');
        Route::get('/', 'index')->name('home');
        Route::get('room', 'indexRoom')->name('room.indexRoom');
        Route::get('room-type/{id}', 'showRoomType')->name('room_type.detail');
        Route::get('check-available-room', 'checkAvailableRoom')->name('room_type.check_availability');
    });
    Route::controller(BookingController::class)->group(function () {
        Route::post('/booking', 'index')->name('booking.index');
        Route::post('/booking/checkout', 'checkout')->name('booking.checkout');
        Route::get('/booking/checkout', 'showCheckoutPage')->name('booking.checkout.view');
        Route::post('/booking/store', 'store')->name('booking.store');
    });

    Route::controller(UserServiceController::class)->group(function () {
        Route::get('/service', 'indexFood')->name('services.indexFood');
        Route::get('/service-detail/{id}', 'showClient')->name('services.showClient');
    });

    Route::controller(CartController::class)->group(function () {
        Route::post('/cart/add', 'addService')->name('cart.add');
        route::get('/cart', 'index')->name('cart.ídex');
        Route::post('/cart/remove/{id}', 'remove')->name('cart.remove');
        Route::post('/cart/update', 'update')->name('cart.update');
        Route::post('/cart/order', 'order')->name('cart.order');
    });
});


// Route::get('/cart', function () {
//     return view('client.cart.index');
// });
Route::get('/room-detail', function () {
    return view('client.room.detail');
});


Route::get('/admin', function () {
    return view('admin.dashboard');
});
Route::get('/admin/info', function () {
    return view('admin.infoHotel');
});


Route::prefix('admin')->group(function () {

    Route::controller(RoomController::class)->group(function () {
        Route::get('rooms', 'index')->name('room.index');
        Route::get('rooms/map', 'map')->name('room.map');
        Route::get('rooms/add', 'create')->name('room.create');
        Route::post('rooms/store', 'store')->name('room.store');
        Route::get('rooms/show/{id}', 'show')->name('room.show');
        Route::get('rooms/edit/{id}', 'edit')->name('room.edit');
        Route::put('rooms/update/{id}', 'update')->name('room.update');
        Route::delete('rooms/delete/{id}', 'destroy')->name('room.destroy');
        Route::delete('rooms/image/delete/{id}', 'deleteImage')->name('room.image.delete');

        Route::get('rooms/trash', 'trash')->name('room.trash');
        Route::patch('rooms/restore/{id}', 'restore')->name('room.restore');
        Route::delete('rooms/forceDelete/{id}', 'forceDelete')->name('room.forceDelete');
    });

    // quan ly loai phong
    Route::controller(RoomTypeController::class)->group(function () {
        Route::get('room_types', 'index')->name('room_types.index');
        Route::get('room_types/add', 'create')->name('room_types.create');
        Route::post('room_types/store', 'store')->name('room_types.store');
        Route::get('room_types/show/{id}', 'show')->name('room_types.show');
        Route::get('room_types/edit/{id}', 'edit')->name('room_types.edit');
        Route::put('room_types/update/{id}', 'update')->name('room_types.update');
        Route::delete('room_types/delete/{id}', 'destroy')->name('room_types.destroy');
    });


    // Quản lý dịch vụ
    Route::controller(ServiceController::class)->group(function () {
        Route::get('services', 'index')->name('services.index');
        Route::get('services/add', 'create')->name('services.create');
        Route::post('services/store', 'store')->name('services.store');
        Route::get('services/show/{id}', 'show')->name('services.show');
        Route::get('services/edit/{id}', 'edit')->name('services.edit');
        Route::put('services/update/{id}', 'update')->name('services.update');
        Route::delete('services/delete/{id}', 'destroy')->name('services.destroy');

        Route::get('/trash', [ServiceController::class, 'trash'])->name('services.trash');
        Route::post('/{id}/restore', [ServiceController::class, 'restore'])->name('services.restore');
        Route::delete('/{id}/force-delete', [ServiceController::class, 'forceDelete'])->name('services.forceDelete');

        Route::post('/upload', [ServiceController::class, 'uploadImage'])->name('services.upload');
    });

    // quan ly tien ich
    Route::get('/amenities', [AmenitieController::class, 'index'])->name('amenitie.index');
    Route::get('/amenities/add', [AmenitieController::class, 'create'])->name('amenitie.create');
    Route::post('/amenities', [AmenitieController::class, 'store'])->name('amenitie.store');
    Route::get('/amenities/{id}/edit', [AmenitieController::class, 'edit'])->name('amenitie.edit');
    Route::put('/amenities/{id}', [AmenitieController::class, 'update'])->name('amenitie.update');
    Route::delete('/amenities/{id}', [AmenitieController::class, 'destroy'])->name('amenitie.destroy');
    Route::get('/amenities/trash', [AmenitieController::class, 'trash'])->name('amenitie.trash');
    Route::put('/amenities/{id}/restore', [AmenitieController::class, 'restore'])->name('amenitie.restore');
    Route::delete('/amenities/{id}/force-delete', [AmenitieController::class, 'forceDelete'])->name('amenitie.forceDelete');

    // Quản lý Booking phòng
    Route::controller(BookingRoomController::class)->group(function () {
        Route::get('room_order', 'index')->name('room_order.index');
        Route::get('room_order/{id}/show', 'show')->name('room_order.show');
        // Route::get('room_order/edit/{id}', 'edit')->name('room_order.edit');
        // Route::put('room_order/update/{id}', 'update')->name('room_order.update');
        Route::put('/room_order/{id}/cancel', [BookingRoomController::class, 'cancel'])->name('room_order.cancel');
    });

    // Quản lý Bill
    Route::controller(BillController::class)->group(function () {
        Route::get('/{id}/temporary', [BillController::class, 'temporary'])->name('bills.temporary');
        Route::put('/bills/{id}/confirm', [BillController::class, 'confirmPayment'])->name('bills.confirm');
        Route::get('/{id}/final', [BillController::class, 'final'])->name('bills.final');
    });

    // cart dịch vụ
    Route::controller(AdminCartController::class)->group(function () {
        Route::post('/cart/add', [AdminCartController::class, 'add'])->name('cart.add');
    });

    Route::controller(InforController::class)->group(function () {
        Route::get('/profile', [InforController::class, 'showProfile'])->name('admin.profile');
        Route::post('/profile/update', [InforController::class, 'updateProfile'])->name('admin.profile.update');
    })->middleware(['auth']);

});


// routes thanh toán và booking
Route::post('/payment', [PaymentController::class, 'createPayment'])->name('payment.create');
Route::get('/payment/return', [PaymentController::class, 'paymentReturn'])->name('payment.return');

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

// routes/web.php
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [UserController::class, 'showProfile'])->name('user.profile');
    Route::post('/profile/update', [UserController::class, 'updateProfile'])->name('user.profile.update');
});



Route::get('/account/room', function () {
    return view('client.account.roomDetail');
});

Auth::routes(['verify' => true]);


//Dịch vụ bên User
Route::get('/services', [UserServiceController::class, 'index'])->name('services.list');
Route::get('/service/detail', [UserServiceController::class, 'detail'])->name('services.detail');
