<?php

namespace Modules\Admin\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ShippingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Admin\App\Models\Shipping::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'shipping_method_name' => fake()->name(),
            'shipping_price' => rand(5, 100),
            'estimate_shipping_days' => rand(1, 14),
            'updated_by' => 1
        ];
    }
}

