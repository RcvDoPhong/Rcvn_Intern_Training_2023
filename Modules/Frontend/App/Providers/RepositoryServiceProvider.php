<?php

namespace Modules\Frontend\App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Frontend\App\Repositories\Cart\CartRepository;
use Modules\Frontend\App\Repositories\Push\PushRepository;
use Modules\Frontend\App\Repositories\User\UserRepository;
use Modules\Frontend\App\Repositories\Place\CityRepository;
use Modules\Frontend\App\Repositories\Place\WardRepository;
use Modules\Frontend\App\Repositories\Brand\BrandRepository;
use Modules\Frontend\App\Repositories\Order\OrderRepository;
use Modules\Frontend\App\Repositories\Coupon\CouponRepository;
use Modules\Frontend\App\Repositories\Review\ReviewRepository;
use Modules\Frontend\App\Repositories\Place\DistrictRepository;
use Modules\Frontend\App\Repositories\Product\ProductRepository;
use Modules\Frontend\App\Repositories\Category\CategoryRepository;
use Modules\Frontend\App\Repositories\Shipping\ShippingRepository;
use Modules\Frontend\App\Repositories\Cart\CartRepositoryInterface;
use Modules\Frontend\App\Repositories\User\UserRepositoryInterface;
use Modules\Frontend\App\Repositories\Place\CityRepositoryInterface;
use Modules\Frontend\App\Repositories\Place\WardRepositoryInterface;
use Modules\Frontend\App\Repositories\Brand\BrandRepositoryInterface;
use Modules\Frontend\App\Repositories\Order\OrderRepositoryInterface;
use Modules\Frontend\App\Repositories\Coupon\CouponRepositoryInterface;
use Modules\Frontend\App\Repositories\Review\ReviewRepositoryInterface;
use Modules\Frontend\App\Repositories\Place\DistrictRepositoryInterface;
use Modules\Frontend\App\Repositories\Product\ProductRepositoryInterface;
use Modules\Frontend\App\Repositories\Category\CategoryRepositoryInterface;
use Modules\Frontend\App\Repositories\Push\PushRepositoryInterface;
use Modules\Frontend\App\Repositories\Home\HomeRepository;
use Modules\Frontend\App\Repositories\Home\HomeRepositoryInterface;
use Modules\Frontend\App\Repositories\Shipping\ShippingRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(
            UserRepositoryInterface::class,
            UserRepository::class,
        );

        $this->app->singleton(ProductRepositoryInterface::class, ProductRepository::class);

        $this->app->singleton(BrandRepositoryInterface::class, BrandRepository::class);

        $this->app->singleton(CategoryRepositoryInterface::class, CategoryRepository::class);

        $this->app->singleton(CartRepositoryInterface::class, CartRepository::class);

        $this->app->singleton(ShippingRepositoryInterface::class, ShippingRepository::class);

        $this->app->singleton(CityRepositoryInterface::class, CityRepository::class);
        $this->app->singleton(DistrictRepositoryInterface::class, DistrictRepository::class);
        $this->app->singleton(WardRepositoryInterface::class, WardRepository::class);

        $this->app->singleton(OrderRepositoryInterface::class, OrderRepository::class);


        $this->app->singleton(CouponRepositoryInterface::class, CouponRepository::class);

        $this->app->singleton(ReviewRepositoryInterface::class, ReviewRepository::class);

        $this->app->singleton(PushRepositoryInterface::class, PushRepository::class);

        $this->app->singleton(HomeRepositoryInterface::class, HomeRepository::class);


    }
}
