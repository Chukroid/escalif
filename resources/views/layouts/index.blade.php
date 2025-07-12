@extends('layouts.main')

@section('content')

@auth
    <div class="main-container">
        <div class="sidebar">
            <p><i class="fa-solid fa-chart-simple"></i>ESCALIF</p>
            <a href="{{ route('index') }}"><i class="fa-solid fa-house"></i> <span>Inicio</span><i class="fa-solid fa-chevron-right arrow"></i></a>
            @if(Auth::user()->role->id == 1)

            <a href="{{ route('materias.index') }}"><i class="fa-solid fa-book"></i><span>Materias</span><i class="fa-solid fa-chevron-right arrow"></i></a>
            <a href="{{ route('cursos.index') }}"><i class="fa-solid fa-school"></i><span>Cursos</span><i class="fa-solid fa-chevron-right arrow"></i></a>
            <a href="{{ route('modalidades.index') }}"><i class="fa-solid fa-business-time"></i><span>Modalidades</span><i class="fa-solid fa-chevron-right arrow"></i></a>
            <a href="{{ route('profesores.index') }}"><i class="fa-solid fa-user-tie"></i><span>Professores</span><i class="fa-solid fa-chevron-right arrow"></i></a>
            <div class="sub-menu">
                <a href="{{ route('grupoprofesor.index') }}"><i class="fa-solid fa-circle"></i>GRUPOS</a>
            </div>
            <a href="{{ route('estudiantes.index') }}"><i class="fa-solid fa-graduation-cap"></i><span>Estudiantes</span><i class="fa-solid fa-chevron-right arrow"></i></a>
            
            @elseif(Auth::user()->role->id == 2)

            <div class="sub-sidebar sub-sidebar-title"><i class="fa-solid fa-graduation-cap"></i><span>Todos tus Cursos</span></div>
            @yield('sidebar-subcontent')

            @elseif(Auth::user()->role->id == 3)

            @yield('sidebar-subcontent')

            @endif
        </div>
        <div class="main-frame">
            <div class="main-header">
                <div>
                    @yield('main-title')
                </div>
                <div class="header-user">
                    <i class="fa-solid fa-user"></i>
                    <span>
                        {{ Auth::user()->name ?? 'N/A' }}
                    </span>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="logout-form">
                    @csrf
                    <button type="submit"><i class="fa-solid fa-right-from-bracket"></i></button>
                </form>
            </div>
            <div class="line"></div>
            <div class="main-content">
                @yield('main-content')
            </div>
        </div>
    </div>
@else
    <p>You are not logged in as an admin.</p>
    <p><a href="{{ route('login') }}">Go to Login</a></p>
@endauth
    
@endsection