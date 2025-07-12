@extends('layouts.index')

@section('title', 'Superadmin Panel')
@section('main-title','Tu Panel')

@section('main-content')

<p class="success-message"><i class="fa-solid fa-bullhorn"></i><span>Bienvenido a tu panel, {{ Auth::user()->name }}!</span></p>

<div class="card-box-container">
    <div class="card-box">
        <div class="card-box-top">
            <i class="fa-solid fa-school" style="color: rgb(226, 167, 5)"></i>
            <div class="card-info">
                <span class="card-info-nombre">Cursos</span>
                <span class="card-info-cantidad">{{ $cursoCantidad }}</span>
            </div>
        </div>
        <div class="line"></div>
        <a href="{{ route('cursos.index') }}" class="card-box-view">
            <i class="fa-solid fa-arrow-right"></i>
            <span>Ver</span>
        </a>
    </div>

    <div class="card-box">
        <div class="card-box-top">
            <i class="fa-solid fa-book" style="color: rgb(71, 230, 177)"></i>
            <div class="card-info">
                <span class="card-info-nombre">Materias</span>
                <span class="card-info-cantidad">{{ $materiaCantidad }}</span>
            </div>
        </div>
        <div class="line"></div>
        <a href="{{ route('materias.index') }}" class="card-box-view">
            <i class="fa-solid fa-arrow-right"></i>
            <span>Ver</span>
        </a>
    </div>

    <div class="card-box">
        <div class="card-box-top">
            <i class="fa-solid fa-business-time" style="color: rgb(161, 71, 230)"></i>
            <div class="card-info">
                <span class="card-info-nombre">Modalidades</span>
                <span class="card-info-cantidad">{{ $modalidadCantidad }}</span>
            </div>
        </div>
        <div class="line"></div>
        <a href="{{ route('modalidades.index') }}" class="card-box-view">
            <i class="fa-solid fa-arrow-right"></i>
            <span>Ver</span>
        </a>
    </div>

    <div class="card-box">
        <div class="card-box-top">
            <i class="fa-solid fa-user-tie"  style="color: rgb(230, 71, 71)"></i>
            <div class="card-info">
                <span class="card-info-nombre">Professores</span>
                <span class="card-info-cantidad">{{ $profesorCantidad }}</span>
            </div>
        </div>
        <div class="line"></div>
        <a href="{{ route('profesores.index') }}" class="card-box-view">
            <i class="fa-solid fa-arrow-right"></i>
            <span>Ver</span>
        </a>
    </div>

    <div class="card-box">
        <div class="card-box-top">
            <i class="fa-solid fa-graduation-cap" style="color: rgb(71, 100, 230)"></i>
            <div class="card-info">
                <span class="card-info-nombre">Estudiantes</span>
                <span class="card-info-cantidad">{{ $estudianteCantidad }}</span>
            </div>
        </div>
        <div class="line"></div>
        <a href="{{ route('estudiantes.index') }}" class="card-box-view">
            <i class="fa-solid fa-arrow-right"></i>
            <span>Ver</span>
        </a>
    </div>
</div>


@endsection