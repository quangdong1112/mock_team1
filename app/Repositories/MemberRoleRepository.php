<?php

namespace App\Repositories;

use App\Models\MemberRole;

class MemberRoleRepository extends BaseRepository
{

    public function getModel()
    {
        return MemberRole::class;
    }
}
