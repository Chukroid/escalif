@extends('layouts.index')

@section('title', 'Grupos de Profesor')
@section('main-title','Profesores y Grupos')

@section('main-content')

@if (session('success'))
    <p class="success-message"><i class="fa-solid fa-circle-check"></i><span>{{ session('success') }}</span></p>
@endif

<div class="tab-submenu">
    <a class="button" href="{{ route('grupoprofesor.create') }}" style="background-color: rgba(0, 76, 255, 0.852)"><i class="fa-solid fa-plus"></i><span>Asignar Profesor a un Grupo</span></a>
</div>

<div class="semestre-materias">
    @foreach ($datos as $profesor => $cursos)

        <div class="semestre-materia-item">
            <div class="table-header">
                <p>{{$profesor}}</p>
                <form action="{{ route('grupoprofesor.deleteprofesor', $cursos['profesor_id']) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="ver-materia-btn button-2" style="background-color: rgb(255, 69, 69)">
                        <i class="fa-solid fa-plus"></i>
                        <span>Desasignar</span>
                    </button>
                </form>
            </div>
            <div class="table-list">
                @foreach ($cursos['cursos'] as $curso => $semestres)
                    <div class="table-list-item">
                        <div class="table-list-sub-name">
                            <form action="{{ route('grupoprofesor.deletecurso', [$cursos['profesor_id'], $semestres['curso_id']]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                            <h4>{{$curso}}</h4>
                        </div>
                        <div class="table-list2">
                            @foreach ($semestres['semestres'] as $semestre => $materias)
                            <div class="table-list3">
                                <div class="table-list-sub-name">
                                    <form action="{{ route('grupoprofesor.deletesemestre', [$cursos['profesor_id'], $semestres['curso_id'], $semestre]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                    <span>Semestre {{$semestre}}:</span>
                                </div>
                                <div class="table-list3-itemlist">
                                    @foreach ($materias as $materia)
                                        <div class="table-list3-item">
                                            <span>{{$materia[1]}}</span>
                                            <form action="{{ route('grupoprofesor.destroy', $materia[0]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit">
                                                    <i class="fa-solid fa-xmark"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    @endforeach
</div>

@endsection