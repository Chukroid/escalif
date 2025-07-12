@extends('layouts.index')

@section('title', 'Editar Profesor')
@section('main-title','Editar un Profesor')

@section('main-content')

<form class="formulario" action="{{ route('profesores.update', $profesor->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="campo">
        <label for="name">Nombre del Professor: </label>
        <input type="text" name="name" id="name" value="{{ old('name', $profesor->name) }}" required placeholder="Escribe el nombre del Professor">
        @error('name')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>

    <div class="campo">
        <label for="email">Correo para el Profesor: </label>
        <input type="email" name="email" id="email" value="{{ old('email', $profesor->email) }}" required placeholder="Escribe el correo que usara el profesor">
        @error('email')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>


    <div class="formulario-botones">
            <button class="button-2" type="submit">
                Actualizar Professor
            </button>

        <a class="button" style="background-color: rgb(120, 120, 120)" href="{{ route('profesores.index') }}">
            Regresar
        </a>
    </div>
</form>

@endsection