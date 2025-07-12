@extends('layouts.index')

@section('title', 'Profesores')
@section('main-title','Profesores')

@section('main-content')

@if (session('success'))
    <p class="success-message"><i class="fa-solid fa-circle-check"></i><span>{{ session('success') }}</span></p>
@endif

<div class="tab-submenu">
    <a class="button" href="{{ route('profesores.create') }}" style="background-color: rgba(0, 76, 255, 0.852)"><i class="fa-solid fa-plus"></i><span>Nuevo Profesor</span></a>
</div>

@if ($profesores->isEmpty())
    <p class="neutral-message">Ningun Profesor encontrado.</p>
@else

    <table class="curso-lista">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Correo</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($profesores as $profesor)
                <tr>
                    <td class="curso-nombre">{{ $profesor->name }}</td>
                    <td class="curso-descripcion">{{ $profesor->email ?? 'N/A' }}</td>
                    <td class="curso-acciones">
                        <a class="curso-editar" href="{{ route('profesores.edit', $profesor->id) }}"><i class="fa-solid fa-pen-to-square"></i></a>
                        <form action="{{ route('profesores.destroy', $profesor->id) }}" method="POST">
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