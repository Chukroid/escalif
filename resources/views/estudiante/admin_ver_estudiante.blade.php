@extends('layouts.index')

@section('title', 'Ver Estudiante')
@section('main-title','Detalles del Estudiante: ' . $estudiante->user->name . '')

@section('modal')

@endsection

@section('main-content')

@if (session('success'))
    <p class="success-message"><i class="fa-solid fa-circle-check"></i><span>{{ session('success') }}</span></p>
@endif

<div class="tab-submenu">
    <a class="button" href="{{ route('estudiantes.grupoestudiantes.create', $estudiante->id) }}" style="background-color: rgba(0, 76, 255, 0.852)"><i class="fa-solid fa-plus"></i><span>Asignar a un grupo</span></a>
    <a class="button" href="{{ route('estudiantes.index') }}" style="background-color: rgba(121, 121, 121, 0.852)"><i class="fa-solid fa-arrow-left"></i><span>Regresar</span></a>
</div>

<div class="semestre-materias">
    @foreach ($grupos as $modalidad => $grupos)

        <div class="semestre-materia-item">
            <div class="table-header">
                <p>{{$modalidad}}</p>
                <form action="{{ route('grupoestudiantes.deletemodalidad', [$estudiante->id,$grupos['id']]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="ver-materia-btn button-2" style="background-color: rgb(255, 69, 69)">
                        <i class="fa-solid fa-plus"></i>
                        <span>Desasignar</span>
                    </button>
                </form>
            </div>
            <table>
                <tbody>
                    <tr>
                        @if (empty($grupos['grupos']))
                            <p class="neutral-message">Ningun Curso Asignado.</p>
                        @else
                            @foreach ($grupos['grupos'] as $grupo)

                                <td>
                                    <div class="tbody-item">
                                        <h3>Curso: </h3>
                                        <span>{{ $grupo['cursoname'] }}</span>
                                        <h3>Semestre: </h3>
                                        <span>{{ $grupo['semestre'] }}</span>
                                    </div>
                                    <form action="{{ route('grupoestudiantes.destroy', $grupo['grupoestudianteid']) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </td>

                            @endforeach
                        @endif
                    </tr>
                </tbody>
            </table>
        </div>

    @endforeach
</div>

@endsection