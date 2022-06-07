<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;

    protected $table = 'divisions';

    public $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'pivot',
    ];

}
