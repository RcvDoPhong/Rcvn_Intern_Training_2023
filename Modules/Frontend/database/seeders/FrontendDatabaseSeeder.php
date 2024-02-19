<?php

namespace Modules\Frontend\database\seeders;

use Illuminate\Database\Seeder;
use Modules\Admin\database\seeders\AdminSeeder;
use Modules\Admin\database\seeders\BrandSeeder;
use Modules\Admin\database\seeders\CategorySeeder;
use Modules\Admin\database\seeders\CitySeeder;
use Modules\Admin\database\seeders\OrderStatusSeeder;
use Modules\Admin\database\seeders\PermissionSeeder;
use Modules\Admin\database\seeders\ProductSeeder;
use Modules\Admin\database\seeders\ReviewSeeder;
use Modules\Admin\database\seeders\RoleSeeder;
use Modules\Admin\database\seeders\ShippingSeeder;
use Modules\Admin\database\seeders\UserSeeder;

class FrontendDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            BrandSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            UserSeeder::class,
            ReviewSeeder::class,
            CitySeeder::class,
            OrderStatusSeeder::class,
            ShippingSeeder::class,
        ]);
    }
}
