@extends('layouts.index')

@section('title', 'Asignar un grupo a un Profesor')
@section('main-title','Asignar un grupo a un Profesor')

@section('main-content')

<form class="formulario" action="{{ route('grupoprofesor.store') }}" method="POST">
    @csrf

    <div class="campo">
        <label for="profesor_id">Profesor: </label>
        <select name="profesor_id" id="profesor_id" required>
            <option value="" disabled selected>-- Seleccionar un Profesor --</option>
            @foreach ($profesores as $profesor)
                <option value="{{$profesor->id}}">{{ $profesor->name }}</option>
            @endforeach
        </select>
        @error('profesor_id')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>

    <div class="campo">
        <label for="curso_id">Curso o Carrera: </label>
        <select name="curso_id" id="curso_id" required>
            <option value="" disabled selected>-- Seleccionar un Curso --</option>
            @foreach ($cursos as $curso)
                <option value="{{$curso->id}}">{{ $curso->name }}</option>
            @endforeach
        </select>
         @error('curso_id')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>

    <div class="campo">
        <label for="semestre">Semestre: </label>
        <select name="semestre" id="semestre" required>
            <option value="" disabled selected>-- Seleccionar un Semestre --</option>
        </select>
         @error('semestre')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>

    <div class="campo">
        <label for="materia_id">Materia: </label>
        <select name="materia_id" id="materia_id" required>
            <option value="" disabled selected>-- Seleccionar un Materia --</option>
        </select>
         @error('materia_id')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>


    <div class="formulario-botones">
            <button class="button-2" type="submit">
                Asignar ese grupo al Profesor
            </button>

        <a class="button" style="background-color: rgb(120, 120, 120)" href="{{ route('grupoprofesor.index') }}">
            Regresar
        </a>
    </div>
</form>

@endsection