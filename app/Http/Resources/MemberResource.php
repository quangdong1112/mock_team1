<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
 
class MemberResource extends JsonResource
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
    //    return [
    //         'member_code' => $this->member_code,
    //         'name' => $this->full_name,
    //         'email' => $this->email,
    //         'other_email' => $this->other_email,
    //         'phone_number' => $this->phone,
    //         'gender' => $this->gender,
    //         'skype' => $this->skype,
    //         'birth_date' => $this->birth_date,
    //         'identity_number' => $this->identity_number,
    //         'identity_card_date' => $this->identity_card_date,
    //         'facebook' => $this->facebook,
    //         'marital_status' => $this->marital_status,
    //         'avatar' => $this->avatar,
    //         'avatar_official' => $this->avatar_official,
    //         'permanent_address' => $this->permanent_address,
    //         'temporary_address' => $this->temporary_address,
    //         'identity_card_place' => $this->identity_card_place,
    //         'passport_number' => $this->passport_number,
    //         'emergency_contact_name' => $this->emergency_contact_name,
    //         'nationality' => $this->nationality,
    //         'emergency_contact_relationship' => $this->emergency_contact_relationship,
    //         'emergency_contact_number' => $this->emergency_contact_number,
    //         'academic_level' => $this->academic_level,
    //     ];
    }
}
