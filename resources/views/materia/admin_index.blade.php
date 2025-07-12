@extends('layouts.index')

@section('title', 'Cursos')
@section('main-title','Cursos')

@section('main-content')

@if (session('success'))
    <p class="success-message"><i class="fa-solid fa-circle-check"></i><span>{{ session('success') }}</span></p>
@endif

<div class="tab-submenu">
    <a class="button" href="{{ route('materias.create') }}" style="background-color: rgba(0, 76, 255, 0.852)"><i class="fa-solid fa-plus"></i><span>Nueva Materia</span></a>
</div>

@if ($materias->isEmpty())
    <p class="neutral-message">Ninguna Materia encontrado.</p>
@else

    <table class="curso-lista ">
        <thead>
            <tr>
                <th>Nombre de la Materia</th>
                <th>Descripcion</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($materias as $materia)
                <tr>
                    <td class="curso-nombre">{{ $materia->name }}</td>
                    <td class="curso-descripcion">{{ $materia->description ?? 'N/A' }}</td>
                    <td class="curso-acciones">
                        <a class="curso-editar" href="{{ route('materias.edit', $materia->id) }}"><i class="fa-solid fa-pen-to-square"></i></a>
                        <form action="{{ route('materias.destroy', $materia->id) }}" method="POST">
                            @csrf
                            @method('DELETE') {{-- Required for DELETE method --}}
                            <button class="curso-eliminar" type="submit">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

@endsection