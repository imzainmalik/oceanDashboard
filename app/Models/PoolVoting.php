<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PoolVoting extends Model
{
    protected $fillable = ['pool_id', 'user_id', 'choice', 'comment'];

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
        return $this->hasMany(VotingComment::class, 'parent_id');
    }
}
