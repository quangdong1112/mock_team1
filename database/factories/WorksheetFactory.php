<?php

namespace Database\Factories;

use App\Models\Checklog;
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
        static $day = 3;
        static $month = 1;
        static $year = 2022;
        $workDate = $year.'-'.$month.'-'.$day;
        if ($id == 99) {
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
        $memberId = $id++ < 100 ? $id : $id=1;
        $checkLog = Checklog::where('member_id', $memberId)->where('date', $workDate);
        $checkIN = $checkLog->first()->checktime ?? null;
        $checkOUT = $checkLog->latest()->first()->checktime ?? null;

        $ot = mktime(18, 0, 0, $month, $day, $year);
        $start = mktime(8, 30, 0, $month, $day, $year);
        $finish = mktime(17, 30, 0, $month, $day, $year);
        $inOffice = date('H:i', (strtotime($checkOUT) - strtotime($checkIN)));
        $worktime =  (date('D',strtotime($workDate)) != 'Sat' && date('D',strtotime($workDate)) != 'Sun') ? date('H:i', strtotime("-1 hour", (strtotime($checkOUT) - strtotime($checkIN)))) : null;
        $timeworkOffice =  date('H:i', ($finish-$start));
        $late = strtotime($checkIN) > $start ? strtotime($checkIN) - $start : 0;
        $early = strtotime($checkOUT) < $finish ? $finish - strtotime($checkOUT) : 0;
        $lack = $late + $early;
        $otTime = strtotime($checkOUT) - $ot;
        $compensation = strtotime($inOffice) - strtotime($timeworkOffice);
        return [
            'member_id' => $memberId,
            'work_date' => $workDate,
            'checkin' => null,
            'checkin_original' => $checkIN,
            'checkout' => null,
            'checkout_original' => $checkOUT,
            'late' => (date('D',strtotime($workDate)) != 'Sat' && date('D',strtotime($workDate)) != 'Sun') ? ((strtotime($checkIN) > $start) ? date('H:i', (strtotime($checkIN) - $start)) : null) : null,
            'early' => (date('D',strtotime($workDate)) != 'Sat' && date('D',strtotime($workDate)) != 'Sun') ?((strtotime($checkOUT) < $finish) ? date('H:i', ($finish - strtotime($checkOUT))) : null) :null,
            'in_office' => (date('D',strtotime($workDate)) != 'Sat' && date('D',strtotime($workDate)) != 'Sun') ? $inOffice : null,
            'work_time' => $worktime,
            'lack' => (date('D',strtotime($workDate)) != 'Sat' && date('D',strtotime($workDate)) != 'Sun') ? ($lack>0 ? date('H:i', $lack) : null) : null,
            'ot_time' =>(date('D',strtotime($workDate)) != 'Sat' && date('D',strtotime($workDate)) != 'Sun') ? (($ot < strtotime($checkOUT)) ? date('H:i', $otTime) : null) : null,
            'compensation' =>(date('D',strtotime($workDate)) != 'Sat' && date('D',strtotime($workDate)) != 'Sun') ? ((strtotime($timeworkOffice) < strtotime($inOffice)) ? date('H:i', $compensation) : null) : null,
        ];
    }
}
