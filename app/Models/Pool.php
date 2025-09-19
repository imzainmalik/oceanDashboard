<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pool extends Model
{
    protected $fillable = [
        'owner_id', 'title', 'description', 'status',
        'voting_expires_at', 'final_decision_by', 'final_decision_notes',
    ];

       protected $casts = [
        'voting_expires_at' => 'datetime',  
    ];

    protected $dates = ['voting_expires_at', 'created_at', 'updated_at'];

    // Creator of pool (family owner or admin)
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    // Votes casted in this pool
    public function votings()
    {
        return $this->hasMany(PoolVoting::class, 'pool_id');
    }

    // Discussion comments
    public function comments()
    {
        return $this->hasMany(VotingComment::class, 'pool_id');
    }

    // Users who voted (many-to-many via PoolVoting)
    public function voters()
    {
        return $this->belongsToMany(User::class, 'pool_votings', 'pool_id', 'user_id')
            ->withPivot('choice', 'comment', 'created_at');
    }

    // User who made the final mediation decision
    public function finalDecisionBy()
    {
        return $this->belongsTo(User::class, 'final_decision_by');
    }

     public function votes()
    {
        return $this->hasMany(PoolVoting::class, 'pool_id');
    }

    // Helper to count votes
    public function counts()
    {
        return [
            'yes' => $this->votings()->where('choice', 'yes')->count(),
            'no' => $this->votings()->where('choice', 'no')->count(),
            'abstain' => $this->votings()->where('choice', 'abstain')->count(),
            'total' => $this->votings()->count(),
        ];
    }

    public function isOpen()
    {
        return $this->status === 'open' &&
               (! $this->voting_expires_at || $this->voting_expires_at->isFuture());
    }
}
