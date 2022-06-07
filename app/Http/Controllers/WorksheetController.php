<?php

namespace App\Http\Controllers;

use App\Http\Requests\WorksheetRequest;
use App\Services\WorksheetService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WorksheetController extends BaseController
{
    protected $worksheetService;

    public function __construct(WorksheetService $worksheetService)
    {
        parent::__construct();
        $this->worksheetService = $worksheetService;
    }

    public function index(WorksheetRequest $request)
    {
        return $this->worksheetService->get($request);
    }

    public function getById(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => 'error',
                    'code' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                    'error' => $validator->errors(),
                ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY
            );
        }
        return $this->worksheetService->getById($request->id);
    }

    public function getByDate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'work_date' => 'required|date_format:Y-m-d',
        ]);
        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => 'error',
                    'code' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                    'error' => $validator->errors(),
                ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY
            );
        }
        return $this->worksheetService->getByDate($request->work_date);
    }
}
