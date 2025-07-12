@extends('layouts.index')

@section('title', 'Asignar un grupo a un Estudiante')
@section('main-title','Asignar un grupo al Estudiante: '.$estudiante->user->name)

@section('main-content')

<form class="formulario" action="{{ route('grupoestudiantes.store') }}" method="POST">
    @csrf

    <input type="hidden" name="user_id" value="{{$estudiante->user->id}}">

    <div class="campo">
        <label for="modalidad_id_estudiante">Modalidad: </label>
        <select name="modalidad_id" id="modalidad_id_estudiante" required>
            <option value="" disabled selected>-- Seleccionar una Modalidad --</option>
            @foreach ($modalidades as $modalidad)
                @if($modalidad->activo)
                    <option value="{{$modalidad->id}}">{{ $modalidad->name }}</option>
                @endif
            @endforeach
        </select>
        @error('modalidad_id')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>

    <div class="campo">
        <label for="curso_id_estudiante">Curso o Carrera:: </label>
        <select name="curso_id" id="curso_id_estudiante" required>
            <option value="" disabled selected>-- Seleccionar una Curso --</option>
            @foreach ($cursos as $curso)
                <option value="{{$curso->id}}">{{ $curso->name }}</option>
            @endforeach
        </select>
        @error('curso_id')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>

    <div class="campo">
        <label for="semestre_estudiante">Semestre: </label>
        <select name="semestre" id="semestre_estudiante" required>
            <option value="" disabled selected>-- Seleccionar un Semestre --</option>
        </select>
         @error('semestre')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>


    <div class="formulario-botones">
            <button class="button-2" type="submit">
                Asignar ese grupo al Estudiante
            </button>

        <a class="button" style="background-color: rgb(120, 120, 120)" href="{{ route('estudiantes.show', $estudiante->id) }}">
            Regresar
        </a>
    </div>
</form>

@endsection