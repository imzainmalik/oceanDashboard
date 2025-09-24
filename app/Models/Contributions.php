<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contributions extends Model
{
    //

    protected $fillable = [
        'family_member_id',
        'bill_id',
        'amount',
        'type',
        'note',
    ];

    public function familyMember()
    {
        return $this->belongsTo(User::class, 'family_member_id');
    }

    public function bill()
    {
        return $this->belongsTo(Bills::class);
    }
}
