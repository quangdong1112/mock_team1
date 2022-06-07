<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DivisionMember extends Model
{
    use HasFactory;

    protected $table = 'division_member';

    public $timestamps = false;

    public function Division()
    {
        return $this->hasMany(Division::class);
    }

}
