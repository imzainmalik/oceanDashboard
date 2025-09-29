<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vacation extends Model
{
    //

    protected $fillable = ['title', 'description', 'start_date', 'end_date', 'type'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'vacation_users');
    }
}
