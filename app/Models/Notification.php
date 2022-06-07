<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Casts\Json;

class Notification extends Model
{
    use HasFactory;
    protected $table = 'notifications';
    protected $fillable = [
        'published_date',
        'subject',
        'message',
        'status',
        'attachment',
        'created_by',
        'published_to'
    ];

    protected $attributes = [
        'published_to' => 'all'
    ];

    public function authorInfo()
    {
        return $this->belongsTo(Member::class, 'created_by');
    }

    public function getPublishedToAttribute()
    {
        if ($this->attributes['published_to'] !== '["all"]') {
            $publishedTo = json_decode($this->attributes['published_to']);

            return Division::select('division_name')->whereIn('id', $publishedTo)->get();
        }

        return $this->attributes['published_to'];
    }


}
