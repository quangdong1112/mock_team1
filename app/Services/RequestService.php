<?php

namespace App\Services;

use App\Repositories\RequestRepository;

class RequestService extends BaseService
{

    public function getRepository()
    {
        return RequestRepository::class;
    }

    public function showRequest($memberId) {
        $model = $this->model();
        $request = $model->where('member_id', $memberId);
//        $work_date =
    }
}
