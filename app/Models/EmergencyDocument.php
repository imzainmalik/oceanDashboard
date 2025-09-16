<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmergencyDocument extends Model
{

    protected $fillable = ['uploader_id','original_name','disk_path','mime','size','is_private'];

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploader_id');
    }

}
