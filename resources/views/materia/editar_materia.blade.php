@extends('layouts.index')

@section('title', 'Editar Materia')
@section('main-title','Editar una Materia')

@section('main-content')

<form class="formulario" action="{{ route('materias.update', $materia->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="campo">
        <label for="name">Nombre de la Materia: </label>
        <input type="text" name="name" id="name" value="{{ old('name', $materia->name) }}" required placeholder="Escribe el nombre de la materia">
        @error('name')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>

    <div class="campo">
        <label for="description">Descripcion de la Materia: </label>
        <textarea id="description" name="description" rows="4">{{ old('description', $materia->description) }}</textarea>
        @error('description')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>


    <div class="formulario-botones">
            <button class="button-2" type="submit">
                Actualizar Materia
            </button>

        <a class="button" style="background-color: rgb(120, 120, 120)" href="{{ route('materias.index') }}">
            Regresar
        </a>
    </div>
</form>

@endsection