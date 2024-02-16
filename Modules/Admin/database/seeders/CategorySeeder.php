<?php

namespace Modules\Admin\database\seeders;

use Illuminate\Database\Seeder;
use Modules\Admin\App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::factory()
            ->count(10)
            ->create();

        $categoryObj = new Category();
        $categoryList = $categoryObj->getList()->pluck('category_id')->toArray();
        for ($i = 0; $i < 10; $i++) {
            $categoryRandId = array_rand($categoryList);
            Category::factory()
                ->create([
                    'parent_categories_id' => $categoryList[$categoryRandId],
                    'category_name' => fake()->unique()->name(),
                    'updated_by' => 1
                ]);
        }
    }
}
