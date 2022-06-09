<?php

namespace App\Services;

use App\Models\MemberRequestQuota;
use App\Models\Worksheet;
use App\Repositories\RequestRepository;
use Illuminate\Support\Facades\Auth;

class RegisterOTService extends BaseService
{

    public function getRepository()
    {
        return RequestRepository::class;
    }

    public function store($request)
    {
        $requestForDate = $request->request_for_date;
        $requestType = $request->request_type;
        $reason = $request->reason;
        $checkIn = $request->check_in;
        $checkOut = $request->check_out;
        $TimeOT = $request->request_ot_time;

        $workSheet = Worksheet::where('member_id', Auth::id())->where('work_date', $requestForDate)->first();
        $inOffice = $workSheet->in_office;
        if (strtotime($inOffice) > strtotime('10:00')) {
            $actualOT = gmdate("H:i", (strtotime($inOffice) - strtotime('10:00')));
        } else {
            return response()->json([
                'status' => false,
                'code' => 400,
                'error' => 'Working time less than 10 hours'
            ], 400);
        }

        $registerOT = $this->model()->where('member_id', auth()->id())
            ->where('request_for_date', $requestForDate)
            ->where('request_type', $requestType)
            ->exists();

        if ($registerOT) {
            return response()->json([
                'status' => false,
                'code' => 400,
                'error' => 'Request already exists'
            ], 400);
        } elseif ($request->request_ot_time > $actualOT) {
            return response()->json([
                'status' => false,
                'code' => 400,
                'error' => 'OT requirements cannot be greater than actual overtime'
            ], 400);
        } else {
            $data = [
                'member_id' => auth()->id(),
                'request_type' => $requestType,
                'request_for_date' => $requestForDate,
                'check_in' => date('Y-m-d H:i:s', strtotime($requestForDate . ' ' . $checkIn)),
                'check_out' => date('Y-m-d H:i:s', strtotime($requestForDate . ' ' . $checkOut)),
                'request_ot_time' => $TimeOT,
                'reason' => $reason,
            ];
            $this->create($data);

            return response()->json([
                'status' => true,
                'code' => 200,
                'message' => 'Create request success!'
            ], 200);
        }
    }

    public function show($id)
    {
        $request = $this->findOrFail($id);
        if ($request->member_id == auth()->id()) {
            return $request;
        } else {
            return response()->json([
                'status' => false,
                'code' => 403,
                'error' => 'The request invalid'
            ], 403);
        }
    }

    public function edit($request, $id)
    {
        $requestOT = $this->findOrFail($id);
        if ($requestOT->status == 0 && $requestOT->member_id == auth()->id()) {
            $requestForDate = $request->request_for_date;
            $requestType = $request->request_type;
            $reason = $request->reason;
            $checkIn = $request->check_in;
            $checkOut = $request->check_out;
            $TimeOT = $request->request_ot_time;

            $workSheet = Worksheet::where('member_id', Auth::id())->where('work_date', $requestForDate)->first();
            $inOffice = $workSheet->in_office;
            if (strtotime($inOffice) > strtotime('10:00')) {
                $actualOT = gmdate("H:i", (strtotime($inOffice) - strtotime('10:00')));
            } else {
                return response()->json([
                    'status' => false,
                    'code' => 400,
                    'error' => 'Working time less than 10 hours'
                ], 400);
            }

            if ($request->request_ot_time > $actualOT) {
                return response()->json([
                    'status' => false,
                    'code' => 400,
                    'error' => 'OT requirements cannot be greater than actual overtime'
                ], 400);
            } else {
                $data = [
                    'member_id' => auth()->id(),
                    'request_type' => $requestType,
                    'request_for_date' => $requestForDate,
                    'check_in' => date('Y-m-d H:i:s', strtotime($requestForDate . ' ' . $checkIn)),
                    'check_out' => date('Y-m-d H:i:s', strtotime($requestForDate . ' ' . $checkOut)),
                    'request_ot_time' => $TimeOT,
                    'reason' => $reason,
                ];
                $this->update($id, $data);
                return response()->json([
                    'status' => true,
                    'code' => 201,
                    'message' => 'Update request success!'
                ], 201);
            }
        } else {
            return response()->json([
                'status' => false,
                'code' => 403,
                'error' => 'You do not have permission to edit this request'
            ], 403);
        }
    }
}
