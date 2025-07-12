<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GrupoProfesor extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'curso_id',
        'materia_id',
        'profesor_id',
        'semestre',
    ];

    public function curso(): BelongsTo
    {
        return $this->belongsTo(Curso::class);
    }
    public function profesor(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function materia(): BelongsTo
    {
        return $this->belongsTo(Materia::class);
    }
    
    
    public static function semestreMaterias(int $profesor_id, int $cursoid)
    {
        $data = [];
        $allData = self::where('profesor_id',$profesor_id)->where('curso_id',$cursoid)->get();

        foreach($allData as $registro){
            $semestre = $registro->semestre;
            $materia = $registro->materia->name;

            // checar si el semestre ha sido agregado
            if (!array_key_exists($semestre,$data)){
                $data[$semestre] = [];
            }

            $data[$semestre][] = [
                'materiaName' => $materia,
                'materiaId' => $registro->materia->id,
                'estudiantesCantidad' => GrupoEstudiante::where('curso_id',$cursoid)->where('semestre',$semestre)->count()
            ];

        }

        ksort($data);
        return $data;
    }
    public static function lists(): array
    {
        $data = [];
        $allData = self::all();

        foreach($allData as $index => $registro){
            if (!$registro->profesor || !$registro->curso || !$registro->materia) {
                continue;
            }
            // obtener todos los datos del registro
            $profesorName = $registro->profesor->name;
            $cursoName = $registro->curso->name;
            $semestre = $registro->semestre;
            $materia = $registro->materia->name;

            // checar si el profesor ya esta en la lista
            if (!array_key_exists($profesorName,$data)){
                $data[$profesorName] = [
                    'profesor_id' => $registro->profesor->id,
                    'cursos' => []
                ];
            }
            // checar si el curso ha sido agregado
            if (!array_key_exists($cursoName,$data[$profesorName]['cursos'])){
                $data[$profesorName]['cursos'][$cursoName] = [
                    'curso_id' => $registro->curso->id,
                    'semestres' => []
                ];
            }
            // checar si el semestre ha sido agregado
            if (!array_key_exists($semestre,$data[$profesorName]['cursos'][$cursoName]['semestres'])){
                $data[$profesorName]['cursos'][$cursoName]['semestres'][$semestre] = [];
            }

            $data[$profesorName]['cursos'][$cursoName]['semestres'][$semestre][] = [$registro->id,$materia];

        }

        foreach ($data as $profesorName => $profesordatos) {
            foreach ($profesordatos['cursos'] as $cursoName => $cursodatos) {
                // ksort() ordena el array por sus claves (en este caso, los números de semestre)
                // de forma ascendente por defecto.
                ksort($data[$profesorName]['cursos'][$cursoName]['semestres']);
            }
        }

        return $data;
    }

}
