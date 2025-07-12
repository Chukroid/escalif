<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

use App\Models\Materia;

class Curso extends Model
{
    protected $fillable = [
        'name',
        'description',
        'semestres',
    ];

    public function materias(): BelongsToMany
    {
        return $this->belongsToMany(Materia::class, 'curso_materia');
        // 'Subject::class' is the related model
        // 'course_subject' is the name of the pivot table (Laravel's convention)
    }
}
