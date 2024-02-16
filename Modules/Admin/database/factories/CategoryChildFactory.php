<?php

namespace Modules\Admin\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryChildFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Admin\App\Models\Category::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            // 'parent_categories_id' => rand(1, Category::all()->pluck('category_id')->toArray()),
            // 'category_name' => fake()->name(),
            // 'updated_by' => 1
        ];
    }
}

