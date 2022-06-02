<?php

namespace App\Services;

use App\Repositories\WorksheetRepository;
use Illuminate\Http\Request;

class WorksheetService extends BaseService
{

    public function getRepository()
    {
        return WorksheetRepository::class;
    }

    public function showWorksheet($request, $memberId)
    {
        $model = $this->model();
        $worksheet = $model->where('member_id', $memberId);
        $orderBy = 'ASC';

        $sort = trim($request->sort);
        if (strcasecmp($sort, 'asc') == 0 || strcasecmp($sort, 'desc') == 0) {
            $orderBy = $sort;
        }

        $start_date = trim($request->start_date);
        $end_date = trim($request->end_date);
        if ($start_date) {
            $start_date = date('Y-m-d', strtotime($start_date));
            $worksheet = $worksheet->where('work_date', '>=', $start_date);
        }
        if ($end_date) {
            $end_date = date('Y-m-d', strtotime($end_date));
            $worksheet = $worksheet->where('work_date', '<=', $end_date);
        }

        $perPage = $request->per_page;
        return $worksheet->orderBy('work_date', $orderBy)->paginate(
            $perPage = $perPage ?? 30,
            $columns = ['*'],
            $pageName = 'page',
            $page = null
        )->withQueryString();
    }
}
