<?php

namespace App\Services;

use App\Repositories\ChecklogRepository;

class ChecklogService extends BaseService
{

    public function getRepository()
    {
        return ChecklogRepository::class;
    }

    public function showTimeLog($request, $memberId)
    {
        $model = $this->model();
        $timeLogs = $model->where('member_id', $memberId);

        $workDate = trim($request->work_date);
        if ($workDate) {
            $workDate = date('Y-m-d', strtotime($workDate));
            $timeLogDate = $timeLogs->where('date', $workDate)->orderBy('checktime', 'asc')->get();
            if ($timeLogDate->isNotEmpty()) {
                return $timeLogDate;
            } else {
                return response()->json([
                    'error' => 'Error! Work date invalid'
                ]);
            }
        } else {
            return response()->json([
                'error' => 'Error! Work date invalid'
            ]);
        }

    }
}
