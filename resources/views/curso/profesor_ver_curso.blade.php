@extends('layouts.index')

@section('title', 'Semestres')
@section('main-title','Detalles del Curso "'.$curso->name.'"')

@section('sidebar-subcontent')
    @foreach ($cursos as $cursounico)
        <a href="{{ route('cursos.show',$cursounico->id) }}"><div class="name-icon" style="background-color: rgba(165, 42, 112, 0.325);color:rgb(131, 27, 86);">{{$cursounico->name[0]}}</div></i><span>{{ $cursounico->name }}</span><i class="fa-solid fa-chevron-right arrow"></i></a>
    @endforeach
@endsection

@section('main-content')

<div class="semestre-materias">
    @foreach ($semestresProfesor as $semestre => $materias)

        <div class="semestre-materia-item">
            <div class="table-header">
                <p>Semestre {{$semestre}}</p>
            </div>
            <table>
                <tbody>
                    @if (empty($materias))
                        <p class="neutral-message">Ninguna Materia Registrada.</p>
                    @else
                        @foreach ($materias as $materia)
                            <tr>
                                <td>
                                    <span>{{ $materia['materiaName'] }}</span>
                                    <span class="curso-semestres">{{ '('.$materia['estudiantesCantidad'].' ' }}<i class="fa-solid fa-user-large"></i>{{')'}}</span>
                                    <a class="button" style="background-color: rgb(48, 99, 167)" href="{{ route('grupoestudiantes.ver_estudiantes', [$curso->id,$semestre,$materia['materiaId']]) }}"><i class="fa-solid fa-eye"></i><span>Ver Alumnos</span></a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

    @endforeach
</div>


@endsection