<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //

    protected $fillable = [
        'owner_id',
        'assignee_id',
        'title',
        'type',
        'description',
        'status',
    ];

    protected $table = 'tasks';

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'family_owner_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(TaskComment::class);
    }
}
