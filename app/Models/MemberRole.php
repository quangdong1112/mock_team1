<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberRole extends Model
{
    use HasFactory;

    protected $table = 'member_role';

    public $timestamps = false;

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

}
