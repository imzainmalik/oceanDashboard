<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmergencyDocument extends Model
{

    protected $fillable = [
        'uploader_id','original_name','disk_path','mime','size','is_private','category','senior_id'
    ];

    protected $casts = [
        'is_private' => 'boolean',
    ];

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploader_id');
    }

    public function senior()
    {
        return $this->belongsTo(Senior::class, 'senior_id');
    }

}
