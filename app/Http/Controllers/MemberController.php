<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemberRequest;
use App\Http\Resources\MemberResource;
use App\Services\MemberService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class MemberController extends BaseController
{
    protected $service;

    public function __construct(MemberService $memberService)
    {
        parent::__construct();
        $this->service = $memberService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return MemberResource::collection($this->service->index());
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if ($id == auth()->user()->id) {

            return new MemberResource($this->service->findOrFail($id));
        } else {

            return response()->json([
                'status' => 'error',
                'code' => JsonResponse::HTTP_UNAUTHORIZED,
                'error' => 'Not ID',
            ], JsonResponse::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, MemberRequest $request)
    {
        if ($id == auth()->user()->id) {

            $this->service->updateMember($id, $request);

            return response()->json([
                'status' => 'success',
                'code' => JsonResponse::HTTP_CREATED,
                'message' => 'Update Success'
            ], JsonResponse::HTTP_CREATED);
        } else {

            return response()->json([
                'status' => 'error',
                'code' => JsonResponse::HTTP_UNAUTHORIZED,
                'error' => 'Not ID',
            ], JsonResponse::HTTP_UNAUTHORIZED);
        }
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
