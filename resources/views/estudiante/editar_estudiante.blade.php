@extends('layouts.index')

@section('title', 'Editar Profesor')
@section('main-title','Editar un Profesor')

@section('main-content')

<form class="formulario" action="{{ route('estudiantes.update', $estudiante->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="campo">
        <label for="matricula">Matricula del Estudiante: </label>
        <input type="text" name="matricula" id="matricula" value="{{ old('matricula', $estudiante->matricula) }}" required placeholder="Escribe la matricula del estudiante">
        @error('matricula')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>

    <div class="campo">
        <label for="name">Nombre del Estudiante: </label>
        <input type="text" name="name" id="name" value="{{ old('name', $estudiante->user->name) }}" required placeholder="Escribe el nombre completo del estudiante">
        @error('name')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>

    <div class="campo">
        <label for="email">Correo para el Estudiante: </label>
        <input type="email" name="email" id="email" value="{{ old('email', $estudiante->user->email) }}" required placeholder="Escribe el correo que usara el estudiante">
        @error('email')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>


    <div class="formulario-botones">
            <button class="button-2" type="submit">
                Actualizar Estudiante
            </button>

        <a class="button" style="background-color: rgb(120, 120, 120)" href="{{ route('estudiantes.index') }}">
            Regresar
        </a>
    </div>
</form>

@endsection