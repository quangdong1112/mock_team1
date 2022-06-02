<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checklog extends Model
{
    use HasFactory;

    protected $table = 'check_logs';
    public $timestamps = false;
}
