<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Member extends Authenticatable implements JWTSubject
{
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'member_code',
        'email',
        'password',
        'full_name',
        'created_by',
        'avatar',
        'nick_name',
        'other_email',
        'phone',
        'skype',
        'facebook',
        'gender',
        'marital_status',
        'bank_name',
        'birth_date',
        'permanent_address',
        'temporary_address',
        'identity_number',
        'identity_card_date',
        'identity_card_place',
        'passport_number',
        'passport_expiration',
        'nationality',
        'emergency_contact_name',
        'emergency_contact_relationship',
        'emergency_contact_number',
        'academic_level',
        'graduate_year',
        'bank_account',
        'tax_identification',
        'tax_date',
        'tax_place',
        'insurance_number',
        'healthcare_provider',
        'start_date_official',
        'start_date_probation',
        'end_date',
        'status',
        'note',
        'created_by'

    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function role()
    {
        return $this->hasOne(MemberRole::class, 'member_id');
    }

}
