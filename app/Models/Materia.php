<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

use App\Models\Curso;

class Materia extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    public function cursos(): BelongsToMany
    {
        return $this->belongsToMany(Curso::class, 'curso_materia');
        // 'Subject::class' is the related model
        // 'course_subject' is the name of the pivot table (Laravel's convention)
    }
}
