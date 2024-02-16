<?php

namespace Modules\Admin\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BrandFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Admin\App\Models\Brand::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'brand_name' => fake()->name(),
            'founded' => fake()->date(),
            'updated_by' => 1,
            'is_delete' => 0
        ];
    }
}

