<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillPayment extends Model
{
    //
    protected $fillable = ['bills_id','payer_id','amount_paid','payment_method','confirmation_number','receipt_path','status','type'];

    public function bill()
    {
        return $this->hasOne(Bills::class,'id','bills_id');
    }

    public function payer()
    {
        return $this->belongsTo(User::class, 'payer_id');
    }
}
