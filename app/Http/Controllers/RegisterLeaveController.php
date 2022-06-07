<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterForgetRequest;
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
}
