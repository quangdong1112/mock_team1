<?php

namespace App\Repositories;

use App\Models\Worksheet;

class WorksheetRepository extends BaseRepository
{

    public function getModel()
    {
        return Worksheet::class;
    }
}
