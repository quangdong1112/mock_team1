<?php

namespace App\Http\Controllers;

use App\Services\MemberRoleService;
use Illuminate\Http\Request;

class MemberRoleController extends BaseController
{
    protected $memberRoleService;

    public function __construct(MemberRoleService $memberRoleService)
    {
        parent::__construct();
        $this->memberRoleService = $memberRoleService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        if (auth()->id()) {
            $memberId = auth()->id();
            return $this->memberRoleService->showRole($memberId);
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
     * @return \App\Http\Resources\MemberRoleResource|\Illuminate\Http\JsonResponse
     */
    public function show($id)
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
