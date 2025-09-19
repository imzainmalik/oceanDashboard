<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VotingComment extends Model
{
    protected $fillable = ['pool_id', 'user_id', 'parent_id', 'message'];

    public function pool()
    {
        return $this->belongsTo(Pool::class, 'pool_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function replies()
    {
        return $this->hasMany(VotingComment::class, 'parent_id')->with('user', 'replies');
    }
}
