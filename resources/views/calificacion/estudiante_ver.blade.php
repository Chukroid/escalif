@extends('layouts.index')

@section('title', 'Estudiante Panel')
@section('main-title','Tu Boleta')

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

@php
    $promedioTotal = 0;
    $materiasTotal = 0;
@endphp

<div id="boleta-contenedor" data-boleta-user-id="{{ $user->email }}">
    <div class="boleta-titulo">
        <p><i class="fa-solid fa-chart-simple"></i>ESCALIF</p>
    </div>
    <div class="boleta-info">
        <div><i class="fa-solid fa-arrows-to-dot"></i><strong>Nombre del Estudiante:</strong> {{$datos['name']}}</div>
        <div><i class="fa-solid fa-arrows-to-dot"></i><strong>Curso o Carrera:</strong> {{$datos['curso']}}</div>
        <div><i class="fa-solid fa-arrows-to-dot"></i><strong>Semestre:</strong> {{$datos['semestre']}}</div>
    </div>
    <table class="curso-lista">
        <thead>
            <tr>
                <th>Materia</th>
                @if($modalidadid === 1)
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
            @foreach ($calificacion as $materia => $lista)
                <tr>
                    <td>{{$materia}}</td>
                    @if($modalidadid === 1)
                        <td style="background-color: {{ ($lista->parcial1 ?? 0) < 8 ? 'rgba(255, 0, 0, 0.1)' : 'rgba(0, 255, 0, 0.1)' }}">{{ $lista->parcial1 ?? 0 }}</td>
                        <td style="background-color: {{ ($lista->parcial2 ?? 0) < 8 ? 'rgba(255, 0, 0, 0.1)' : 'rgba(0, 255, 0, 0.1)' }}">{{ $lista->parcial2 ?? 0 }}</td>
                        <td style="background-color: {{ ($lista->parcial3 ?? 0) < 8 ? 'rgba(255, 0, 0, 0.1)' : 'rgba(0, 255, 0, 0.1)' }}">{{ $lista->parcial3 ?? 0 }}</td>
                        
                        @php
                            $promedio = round((($lista->parcial1 ?? 0) + ($lista->parcial2 ?? 0) + ($lista->parcial3 ?? 0)) / 3,1);
                        @endphp
                        <td style="text-align: center; color:white; background-color: {{ $promedio < 9 ? 'rgba(107, 0, 0, 1)' : 'rgba(36, 107, 0, 1)' }};">
                            {{$promedio}}
                        </td>

                        <td style="background-color: {{ ($lista->final ?? 0) < 9 ? 'rgba(255, 0, 0, 0.1)' : 'rgba(0, 255, 0, 0.1)' }}">{{ $lista->final ?? 0 }}</td>
                        
                        @php
                            $promediofinal = round((($lista->final ?? 0) + $promedio) / 2,1);
                            $promedioTotal = $promedioTotal + $promediofinal;
                            $materiasTotal = $materiasTotal + 1;
                        @endphp
                        <td style="text-align: center; color:white; background-color: {{ $promediofinal < 8 ? 'rgba(107, 0, 0, 1)' : 'rgba(36, 107, 0, 1)' }};">
                            @if($promediofinal >= 8)
                                Exentado con {{$promediofinal}}
                            @else
                                Extraordinario
                            @endif
                        </td>

                        <td style="background-color: {{ ($lista->extra ?? 0) < 8 ? 'rgba(255, 0, 0, 0.1)' : 'rgba(0, 255, 0, 0.1)' }}">{{ $lista->extra ?? 0 }}</td>
                    @else
                        <td style="background-color: {{ ($lista->bloque1 ?? 0) < 8 ? 'rgba(255, 0, 0, 0.1)' : 'rgba(0, 255, 0, 0.1)' }}">{{ $lista->bloque1 ?? 0 }}</td>
                        <td style="background-color: {{ ($lista->bloque2 ?? 0) < 8 ? 'rgba(255, 0, 0, 0.1)' : 'rgba(0, 255, 0, 0.1)' }}">{{ $lista->bloque2 ?? 0 }}</td>

                        @php
                            $promediofinal = round((($lista->bloque1 ?? 0) + ($lista->bloque2 ?? 0)) / 2,1);
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
            @endforeach
        </tbody>
    </table>

    <div class="boleta-promedio-general">
        <strong>Tu calificacion general: </strong>
        {{ round( $promedioTotal/($materiasTotal == 0 ? 1 : $materiasTotal) ,1) }}
    </div>
</div>

<div class="tab-submenu" style="margin-top: 1em">
    <a class="button printbutton" href="" style="background-color: rgb(255, 0, 0)" data-print-frame="boleta-contenedor"><i class="fa-solid fa-print"></i><span>Guardar Boleta (PDF)</span></a>
    <a class="button enviarBoletaBoton" href="" style="background-color: rgb(0, 110, 255)" data-print-frame="boleta-contenedor"><i class="fa-solid fa-envelope"></i><span>Enviar por Correo</span></a>
</div>

@endsection