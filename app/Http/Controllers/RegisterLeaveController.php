<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterLeaveRequest;
use App\Services\RegisterLeaveService;
use Illuminate\Http\Request;

class RegisterLeaveController extends BaseController
{
    protected $registerLeaveService;

    public function __construct(RegisterLeaveService $registerLeaveService)
    {
        parent::__construct();
        $this->registerLeaveService = $registerLeaveService;
    }

    public function store(RegisterLeaveRequest $request)
    {
        return $this->registerLeaveService->store($request);
    }

    public function show(RegisterLeaveRequest $request)
    {
        return $this->registerLeaveService->show($request);
    }

    public function update(RegisterLeaveRequest $request, $id)
    {
        return $this->registerLeaveService->edit($request, $id);
    }
}
