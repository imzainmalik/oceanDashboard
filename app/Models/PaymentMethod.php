<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
     protected $fillable = [
        'family_owner_id',
        'card_last_four',
        'card_brand',
        'expiry_month',
        'expiry_year',
        'is_primary',
        'gateway_token',
    ];

    public function familyOwner()
    {
        return $this->belongsTo(FamilyOwner::class);
    }
}
