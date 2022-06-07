<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Member;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return parent::toArray($request);
        // return[
        //     'published_date' => $this->published_date,
        //     'subject' => $this->subject,
        //     'status' => $this->status,
        //     'attachment' => $this->attachment,
        //     'created_by' => $this->authorInfo->full_name,
        //      'published_to' => $this->published_to,
        // ];
    }
}
