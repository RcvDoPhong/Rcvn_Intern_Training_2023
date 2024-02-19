<?php

namespace Modules\Admin\database\seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\Admin\App\Models\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::factory()
            ->count(1)
            ->forRole([
                'role_id' => 1,
                'role_name' => 'Admin'
            ])
            ->create();
    }
}
