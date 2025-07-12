<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Validation\Rule;
use App\Models\GrupoProfesor;
use App\Models\User;
use App\Models\Curso;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class GrupoProfesorController extends Controller
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
         $user = Auth::user(); // Get the authenticated user

        if ($user && $user->role) {
            $datos = GrupoProfesor::lists();

            switch ($user->role->id) {
                case 1:
                    return view('grupoProfesor.admin_index', compact('datos'));
                case 2:
                    return view('grupoProfesor.admin_index');
                case 3:
                    return view('grupoProfesor.admin_index');
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
    public function create(): View
    {
        $profesores = User::where('role_id', 2)->get();
        $cursos = Curso::all();

        return view('grupoProfesor.crear_grupoProfesor', compact('profesores','cursos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'profesor_id' => [
                'required',
                'integer',
                'exists:users,id',
            ],
            'curso_id' => 'required|integer|exists:cursos,id',
            'semestre' => 'required|integer|min:1|max:10',
            'materia_id' => [
                'required',
                'integer',
                'exists:materias,id',
                Rule::unique('grupo_profesors')->where(function ($query) use ($request) {
                    return $query->where('curso_id', $request->input('curso_id'))
                                ->where('materia_id', $request->input('materia_id'))
                                ->where('semestre', $request->input('semestre'))
                                ->where('profesor_id',$request->input('profesor_id'));
                })]
        ]);

        GrupoProfesor::create($validatedData);
        return redirect()->route('grupoprofesor.index')->with('success', 'La asignacion fue creado correctamente!');
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
    public function destroy(int $grupoProfesorid)
    {
        $grupoProfesor = GrupoProfesor::find($grupoProfesorid);
        $grupoProfesor->delete();
        return redirect()->route('grupoprofesor.index')->with('success', 'La materia ha sido eliminado correctamente!');
    }


    // CUSTOMS
    public function borrar_profesor(int $profesorid): RedirectResponse
    {
        GrupoProfesor::where('profesor_id',$profesorid)->delete();
        return redirect()->route('grupoprofesor.index')->with('success','La asignacion ha sido eliminado!');
    }
    public function borrar_curso(int $profesorid, int $cursoid): RedirectResponse
    {
        GrupoProfesor::where('profesor_id',$profesorid)->where('curso_id',$cursoid)->delete();
        return redirect()->route('grupoprofesor.index')->with('success','El curso de esta asignacion ha sido eliminado!');
    }
    public function borrar_semestre(int $profesorid, int $cursoid, int $semestre): RedirectResponse
    {
        GrupoProfesor::where('profesor_id',$profesorid)->where('curso_id',$cursoid)->where('semestre',$semestre)->delete();
        return redirect()->route('grupoprofesor.index')->with('success','El semestre del curso de esta asignacion ha sido eliminado!');
    }
}
