<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class DivisionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $managerMember = DB::table('members')->pluck('id');
        $id = $this->faker->unique()->randomElement($managerMember);
        return [
            'member_id' => $id,
            'division_name' => $this->faker->unique()->randomElement(['D1', 'D2', 'D3', 'D4', 'D5', 'D6']),
            'created_by' => $id,
        ];
    }
}
