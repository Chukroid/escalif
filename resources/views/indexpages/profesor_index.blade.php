@extends('layouts.index')

@section('title', 'Profesor Panel')
@section('main-title','Tu Panel')

@section('sidebar-subcontent')
    @foreach ($cursos as $curso)
        <a href="{{ route('cursos.show',$curso->id) }}"><div class="name-icon" style="background-color: rgba(165, 42, 112, 0.325);color:rgb(131, 27, 86);">{{$curso->name[0]}}</div></i><span>{{ $curso->name }}</span><i class="fa-solid fa-chevron-right arrow"></i></a>
    @endforeach
@endsection

@section('main-content')

<p class="success-message"><i class="fa-solid fa-bullhorn"></i><span>Bienvenido a tu panel, {{ Auth::user()->name }}!</span></p>

<div class="card-box-container">
    @foreach($cursos as $curso)
        <div class="card-box">
            <div class="card-box-top">
                <i class="fa-solid fa-school" style="color: rgb(180, 185, 22)"></i>
                <div class="card-info" style="padding-left: 1em">{{ $curso->name }}</div>
            </div>
            <div class="line"></div>
            <a href="{{ route('cursos.show',$curso->id) }}" class="card-box-view">
                <i class="fa-solid fa-arrow-right"></i>
                <span>Ver</span>
            </a>
        </div>
    @endforeach
</div>


@endsection