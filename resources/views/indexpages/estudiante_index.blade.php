@extends('layouts.index')

@section('title', 'Estudiante Panel')
@section('main-title','Tu Panel')

@section('sidebar-subcontent')
    @foreach($cursos as $modalidad => $cursolista)
        @if($modalidad == 1)
            <div class="sub-sidebar sub-sidebar-title"><i class="fa-solid fa-graduation-cap"></i><span>ESCOLARIZADO</span></div>
        @elseif($modalidad == 2)
            <div class="sub-sidebar sub-sidebar-title"><i class="fa-solid fa-graduation-cap"></i><span>EJECUTIVO</span></div>
        @endif
        @foreach ($cursolista as $curso)
            <a href="{{ route('cursos.ver_cursosmodalidad',[$curso['cursoObj']->id, $modalidad] ) }}"><div class="name-icon" style="background-color: rgba(165, 42, 112, 0.325);color:rgb(131, 27, 86);">{{$curso['cursoObj']->name[0]}}</div><span>{{ $curso['cursoObj']->name }}</span><i class="fa-solid fa-chevron-right arrow"></i></a>
            <div class="sub-menu">
                @foreach($curso['semestres'] as $semestre)
                    <a href="{{ route('calificaciones.ver_calificaciones', [Auth::user()->id, $modalidad, $curso['cursoObj']->id, $semestre]) }}"><i class="fa-solid fa-circle"></i>Semestre {{$semestre}}</a>
                @endforeach
            </div>
        @endforeach
    @endforeach
@endsection

@section('main-content')

<p class="success-message"><i class="fa-solid fa-bullhorn"></i><span>Bienvenido a tu panel, {{ Auth::user()->name }}!</span></p>

@foreach($cursos as $modalidad => $cursolista)
    @if($modalidad == 1)
            <h3>Escolarizado</h3>
        @elseif($modalidad == 2)
            <h3>Ejecutivo</h3>
        @endif
    <div class="card-box-container">
        @foreach($cursolista as $curso)
            <div class="card-box">
                <div class="card-box-top">
                    <i class="fa-solid fa-school" style="color: rgb(180, 185, 22)"></i>
                    <div class="card-info" style="padding-left: 1em">{{ $curso['cursoObj']->name }}</div>
                </div>
                <div class="line"></div>
                <a href="{{ route('cursos.ver_cursosmodalidad',[$curso['cursoObj']->id, $modalidad] ) }}" class="card-box-view">
                    <i class="fa-solid fa-arrow-right"></i>
                    <span>Ver</span>
                </a>
            </div>
        @endforeach
    </div>
@endforeach


@endsection