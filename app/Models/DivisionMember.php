<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DivisionMember extends Model
{
    use HasFactory;

    protected $table = 'division_member';

    public $timestamps = false;

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

}
