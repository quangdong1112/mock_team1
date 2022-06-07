<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    public $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'pivot',
    ];

    public function members()
    {
        return $this->belongsToMany(Member::class, 'member_role');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permissions_role');
    }
}
