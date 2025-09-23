<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    protected $fillable = [
        'senior_id', 'created_by', 'topic', 'agenda',
        'start_time', 'duration', 'zoom_meeting_id',
        'join_url', 'start_url', 'status',
    ];

    public function senior()
    {
        return $this->belongsTo(Senior::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
