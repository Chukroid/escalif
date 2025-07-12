<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalificacionesEscolarizado extends Model
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
        'parcial1',
        'parcial2',
        'parcial3',
        'final',
        'extra',
    ];
}
