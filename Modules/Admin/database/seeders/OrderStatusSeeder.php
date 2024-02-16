<?php

namespace Modules\Admin\database\seeders;

use Illuminate\Database\Seeder;
use Modules\Admin\App\Constructs\Constants;
use Modules\Admin\App\Models\OrderStatus;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach(Constants::ORDER_STATUS as $status) {
            OrderStatus::create([
                'name' => $status['name'],
                'updated_by' => 1,
            ]);
        }
    }
}
