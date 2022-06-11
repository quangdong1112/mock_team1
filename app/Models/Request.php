<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    public $fillable = [
        'member_id',
        'request_for_date',
        'request_type',
        'check_in',
        'check_out',
        'reason',
        'status',
        'request_ot_time',
        'leave_all_day',
        'leave_start',
        'leave_end',
        'leave_time',
    ];
}
