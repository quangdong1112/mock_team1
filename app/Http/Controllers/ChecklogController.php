<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChecklogRequest;
use App\Services\ChecklogService;
use Illuminate\Http\Request;

class ChecklogController extends BaseController
{
    protected $checklogService;

    public function __construct(ChecklogService $checklogService)
    {
        parent::__construct();
        $this->checklogService = $checklogService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(ChecklogRequest $request)
    {
        if (auth()->id()) {
            $memberId = auth()->id();
            return $this->checklogService->showTimeLog($request, $memberId);
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
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(ChecklogRequest $request,)
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
