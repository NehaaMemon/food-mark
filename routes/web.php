<?php

use App\Http\Controllers\Admin\AdminAuthController;
// use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Frontend\DashboardController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::group(['middleware' => 'guest'], function (){


//Admin Route
Route::get('admin/login',[AdminAuthController::class, 'index'])->name('admin.login');
Route::get('admin/forget-password',[AdminAuthController::class, 'forgetPassword'])->name('admin.forget-password');

});


Route::group(['middleware' => 'auth'],function(){
Route::get('dashboard',[DashboardController::class, 'index'])->name('dashboard');
Route::put('profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
Route::post('profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';
// show Home Page//

Route::get('/', [FrontendController::class, 'index'])->name('home');

//Show product Page //

Route::get('/product/{slug}',[FrontendController::class, 'showProduct'])->name('product.show');

//Show product load Page //
Route::get('/load-product-modal/{productId}',[FrontendController::class, 'loadProductModal'])->name('load-product-Modal');

