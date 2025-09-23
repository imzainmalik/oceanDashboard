<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillPayment extends Model
{
    //
    protected $fillable = ['bills_id','payer_id','amount_paid','payment_method','confirmation_number','receipt_path','status'];

    public function bill()
    {
        return $this->belongsTo(Bills::class);
    }

    public function payer()
    {
        return $this->belongsTo(User::class, 'payer_id');
    }
}
