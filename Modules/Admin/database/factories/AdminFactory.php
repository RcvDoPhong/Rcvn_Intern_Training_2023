<?php

namespace Modules\Admin\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class AdminFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Admin\App\Models\Admin::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            // 'email' => fake()->unique()->safeEmail(),
            'email' => 'admin@email.com',
            'nickname' => fake()->name(),
            'birthday' => fake()->date(),
            'password' => Hash::make('password'),
            'gender' => random_int(0, 1),
            'updated_by' => 1,
            'is_delete' => 1,
            'is_active' =>1
        ];
    }
}

