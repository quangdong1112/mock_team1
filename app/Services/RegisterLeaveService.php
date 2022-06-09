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
                $leaveQuota->paid_leave = $timeLeave;
                $leaveQuota->save();
            } else {
                $leaveQuota->unpaid_leave = $timeLeave;
                $leaveQuota->save();
            }

            return response()->json([
                'status' => true,
                'code' => 200,
                'message' => 'Create request success!'
            ], 200);

        }
    }

    public function show($request)
    {
        $requestForDate = trim($request->request_for_date);
        $registerLeavePaid = $this->model()->where('member_id', auth()->id())
            ->where('request_for_date', $requestForDate)
            ->where('request_type', 2);
        $registerLeaveUnpaid = $this->model()->where('member_id', auth()->id())
            ->where('request_for_date', $requestForDate)
            ->where('request_type', 3);
        if ($registerLeavePaid->exists() || $registerLeaveUnpaid->exists()) {
            return $registerLeavePaid->first() ?? $registerLeaveUnpaid->first();
        } else {
            return response()->json([
                'status' => false,
                'code' => 404,
                'error' => 'This request is not available yet'
            ], 404);
        }
    }

    public function edit($request, $id)
    {
        $requestLeave = $this->findOrFail($id);
        if ($requestLeave->request_type == 2) {
            $timeLeave = $requestLeave->paid_leave;
            $requestLeave->remain = $requestLeave->remain + $timeLeave;
            $requestLeave->paid_leave = 0;
            $requestLeave->save();
        } else {
            $requestLeave->unpaid_leave = 0;
            $requestLeave->save();
        }
        if ($requestLeave->status == 0 && $requestLeave->member_id == auth()->id()) {
            $requestForDate = trim($request->request_for_date);
            $requestType = $request->request_type;
            $checkin = trim($request->check_in);
            $checkout = trim($request->check_out);
            $reason = trim($request->reason);
            $leaveAllDay= $request->leave_all_day;
            $leaveStart= $request->leave_start;
            $leaveEnd= $request->leave_end;
            $leaveTime= $request->leave_time;
            $leaveTime ? $timeLeave = round((((strtotime($leaveTime)-strtotime('08:00'))/60)/480) +1,2) : $timeLeave = 1;
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
            $this->update($id, $data);

            if ($requestType == 2) {
                $requestLeave->remain = $requestLeave->remain - $timeLeave;
                $requestLeave->paid_leave = $timeLeave;
                $requestLeave->save();
            } else {
                $requestLeave->unpaid_leave = $timeLeave;
                $requestLeave->save();
            }
            return response()->json([
                'status' => true,
                'code' => 201,
                'message' => 'Update request success!'
            ], 201);
        } else {
            return response()->json([
                'status' => false,
                'code' => 403,
                'error' => 'The request is pending. You cannot edit this request'
            ], 403);
        }
    }
}
