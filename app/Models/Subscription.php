<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    //

    protected $fillable = [
        'family_owner_id',
        'plan',
        'amount',
        'status',
        'start_date',
        'end_date',
        'payment_gateway',
        'transaction_id',
    ];

    public function familyOwner()
    {
        return $this->belongsTo(FamilyOwner::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
