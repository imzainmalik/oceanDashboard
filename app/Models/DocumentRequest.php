<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentRequest extends Model
{
    //

    protected $fillable = [
        'requester_id', 'target_user_id', 'title', 'message', 'expires_at', 'status', 'document_id',
    ];

    protected $dates = ['expires_at'];

    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function target()
    {
        return $this->belongsTo(User::class, 'target_user_id');
    }

    public function document()
    {
        return $this->belongsTo(EmergencyDocument::class, 'document_id');
    }

    public function isExpired()
    {
        return $this->expires_at->isPast();
    }
}
