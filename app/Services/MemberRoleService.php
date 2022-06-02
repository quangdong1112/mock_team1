<?php

namespace App\Services;

use App\Http\Resources\MemberLoginResource;
use App\Http\Resources\MemberRoleResource;
use App\Repositories\MemberRoleRepository;

class MemberRoleService extends BaseService
{

    public function getRepository()
    {
        return MemberRoleRepository::class;
    }

    public function showRole($id): MemberRoleResource
    {
        $model = $this->model();
        $memberRole = $model->where('member_id', $id)->first();
        return new MemberRoleResource($memberRole);
    }
}
