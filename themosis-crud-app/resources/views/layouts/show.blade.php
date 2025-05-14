@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Detalles del Registro</h2>
    
    <div class="card">
        <div class="card-header">
            Información Personal
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">ID:</dt>
                <dd class="col-sm-9">{{ $person->id }}</dd>
                
                <dt class="col-sm-3">Nombre:</dt>
                <dd class="col-sm-9">{{ $person->nombre }}</dd>
                
                <dt class="col-sm-3">Apellido:</dt>
                <dd class="col-sm-9">{{ $person->apellido }}</dd>
                
                <dt class="col-sm-3">RUT:</dt>
                <dd class="col-sm-9">{{ $person->rut }}</dd>
                
                <dt class="col-sm-3">Fecha de Nacimiento:</dt>
                <dd class="col-sm-9">{{ date('d/m/Y', strtotime($person->fecha_nacimiento)) }}</dd>
                
                <dt class="col-sm-3">Fecha de Creación:</dt>
                <dd class="col-sm-9">{{ $person->created_at->format('d/m/Y H:i:s') }}</dd>
                
                <dt class="col-sm-3">Última Actualización:</dt>
                <dd class="col-sm-9">{{ $person->updated_at->format('d/m/Y H:i:s') }}</dd>
            </dl>
        </div>
        <div class="card-footer">
            <a href="{{ route('person.edit', $person->id) }}" class="btn btn-primary">Editar</a>
            <a href="{{ route('person.index') }}" class="btn btn-secondary">Volver al Listado</a>
            <form action="{{ route('person.destroy', $person->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Está seguro que desea eliminar este registro?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Eliminar</button>
            </form>
        </div>
    </div>
</div>
@endsection