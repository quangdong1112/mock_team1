<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        static $random = 100;
        return [
            'full_name' => $this->faker->lastName,
            'member_code' => $this->faker->randomElement(['CTV-', 'D1-', 'D2-', 'D5-', 'G6-', 'HR-', 'ADMIN-', 'NS-']
                ) . $random,
            'email' => 'test' . $random++ . '@gmail.com',
            'avatar' => 'http://127.0.0.1:8000/storage/avatar/avatar.png',
            'password' => Hash::make('123456'), // password
            'created_by' => 1,
        ];
    }
}
