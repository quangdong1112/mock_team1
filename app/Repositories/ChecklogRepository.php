<?php

namespace App\Repositories;

use App\Models\Checklog;

class ChecklogRepository extends BaseRepository
{

    public function getModel()
    {
        return Checklog::class;
    }
}
