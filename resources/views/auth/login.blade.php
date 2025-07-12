@extends('layouts.main')

@section('title', 'Iniciar Session')

@section('content')

<img id="login-background" src="/images/studentsExam.jpg" alt="">

<div id="login-headshot">
    <h1>ESCALIF</h1>
    <p>El sistema que te ayuda en registrar calificaciones de manera mas facil y segura. Somos el Top 1 del Estado!</p>
    <h3>Hecho por Chukroid</h3>
</div>

<!-- Session Status -->

<form method="POST" action="{{ route('login') }}" id="login-form">
    @csrf

    <h1>ESCALIF</h1>

    <div id="login-welcome-msg">
        <p>Bienvenido de Nuevo</p>
        <span>Entra con el correo y contraseña que fue asignado por el administrador para ti!</span>
    </div>

    <!-- Status -->

    <!-- Email Address -->
    <div class="campo">
        <label for="email">Correo</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus placeholder="Escribe tu correo">
        @error('email')
        <div class="error-message">{{ $message }}</div>
        @enderror
    </div>

    <!-- Password -->
    <div class="campo">
        <label for="password">Contraseña</label>
        <input type="password" name="password" id="password" required placeholder="Escribe tu contraseña">
        @error('password') 
        <div class="error-message">{{ $message }}</div>
        @enderror
    </div>

    <input class="button-2" type="submit" name="submit" id="submit" value="INICIAR SESSION">
</form>

@endsection