<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\App\Http\Controllers\AdminController;
use Modules\Admin\App\Http\Controllers\AuthController;
use Modules\Admin\App\Http\Controllers\BrandController;
use Modules\Admin\App\Http\Controllers\CategoryController;
use Modules\Admin\App\Http\Controllers\DistrictController;
use Modules\Admin\App\Http\Controllers\OrderController;
use Modules\Admin\App\Http\Controllers\ProductController;
use Modules\Admin\App\Http\Controllers\ReportController;
use Modules\Admin\App\Http\Controllers\ReviewController;
use Modules\Admin\App\Http\Controllers\RoleController;
use Modules\Admin\App\Http\Controllers\ShippingController;
use Modules\Admin\App\Http\Controllers\UserController;
use Modules\Admin\App\Http\Controllers\WardController;

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

Route::middleware('guest:admin')->group(function () {
    Route::group(['prefix' => 'admin'], function () {
        Route::get('/login', [AuthController::class,  'index'])->name('admin.auth.login');
        Route::post('/login.process', [AuthController::class, 'login'])->name('admin.auth.process');
    });
});

Route::middleware(['auth:admin'])->group(function () {

    Route::group(['prefix' => 'admin'], function () {

        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.admin.dashboard');

        Route::post('/logout', [AuthController::class, 'logout'])->name('admin.auth.logout');

        Route::group(['prefix' => 'admins'], function () {
            Route::get('/', [AdminController::class, 'index'])->name('admin.admin.index')
                ->middleware('permission:admin.view');
            Route::get('/create', [AdminController::class, 'create'])->name('admin.admin.create')
                ->middleware('permission:admin.create');
            Route::get('/edit/{id}', [AdminController::class, 'edit'])->name('admin.admin.edit')
                ->middleware('permission:admin.update');

            Route::post('/store', [AdminController::class, 'store'])->name('admin.admin.store')
                ->middleware('permission:admin.create');

            Route::put('/update/{id}', [AdminController::class, 'update'])->name('admin.admin.update')
                ->middleware('permission:admin.update');
            Route::put('/updatePassword/{id}', [AdminController::class, 'updatePassword'])->name('admin.admin.password')
                ->middleware('permission:admin.update');
            Route::put('/lock/{id}', [AdminController::class, 'lock'])->name('admin.admin.lock')
                ->middleware('permission:admin.update');

            Route::delete('/delete/{id}', [AdminController::class, 'destroy'])->name('admin.admin.destroy')
                ->middleware('permission:admin.delete');
        });

        Route::group(['prefix' => 'brands'], function () {
            Route::get('/', [BrandController::class, 'index'])->name('admin.brands.index')
                ->middleware('permission:brand.view');
            Route::get('/create', [BrandController::class, 'create'])->name('admin.brands.create')
                ->middleware('permission:brand.create');
            Route::get('/{id}', [BrandController::class, 'show'])->name('admin.brands.show')
                ->middleware('permission:brand.view');
            Route::get('/edit/{id}', [BrandController::class, 'edit'])->name('admin.brands.edit')
                ->middleware('permission:brand.update');

            Route::post('/store', [BrandController::class, 'store'])->name('admin.brands.store')
                ->middleware('permission:brand.create');

            Route::put('/update/{id}', [BrandController::class, 'update'])->name('admin.brands.update')
                ->middleware('permission:brand.update');

            Route::delete('/delete/{id}', [BrandController::class, 'destroy'])->name('admin.brands.destroy')
                ->middleware('permission:brand.delete');
        });

        Route::group(['prefix' => 'categories'], function () {
            Route::get('/', [CategoryController::class, 'index'])->name('admin.categories.index')
                ->middleware('permission:category.view');
            Route::get('/create', [CategoryController::class, 'create'])->name('admin.categories.create')
                ->middleware('permission:category.create');
            Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('admin.categories.edit')
                ->middleware('permission:category.update');

            Route::post('/store', [CategoryController::class, 'store'])->name('admin.categories.store')
                ->middleware('permission:category.create');

            Route::put('/update/{id}', [CategoryController::class, 'update'])->name('admin.categories.update')
                ->middleware('permission:category.update');

            Route::delete('/delete/{id}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy')
                ->middleware('permission:category.delete');
        });

        Route::group(['prefix' => 'products'], function () {
            Route::get('/', [ProductController::class, 'index'])->name('admin.products.index')
                ->middleware('permission:product.view');
            Route::get('/create', [ProductController::class, 'create'])->name('admin.products.create')
                ->middleware('permission:product.create');
            Route::get('/{id}', [ProductController::class, 'show'])->name('admin.products.show')
                ->middleware('permission:product.view');
            Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('admin.products.edit')
                ->middleware('permission:product.update');
            Route::get('/productImages/{id}', [ProductController::class, 'getProductImages'])->name('admin.products.getImages')
                ->middleware('permission:product.update');

            Route::post('/store', [ProductController::class, 'store'])->name('admin.products.store')
                ->middleware('permission:product.create');
            Route::post('/storeImages', [ProductController::class, 'storeImages'])->name('admin.products.storeImages');

            Route::put('/update/{id}', [ProductController::class, 'update'])->name('admin.products.update')
                ->middleware('permission:product.update');

            Route::delete('/removeImage', [ProductController::class, 'removeImage'])->name('admin.product.removeImage')
                ->middleware('permission:product.update');
            Route::delete('/delete/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy')
                ->middleware('permission:product.delete');
        });

        Route::group(['prefix' => 'shippings'], function () {
            Route::get('/', [ShippingController::class, 'index'])->name('admin.shippings.index')
                ->middleware('permission:vendor.view');
            Route::get('/create', [ShippingController::class, 'create'])->name('admin.shippings.create')
                ->middleware('permission:vendor.create');
            Route::get('/edit/{id}', [ShippingController::class, 'edit'])->name('admin.shippings.edit')
                ->middleware('permission:vendor.update');

            Route::post('/store', [ShippingController::class, 'store'])->name('admin.shippings.store')
                ->middleware('permission:vendor.create');

            Route::put('/update/{id}', [ShippingController::class, 'update'])->name('admin.shippings.update')
                ->middleware('permission:vendor.update');

            Route::delete('/delete/{id}', [ShippingController::class, 'destroy'])->name('admin.shippings.destroy')
                ->middleware('permission:vendor.delete');
        });

        Route::group(['prefix' => 'orders'], function () {
            Route::get('/', [OrderController::class, 'index'])->name('admin.orders.index')
                ->middleware('permission:order.view');
            Route::get('/{id}', [OrderController::class, 'show'])->name('admin.orders.show')
                ->middleware('permission:order.view');

            Route::put('/updateStatus/{id}', [OrderController::class, 'updateStatus'])->name('admin.orders.status')
                ->middleware('permission:order.update');
        });

        Route::group(['prefix' => 'users'], function () {
            Route::get('/', [UserController::class, 'index'])->name('admin.users.index')
                ->middleware('permission:customer.view');
            Route::get('/{id}', [UserController::class, 'show'])->name('admin.users.show')
                ->middleware('permission:customer.view');
            Route::get('/{id}/info', [UserController::class, 'edit'])->name('admin.users.edit')
                ->middleware('permission:customer.update');
            Route::get('/{id}/order', [UserController::class, 'orders'])->name('admin.users.orders')
                ->middleware('permission:customer.view');

            Route::put('/updatePassword/{id}', [UserController::class, 'updatePassword'])->name('admin.users.updatePassword')
                ->middleware('permission:customer.update');
            Route::put('/update/{id}', [UserController::class, 'update'])->name('admin.users.update')
                ->middleware('permission:customer.update');
            Route::put('/lock/{id}', [UserController::class, 'lock'])->name('admin.users.lock')
                ->middleware('permission:customer.update');

            Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy')
                ->middleware('permission:customer.delete');
        });

        Route::get('/district/{cityId}', [DistrictController::class, 'show'])->name('admin.districts.show');
        Route::get('/wards/{districtId}', [WardController::class, 'show'])->name('admin.wards.show');

        Route::group(['prefix' => 'reviews'], function () {
            Route::get('/', [ReviewController::class, 'index'])->name('admin.reviews.index')
                ->middleware('permission:review.view');
            Route::get('/getReviewImages/{id}', [ReviewController::class, 'getReviewImages'])->name('admin.reviews.images')
                ->middleware('permission:review.view');
            Route::get('/{id}', [ReviewController::class, 'show'])->name('admin.reviews.show')
                ->middleware('permission:review.view');

            Route::put('/update/{id}', [ReviewController::class, 'update'])->name('admin.reviews.update')
                ->middleware('permission:review.update');
        });

        Route::group(['prefix' => 'reports'], function () {
            Route::get('/', [ReportController::class, 'index'])->name('admin.reports.index');

            Route::post('/reports', [ReportController::class, 'reports'])->name('admin.reports.reports');
        });

        Route::group(['prefix' => 'roles'], function () {
            Route::get('/', [RoleController::class, 'index'])->name('admin.roles.index')
                ->middleware('permission:role.view');
            Route::get('/create', [RoleController::class, 'create'])->name('admin.roles.create')
                ->middleware('permission:role.create');
            Route::get('/permissions/{id}', [RoleController::class, 'permissions'])->name('admin.roles.permissions')
                ->middleware('permission:role.view');
            Route::get('/{id}', [RoleController::class, 'show'])->name('admin.roles.show')
                ->middleware('permission:role.view');

            Route::post('/create', [RoleController::class, 'store'])->name('admin.roles.store')
                ->middleware('permission:role.create');

            Route::put('/update/{id}', [RoleController::class, 'update'])->name('admin.roles.update')
                ->middleware('permission:role.update');
            Route::put('/updatePermission/{id}', [RoleController::class, 'updatePermission'])->name('admin.roles.updatePermission')
                ->middleware('permission:role.update');

            Route::delete('/delete/{id}', [RoleController::class, 'destroy'])->name('admin.roles.destroy')
                ->middleware('permission:role.delete');
        });
    });
});
