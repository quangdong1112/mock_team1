<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class MemberShiftFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        static $memberId = 1;
        $shiftId = DB::table('shifts')->pluck('id');
        return [
            'member_id' => $memberId++,
            'shift_id' => $this->faker->randomElement($shiftId),
            'created_by' => 1,
        ];
    }
}
