<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bills extends Model
{

     const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_DECLINED = 'declined';
    
      protected $fillable = [
        'owner_id',
        'assigned_to',
        'title',
        'amount',
        'details',
        'type',
        'status',
        'payment_method',
        'receipt_path',
    ];

    protected $table = 'bills';
    //
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function payments()
    {
        return $this->hasMany(BillPayment::class);
    }
}
