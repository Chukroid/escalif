<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\GrupoProfesor;
use App\Models\Curso;
use App\Models\CalificacionesEscolarizado;
use App\Models\CalificacionesEjecutivo;
use App\Models\User;
use App\Models\GrupoEstudiante;
use App\Models\CursoMateria;
use App\Models\Materia;

class CalificacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($request->input('modalidad_id') == 1){
            $validatedData = $request->validate([
                'user_id' => 'required|integer|exists:users,id',
                'curso_id' => 'required|integer|exists:cursos,id',
                'semestre' => 'required|integer|min:1|max:10',
                'materia_id' => 'required|integer|exists:materias,id',

                'parcial1' => 'nullable|numeric|min:0|max:10',
                'parcial2' => 'nullable|numeric|min:0|max:10',
                'parcial3' => 'nullable|numeric|min:0|max:10',
                'final' => 'nullable|numeric|min:0|max:10',
                'extra' => 'nullable|numeric|min:0|max:10',
            ]);

            $calificacion = CalificacionesEscolarizado::updateOrCreate(
            [
                'user_id' => $validatedData['user_id'],
                'curso_id' => $validatedData['curso_id'],
                'semestre' => $validatedData['semestre'],
                'materia_id' => $validatedData['materia_id'],
            ], // Search criteria
            [
                'parcial1' => $validatedData['parcial1'],
                'parcial2' => $validatedData['parcial2'],
                'parcial3' => $validatedData['parcial3'],
                'final' => $validatedData['final'],
                'extra' => $validatedData['extra'],
            ] // Attributes to set/update
        );
        }elseif($request->input('modalidad_id') == 2){
            $validatedData = $request->validate([
                'user_id' => 'required|integer|exists:users,id',
                'curso_id' => 'required|integer|exists:cursos,id',
                'semestre' => 'required|integer|min:1|max:10',
                'materia_id' => 'required|integer|exists:materias,id',

                'bloque1' => 'numeric|min:0|max:10',
                'bloque2' => 'numeric|min:0|max:10',
            ]);

            $calificacion = CalificacionesEjecutivo::updateOrCreate(
            [
                'user_id' => $validatedData['user_id'],
                'curso_id' => $validatedData['curso_id'],
                'semestre' => $validatedData['semestre'],
                'materia_id' => $validatedData['materia_id'],
            ], // Search criteria
            [
                'bloque1' => $validatedData['bloque1'],
                'bloque2' => $validatedData['bloque2'],
            ] // Attributes to set/update
            );
        }
        return redirect()->back()->with('success',"Las calificaciones ha sido subido correctamente!");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    // CUSTOM
    public function editar_calificaciones(int $modalidadid, int $cursoid, int $semestre, int $materiaid, int $estudianteUserId)
    {
        $user = Auth::user(); 
        $estudianteUser = User::find($estudianteUserId);

        $cursosidProfesor = GrupoProfesor::where('profesor_id',$user->id)->select(DB::raw('DISTINCT curso_id'))->pluck('curso_id');
        $cursos = Curso::whereIn('id', $cursosidProfesor)->get();

        $calificaciones = null;
        if($modalidadid === 1){
            $calificaciones = CalificacionesEscolarizado::where('user_id',$estudianteUserId)->where('curso_id',$cursoid)->where('semestre',$semestre)->where('materia_id',$materiaid)->first();
        }elseif($modalidadid === 2){
            $calificaciones = CalificacionesEjecutivo::where('user_id',$estudianteUserId)->where('curso_id',$cursoid)->where('semestre',$semestre)->where('materia_id',$materiaid)->first();
        }
        return view('calificacion.profesor_editar_calificacion', [
            'extras' => [
                'cursoid' => $cursoid,
                'semestre' => $semestre,
                'materiaid' => $materiaid,
                'modalidadid' => $modalidadid,
                'nombreEstudiante' => $estudianteUser->name,
            ],
            'cursos' => $cursos,
            'calificacion' => $calificaciones,
            'estudianteUser' => $estudianteUser
        ]);
    }
    public function ver_calificaciones(int $estudianteUserId, int $modalidadid, int $cursoid, int $semestre)
    {
        $user = Auth::user(); 
        $curso = Curso::find($cursoid);

        $cursos = GrupoEstudiante::listasEstudiante($user->id);
        $materiasid = CursoMateria::where('curso_id',$cursoid)->where('semestre',$semestre)->pluck('materia_id');
        $materias = Materia::whereIn('id', $materiasid)->get();

        $calificaciondata = null;
        if($modalidadid == 1){
            $calificaciondata = CalificacionesEscolarizado::where('user_id',$estudianteUserId)->where('curso_id',$cursoid)->where('semestre',$semestre)->get();
        }elseif($modalidadid == 2){
            $calificaciondata = CalificacionesEjecutivo::where('user_id',$estudianteUserId)->where('curso_id',$cursoid)->where('semestre',$semestre)->get();
        }
        
        $calificacion = [];

        // cargar las materias
        foreach($materias as $materia){
            $calificacion[$materia->name] = $calificaciondata->firstWhere('materia_id', $materia->id);
        }

        $datos = [
            'name' => $user->name,
            'curso' => $curso->name,
            'semestre' => $semestre
        ];

        return view('calificacion.estudiante_ver', compact('cursos','calificacion','modalidadid','datos','user'));
    }
}
