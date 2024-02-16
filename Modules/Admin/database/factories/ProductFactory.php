<?php

namespace Modules\Admin\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Admin\App\Models\Brand;
use Modules\Admin\App\Models\Category;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Admin\App\Models\Product::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $category = new Category();
        $childCategories = $category->getList(true, true)->pluck('category_id')->toArray();

        $brand = new Brand();
        $brand = $brand->getList()->pluck('brand_id')->toArray();

        $randCategoryId = array_rand($childCategories);
        $randBrandId = array_rand($brand);

        $productName = fake()->unique()->name();
        return [
            'category_id' => $childCategories[$randCategoryId],
            'brand_id' => $brand[$randBrandId],
            'product_uuid' => strtoupper($productName[0]) . rand(100000000, 999999999),
            'product_name' => $productName,
            'base_price' => rand(10000, 99999),
            'product_description' => fake()->paragraph(),
            'brief_description' => fake()->sentence(),
            'stock' => rand(10, 200),
            'status' => 1,
            'updated_by' => 1,
            'is_delete' => 0
        ];
    }
}

