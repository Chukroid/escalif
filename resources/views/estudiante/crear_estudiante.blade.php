@extends('layouts.index')

@section('title', 'Agregar Estudiante')
@section('main-title','Agregar un Estudiante')

@section('main-content')

<form class="formulario" action="{{ route('estudiantes.store') }}" method="POST">
    @csrf

    <div class="campo">
        <label for="matricula">Matricula del Estudiante: </label>
        <input type="text" name="matricula" id="matricula" value="{{ old('matricula') }}" required placeholder="Escribe la matricula del estudiante">
        @error('matricula')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>

    <div class="campo">
        <label for="name">Nombre del Estudiante: </label>
        <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="Escribe el nombre completo del estudiante">
        @error('name')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>

    <div class="campo">
        <label for="email">Correo para el Estudiante: </label>
        <input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder="Escribe el correo que usara el estudiante">
        @error('email')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>

    <div class="campo">
        <label for="password">Contraseña: </label>
        <input type="password" name="password" id="password" value="{{ old('password') }}" required placeholder="Escribe la contraseña inicial para el estudiante">
        @error('password')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>

    <div class="campo">
        <label for="password_confirmation">Comfirma la contraseña: </label>
        <input type="password" name="password_confirmation" id="password_confirmation" value="{{ old('password_confirmation') }}" required placeholder="Comfirma la contraseña">
        @error('password_confirmation')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>


    <div class="formulario-botones">
            <button class="button-2" type="submit">
                Agregar Estudiante
            </button>

        <a class="button" style="background-color: rgb(120, 120, 120)" href="{{ route('estudiantes.index') }}">
            Regresar
        </a>
    </div>
</form>

@endsection