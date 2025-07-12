<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

use App\Models\Materia;
use Illuminate\Http\RedirectResponse;

class MateriaController extends Controller
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
             $materias = Materia::all();

            switch ($user->role->id) {
                case 1:
                    return view('materia.admin_index', compact('materias'));
                case 2:
                    return view('materia.admin_index', compact('materias'));
                case 3:
                    return view('materia.admin_index', compact('materias'));
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
        return view('materia.crear_materia');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:materias,name',
            'description' => 'nullable|string',
        ]);

        Materia::create($validatedData);

        return redirect()->route('materias.index')->with('success', 'La materia fue creado correctamente!');
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
    public function edit(Materia $materia)
    {
        return view('materia.editar_materia', compact('materia'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Materia $materia): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                // This unique rule ignores the current course's name during update
                
                Rule::unique('materias')->ignore($materia->id),
            ],
            'description' => 'nullable|string',
        ]);

        $materia->update($validatedData);

        // Redirect back to the courses index page with a success message
        return redirect()->route('materias.index')->with('success', 'La materia ha sido actualizado correctamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Materia $materia):RedirectResponse
    {
        $materia->delete();
        return redirect()->route('materias.index')->with('success', 'La materia ha sido eliminado correctamente!');
    }
}
