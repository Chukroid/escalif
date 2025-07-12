@extends('layouts.index')

@section('title', 'Agregar Materia')
@section('main-title','Agregar una Materia')

@section('main-content')

<form class="formulario" action="{{ route('materias.store') }}" method="POST">
    @csrf

    <div class="campo">
        <label for="name">Nombre de la Materia: </label>
        <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus placeholder="Escribe el nombre del curso">
        @error('name')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>

    <div class="campo">
        <label for="description">Descripcion de la Materia: </label>
        <textarea id="description" name="description" rows="4">{{ old('description') }}</textarea>
        @error('description')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>

    <div class="formulario-botones">
            <button class="button-2" type="submit">
                Crear Materia
            </button>

        <a class="button" style="background-color: rgb(120, 120, 120)" href="{{ route('materias.index') }}">
            Regresar
        </a>
    </div>
</form>

@endsection