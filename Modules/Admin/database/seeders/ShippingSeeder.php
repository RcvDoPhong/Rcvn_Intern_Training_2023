<?php

namespace Modules\Admin\database\seeders;

use Illuminate\Database\Seeder;
use Modules\Admin\App\Models\City;
use Modules\Admin\App\Models\Shipping;

class ShippingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Shipping::factory()
            ->count(10)
            ->create();

        $cityList = City::getList()->pluck('city_id')->toArray();

        for ($i = 0; $i < 10; $i++) {
            $citySplit = array_slice($cityList, rand(1, 10), rand(1, 30));

            $shipping = Shipping::create([
                'shipping_method_name' => fake()->name(),
                'shipping_price' => rand(5, 100),
                'estimate_shipping_days' => rand(1, 14),
                'updated_by' => 1
            ]);

            $shipping->cities($citySplit);
        }
    }
}
