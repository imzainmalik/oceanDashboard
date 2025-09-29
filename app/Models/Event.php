<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    //
    public function participants()
    {
        return $this->belongsToMany(User::class, 'senior_id', 'event_id', 'user_id')
            ->withTimestamps();
    }
}
