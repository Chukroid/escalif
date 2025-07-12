@extends('layouts.index')

@section('title', 'Agregar Profesor')
@section('main-title','Agregar un Profesor')

@section('main-content')

<form class="formulario" action="{{ route('profesores.store') }}" method="POST">
    @csrf

    <div class="campo">
        <label for="name">Nombre del Profesor: </label>
        <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="Escribe el nombre completo del profesor">
        @error('name')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>

    <div class="campo">
        <label for="email">Correo para el Profesor: </label>
        <input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder="Escribe el correo que usara el profesor">
        @error('email')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>

    <div class="campo">
        <label for="password">Contraseña: </label>
        <input type="password" name="password" id="password" value="{{ old('password') }}" required placeholder="Escribe la contraseña inicial para el professor">
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
                Agregar Profesor
            </button>

        <a class="button" style="background-color: rgb(120, 120, 120)" href="{{ route('profesores.index') }}">
            Regresar
        </a>
    </div>
</form>

@endsection