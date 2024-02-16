<?php

use Illuminate\Support\Facades\Route;
use Modules\Frontend\App\Http\Controllers\AuthController;
use Modules\Frontend\App\Http\Controllers\CartController;
use Modules\Frontend\App\Http\Controllers\CategoryController;
use Modules\Frontend\App\Http\Controllers\HomeController;
use Modules\Frontend\App\Http\Controllers\OrderHistoryDetailController;
use Modules\Frontend\App\Http\Controllers\ProductController;
use Modules\Frontend\App\Http\Controllers\UserController;
use Modules\Frontend\App\Http\Controllers\VerificationController;
use Modules\Frontend\App\Http\Controllers\PaymentController;
use Modules\Frontend\App\Http\Controllers\PlaceController;
use Modules\Frontend\App\Http\Controllers\OrderHistoryController;
use Modules\Frontend\App\Http\Controllers\PushController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//public route

Route::get('/', "HomeController@index")->name('frontend.home.index');

Route::group(['prefix' => 'frontend'], function () {


    Route::post('/searchSQL', 'HomeController@searchSQL')->name('frontend.home.searchSQL');
    Route::post('/searchElastic', 'HomeController@searchElastic')->name('frontend.home.searchElastic');
    Route::post('/searchList', 'HomeController@searchList')->name('frontend.home.searchList');
    Route::get('/category', "CategoryController@index")->name('frontend.category.index');


    Route::get('/category/query-product', 'CategoryController@queryProduct')->name('frontend.category.query-product');


    Route::get('/product/{id}', "ProductController@index")->name('frontend.product.index');



    Route::resource('/cart', CartController::class)->names('frontend.cart');
    Route::get('/cart/get-table-cart', "CartController@getTableCart")->name('frontend.cart.get-table-cart');
    Route::get('/cart/cart-length', "CartController@getCartLength")->name('frontend.cart.get-cart-length');


    Route::get('/place/city', "PlaceController@getCities")->name('frontend.place.city');
    Route::get('/place/district/{id}', "PlaceController@getDistrictsByCity")->name('frontend.place.district');
    Route::get('/place/ward/{id}', "PlaceController@getWardByDistrict")->name('frontend.place.ward');
});



// guest middleware
Route::middleware('guest')->group(function () {
    Route::group(['prefix' => 'frontend'], function () {
        Route::resource('/auth', AuthController::class)->names('frontend.auth');
        Route::post('/auth/login', "AuthController@login")->name('frontend.auth.login');
    });
});




// auth middleware
Route::middleware('auth')->group(function () {
    Route::group(['prefix' => 'frontend'], function () {
        Route::post('/auth/logout', "AuthController@logout")->name('frontend.auth.logout');



        Route::get('/user', "UserController@index")->name('frontend.user.index');
        Route::post('/user/update', "UserController@update")->name('frontend.user.update');
        Route::get('/user/change-password', "UserController@changePasswordPage")
            ->name('frontend.user.change-password-page');
        Route::post('/user/change-password', "UserController@changePassword")->name('frontend.user.change-password');


        Route::get('/payment', "PaymentController@index")->name('frontend.payment.index');
        Route::get('/payment/confirm-page', "PaymentController@confirmPage")->name('frontend.payment.confirm-page');
        Route::post("/payment/add-payment", "PaymentController@addPayment")->name('frontend.payment.add-payment');
        Route::post('/payment/apply-coupon', "PaymentController@applyCoupon")->name('frontend.payment.apply-coupon');
        Route::put('/payment/change-billing-address', "PaymentController@changeBillingAddress")->name('frontend.payment.change-billing-address');


        Route::get('/order-history', "OrderHistoryController@index")->name('frontend.order-history.index');
        Route::post('/order-history/cancel-order', "OrderHistoryController@cancelOrder")
            ->name('frontend.order-history.cancel-order');


        Route::get(
            '/order-history-detail/{id}',
            "OrderHistoryDetailController@index"
        )
            ->name('frontend.order-history-detail.index');

        Route::get('/order-history-detail/review-page/{orderHistoryID}/{productID}', "OrderHistoryDetailController@reviewPage")
            ->name('frontend.order-history-detail.review-page');

        Route::post(
            '/order-history-detail/add-review',
            "OrderHistoryDetailController@addReview"
        )->name('frontend.order-history-detail.add-review');
    });
});

//Email verification
Route::middleware('auth:web,frontend.auth.index')->group(function () {
    Route::get(
        '/send-verification-email',
        'VerificationController@sendVerificationEmail'
    )
        ->name('send.verification.email');
    Route::get('/email/sent-page', "VerificationController@showSentPage")->name('verification.sent');

    Route::get('/email/verify', "VerificationController@verifyEmail")->name('verification.notice');
    Route::get(
        '/email/verify/{id}/{hash}',
        "VerificationController@fulfillVerify"
    )
        ->middleware(['signed'])
        ->name('verification.verify');
});

Route::middleware('auth')->group(
    function () {
        Route::group(
            ['prefix' => 'frontend'],
            function () {
                // Push Notification:
                Route::post('/push/subscribe-user', 'PushController@subscribeUser')->name('frontend.push.subscribe-user');
                Route::get('/push/notify-user', 'PushController@pushNotifyUser')->name('frontend.push.notify-user');
            }
        );
    }
);
