<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoiceJournal extends Model
{
    protected $fillable = ['senior_id','created_by','title','file_path'];

    public function senior() {
        return $this->belongsTo(Senior::class);
    }

    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }
}
