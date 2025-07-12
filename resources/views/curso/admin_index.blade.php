@extends('layouts.index')

@section('title', 'Cursos')
@section('main-title','Cursos')

@section('main-content')

@if (session('success'))
    <p class="success-message"><i class="fa-solid fa-circle-check"></i><span>{{ session('success') }}</span></p>
@endif

<div class="tab-submenu">
    <a class="button" href="{{ route('cursos.create') }}" style="background-color: rgba(0, 76, 255, 0.852)"><i class="fa-solid fa-plus"></i><span>Nuevo Curso</span></a>
</div>

@if ($cursos->isEmpty())
    <p class="neutral-message">Ningun curso encontrado.</p>
@else

    <table class="curso-lista">
        <thead>
            <tr>
                <th>Nombre del Curso</th>
                <th>Descripcion</th>
                <th>Semestres</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cursos as $curso)
                <tr>
                    <td class="curso-nombre">{{ $curso->name }}</td>
                    <td class="curso-descripcion">{{ $curso->description ?? 'N/A' }}</td>
                    <td class="curso-semestres">{{ $curso->semestres }} {{ $curso->semestres > 1 ? 'semestres' : 'semestre' }}</td>
                    <td class="curso-acciones">
                        <a class="curso-ver" href="{{ route('cursos.show', $curso->id) }}"><i class="fa-solid fa-eye"></i></a>
                        <a class="curso-editar" href="{{ route('cursos.edit', $curso->id) }}"><i class="fa-solid fa-pen-to-square"></i></a>
                        <form action="{{ route('cursos.destroy', $curso->id) }}" method="POST">
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