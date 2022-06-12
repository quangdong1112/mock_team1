<?php

namespace App\Services;

use App\Models\LeaveQuota;
use App\Models\LeaveRequest;
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
        $requestLeave = LeaveRequest::where('member_id', auth()->id())
                                    ->where('request_for_date',$requestForDate)
                                    ->exists();

        $leaveQuota = LeaveQuota::where('member_id', auth()->id())->where('year', $year)->first();
        $leaveAllDay != null ? $timeLeave = 1 : $timeLeave = round((((strtotime($leaveTime)-strtotime('08:00'))/60)/480) +1,2);

        if ($registerLeavePaid || $registerLeaveUnpaid || $requestLeave) {
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
            $dataRequest = [
                'member_id' => auth()->id(),
                'request_type' => $requestType,
                'request_for_date' => $requestForDate,
                'check_in' => date('Y-m-d H:i:s', strtotime($requestForDate.' '.$checkin)),
                'check_out' => date('Y-m-d H:i:s', strtotime($requestForDate.' '.$checkout)),
                'reason' => $reason,
                'leave_all_day' => $leaveAllDay != null ? 1 : 0,
                'leave_start' => $leaveAllDay != null ? null : $leaveStart,
                'leave_end' => $leaveAllDay != null ? null : $leaveEnd,
                'leave_time' => $leaveAllDay != null ? null : $leaveTime,
            ];

            $dataLeave = [
                'member_id' => auth()->id(),
                'type' => $requestType,
                'request_for_date' => $requestForDate,
                'quota' => $timeLeave,
                'status' => 0,
                'created_by' => auth()->id(),
            ];

            $this->create($dataRequest);
            LeaveRequest::create($dataLeave);

            if ($requestType == 2) {
                $leaveQuota->remain = $leaveQuota->remain - $timeLeave;
                $leaveQuota->paid_leave =  $leaveQuota->paid_leave + $timeLeave;
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

    public function show($request)
    {
        $requestForDate = trim($request->request_for_date);
        $registerLeavePaid = $this->model()->where('member_id', auth()->id())
            ->where('request_for_date', $requestForDate)
            ->where('request_type', 2);
        $registerLeaveUnpaid = $this->model()->where('member_id', auth()->id())
            ->where('request_for_date', $requestForDate)
            ->where('request_type', 3);
        $requestLeave = LeaveRequest::where('member_id', auth()->id())
            ->where('request_for_date',$requestForDate);
        if ($registerLeavePaid->exists() || $registerLeaveUnpaid->exists() || $requestLeave->exists()) {
            return $registerLeavePaid->first() ?? $registerLeaveUnpaid->first();
        } else {
            return response()->json([
                'status' => false,
                'code' => 204,
                'error' => 'This request is not available yet'
            ], 204);
        }
    }

    public function edit($request, $id)
    {
        $registerLeave = $this->findOrFail($id);
        $leaveDate = $registerLeave->request_for_date;
        $year = date('Y', strtotime($leaveDate));
        $leaveRequest = LeaveRequest::where('member_id', auth()->id())->where('request_for_date', $leaveDate)->first();
        $leaveQuota = LeaveQuota::where('member_id', auth()->id())->where('year', $year)->first();
        $timeQuota = $leaveRequest->quota;

        if ($registerLeave->status == 0 && $registerLeave->member_id == auth()->id()) {
            $requestForDate = trim($request->request_for_date);
            $requestType = $request->request_type;
            $checkin = trim($request->check_in);
            $checkout = trim($request->check_out);
            $reason = trim($request->reason);
            $leaveAllDay= $request->leave_all_day;
            $leaveStart= $request->leave_start;
            $leaveEnd= $request->leave_end;
            $leaveTime= $request->leave_time;

            $leaveAllDay != null ? $timeLeave = 1 : $timeLeave = round((((strtotime($leaveTime)-strtotime('08:00'))/60)/480) +1,2);
            $dataRequest = [
                'member_id' => auth()->id(),
                'request_type' => $requestType,
                'request_for_date' => $requestForDate,
                'check_in' => date('Y-m-d H:i:s', strtotime($requestForDate.' '.$checkin)),
                'check_out' => date('Y-m-d H:i:s', strtotime($requestForDate.' '.$checkout)),
                'reason' =>$reason,
                'leave_all_day' => $leaveAllDay != null ? 1 : 0,
                'leave_start' => $leaveAllDay != null ? null : $leaveStart,
                'leave_end' => $leaveAllDay != null ? null : $leaveEnd,
                'leave_time' => $leaveAllDay != null ? null : $leaveTime,
            ];

            $dataLeave = [
                'member_id' => auth()->id(),
                'type' => $requestType,
                'request_for_date' => $requestForDate,
                'quota' => $timeLeave,
                'status' => 0,
                'created_by' => auth()->id(),
            ];
            if ($registerLeave->request_type == 2) {
                $leaveQuota->remain = $leaveQuota->remain + $timeQuota;
                $leaveQuota->paid_leave = $leaveQuota->paid_leave - $timeQuota;
                $leaveQuota->save();
            } else {
                $leaveQuota->unpaid_leave = $leaveQuota->unpaid_leave - $timeQuota;
                $leaveQuota->save();
            }
            $this->update($id, $dataRequest);
            $leaveRequest->fill($dataLeave);
            $leaveRequest->save();

            if ($requestType == 2) {
                $leaveQuota->remain = $leaveQuota->remain - $timeLeave;
                $leaveQuota->paid_leave = $leaveQuota->paid_leave + $timeLeave;
                $leaveQuota->save();
            } else {
                $leaveQuota->unpaid_leave = $leaveQuota->unpaid_leave + $timeLeave;
                $leaveQuota->save();
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
