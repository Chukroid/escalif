<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;

use App\Models\Modalidade;

class ModalidadController extends Controller
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
        $user = Auth::user();

        if ($user && $user->role) {
            $modalidades = Modalidade::all();

            switch ($user->role->id) {
                case 1:
                    return view('modalidad.admin_index', compact('modalidades'));
                case 2:
                    return view('modalidad.admin_index', compact('modalidades'));
                case 3:
                    return view('modalidad.admin_index', compact('modalidades'));
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
        //
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
    public function edit(int $modalidadid)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $modalidadid)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $modalidadid)
    {
        //
    }


    //
    public function activarModalidad(Request $request, string $accion, int $modalidadid)
    {
        $modalidad = Modalidade::find($modalidadid);

        if(!$modalidad){
            abort(404);
        }

        $validatedData = $request->validate([
            'activo' => 'required|boolean',
        ]);

        $modalidad->activo = $validatedData['activo'];
        $modalidad->save();

        return response()->json([
            'success' => true,
        ]);
    }
}
