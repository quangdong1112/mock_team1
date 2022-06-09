<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ChecklogFactory extends Factory
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
        static $month = 1;
        static $year = 2022;
        $workDate = $year.'-'.$month.'-'.$day;
        $checkin = mktime(random_int(7,9), random_int(0, 59), random_int(0, 59), $month, $day, $year);
        $exit = mktime(random_int(9, 16), random_int(0, 59), random_int(0, 59), $month, $day, $year);
        $checkout = mktime(random_int(16,19), random_int(0, 59), random_int(0, 59), $month, $day, $year);
        static $cout = 0;
        static $time;
        if ($id == 101) {
            $id = 1;
        }
        if ($id == 99) {
            if(date('D',strtotime($workDate)) == 'Sat' || date('D',strtotime($workDate)) == 'Sun') {
                $cout = 3;
            } else {
                $cout++;
            }
            if ($cout > 2) {
                $cout = 0;
                $day++;
            }
        }
        if ($cout == 0) {
            $time = $checkin;
        }
        if ($cout == 1) {
            $time = $exit;
        }
        if ($cout == 2) {
            $time = $checkout;
        }

        if ($month % 2 != 0) {
            if ($day == 32) {
                $day = 1;
                $month = $month+1;
            }
        } else {
            if ($month == 2) {
                if ($day >= 29) {
                    if (!checkdate($month, $day, $year)) {
                        $day = 1;
                        $month= $month+1;
                    }
                }
            } else {
                if ($day == 31) {
                    $day = 1;
                    $month= $month+1;
                }
            }

        }
        return [
            'member_id' => $id++ < 100 ? $id : $id=1,
            'checktime' => (date('D',strtotime($workDate)) != 'Sat' && date('D',strtotime($workDate)) != 'Sun') ? date('Y-m-d H:i:s', $time ?? $checkin) : null,
            'date' => $workDate,
            'created_at' => (date('D',strtotime($workDate)) != 'Sat' && date('D',strtotime($workDate)) != 'Sun') ? date('Y-m-d H:i:s', $time ?? $checkin) : null,
        ];
    }
}
