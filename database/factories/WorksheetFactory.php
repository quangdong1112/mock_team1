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
        static $month = 1;
        static $year = 2022;
        $workDate = $year.'-'.$month.'-'.$day;
        if ($id == 101) {
            $id = 1;
        }
        if ($id == 100) {
            $day++;
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

        $ot = mktime(18, 0, 0, $month, $day, $year);
        $start = mktime(8, 30, 0, $month, $day, $year);
        $finish = mktime(17, 30, 0, $month, $day, $year);
        $checkin = mktime(random_int(7, 9), random_int(0, 59), random_int(0, 59), $month, $day, $year);
        $checkout = mktime(random_int(16,18), random_int(0, 59), random_int(0, 59), $month, $day, $year);
        $inOffice = date('H:i', ($checkout - $checkin));
        $worktime =  (date('D',strtotime($workDate)) != 'Sat' && date('D',strtotime($workDate)) != 'Sun') ? date('H:i', strtotime("-1 hour", ($checkout - $checkin))) : null;
        $timework =  date('H:i', strtotime('-1 hour', ($finish-$start)));
        $timeworkOffice =  date('H:i', ($finish-$start));
        $timeworkOT =  date('H:i', strtotime('+1 hour', ($finish-$start)));
        $late = $checkin > $start ? $checkin - $start : 0;
        $early = $checkout < $finish ? $finish - $checkout : 0;
//        $lack = strtotime($timework) - strtotime($worktime);
        $lack = $late + $early;
        $otTime = $checkout - $ot;
        $compensation = strtotime($inOffice) - strtotime($timeworkOffice);
        return [
            'member_id' => $id++ < 100 ? $id : $id=1,
            'work_date' => $workDate,
            'checkin' => null,
            'checkin_original' => (date('D',strtotime($workDate)) != 'Sat' && date('D',strtotime($workDate)) != 'Sun') ? date('Y-m-d H:i:s', $checkin) : null,
            'checkout' => null,
            'checkout_original' =>(date('D',strtotime($workDate)) != 'Sat' && date('D',strtotime($workDate)) != 'Sun') ?  date('Y-m-d H:i:s', $checkout) : null,
            'late' => (date('D',strtotime($workDate)) != 'Sat' && date('D',strtotime($workDate)) != 'Sun') ? (($checkin > $start) ? date('H:i', ($checkin - $start)) : null) : null,
            'early' => (date('D',strtotime($workDate)) != 'Sat' && date('D',strtotime($workDate)) != 'Sun') ?(($checkout < $finish) ? date('H:i', ($finish - $checkout)) : null) :null,
            'in_office' => (date('D',strtotime($workDate)) != 'Sat' && date('D',strtotime($workDate)) != 'Sun') ? $inOffice : null,
            'work_time' => $worktime,
            'lack' => (date('D',strtotime($workDate)) != 'Sat' && date('D',strtotime($workDate)) != 'Sun') ? ($lack>0 ? date('H:i', $lack) : null) : null,
            'ot_time' =>(date('D',strtotime($workDate)) != 'Sat' && date('D',strtotime($workDate)) != 'Sun') ? (($ot < $checkout) ? date('H:i', $otTime) : null) : null,
            'compensation' =>(date('D',strtotime($workDate)) != 'Sat' && date('D',strtotime($workDate)) != 'Sun') ? ((strtotime($timeworkOffice) < strtotime($inOffice)) ? date('H:i', $compensation) : null) : null,
        ];
    }
}
