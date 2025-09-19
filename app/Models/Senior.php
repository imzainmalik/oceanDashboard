<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Senior extends Model
{
    //

    protected $table = "seniors";

    public function user()
{
    return $this->belongsTo(User::class);
}

}
