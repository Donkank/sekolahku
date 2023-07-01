<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    public function definition(): array
    {
        $int = mt_rand(1612055681, 1684818996);
        $date = date("Y-m-d H:i:s", $int);

        return [
            'name'              => fake()->name(),
            'email'             => fake()->unique()->safeEmail(),
            'email_verified_at' => $date,
            'password'          => Hash::make('123'),
            'created_at'        => $date,
            'updated_at'        => $date
        ];
    }
}
