<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class DivisionMemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $divison = DB::table('divisions')->pluck('id');
        return [
                'member_id' => $this->faker->unique()->randomElement(DB::table('members')->pluck('id')),
                'division_id' => $this->faker->randomElement($divison),
            ];
    }
}
