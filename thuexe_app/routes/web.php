<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Client\HomeController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\PhanLoaiXeController;
use App\Http\Controllers\Admin\XeController;
use App\Http\Controllers\Admin\KhachThueController;
use App\Http\Controllers\Admin\ChuXeController;
use App\Http\Controllers\Admin\DonThueController;
use App\Http\Controllers\Admin\TienIchController;
use App\Http\Controllers\Admin\DanhGiaController;
use App\Http\Controllers\Admin\ThanhToanController;
use App\Http\Controllers\Admin\QuanTriVienController;
use App\Http\Controllers\Admin\LichXeController;
use App\Http\Controllers\Admin\DanhMucThongSoController;
use App\Http\Controllers\Admin\LoaiTienIchController;
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Admin\CmsPageController;
use App\Http\Controllers\Admin\CmsBlockController;
use App\Http\Controllers\Client\ClientAuthController;
use App\Http\Controllers\Client\ClientAccountController;
use App\Http\Controllers\Client\PartnerController;
use App\Http\Controllers\Client\PartnerCarController;
use App\Http\Controllers\Client\ClientForgotPasswordController;
use App\Http\Controllers\Client\BookingController;

Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('about', 'about')->name('about');
    Route::get('blog', 'blog')->name('blog');
    Route::get('contact', 'contact')->name('contact');
    Route::get('team', 'team')->name('team');
    Route::get('vehicle', 'vehicle')->name('vehicle');
    Route::get('cardetail', fn() => redirect()->route('vehicle'));
    Route::get('cardetail/{id}', 'detail')->name('cardetail');
});

Route::controller(BookingController::class)->group(function () {
    Route::get('booking/{id}', 'create')->name('booking.create');
    Route::post('booking/{id}', 'store')->name('booking.store');
});

Route::resource('contact', PartnerCarController::class)->only(['store'])->names(['store' => 'partner.car.store']);

Route::controller(ClientAuthController::class)->name('client.')->group(function () {
    Route::get('dang-nhap', 'showLoginForm')->name('login');
    Route::post('dang-nhap', 'login')->name('login.post');
    Route::post('dang-xuat', 'logout')->name('logout');
    Route::get('dang-ky', 'showRegisterForm')->name('register');
    Route::post('dang-ky', 'register')->name('register.post');
});

Route::controller(ClientAccountController::class)->name('client.')->group(function () {
    Route::get('ho-so-ca-nhan', 'profile')->name('profile');
    Route::prefix('ho-so-ca-nhan')->name('profile.')->group(function () {
        Route::post('cap-nhat', 'update')->name('update');
        Route::post('avatar', 'updateAvatar')->name('avatar');
        Route::delete('xoa-tai-khoan', 'destroyAccount')->name('destroy');
    });
    Route::get('lich-su-thue-xe', 'history')->name('history');
    Route::get('lich-su-thue-xe/{order}/thanh-toan-coc', 'depositPage')->name('deposit.page');
    Route::post('lich-su-thue-xe/{order}/dat-coc', 'payDeposit')->name('deposit');
    Route::post('lich-su-thue-xe/{order}/da-nhan-xe', 'confirmReceivedCar')->name('received');
    Route::post('lich-su-thue-xe/{order}/tra-xe', 'returnCar')->name('return');
    Route::get('lich-su-thue-xe/{order}', 'bookingDetail')->name('booking-detail');
});

Route::prefix('doi-tac')->name('partner.')->controller(PartnerController::class)->group(function () {
    Route::get('quan-ly', 'index')->name('profile');
    Route::prefix('quan-ly')->name('profile.')->group(function () {
        Route::post('cap-nhat', 'update')->name('update');
        Route::post('avatar', 'updateAvatar')->name('avatar');
        Route::delete('xoa-tai-khoan', 'destroyAccount')->name('destroy');
    });
    Route::get('don-hang', 'orders')->name('orders');
    Route::get('don-hang/{order}', 'bookingDetail')->name('booking-detail');
    Route::post('don-hang/{order}/trang-thai', 'updateOrderStatus')->name('orders.status');
});

Route::prefix('doi-tac')->name('partner.')->group(function () {
    Route::resource('quan-ly-xe', PartnerCarController::class)->only(['index', 'edit', 'update', 'destroy'])->parameters(['quan-ly-xe' => 'xe'])->names([
        'index' => 'cars',
        'edit' => 'cars.edit',
        'update' => 'cars.update',
        'destroy' => 'cars.destroy',
    ]);
});

Route::controller(ClientForgotPasswordController::class)->name('client.password.')->group(function () {
    Route::get('quen-mat-khau', 'showLinkRequestForm')->name('request');
    Route::post('quen-mat-khau', 'sendResetLinkEmail')->name('email');
    Route::get('dat-lai-mat-khau/{token}', 'showResetForm')->name('reset');
    Route::post('dat-lai-mat-khau', 'reset')->name('update');
});





// --- ADMIN ---
Route::get('admin', [AdminController::class, 'index'])->name('admin.dashboard');
Route::resource('admin/phan-loai-xe', PhanLoaiXeController::class);
Route::resource('admin/xe', XeController::class);
Route::resource('admin/khach-thue', KhachThueController::class);
Route::resource('admin/chu-xe', 'App\\Http\\Controllers\\Admin\\ChuXeController');
Route::resource('admin/don-thue', DonThueController::class);
Route::resource('admin/tien-ich', TienIchController::class);
Route::resource('danh-gia', DanhGiaController::class)->only(['index', 'store', 'destroy']);
Route::resource('thanh-toan', ThanhToanController::class)->only(['index', 'store', 'destroy']);
Route::resource('admin/quan-tri-vien', QuanTriVienController::class);
Route::resource('admin/lich-xe', LichXeController::class);
Route::resource('admin/danh_muc_thong_so', DanhMucThongSoController::class);
Route::resource('admin/loai-tien-ich', LoaiTienIchController::class);
Route::resource('admin/khuyen-mai', PromotionController::class)->names('promotion')->except(['show'])->parameters(['khuyen-mai' => 'promotion']);
Route::resource('admin/cms-pages', CmsPageController::class)->names('cms-pages')->except(['show'])->parameters(['cms-pages' => 'cmsPage']);
Route::resource('admin/cms-blocks', CmsBlockController::class)->names('cms-blocks')->except(['show'])->parameters(['cms-blocks' => 'cmsBlock']);
Route::resource('lich-xe', LichXeController::class)->only(['index', 'show']);
Auth::routes();
