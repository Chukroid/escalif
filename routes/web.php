<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\indexController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; // Needed for Auth::check()

use App\Http\Controllers\CursoController; 
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\ProfesorController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\CursoMateriaController;
use App\Http\Controllers\ModalidadController;
use App\Http\Controllers\GrupoProfesorController;
use App\Http\Controllers\GrupoEstudianteController;
use App\Http\Controllers\CalificacionController;
use App\Http\Controllers\EmailController;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('index');
    }
    return redirect()->route('login');;
});

//Route::get('/login', function () {
//    // If the user is already authenticated, redirect them to your custom welcome page
//    if (Auth::check()) {
//        return redirect()->route('index');
//    }
//    return view('login');
//})->middleware('guest')->name('login');

Route::get('/index', [indexController::class, 'index'])->middleware('auth')->name('index'); // This page requires authentication


//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    //Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    //Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    //Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

     // --- RESOURCE ROUTES ---
    Route::resource('cursos', CursoController::class)->middleware('can:is-admin')->except(['index']);
    Route::resource('cursos', CursoController::class)->only(['index','show']);
    Route::get('/cursos/{cursoid}/{semestre}/materias', [CursoController::class, 'materias'])->middleware('can:is-admin')
        ->name('cursos.materias');
    Route::get('/cursos/{cursoid}/{semestre}/materiascompleta',[CursoController::class, 'materiasCompletas'])->middleware('can:is-admin')
        ->name('cursos.materiascompletas');
    Route::get('/cursos/{cursoid}/semestres',[CursoController::class, 'semestres'])->middleware('can:is-admin')
        ->name("cursos.semestres");
    Route::get('/cursos/{cursoid}/{modalidadid}',[CursoController::class, 'ver_cursosmodalidad'])
        ->name("cursos.ver_cursosmodalidad");

    Route::resource('materias', MateriaController::class)->middleware('can:is-admin')->except(['index']);
    Route::resource('materias', MateriaController::class)->only(['index']);

    Route::resource('profesores', ProfesorController::class)->middleware('can:is-admin')->except(['index']);
    Route::resource('profesores', ProfesorController::class)->only(['index']);

    Route::resource('cursomateria', CursoMateriaController::class)->middleware('can:is-admin');
    
    Route::resource('modalidades',ModalidadController::class)->middleware('can:is-admin')->except(['index']);
    Route::resource('modalidades',ModalidadController::class)->only(['index']);
    Route::patch('/modalidades/{customaction}/{modalidadid}', [ModalidadController::class, 'activarModalidad'])->middleware('can:is-admin')
    ->name('modalidad.custom');
    
    Route::resource('grupoprofesor', GrupoProfesorController::class)->middleware('can:is-admin')->except(['index']);
    Route::resource('grupoprofesor', GrupoProfesorController::class)->only(['index']);
    Route::delete('/grupoprofesor/borrartodo/profesor/{profesorid}',[GrupoProfesorController::class, 'borrar_profesor'])->middleware('can:is-admin')
        ->name('grupoprofesor.deleteprofesor');
    Route::delete('/grupoprofesor/borrartodo/curso/{profesorid}/{cursoid}',[GrupoProfesorController::class, 'borrar_curso'])->middleware('can:is-admin')
        ->name('grupoprofesor.deletecurso');
    Route::delete('/grupoprofesor/borrartodo/semestre/{profesorid}/{cursoid}/{semestre}',[GrupoProfesorController::class, 'borrar_semestre'])->middleware('can:is-admin')
        ->name('grupoprofesor.deletesemestre');

    Route::resource('estudiantes', EstudianteController::class)->middleware('can:is-admin')->except(['index']);
    Route::resource('estudiantes', EstudianteController::class)->only(['index']);
    Route::resource('estudiantes.grupoestudiantes', GrupoEstudianteController::class)->middleware('can:is-admin');

    Route::resource('grupoestudiantes', GrupoEstudianteController::class)->middleware('can:is-admin')->except(['index']);
    Route::resource('grupoestudiantes', GrupoEstudianteController::class)->only(['index']);
    Route::delete('/grupoestudiantes/borrartodo/{estudianteid}/{modalidadid}',[GrupoEstudianteController::class, 'borrar_modalidad'])->middleware('can:is-admin')
    ->name('grupoestudiantes.deletemodalidad');
    Route::get('/grupoestudiantes/estudiantes/{cursoid}/{semestre}/{materiaid}', [GrupoEstudianteController::class, 'ver_estudiantes'])->middleware('can:is-profesor')
    ->name('grupoestudiantes.ver_estudiantes');

    Route::resource('calificaciones', CalificacionController::class)->middleware('can:is-profesor')->except(['index']);
    Route::resource('calificaciones', CalificacionController::class)->only(['index']);
    Route::get('/calificaciones/editar/{modalidadid}/{cursoid}/{semestre}/{materia}/{estudianteUserId}', [CalificacionController::class, 'editar_calificaciones'])->middleware('can:is-profesor')
    ->name('calificaciones.editarcalificacion');
    Route::get('/calificaciones/ver/{estudianteUserId}/{modalidadid}/{cursoid}/{semestre}', [CalificacionController::class, 'ver_calificaciones'])
    ->name('calificaciones.ver_calificaciones');

    Route::post('/correo', [EmailController::class, 'enviarBoleta'])->name('correo.enviarBoleta');
});


require __DIR__.'/auth.php';
