<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    //
    public function users(){
        // Tenant ke saare users (all roles)
        return $this->hasOne(User::class, 'id', 'child_id');
    }
        public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }



}
