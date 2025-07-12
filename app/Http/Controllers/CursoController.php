<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

use App\Models\Curso;
use App\Models\CursoMateria;
use App\Models\GrupoProfesor;
use App\Models\Materia;
use App\Models\GrupoEstudiante;
use App\Models\Modalidade;

class CursoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    

    /**
     * Display a listing of the resource.
     */
    public function index(): View | RedirectResponse
    {
        $user = Auth::user(); // Get the authenticated user

        if ($user && $user->role) {
             $cursos = Curso::all();

            switch ($user->role->id) {
                case 1:
                    // Admin view for courses
                    return view('curso.admin_index', compact('cursos'));
                case 2:
                    // Teacher view for courses
                    return view('curso.admin_index', compact('cursos'));
                case 3:
                    // Student view for courses
                    return view('curso.admin_index', compact('cursos'));
                default:
                    // Fallback for logged-in users with unhandled roles
                    Auth::logout();
                    session()->invalidate();
                    session()->regenerateToken();
                    return redirect()->route('login')->with('status', 'Tu role no fue reconocido');
            }
        }

        // This part should ideally not be hit if middleware('auth') is correctly applied to the route.
        // It's a fail-safe, but unauthenticated users should be redirected by middleware first.
        return redirect()->route('login');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('curso.crear_curso');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:cursos,name', // 'unique:cursos,name' ensures the name is unique in the cursos table
            'description' => 'nullable|string',
            'semestres' => 'required|integer|min:1|max:10',
        ]);

        // 2. Create a new Course record in the database
        Curso::create($validatedData);

        // 3. Redirect back to the courses index page with a success message
        return redirect()->route('cursos.index')->with('success', 'Curso fue creado correctamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Curso $curso): View | RedirectResponse
    {
         $user = Auth::user(); // Get the authenticated user

        if ($user && $user->role) {

            switch ($user->role->id) {
                case 1:
                    $datos = [];
            
                    //loopeamos en todos los semestres
                    for ($i = 1; $i <= $curso->semestres; $i++){
                        // creamos el array
                        $datos[$i] = [];
                        //obtenemos todas las cursos_materias en ese semestre y en ese curso
                        $cursomaterias = CursoMateria::where('curso_id',$curso->id)->where('semestre',$i)->get();
                        //loopeamos y agregamos las materias a los datos
                        foreach ($cursomaterias as $cursomateria){
                            $materia = Materia::find($cursomateria->materia_id);
                            if($materia){
                                $materiaWithPivotId = (object) $materia->toArray();
                                $materiaWithPivotId->cursomateriaid = $cursomateria->id;
                                array_push($datos[$i],$materiaWithPivotId);
                            }
                        }
                    }

                    return view('curso.admin_ver_cursos', compact('datos','curso'));
                case 2:
                    $cursosidProfesor = GrupoProfesor::where('profesor_id',$user->id)->select(DB::raw('DISTINCT curso_id'))->pluck('curso_id');
                    $cursos = Curso::whereIn('id', $cursosidProfesor)->get();

                    $semestresProfesor = GrupoProfesor::semestreMaterias($user->id,$curso->id);

                    return view('curso.profesor_ver_curso', compact('curso','cursos','semestresProfesor'));
                default:
                    // Fallback for logged-in users with unhandled roles
                    Auth::logout();
                    session()->invalidate();
                    session()->regenerateToken();
                    return redirect()->route('login')->with('status', 'Tu role no fue reconocido');
            }
        }

        return redirect()->route('login');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Curso $curso):View
    {
        return view('curso.editar_curso', compact('curso'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Curso $curso): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                // This unique rule ignores the current course's name during update
                
                Rule::unique('cursos')->ignore($curso->id),
            ],
            'description' => 'nullable|string',
        ]);

        $curso->update($validatedData);

        // Redirect back to the courses index page with a success message
        return redirect()->route('cursos.index')->with('success', 'El Curso ha sido actualizado correctamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Curso $curso): RedirectResponse
    {
        $curso->delete();
        return redirect()->route('cursos.index')->with('success', 'El curso ha sido eliminado correctamente!');
    }


    // -- CUSTOM
    public function materias(int $cursoid, int $semestre): JsonResponse
    {
        $materias = Materia::all();
        $cursomaterias = CursoMateria::where('curso_id',$cursoid)->where('semestre',$semestre)->pluck('materia_id')->toArray();

        $materiasDisponibles = Materia::whereNotIn('id', $cursomaterias)->get();

        return response()->json($materiasDisponibles);
    }
    public function materiasCompletas(Curso $cursoid, int $semestre): JsonResponse
    {
        // The 'pluck' method is perfect for getting a list of values from a specific column.
        $materiasid = CursoMateria::where('curso_id',$cursoid->id)->where('semestre',$semestre)->get();
        $materiasid = $materiasid->pluck('materia_id');
        $materiasDelSemestre = Materia::whereIn('id', $materiasid)->get();
        return response()->json($materiasDelSemestre);
    }
    public function semestres(Curso $cursoid): JsonResponse
    {
        return response()->json(['semestres' => $cursoid->semestres]);
    }
    public function ver_cursosmodalidad(int $cursoid, int $modalidadid){
        $user = Auth::user();
        $curso = Curso::find($cursoid);

        if(!$curso || !Modalidade::find($modalidadid)){
            abort(404);
        }

        $cursos = GrupoEstudiante::listasEstudiante($user->id);
        $semestres = $cursos[$modalidadid][$curso->name];

        return view('curso.estudiante_ver_curso', compact('cursos','semestres'));
    }
}
