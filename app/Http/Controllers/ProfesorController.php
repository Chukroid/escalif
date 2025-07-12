<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Illuminate\Http\RedirectResponse;

class ProfesorController extends Controller
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
            $profesores = User::where('role_id',2)->get();

            switch ($user->role->id) {
                case 1:
                    return view('profesor.admin_index', compact('profesores'));
                case 2:
                    return view('profesor.admin_index', compact('profesores'));
                case 3:
                    return view('profesor.admin_index', compact('profesores'));
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
        return view('profesor.crear_profesor');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8'
        ]);

        $user = new User();
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->password = Hash::make($validatedData['password']);

        $user->role_id = 2;
        $user->save();

        return redirect()->route('profesores.index')->with('success', 'El profesor ha sido agregado correctamente');
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
    public function edit(int $profesorid): View
    {
        $profesor = User::find($profesorid);
        if (!$profesor) {
            abort(404);
        }
        return view('profesor.editar_profesor', compact('profesor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $profesorid): RedirectResponse
    {
        $profesor = User::find($profesorid);

        if (!$profesor) {
            abort(404);
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',

                Rule::unique('users')->ignore($profesor->id),
            ]
        ]);

        $profesor->update($validatedData);

        return redirect()->route('profesores.index')->with('success', 'El professor ha sido actualizado correctamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $profesorid)
    {
        $profesor = User::find($profesorid);

        if (!$profesor){
            abort(404);
        }

        $profesor->delete();
        return redirect()->route('profesores.index')->with('success', 'El professor ha sido eliminado correctamente!');
    }
}
