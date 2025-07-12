@extends('layouts.index')

@section('title', 'Agregar Curso')
@section('main-title','Agregar un Curso')

@section('main-content')

<form class="formulario" action="{{ route('cursos.store') }}" method="POST">
    @csrf

    <div class="campo">
        <label for="name">Nombre del Curso: </label>
        <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="Escribe el nombre del curso">
        @error('name')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>

    <div class="campo">
        <label for="description">Descripcion del Curso: </label>
        <textarea id="description" name="description" rows="4">{{ old('description') }}</textarea>
        @error('description')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>

    <div class="campo">
        <label for="semestres">Semestres:</label>
        <input type="number" id="semestres" name="semestres" min="1" max="10" required value="{{ old('semestres') }}" placeholder="Elegir la cantidad de semestres">
        @error('semestres')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>


    <div class="formulario-botones">
            <button class="button-2" type="submit">
                Crear Curso
            </button>

        <a class="button" style="background-color: rgb(120, 120, 120)" href="{{ route('cursos.index') }}">
            Regresar
        </a>
    </div>
</form>

@endsection