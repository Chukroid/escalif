@extends('layouts.index')

@section('title', 'Editar Curso')
@section('main-title','Editar un Curso')

@section('main-content')

<form class="formulario" action="{{ route('cursos.update', $curso->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="campo">
        <label for="name">Nombre del Curso: </label>
        <input type="text" name="name" id="name" value="{{ old('name', $curso->name) }}" required placeholder="Escribe el nombre del curso">
        @error('name')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>

    <div class="campo">
        <label for="description">Descripcion del Curso: </label>
        <textarea id="description" name="description" rows="4">{{ old('description', $curso->description) }}</textarea>
        @error('description')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>


    <div class="formulario-botones">
            <button class="button-2" type="submit">
                Actualizar Curso
            </button>

        <a class="button" style="background-color: rgb(120, 120, 120)" href="{{ route('cursos.index') }}">
            Regresar
        </a>
    </div>
</form>

@endsection