@extends('layouts.index')

@section('title', 'Semestres')
@section('main-title','Lista de Alumnos')

@section('sidebar-subcontent')
    @foreach ($cursos as $cursounico)
        <a href="{{ route('cursos.show',$cursounico->id) }}"><div class="name-icon" style="background-color: rgba(165, 42, 112, 0.325);color:rgb(131, 27, 86);">{{$cursounico->name[0]}}</div></i><span>{{ $cursounico->name }}</span><i class="fa-solid fa-chevron-right arrow"></i></a>
    @endforeach
@endsection

@section('main-content')

<div class="tab-submenu">
    <a class="button" href="{{ route('cursos.show', $cursoid) }}" style="background-color: rgba(87, 90, 99, 0.852)"><i class="fa-solid fa-chevron-left"></i><span>Regresar</span></a>
</div>

@if ($estudiantes->isEmpty())
    <p class="neutral-message">Ningun Estudiante registrado a este curso o semestre.</p>
@else

    <table class="curso-lista">
        <thead>
            <tr>
                <th>Matricula</th>
                <th>Nombre</th>
                <th>Modalidad</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($estudiantes as $estudiante)
                <tr>
                    <td class="curso-nombre">{{ $estudiante->estudiante->matricula }}</td>
                    <td class="curso-descripcion">{{ $estudiante->user->name ?? 'N/A' }}</td>
                    <td class="curso-semestres">{{ $estudiante->modalidad->name }}</td>
                    <td class="curso-acciones">
                        <a class="curso-ver" href="{{ route('calificaciones.editarcalificacion', [ $estudiante->modalidad,$cursoid, $semestre, $materiaid, $estudiante->user->id ]) }}"><i class="fa-solid fa-eye"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

@endsection