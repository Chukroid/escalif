<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; // para crear relaciones

class Role extends Model
{
    protected $fillable = [
        'name'
    ];
}
