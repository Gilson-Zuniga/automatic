@extends('adminlte::page')

@section('title', 'Inventario')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Inventario</h1>

    <!-- Formulario de búsqueda -->
    <form method="GET" action="{{ route('inventario.index') }}" class="mb-3">
        <div class="input-group">
            <input type="text" name="buscar" class="form-control" placeholder="Buscar por producto o proveedor" value="{{ request('buscar') }}">
            <button class="btn btn-info" type="submit">Buscar</button>
        </div>
    </form>

    <!-- Tabla de inventario -->
    <div class="table-responsive">
        <table class="table ">
            <thead class="table-primary">
                <tr>
                    <th>ID</th>
                    <th>Producto</th>
                    <th>Proveedor</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Actualizado</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($inventario as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->producto->nombre ?? 'N/A' }}</td>
                        <td>{{ $item->proveedor->nombre ?? 'N/A' }}<br><small>{{ $item->proveedor_nit }}</small></td>
                        <td>{{ $item->cantidad }}</td>
                        <td>$ {{ number_format($item->precio_unitario, 2) }}</td>
                        <td>{{ $item->updated_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">No se encontraron resultados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div class="d-flex justify-content-center">
        {{ $inventario->withQueryString()->links() }}
    </div>
</div>
@endsection
