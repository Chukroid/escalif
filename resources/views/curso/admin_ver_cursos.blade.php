@extends('layouts.index')

@section('title', 'Ver Curso')
@section('main-title','Detalles de "' . $curso->name . '"')

@section('modal')

<div class="modal-bg">
    <div class="modal-list">
        <p style="margin: 0; font-weight:600">Seleccionar una Materia</p>
        <div id="materia-choose-list">
            <!--<a href=""><span>Matematicas</span><i class="fa-solid fa-caret-right"></i></a>-->
        </div>
        <button id="modal-materia-cerrar-btn" class="button-2" style="background-color: rgb(108, 108, 108)">CERRAR</button>
    </div>
</div>

@endsection

@section('main-content')

<div class="tab-submenu">
    <a class="button" href="{{ route('cursos.index') }}" style="background-color: rgba(121, 121, 121, 0.852)"><i class="fa-solid fa-arrow-left"></i><span>Regresar</span></a>
</div>

<div class="semestre-materias">
    @foreach ($datos as $semestre => $materias)

        <div class="semestre-materia-item">
            <div class="table-header">
                <p>Semestre {{$semestre}}</p>
                <button data-curso="{{ $curso->id }}" data-semestre="{{ $semestre }}" class="ver-materia-btn button-2" style="background-color: rgb(69, 122, 255)"><i class="fa-solid fa-plus"></i>Agregar</button>
            </div>
            <table>
                <tbody>
                    <tr>
                        @if (empty($materias))
                            <p class="neutral-message">Ninguna Materia Registrada.</p>
                        @else
                            @foreach ($materias as $materia)

                                <td>
                                    <span>{{ $materia->name }}</span>
                                    <form action="{{ route('cursomateria.destroy', $materia->cursomateriaid) }}" method="POST">
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