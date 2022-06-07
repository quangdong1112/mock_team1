<?php

namespace App\Repositories;

use App\Models\Request;

class RequestRepository extends BaseRepository
{

    public function getModel()
    {
        return Request::class;
    }
}
