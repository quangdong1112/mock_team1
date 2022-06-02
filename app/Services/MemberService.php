<?php

namespace App\Services;

use App\Models\Member;
use App\Repositories\MemberRepository;
use App\Services\BaseService;

class MemberService extends BaseService
{
    public function getRepository()
    {
        return MemberRepository::class;
    }

    public function updateMember($id, $data)
    {
        $member = $this->repo->findOrFail($id);

        $member->fill($data->all());

        if ($data->hasFile('avatar')) {
            $newFileName = uniqid() . '-' . $data->avatar->getClientOriginalName();
            $imagePath = $data->avatar->storeAs(config('common.default_image_path') . 'members', $newFileName);
            $member->avatar = str_replace(config('common.default_image_path') . 'members', '', $imagePath);
        }

        if ($data->hasFile('avatar_official')) {
            $newFileName = uniqid() . '-' . $data->avatar_official->getClientOriginalName();
            $imagePath = $data->avatar_official->storeAs(config('common.default_image_path') . 'members', $newFileName);
            $member->avatar_official = str_replace(config('common.default_image_path') . 'members', '', $imagePath);
        }

        return $member->save();
    }
}
