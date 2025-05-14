@extends('adminlte::page')

@section('title', 'Proveedores')

@section('content')


    

    <main class="container-fluid">
        <a href="{{ route('proveedores.create') }}" class="btn btn-success mb-3 mt-3">Nuevo Proveedor</a>
        <div class="table responsive">
                <table class="table table">
        <thead class="table table-primary">
            <tr>
                <th colspan="9" class="text-center">Proveedores</th>
            <tr>
                <th>NIT</th>
                <th>Nombre</th>
                <th>Dirección</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Ciudad</th>
                <th>RUT</th>
                <th colspan="2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($proveedores as $proveedor)
                <tr>
                    <td>{{ $proveedor->nit }}</td>
                    <td>{{ $proveedor->nombre }}</td>
                    <td>{{ $proveedor->direccion }}</td>
                    <td>{{ $proveedor->email }}</td>
                    <td>{{ $proveedor->telefono }}</td>
                    <td>{{ $proveedor->ciudad }}</td>
                    <td>{{ $proveedor->rut }}</td>
                    <td>
                        <a href="{{ route('proveedores.edit', $proveedor->nit) }}" class="btn btn-warning btn-sm">Editar</a>
                    </td>
                    <td>
                        <form action="{{ route('proveedores.destroy', $proveedor->nit) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar proveedor?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
        </div>



    </main>
@endsection
