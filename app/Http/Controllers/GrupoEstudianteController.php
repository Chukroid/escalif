<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Curso;
use App\Models\Modalidade;
use App\Models\Estudiante;
use App\Models\GrupoEstudiante;
use App\Models\GrupoProfesor;

class GrupoEstudianteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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
    public function create(Estudiante $estudiante)
    {
        $modalidades = Modalidade::all();
        $cursos = Curso::all();

        return view('grupoEstudiante.crear_grupoestudiante', compact('estudiante','modalidades','cursos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => [
                'required',
                'integer',
                'exists:users,id',
            ],
            'modalidad_id' => [
                'required',
                'integer',
                'exists:modalidades,id',
            ],
            'curso_id' => 'required|integer|exists:cursos,id',
            'semestre' => [
                'required',
                'integer',
                'min:1',
                'max:10',
                Rule::unique('grupo_estudiantes')->where(function ($query) use ($request) {
                    return $query->where('modalidad_id', $request->input('modalidad_id'))
                                ->where('curso_id', $request->input('curso_id'))
                                ->where('user_id', $request->input('user_id'))
                                ->where('semestre', $request->input('semestre'));
                })]
        ]);

        GrupoEstudiante::create($validatedData);

        $estudiante = Estudiante::where('user_id',$validatedData['user_id'])->first();
        return redirect()->route('estudiantes.show',$estudiante->id)->with('success', 'La asignacion fue creado correctamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show($cursoid, $semestre)
    {
        dd($semestre);
        $user = Auth::user();

        if ($user && $user->role){
            switch ($user->role->id) {
                case 2:
                    $cursosidProfesor = GrupoProfesor::where('profesor_id',$user->id)->select(DB::raw('DISTINCT curso_id'))->pluck('curso_id');
                    $cursos = Curso::whereIn('id', $cursosidProfesor)->get();

                    return view('grupoEstudiante.profesor_ver_estudiantes', compact('cursos'));
                default:
                    // Fallback for logged-in users with unhandled roles
                    Auth::logout();
                    session()->invalidate();
                    session()->regenerateToken();
                    return redirect()->route('login')->with('status', 'Tu role no fue reconocido');
            }
        }

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
    public function destroy(GrupoEstudiante $grupoestudiante)
    {
        $userid = $grupoestudiante->user_id;
        $estudiante = Estudiante::where('user_id',$userid)->first();

        $grupoestudiante->delete();
        return redirect()->route('estudiantes.show', $estudiante->id)->with('success', 'La asignacion fue creado correctamente!');
    }


    // CUSTOM
    public function borrar_modalidad(int $estudianteid,int $modalidadid)
    {
        $estudiante = Estudiante::find($estudianteid);

        GrupoEstudiante::where('modalidad_id',$modalidadid)->delete();
        return redirect()->route('estudiantes.show', $estudiante->id)->with('success','La modalidad ha sido eliminado correctamente');
    }
    public function ver_estudiantes($cursoid, $semestre, $materiaid)
    {
        $user = Auth::user();

        if ($user && $user->role){
            switch ($user->role->id) {
                case 2:
                    $cursosidProfesor = GrupoProfesor::where('profesor_id',$user->id)->select(DB::raw('DISTINCT curso_id'))->pluck('curso_id');
                    $cursos = Curso::whereIn('id', $cursosidProfesor)->get();

                    $estudiantes = GrupoEstudiante::where('curso_id',$cursoid)->where('semestre',$semestre)->get();

                    return view('grupoEstudiante.profesor_ver_estudiantes', compact('cursoid','cursos','estudiantes','semestre','materiaid'));
                default:
                    // Fallback for logged-in users with unhandled roles
                    Auth::logout();
                    session()->invalidate();
                    session()->regenerateToken();
                    return redirect()->route('login')->with('status', 'Tu role no fue reconocido');
            }
        }

    }
}
