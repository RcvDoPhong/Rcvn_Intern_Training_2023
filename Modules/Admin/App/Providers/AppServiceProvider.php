<?php

namespace Modules\Admin\App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(
            \Modules\Admin\App\Http\Repositories\AuthRepository\AuthRepositoryInterface::class,
            \Modules\Admin\App\Http\Repositories\AuthRepository\AuthRepository::class,
        );

        $this->app->singleton(
            \Modules\Admin\App\Http\Repositories\RoleRepository\RoleRepositoryInterface::class,
            \Modules\Admin\App\Http\Repositories\RoleRepository\RoleRepository::class,
        );

        $this->app->singleton(
            \Modules\Admin\App\Http\Repositories\AdminRepository\AdminRepositoryInterface::class,
            \Modules\Admin\App\Http\Repositories\AdminRepository\AdminRepository::class,
        );

        $this->app->singleton(
            \Modules\Admin\App\Http\Repositories\BrandRepository\BrandRepositoryInterface::class,
            \Modules\Admin\App\Http\Repositories\BrandRepository\BrandRepository::class,
        );

        $this->app->singleton(
            \Modules\Admin\App\Http\Repositories\CategoryRepository\CategoryRepositoryInterface::class,
            \Modules\Admin\App\Http\Repositories\CategoryRepository\CategoryRepository::class,
        );

        $this->app->singleton(
            \Modules\Admin\App\Http\Repositories\ProductRepository\ProductRepositoryInterface::class,
            \Modules\Admin\App\Http\Repositories\ProductRepository\ProductRepository::class,
        );

        $this->app->singleton(
            \Modules\Admin\App\Http\Repositories\ShippingRepository\ShippingRepositoryInterface::class,
            \Modules\Admin\App\Http\Repositories\ShippingRepository\ShippingRepository::class,
        );

        $this->app->singleton(
            \Modules\Admin\App\Http\Repositories\OrderRepository\OrderRepositoryInterface::class,
            \Modules\Admin\App\Http\Repositories\OrderRepository\OrderRepository::class,
        );

        $this->app->singleton(
            \Modules\Admin\App\Http\Repositories\CityRepository\CityRepositoryInterface::class,
            \Modules\Admin\App\Http\Repositories\CityRepository\CityRepository::class,
        );

        $this->app->singleton(
            \Modules\Admin\App\Http\Repositories\DistrictRepository\DistrictRepositoryInterface::class,
            \Modules\Admin\App\Http\Repositories\DistrictRepository\DistrictRepository::class,
        );

        $this->app->singleton(
            \Modules\Admin\App\Http\Repositories\WardRepository\WardRepositoryInterface::class,
            \Modules\Admin\App\Http\Repositories\WardRepository\WardRepository::class,
        );

        $this->app->singleton(
            \Modules\Admin\App\Http\Repositories\UserRepository\UserRepositoryInterface::class,
            \Modules\Admin\App\Http\Repositories\UserRepository\UserRepository::class,
        );

        $this->app->singleton(
            \Modules\Admin\App\Http\Repositories\ReviewRepository\ReviewRepositoryInterface::class,
            \Modules\Admin\App\Http\Repositories\ReviewRepository\ReviewRepository::class,
        );
    }
}
