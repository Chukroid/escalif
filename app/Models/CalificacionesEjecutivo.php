<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalificacionesEjecutivo extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'curso_id',
        'semestre',
        'materia_id',
        'bloque1',
        'bloque2',
    ];
}
