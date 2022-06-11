<?php

namespace App\Services;

use App\Models\MemberRequestQuota;
use App\Repositories\RequestRepository;

class RegisterForgetService extends BaseService
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
        $errorCount = $request->error_count;
        $month = date('Y-m', strtotime($requestForDate));

        $registerForget = $this->model()->where('member_id', auth()->id())
                         ->where('request_type', $requestType)
                         ->where('request_for_date', $requestForDate)
                         ->exists();

        $requestQuota = MemberRequestQuota::where('member_id', auth()->id())->where('month', $month)->first();
        $remain = $requestQuota->remain;

        if ($registerForget) {
            return response()->json([
                'status' => false,
                'code' => 423,
                'error' => 'Request already exists'
            ], 423);
        } elseif ($requestQuota->remain == 0) {
            return response()->json([
                'status' => false,
                'code' => 423,
                'error' => 'You have run out of requests for this month'
            ], 423);
        } else {
            $data = [
                'member_id' => auth()->id(),
                'request_type' => $requestType,
                'request_for_date' => $requestForDate,
                'check_in' => date('Y-m-d H:i:s', strtotime($requestForDate.' '.$checkin)),
                'check_out' => date('Y-m-d H:i:s', strtotime($requestForDate.' '.$checkout)),
                'reason' =>$reason,
                'error_count' => $errorCount,
            ];
            $this->create($data);
            $requestQuota->remain = $remain - 1;
            $requestQuota->save();

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
        $registerForget = $this->model()->where('member_id', auth()->id())
            ->where('request_type', 1)
            ->where('request_for_date', $requestForDate);
        if ($registerForget->exists()) {
            return $registerForget->first();
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
        $requestForget = $this->findOrFail($id);
        if ($requestForget->status == 0 && $requestForget->member_id == auth()->id()) {
            $requestForDate = trim($request->request_for_date);
            $requestType = $request->request_type;
            $checkin = trim($request->check_in);
            $checkout = trim($request->check_out);
            $reason = trim($request->reason);
            $errorCount = $request->error_count;

            $data = [
                'member_id' => auth()->id(),
                'request_type' => $requestType,
                'request_for_date' => $requestForDate,
                'check_in' => date('Y-m-d H:i:s', strtotime($requestForDate.' '.$checkin)),
                'check_out' => date('Y-m-d H:i:s', strtotime($requestForDate.' '.$checkout)),
                'reason' =>$reason,
                'error_count' => $errorCount,
            ];
            $this->update($id, $data);
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
