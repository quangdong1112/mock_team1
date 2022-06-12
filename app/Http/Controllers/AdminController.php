<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApproveRequest;
use App\Services\RequestService;
use Illuminate\Http\Request;

class AdminController extends BaseController
{
    protected $requestService;
    public function __construct(RequestService $requestService)
    {
        parent::__construct();
        $this->requestService = $requestService;
    }

    public function index()
    {
        return $this->requestService->getRequestConfirm();
    }

    public function update(ApproveRequest $request, $id)
    {
        return $this->requestService->approve($request, $id);
    }
}
