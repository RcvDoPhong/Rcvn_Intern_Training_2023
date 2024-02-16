<?php

namespace Modules\Admin\database\seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Route;
use Modules\Admin\App\Models\Role;
use Modules\Admin\App\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::factory()
            ->count(10)
            ->create();

        $roles = Role::getList();
        $permissions = new Permission();
        $permissionList = $permissions->getList()->pluck('permission_id')->toArray();

        foreach($roles as $role) {
            $role->permissions()->sync($permissionList);
        }
    }
}
