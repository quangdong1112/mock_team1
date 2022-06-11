<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    use HasFactory;

    protected $table = 'leave_requests';
    protected $fillable = [
        'member_id',
        'request_for_date',
        'type',
        'quota',
        'status',
        'created_by',
        'note',
    ];
}
