<?php

namespace App\Http\Controllers;

use App\Http\Requests\WorksheetRequest;
use App\Services\WorksheetService;
use Illuminate\Http\Request;

class WorksheetController extends BaseController
{
    protected $worksheetService;

    public function __construct(WorksheetService $worksheetService)
    {
        parent::__construct();
        $this->worksheetService  = $worksheetService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(WorksheetRequest $request)
    {
        if (auth()->id()) {
            $memberId = auth()->id();
            return $this->worksheetService->showWorksheet($request, $memberId);
        } else {
            return response()->json(
                [
                    'status' => 'error',
                    'error' => 'Unauthorized',
                    'code' => 401,
                ],401);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param WorksheetRequest $request
     * @param $memberId
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(WorksheetRequest $request, $memberId)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
