<?php

namespace App\Services;

use App\Models\LeaveQuota;
use App\Models\MemberRequestQuota;
use App\Repositories\RequestRepository;

class RegisterLeaveService extends BaseService
{

    public function getRepository()
    {
        return RequestRepository::class;
    }

    public function store($request)
    {
        $requestForDate = trim($request->request_for_date);
        $requestType = $request->request_type;
        $checkin = trim($request->check_in);
        $checkout = trim($request->check_out);
        $reason = trim($request->reason);
        $leaveAllDay= $request->leave_all_day;
        $leaveStart= $request->leave_start;
        $leaveEnd= $request->leave_end;
        $leaveTime= $request->leave_time;

        $year = date('Y', strtotime($requestForDate));

        $registerLeavePaid = $this->model()->where('member_id', auth()->id())
            ->where('request_for_date', $requestForDate)
            ->where('request_type', 2)
            ->exists();
        $registerLeaveUnpaid = $this->model()->where('member_id', auth()->id())
            ->where('request_for_date', $requestForDate)
            ->where('request_type', 3)
            ->exists();

        $leaveQuota = LeaveQuota::where('member_id', auth()->id())->where('year', $year)->first();
        $remain = $leaveQuota->remain;
        $leaveTime ? $timeLeave = round((((strtotime($leaveTime)-strtotime('08:00'))/60)/480) +1,2) : $timeLeave = 1;


        if ($registerLeavePaid || $registerLeaveUnpaid) {
            return response()->json([
                'status' => false,
                'code' => 423,
                'error' => 'Request leave for date already exists'
            ], 423);
        } elseif ($leaveQuota->remain < $timeLeave && $requestType == 2) {
            return response()->json([
                'status' => false,
                'code' => 423,
                'error' => "Claiming the number of paid leave days beyond the remaining limit.\n
                Remaining days of leave is: ".$leaveQuota->remain,
            ], 423);
        } else {
            $data = [
                'member_id' => auth()->id(),
                'request_type' => $requestType,
                'request_for_date' => $requestForDate,
                'check_in' => date('Y-m-d H:i:s', strtotime($requestForDate.' '.$checkin)),
                'check_out' => date('Y-m-d H:i:s', strtotime($requestForDate.' '.$checkout)),
                'reason' =>$reason,
                'leave_all_day' => $leaveAllDay,
                'leave_start' => $leaveStart,
                'leave_end' => $leaveEnd,
                'leave_time' => $leaveTime,
            ];
            $this->create($data);

            if ($requestType == 2) {
                $leaveQuota->remain = $remain - $timeLeave;
                $leaveQuota->paid_leave = $leaveQuota->paid_leave + $timeLeave;
                $leaveQuota->save();
            } else {
                $leaveQuota->unpaid_leave = $leaveQuota->unpaid_leave + $timeLeave;
                $leaveQuota->save();
            }

            return response()->json([
                'status' => true,
                'code' => 200,
                'message' => 'Create request success!'
            ], 200);

        }
    }
}
