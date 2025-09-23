<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FamilyNote extends Model
{
    protected $fillable = [
        'family_member_id',
        'family_owner_id',
        'title',
        'content',
        'type',
        'visibility',
    ];

    public function familyOwner()
    {
        return $this->belongsTo(FamilyOwner::class);
    }
}
