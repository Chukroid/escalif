<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

use App\Models\User;
use App\Models\Estudiante;
use App\Models\GrupoEstudiante;

class EstudianteController extends Controller
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
            $estudiantes = Estudiante::all();

            switch ($user->role->id) {
                case 1:
                    return view('estudiante.admin_index', compact('estudiantes'));
                case 2:
                    return view('estudiante.admin_index', compact('estudiantes'));
                case 3:
                    return view('estudiante.admin_index', compact('estudiantes'));
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
        return view('estudiante.crear_estudiante');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData1 = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8'
        ]);
        $validatedData2 = $request->validate([
            'matricula' => 'required|string|max:255|unique:estudiantes,matricula',
        ]);

        $user = new User();
        $user->name = $validatedData1['name'];
        $user->email = $validatedData1['email'];
        $user->password = Hash::make($validatedData1['password']);
        $user->role_id = 3;
        $user->save();

        $estudiante = new Estudiante();
        $estudiante->matricula = $validatedData2['matricula'];
        $estudiante->user_id = $user->id;
        $estudiante->save();

        return redirect()->route('estudiantes.index')->with('success', 'El estudiante ha sido agregado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Estudiante $estudiante)
    {
        $user = Auth::user();

        if ($user && $user->role) {
            $grupos = $estudiante->obtenerGruposEstudiante();

            switch ($user->role->id) {
                case 1:
                    return view('estudiante.admin_ver_estudiante', compact('estudiante', 'grupos'));
                case 2:
                    return view('estudiante.admin_ver_estudiante', compact('estudiante', 'grupos'));
                case 3:
                    return view('estudiante.admin_ver_estudiante', compact('estudiante', 'grupos'));
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
    public function edit(Estudiante $estudiante)
    {
        return view('estudiante.editar_estudiante', compact('estudiante'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Estudiante $estudiante)
    {
        $validatedData1 = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',

                Rule::unique('users')->ignore($estudiante->user_id),
            ]
        ]);

        $validatedData2 = $request->validate([
            'matricula' => [
                'required',
                'string',
                'max:255',

                Rule::unique('estudiantes')->ignore($estudiante->id),
            ],
        ]);

        $estudiante->user->update($validatedData1);
        $estudiante->update($validatedData2);

        return redirect()->route('estudiantes.index')->with('success', 'El estudiante ha sido actualizado correctamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Estudiante $estudiante)
    {
        $estudiante->delete();
        return redirect()->route('estudiantes.index')->with('success', 'El estudiante ha sido eliminado correctamente!');
    }
}
