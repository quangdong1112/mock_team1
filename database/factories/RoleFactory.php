<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->unique()->randomElement(['Admin','Manager','Member']),
            'created_at'=>$this->faker->dateTimeBetween('-1 day' ),
            'updated_at'=>$this->faker->dateTimeBetween('-1 day' ),
        ];
    }
}
