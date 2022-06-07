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

    public function get($request)
    {
        $worksheet = $this->model()->where('member_id', auth()->id());
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
            $perPage = $perPage ?? config('common.default_page_size'),
            $columns = ['*'],
            $pageName = 'page',
            $page = null
        )->withQueryString();
    }

    public function getById($id)
    {
        $worksheet = $this->findOrFail($id);

        if ($worksheet->member_id == auth()->id()) {
            return $worksheet;
        } else {
            return response()->json([
                'status' => false,
                'code' => 403,
                'error' => 'Request worksheet invalid!'
            ],403);
        }
    }

    public function getByDate($workDate)
    {

        $worksheet = $this->model()->where('member_id', auth()->id())->where('work_date', $workDate);
        if ($worksheet->exists()) {
            return $worksheet->first();
        } else {
            return response()->json([
                'status' => false,
                'code' => 403,
                'error' => 'Request worksheet invalid!'
            ],403);
        }
    }
}
