<?php

namespace App\Services;

use App\Models\Member;
use App\Models\Notification;
use App\Repositories\NotificationRepository;
use App\Services\BaseService;
use Illuminate\Http\Request;


class NotificationService extends BaseService
{
    public function getRepository()
    {
        return NotificationRepository::class;
    }

    public function listNotifications($request)
    {
        $perPage = $request->get('per_page') ?? config('common.default_page_size');

        $divisionId = Member::where('id', auth()->id())->with('divisions')->first();
        $divisionId = $divisionId->divisions->first()->id;

        $query = Notification::orWhereJsonContains('published_to', [$divisionId])->orWhereJsonContains('published_to', ["all"]);

        $orderBy = $request->get('sort');
        if ($orderBy) {
            $query->orderBy('published_date', $orderBy);
        }

        return $query->paginate($perPage);
    }
}
