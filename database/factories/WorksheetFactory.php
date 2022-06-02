<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class WorksheetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        static $id = 0;
        static $day = 1;
        static $mouth = 1;
        static $year = 2022;
        $workDate = $year.'-'.$mouth.'-'.$day;
        if ($id == 101) {
            $id = 1;
        }
        if ($id == 100) {
            $day++;
        }
        if ($mouth % 2 != 0) {
            if ($day == 32) {
                $day = 1;
                $mouth = $mouth+1;
            }
        } else {
            if ($mouth == 2) {
                if ($day >= 29) {
                    if (!checkdate($mouth, $day, $year)) {
                        $day = 1;
                        $mouth= $mouth+1;
                    }
                }
            } else {
                if ($day == 31) {
                    $day = 1;
                    $mouth= $mouth+1;
                }
            }

        }

        $start = mktime(8, 30, 0, 5, $day, 2022);
        $finish = mktime(17, 30, 0, 5, $day, 2022);
        $checkin = mktime(8, random_int(5, 59), random_int(0, 59), 5, $day, 2022);
        $checkout = mktime(17, random_int(20, 50), random_int(0, 59), 5, $day, 2022);
        return [
            'member_id' => $id++ < 100 ? $id : $id=1,
            'work_date' => $workDate,
            'checkin' => date('Y-m-d H:i:s', $start),
            'checkin_original' => date('Y-m-d H:i:s', $checkin),
            'checkout' => date('Y-m-d H:i:s', $finish),
            'checkout_original' => date('Y-m-d H:i:s', $checkout),
            'late' => ($checkin > $start) ? date('H:i', ($checkin - $start)) : null,
            'early' => ($checkout < $finish) ? date('H:i', ($finish - $checkout)) : null,
            'in_office' => date('H:i', ($checkout - $checkin)),
        ];
    }
}
