<?php

namespace Modules\Admin\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Route;
use Modules\Admin\App\Constructs\Constants;
use Modules\Admin\App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = Constants::PERMISSION_LISTS;

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission['permission']
            ]);
        }
    }
}
