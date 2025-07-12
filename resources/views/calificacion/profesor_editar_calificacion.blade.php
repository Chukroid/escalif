@extends('layouts.index')

@section('title', 'Calificaciones')
@section('main-title','Calificaciones de '.$extras['nombreEstudiante'])

@section('sidebar-subcontent')
    @foreach ($cursos as $cursounico)
        <a href="{{ route('cursos.show',$cursounico->id) }}"><div class="name-icon" style="background-color: rgba(165, 42, 112, 0.325);color:rgb(131, 27, 86);">{{$cursounico->name[0]}}</div></i><span>{{ $cursounico->name }}</span><i class="fa-solid fa-chevron-right arrow"></i></a>
    @endforeach
@endsection

@section('main-content')

@if ($errors->any())
    @foreach ($errors->all() as $error)
        <p class="error-message"><i class="fa-solid fa-circle-check"></i><span>{{ $error }}</span></p>
    @endforeach
@endif
@if (session('success'))
    <p class="success-message"><i class="fa-solid fa-circle-check"></i><span>{{ session('success') }}</span></p>
@endif

<div class="tab-submenu">
    <a class="button" href="{{ route('grupoestudiantes.ver_estudiantes', [ $extras['cursoid'], $extras['semestre'], $extras['materiaid'] ] ) }}" style="background-color: rgba(87, 90, 99, 0.852)"><i class="fa-solid fa-chevron-left"></i><span>Regresar</span></a>
</div>

<form id="edit-calificacion-form" class="formulario" action="{{ route('calificaciones.store') }}" method="POST">
    @csrf
    <input type="hidden" name="modalidad_id" value="{{ $extras['modalidadid'] }}">
    <input type="hidden" name="curso_id" value="{{ $extras['cursoid'] }}">
    <input type="hidden" name="semestre" value="{{ $extras['semestre'] }}">
    <input type="hidden" name="materia_id" value="{{ $extras['materiaid'] }}">
    <input type="hidden" name="user_id" value="{{ $estudianteUser->id }}">

    <table class="curso-lista">
        <thead>
            <tr>
                <th>Nombre</th>
                @if($extras['modalidadid'] === 1)
                    <th>Parcial 1</th>
                    <th>Parcial 2</th>
                    <th>Parcial 3</th>
                    <th style="background-color: rgba(109, 109, 109, 0.255)">Promedio</th>
                    <th>Final</th>
                    <th style="background-color: rgba(109, 109, 109, 0.255)">Promedio Final</th>
                    <th>Extra</th>
                @else
                    <th>Bloque 1</th>
                    <th>Bloque 2</th>
                    <th></th>
                @endif
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="curso-descripcion">{{ $estudianteUser->name ?? 'N/A' }}</td>
                @if($extras['modalidadid'] === 1)
                    <td style="background-color: {{ ($calificacion->parcial1 ?? 0) < 8 ? 'rgba(255, 0, 0, 0.1)' : 'rgba(0, 255, 0, 0.1)' }}"><input type="number" name="parcial1" max="10.0" min="0" step="0.5" value="{{ $calificacion->parcial1 ?? 0 }}"></td>
                    <td style="background-color: {{ ($calificacion->parcial2 ?? 0) < 8 ? 'rgba(255, 0, 0, 0.1)' : 'rgba(0, 255, 0, 0.1)' }}"><input type="number" name="parcial2" max="10.0" min="0" step="0.5" value="{{ $calificacion->parcial2 ?? 0 }}"></td>
                    <td style="background-color: {{ ($calificacion->parcial3 ?? 0) < 8 ? 'rgba(255, 0, 0, 0.1)' : 'rgba(0, 255, 0, 0.1)' }}"><input type="number" name="parcial3" max="10.0" min="0" step="0.5" value="{{ $calificacion->parcial3 ?? 0 }}"></td>
                    
                    @php
                        $promedio = round((($calificacion->parcial1 ?? 0) + ($calificacion->parcial2 ?? 0) + ($calificacion->parcial3 ?? 0)) / 3,1);
                    @endphp
                    <td style="text-align: center; color:white; background-color: {{ $promedio < 9 ? 'rgba(107, 0, 0, 1)' : 'rgba(36, 107, 0, 1)' }};">
                        {{$promedio}}
                    </td>

                    <td style="background-color: {{ ($calificacion->final ?? 0) < 9 ? 'rgba(255, 0, 0, 0.1)' : 'rgba(0, 255, 0, 0.1)' }}"><input type="number" name="final" max="10.0" min="0" step="0.5" value="{{ $calificacion->final ?? 0 }}"></td>
                    
                    @php
                        $promediofinal = round((($calificacion->final ?? 0) + $promedio) / 2,1);
                    @endphp
                    <td style="text-align: center; color:white; background-color: {{ $promediofinal < 8 ? 'rgba(107, 0, 0, 1)' : 'rgba(36, 107, 0, 1)' }};">
                        @if($promediofinal >= 8)
                            Exentado con {{$promediofinal}}
                        @else
                            Extraordinario
                        @endif
                    </td>

                    <td style="background-color: {{ ($calificacion->extra ?? 0) < 8 ? 'rgba(255, 0, 0, 0.1)' : 'rgba(0, 255, 0, 0.1)' }}"><input type="number" name="extra" max="10.0" min="0" step="0.5" value="{{ $calificacion->extra ?? 0 }}"></td>
                @else
                    <td style="background-color: {{ ($calificacion->bloque1 ?? 0) < 8 ? 'rgba(255, 0, 0, 0.1)' : 'rgba(0, 255, 0, 0.1)' }}"><input type="number" name="bloque1" max="10.0" min="0" step="0.5" value="{{ $calificacion->bloque1 ?? 0 }}"></td>
                    <td style="background-color: {{ ($calificacion->bloque2 ?? 0) < 8 ? 'rgba(255, 0, 0, 0.1)' : 'rgba(0, 255, 0, 0.1)' }}"><input type="number" name="bloque2" max="10.0" min="0" step="0.5" value="{{ $calificacion->bloque2 ?? 0 }}"></td>

                    @php
                        $promediofinal = round((($calificacion->bloque1 ?? 0) + ($calificacion->bloque2 ?? 0)) / 2,1);
                    @endphp
                    <td style="text-align: center; color:white; background-color: {{ $promediofinal < 8 ? 'rgba(107, 0, 0, 1)' : 'rgba(36, 107, 0, 1)' }};">
                        @if($promediofinal >= 8)
                            Exentado con {{$promediofinal}}
                        @else
                            Reprobado
                        @endif
                    </td>

                @endif
            </tr>
        </tbody>
    </table>
    <button type="submit" form="edit-calificacion-form" class="button-2">SUBIR CALIFICACIONES</button>
</form>

@endsection