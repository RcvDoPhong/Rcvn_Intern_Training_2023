<?php

namespace Modules\Admin\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Admin\App\Models\Role::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'role_name' => fake()->name(),
            'is_delete' => 0
        ];
    }
}

