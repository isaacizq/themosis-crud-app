@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Listado de Personas</h2>
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('person.create') }}" class="btn btn-primary">Crear Nuevo</a>
    </div>
    
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>RUT</th>
                    <th>Fecha de Nacimiento</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($persons as $person)
                <tr>
                    <td>{{ $person->id }}</td>
                    <td>{{ $person->nombre }}</td>
                    <td>{{ $person->apellido }}</td>
                    <td>{{ $person->rut }}</td>
                    <td>{{ date('d/m/Y', strtotime($person->fecha_nacimiento)) }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('person.show', $person->id) }}" class="btn btn-info btn-sm">Ver</a>
                            <a href="{{ route('person.edit', $person->id) }}" class="btn btn-primary btn-sm">Editar</a>
                            <form action="{{ route('person.destroy', $person->id) }}" method="POST" onsubmit="return confirm('¿Está seguro que desea eliminar este registro?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">No hay registros disponibles</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection