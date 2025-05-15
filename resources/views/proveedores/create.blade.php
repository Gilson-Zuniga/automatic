@extends('adminlte::page')

@section('title', isset($proveedor) ? 'Editar Proveedor' : 'Nuevo Proveedor')

@section('content')
    <h1>{{ isset($proveedor) ? 'Editar' : 'Registrar' }} Proveedor</h1>

    <form action="{{ isset($proveedor) ? route('proveedores.update', $proveedor->nit) : route('proveedores.store') }}" method="POST">
        @csrf
        @if(isset($proveedor)) @method('PUT') @endif

        <div class="mb-3">
            <label for="nit">NIT</label>
            <input type="text" name="nit" class="form-control" value="{{ old('nit', $proveedor->nit ?? '') }}" {{ isset($proveedor) ? 'readonly' : '' }}>
        </div>

        <div class="mb-3">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $proveedor->nombre ?? '') }}">
        </div>

        <div class="mb-3">
            <label for="direccion">Dirección</label>
            <input type="text" name="direccion" class="form-control" value="{{ old('direccion', $proveedor->direccion ?? '') }}">
        </div>

        <div class="mb-3">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $proveedor->email ?? '') }}">
        </div>

        <div class="mb-3">
            <label for="telefono">Teléfono</label>
            <input type="text" name="telefono" class="form-control" value="{{ old('telefono', $proveedor->telefono ?? '') }}">
        </div>

        <div class="mb-3">
            <label for="ciudad">Ciudad</label>
            <input type="text" name="ciudad" class="form-control" value="{{ old('ciudad', $proveedor->ciudad ?? '') }}">
        </div>

        <div class="mb-3">
            <label for="rut">RUT</label>
            <input type="text" name="rut" class="form-control" value="{{ old('rut', $proveedor->rut ?? '') }}">
        </div>

        <button class="btn btn-success">{{ isset($proveedor) ? 'Actualizar' : 'Guardar' }}</button>
    </form>
@endsection
