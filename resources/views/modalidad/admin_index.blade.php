@extends('layouts.index')

@section('title', 'Modalidades')
@section('main-title','Modalidades')

@section('main-content')

@if (session('success'))
    <p class="success-message"><i class="fa-solid fa-circle-check"></i><span>{{ session('success') }}</span></p>
@endif

@if ($modalidades->isEmpty())
    <p class="neutral-message">Ninguna Modalidad encontrado.</p>
@else
    <table class="curso-lista ">
        <thead>
            <tr>
                <th>Nombre de la Modalidad</th>
                <th>Descripcion</th>
                <th>Contenidos</th>
                <th>Activo</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($modalidades as $modalidad)
                <tr>
                    <td class="curso-nombre">{{ $modalidad->name }}</td>
                    <td class="curso-descripcion">{{ $modalidad->descripcion ?? 'N/A' }}</td>
                    <td class="curso-contenido">
                        @foreach ($modalidad->contenidos() as $contenido)
                        <span>{{$contenido[0]}}</span>
                        @endforeach
                    </td>
                    <td>
                        <input type="checkbox" id="modalidad-activo-{{$modalidad->id}}" class="modalidad-activo-toggle" data-modalidad-id="{{ $modalidad->id }}" {{ $modalidad->activo ? 'checked' : '' }}>
                        <label for="modalidad-activo-{{$modalidad->id}}"></label>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

@endsection