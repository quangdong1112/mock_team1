<?php

namespace App\Http\Resources;

use App\Models\MemberRole;
use Illuminate\Http\Resources\Json\JsonResource;

class MemberLoginResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $role = new MemberRoleResource(MemberRole::where('member_id', auth()->id())->first());
        return [
            'id' => $this->id,
            'member_code'=> $this->member_code,
            'full_name' => $this->full_name,
            'email' => $this->email,
            'avatar' => $this->avatar,
            'avatar_official' => $this->avatar_official,
            'role' => $role->role->title ?? '',
        ];
    }
}
