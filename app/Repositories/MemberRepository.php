<?php

namespace App\Repositories;

use App\Models\Member;

class MemberRepository extends BaseRepository
{
    public function getModel()
    {
        return Member::class;
    }
}
