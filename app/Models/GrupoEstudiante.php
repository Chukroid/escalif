<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class GrupoEstudiante extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'modalidad_id',
        'curso_id',
        'user_id',
        'semestre',
    ];

    public function modalidad(): BelongsTo
    {
        return $this->belongsTo(Modalidade::class);
    }
    public function curso(): BelongsTo
    {
        return $this->belongsTo(Curso::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function estudiante(): HasOneThrough
    {
        return $this->hasOneThrough(
        Estudiante::class, // 1. Final model: App\Models\Estudiante
        User::class,       // 2. Intermediate model: App\Models\User

        // 3. Foreign key on the *intermediate* model's table (users) that links to the *current* model.
        //    This should be the primary key of the `users` table that `grupo_estudiantes.user_id` refers to.
        //    It's the `id` column on the `users` table.
        'id',              // This is `users.id`

        // 4. Foreign key on the *final* model's table (estudiantes) that links to the *intermediate* model.
        //    This is the column on the `estudiantes` table that holds the user_id.
        'user_id',         // This is `estudiantes.user_id`

        // 5. Local key on the *current* model's table (grupo_estudiantes) that links to the *intermediate* model.
        //    This is the column on `grupo_estudiantes` that holds the user_id.
        'user_id',         // This is `grupo_estudiantes.user_id`

        // 6. Local key on the *intermediate* model's table (users) that links to the *final* model.
        //    This is the primary key of the `users` table that `estudiantes.user_id` refers to.
        //    It's the `id` column on the `users` table.
        'id'               // This is `users.id`
    );
    }

    public static function listasEstudiante(int $user_id)
    {
        $data = [];
        $allData = self::where('user_id',$user_id)->get();

        foreach($allData as $registro){
            if (!$registro->curso || !$registro->semestre || !$registro->modalidad) {
                continue;
            }
            // obtener todos los datos del registro
            $cursoName = $registro->curso->name;
            $semestre = $registro->semestre;
            $modalidad = $registro->modalidad->id;

            // checar si la modalidad ha sido agregado
            if (!array_key_exists($modalidad,$data)){
                $data[$modalidad] = [];
            }

            // checar si el curso ha sido agregado
            if (!array_key_exists($cursoName,$data[$modalidad])){
                $data[$modalidad][$cursoName] = [
                    'cursoObj' => $registro->curso,
                    'semestres' => []
                ];
            }

            $data[$modalidad][$cursoName]['semestres'][$semestre] = $semestre;
        }

        foreach ($data as $modalidadid => $cursos) {
            foreach($cursos as $cursoName => $value){
                ksort($data[$modalidadid][$cursoName]['semestres']);
            }
        }
        return $data;
    }
}
