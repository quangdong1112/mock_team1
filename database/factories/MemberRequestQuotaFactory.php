<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class MemberRequestQuotaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        static $id = 0;
        static $month = 1;
        static $year = 2022;
        $workDate = $year.'-'.$month;

        if ($id == 100) {
            $month++;
        }
        return [
            'member_id' => $id++ < 100 ? $id : $id=1,
            'month' => date('Y-m', strtotime($workDate)),
        ];
    }
}
