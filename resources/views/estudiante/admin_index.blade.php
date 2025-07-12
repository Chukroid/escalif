@extends('layouts.index')

@section('title', 'Estudiantes')
@section('main-title','Estudiantes')

@section('main-content')

@if (session('success'))
    <p class="success-message"><i class="fa-solid fa-circle-check"></i><span>{{ session('success') }}</span></p>
@endif

<div class="tab-submenu">
    <a class="button" href="{{ route('estudiantes.create') }}" style="background-color: rgba(0, 76, 255, 0.852)"><i class="fa-solid fa-plus"></i><span>Nuevo Estudiante</span></a>
</div>

@if ($estudiantes->isEmpty())
    <p class="neutral-message">Ningun Estudiante encontrado.</p>
@else

    <table class="curso-lista">
        <thead>
            <tr>
                <th>Matricula</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($estudiantes as $estudiante)
                <tr>
                    <td class="curso-descripcion">{{ $estudiante->matricula }}</td>
                    <td class="curso-nombre">{{ $estudiante->user->name }}</td>
                    <td class="curso-descripcion">{{ $estudiante->user->email ?? 'N/A' }}</td>
                    <td class="curso-acciones">
                        <a class="curso-ver" href="{{ route('estudiantes.show', $estudiante->id) }}"><i class="fa-solid fa-eye"></i></a>
                        <a class="curso-editar" href="{{ route('estudiantes.edit', $estudiante->id) }}"><i class="fa-solid fa-pen-to-square"></i></a>
                        <form action="{{ route('estudiantes.destroy', $estudiante->id) }}" method="POST">
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