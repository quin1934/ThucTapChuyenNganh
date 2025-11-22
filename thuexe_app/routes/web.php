<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
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

Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('about', function () {
    return view('about');
})->name('about');

Route::get('blog', function () {
    return view('blog');
})->name('blog');

Route::get('contact', function () {
    return view('contact');
})->name('contact');

Route::get('team', function () {
    return view('team');
})->name('team');

Route::get('vehicle', function () {
    return view('vehicle');
})->name('vehicle');

Route::middleware(['auth'])->group(function () {
    
    Route::get('admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::resource('admin/phan-loai-xe', PhanLoaiXeController::class);
    Route::resource('admin/xe', XeController::class);
    Route::resource('admin/khach-thue', KhachThueController::class);
    Route::resource('admin/chu-xe', ChuXeController::class);
    Route::resource('admin/don-thue', DonThueController::class);
    Route::resource('admin/tien-ich', TienIchController::class);
    Route::resource('admin/danh-gia', DanhGiaController::class);
    Route::resource('admin/thanh-toan', ThanhToanController::class);
    Route::resource('admin/quan-tri-vien', QuanTriVienController::class);
    Route::resource('admin/lich-xe', LichXeController::class);
});

Route::get('cardetail', function () {
    return view('cardetail');
})->name('cardetail');



Auth::routes();
Route::get('/logout', [HomeController::class, 'logout'])->name('logout');

