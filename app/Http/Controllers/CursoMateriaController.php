<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Models\CursoMateria;
use App\Models\Curso;
use App\Models\Materia;

class CursoMateriaController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $cursoid = $request->input('curso_id');
        $materiaid = $request->input('materia_id');
        $semestrenum = $request->input('semestre');
        
        $curso = Curso::find($cursoid);
        $materia = Materia::find($materiaid);

        if (!$curso) {
            return response()->json(['error'=> 'Curso no exite']);
        }
        if (!$materia) {
            return response()->json(['error'=> 'Materia no exite']);
        }
        if ($semestrenum < 1 || $semestrenum > $curso->semestres) {
            return response()->json(['error'=> 'Semestre invalido']);
        }

        $alreadyAssigned = CursoMateria::where('curso_id', $cursoid)
                                       ->where('materia_id', $materiaid)
                                       ->where('semestre', $semestrenum)
                                       ->exists();
        if ($alreadyAssigned) {
            return response()->json(['error'=> 'Asignacion ya existe']);
        }

        try {
            CursoMateria::create([
                'curso_id' => $cursoid,
                'materia_id' => $materiaid,
                'semestre' => $semestrenum,
            ]);

            return response()->json(['success'=> 'Materia agregado!']);

        } catch (\Exception $e) {
            return response()->json(['error'=> 'Hubo un error, intenta despues.']);
        }
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
    public function destroy(int $cursomateriaid): RedirectResponse
    {
        $cursomateria = CursoMateria::find($cursomateriaid);
        $cursoid = $cursomateria->curso_id;
        
        $cursomateria->delete();

        return redirect()->route('cursos.show', $cursoid)->with('success', 'Asignación de materia eliminada correctamente.');
    }
}
