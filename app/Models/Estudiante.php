<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Estudiante extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'matricula',
        'user_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function obtenerGruposEstudiante(): array
    {
        $datos = [];
        $grupos = GrupoEstudiante::where('user_id',$this->user->id)->get();

        foreach($grupos as $grupo){
            $modalidadname = $grupo->modalidad->name;
            $cursoname = $grupo->curso->name;
            $semestre = $grupo->semestre;

            if (!array_key_exists($modalidadname,$datos)){
                $datos[$modalidadname] = [
                    'id' => $grupo->modalidad->id,
                    'grupos' => []
                ];
            }

            $datos[$modalidadname]['grupos'][] = [
                'cursoname' => $cursoname,
                'cursoid' => $grupo->curso->id,
                'semestre' => $semestre,
                'grupoestudianteid' => $grupo->id
            ];
        }

        return $datos;
    }
}
