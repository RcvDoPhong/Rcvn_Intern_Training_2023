<?php

namespace Modules\Admin\database\seeders;

use Illuminate\Database\Seeder;
use Modules\Admin\App\Models\Brand;
use Modules\Admin\App\Models\Category;
use Modules\Admin\App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Product::factory()
        //     ->count(100000)
        //     ->create();

        $category = new Category();
        $childCategories = $category->getList(true, true)->pluck('category_id')->toArray();

        $brand = new Brand();
        $brand = $brand->getList()->pluck('brand_id')->toArray();

        $index = 1;
        for ($i = 0; $i < 2; $i++) {
            $data = [];
            for ($j = 0; $j < 50000; $j++) {
                $randCategoryId = array_rand($childCategories);
                $randBrandId = array_rand($brand);

                $productName = fake()->unique()->name() . " " . fake()->word() . " " . rand(0, 100);

                $data[] = [
                    'category_id' => $childCategories[$randCategoryId],
                    'brand_id' => $brand[$randBrandId],
                    // 'product_uuid' => strtoupper($productName[0]) . rand(100000000, 999999999),
                    'product_uuid' => strtoupper($productName[0]) . str_pad($index++, 10, 0, STR_PAD_LEFT),
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

            $chunks = array_chunk($data, 5000);
            foreach ($chunks as $chunk) {
                Product::insert($chunk);
            }
        }
    }
}
