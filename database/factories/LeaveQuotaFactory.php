<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LeaveQuotaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        static $id = 0;
        static $year = 2022;

        if ($id == 100) {
            $year++;
        }
        return [
            'member_id' => $id++ < 100 ? $id : $id=1,
            'year' => date('Y', strtotime($year)),
            'quota' => 12,
            'remain' => 12,
        ];
    }
}
