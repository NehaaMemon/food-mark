<?php

use App\Http\Controllers\Admin\AdminAuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductGalleryController;
use App\Http\Controllers\Admin\ProductOptionController;
use App\Http\Controllers\Admin\ProductSizeController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\WhyChooseUsController;

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {

    //profile routes//
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

    //Slider Routes//
    Route::resource('slider', SliderController::class);

    //Why-Choose-Us Routes//
    Route::put('why-choose-title-update', [WhyChooseUsController::class, 'updateTitle'])->name('why-choose-title.update');
    Route::resource('why-choose-us', WhyChooseUsController::class);

    //product Category Routes//
    Route::resource('category', CategoryController::class);

    //product  Routes//
    Route::resource('product', ProductController::class);


    //product gallery Routes//
    Route::get('product-gallery{product}', [ProductGalleryController::class, 'index'])->name('product-gallery-show.index');
    Route::resource('product-gallery', ProductGalleryController::class);

    //product size Routes//
    Route::get('product-size{product}', [ProductSizeController::class, 'index'])->name('product-size-show.index');
    Route::resource('product-size', ProductSizeController::class);

    //product Option Routes//
    Route::resource('product-option', ProductOptionController::class);

    //Setting Routes //
    Route::get('/setting',[SettingController::class, 'index'])->name('setting.index');
    Route::put('/general-setting',[SettingController::class, 'UpdateGeneralSetting'])->name('general-setting.update');
});
