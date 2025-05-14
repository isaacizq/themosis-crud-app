@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Crear Nuevo Registro</h2>
    
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    
    <form action="{{ route('person.store') }}" method="POST">
        @csrf
        
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
            @error('nombre')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label for="apellido" class="form-label">Apellido</label>
            <input type="text" class="form-control @error('apellido') is-invalid @enderror" id="apellido" name="apellido" value="{{ old('apellido') }}" required>
            @error('apellido')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label for="rut" class="form-label">RUT</label>
            <input type="text" class="form-control @error('rut') is-invalid @enderror" id="rut" name="rut" value="{{ old('rut') }}" placeholder="12.345.678-9" required>
            @error('rut')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div id="rut-error" class="error" style="display: none;"></div>
            <small class="form-text text-muted">Formato: 12.345.678-9</small>
        </div>
        
        <div class="mb-3">
            <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
            <input type="date" class="form-control @error('fecha_nacimiento') is-invalid @enderror" id="fecha_nacimiento" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" required>
            @error('fecha_nacimiento')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <button type="submit" class="btn btn-success">Guardar</button>
            <a href="{{ route('person.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection