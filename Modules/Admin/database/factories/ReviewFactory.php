<?php

namespace Modules\Admin\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Admin\App\Models\Product;
use Modules\Admin\App\Models\User;

class ReviewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Admin\App\Models\Review::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $products = new Product();
        $productIds = $products->getList()->pluck('product_id')->toArray();
        $productRandId = array_rand($productIds);

        $users = new User();
        $userIds = $users->getList()->pluck('user_id')->toArray();
        $userRandId = array_rand($userIds);

        return [
            'user_id' => $userIds[$userRandId],
            'product_id' => $productIds[$productRandId],
            'title' => fake()->name(),
            'rating' => rand(1, 5)
        ];
    }
}

