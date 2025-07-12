<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View; // Needed for return type hint
use Illuminate\Support\Facades\Auth; // Needed to access the authenticated user
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

use App\Models\Curso;
use App\Models\GrupoEstudiante;
use App\Models\GrupoProfesor;
use App\Models\Materia;
use App\Models\Modalidade;
use App\Models\User;

class indexController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(): RedirectResponse|View
    {
        $user = Auth::user(); // Get the currently authenticated user

        // Check if the user has a role and determine which view to show
        if ($user && $user->role) {

            switch ($user->role->name) {
                case 'superadmin':
                    $cursoCantidad = Curso::count();
                    $materiaCantidad = Materia::count();
                    $modalidadCantidad = Modalidade::count();
                    $profesorCantidad = User::where('role_id', 2)->count();
                    $estudianteCantidad = User::where('role_id', 3)->count();

                    return view('indexpages.admin_index',[
                        'cursoCantidad' => $cursoCantidad,
                        'materiaCantidad' => $materiaCantidad,
                        'modalidadCantidad' => $modalidadCantidad,
                        'profesorCantidad' => $profesorCantidad,
                        'estudianteCantidad' => $estudianteCantidad
                    ]);
                case 'profesor':
                    $cursosidProfesor = GrupoProfesor::where('profesor_id',$user->id)->select(DB::raw('DISTINCT curso_id'))->pluck('curso_id');
                    $cursos = Curso::whereIn('id', $cursosidProfesor)->get();

                    return view('indexpages.profesor_index',[
                        'cursos' => $cursos
                    ]);
                case 'estudiante':
                    $cursos = GrupoEstudiante::listasEstudiante($user->id);
                    
                    return view('indexpages.estudiante_index',[
                        'cursos' => $cursos
                    ]);
                default:
                    // Case: User is authenticated but does not have a role assigned.
                    // (The 'auth' middleware will prevent unauthenticated users from reaching this point.)
                    // Log them out and redirect to login.
                    Auth::logout();
                    session()->invalidate();
                    session()->regenerateToken();
                    return redirect()->route('login')->with('status', 'Your role is not recognized. Please log in again.');
            }
        }
            // Case: User is authenticated but does not have a role assigned.
            // (The 'auth' middleware will prevent unauthenticated users from reaching this point.)
            // Log them out and redirect to login.
            Auth::logout();
            session()->invalidate();
            session()->regenerateToken();
            return redirect()->route('login')->with('status', 'Your role is not recognized. Please log in again.');
    }

}
