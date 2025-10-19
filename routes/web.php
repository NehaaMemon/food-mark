<?php

use App\Events\RTOrderPlacedNotificationEvent;
use App\Http\Controllers\Admin\AdminAuthController;
// use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\frontend\CartController;
use App\Http\Controllers\frontend\CheckoutController;
use App\Http\Controllers\Frontend\DashboardController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\PaymentController;
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
Route::post('address',[DashboardController::class,'createAddress'])->name('address.store');
Route::put('address/{id}/edit',[DashboardController::class,'updateAddress'])->name('address.update');
Route::delete('address/{id}',[DashboardController::class,'destroyAddress'])->name('address.destroy');
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
//Add to cart //
Route::post('add-to-cart',[CartController::class,'addtocart'])->name('add-to-cart');

//Update cart product //
Route::get(('cart-update-products'),[CartController::class,'getCartProduct'])->name('cart-update-products');

// remove sidebarcart Product
Route::get('cart-product-remove/{rowId}',[CartController::class,'cartProductRemove'])->name('cart-product-remove');

// Cart Page Route//
Route::get('/cart',[CartController::class,'index'])->name('cart.index');
//Cart Update //
Route::post('/cart-update-qty',[CartController::class,'cartqtyUpdate'])->name('cart.quantity-update');
//Cart destroy //
Route::get('/cart-destroy',[CartController::class,'CartDestroy'])->name('cart.destroy');

//coupon routes//
Route::post('/apply-coupon',[FrontendController::class,'applyCoupon'])->name('apply-coupon');
//remove coupon//
Route::get('/destroy-coupon',[FrontendController::class,'destroyCoupon'])->name('destroy-coupon');

Route::group(['middleware' => 'auth'] ,function(){
    Route::get('checkout',[CheckoutController::class,'index'])->name('checkout.index');
    Route::get('checkout/{id}/delivery-cal',[CheckoutController::class,'calculatedelivery'])->name('checkout.delivery-cal');
    Route::post('checkout',[CheckoutController::class,'checkoutRedirect'])->name('checkout.redirect');
    //Payment route//
    Route::get('payment',[PaymentController::class,'index'])->name('payment.index');
    Route::post('make-payment',[PaymentController::class,'makePayment'])->name('payment-make');
    Route::get('payment-success',[PaymentController::class,'paymentSuccess'])->name('payment.success');
    Route::get('payment-cancel',[PaymentController::class,'paymentCancel'])->name('payment.cancel');

    //PayaPal Routes//
    Route::get('paypal/payment',[PaymentController::class,'payWithPaypal'])->name('paypal.payment');
    Route::get('paypal/success',[PaymentController::class,'paypalSuccess'])->name('paypal.success');
    Route::get('paypal/cancel',[PaymentController::class,'paypalCancel'])->name('paypal.cancel');

      //stripe Routes//
    Route::get('stripe/payment',[PaymentController::class,'payWithStripe'])->name('stripe.payment');
    Route::get('stripe/success',[PaymentController::class,'stripeSuccess'])->name('stripe.success');
    Route::get('stripe/cancel',[PaymentController::class,'stripeCancel'])->name('stripe.cancel');

    //jazzcash Routes//
    // Route::match(['get','post'],'jazzcash/payment', [PaymentController::class, 'payWithJazzcash'])->name('jazzcash.payment');
    // Route::post('jazzcash/response', [PaymentController::class, 'jazzcashResponse'])->name('jazzcash.response');
    // Route::get('jazzcash/success', [PaymentController::class, 'jazzcashSuccess'])->name('jazzcash.success');
    // Route::get('jazzcash/cancel', [PaymentController::class, 'jazzcashCancel'])->name('jazzcash.cancel');
    // routes/web.php

// Payment page -> makes POST to JazzCash (GET only)
Route::get('jazzcash/payment', [PaymentController::class, 'payWithJazzcash'])->name('jazzcash.payment');
Route::post('jazzcash/response', [PaymentController::class, 'jazzcashResponse'])->name('jazzcash.response');
Route::get('jazzcash/success', [PaymentController::class, 'jazzcashSuccess'])->name('jazzcash.success');
Route::get('jazzcash/cancel', [PaymentController::class, 'jazzcashCancel'])->name('jazzcash.cancel');



    Route::get('test',function(){
       RTOrderPlacedNotificationEvent::dispatch('hello there');
    });
});
