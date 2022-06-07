<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterForgetRequest;
use App\Services\RegisterForgetService;
use http\Env\Response;
use Illuminate\Http\Request;

class RegisterForgetController extends BaseController
{
    protected $registerForgetService;

    public function __construct(RegisterForgetService $registerForgetService)
    {
        parent::__construct();
        $this->registerForgetService = $registerForgetService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(RegisterForgetRequest $request)
    {
        return $this->registerForgetService->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(RegisterForgetRequest $request)
    {
        return $this->registerForgetService->show($request);
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
     * @param RegisterForgetRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(RegisterForgetRequest $request, $id)
    {
        return $this->registerForgetService->edit($request,$id);
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
