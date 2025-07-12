<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CursoMateria extends Model
{

    protected $table = 'curso_materia';

    protected $fillable = [
        'curso_id',
        'materia_id',
        'semestre',
    ];
}
