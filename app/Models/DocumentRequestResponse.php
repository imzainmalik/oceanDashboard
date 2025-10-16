<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentRequestResponse extends Model
{
    //
    protected $fillable = ['request_id', 'uploader_id', 'original_name', 'disk_path', 'mime', 'size'];

    public function request()
    {
        return $this->belongsTo(DocumentRequest::class, 'request_id');
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploader_id');
    }
}
