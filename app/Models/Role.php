<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Role extends Model
{
    //

    protected $table = 'roles';   // confirm roles table
    protected $primaryKey = 'id'; // confirm PK

    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }
}
