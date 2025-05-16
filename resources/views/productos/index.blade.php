@extends('adminlte::page')

@section('title', 'Productos')

@section('content')
<main class="container-fluid">
    <h1>Registro Productos</h1>

    <!-- Botón para abrir modal CREAR -->
    <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#crear">
        Nuevo Producto
    </button>

    <!-- Modal CREAR-CRUD -->
    <div class="modal fade" id="crear" tabindex="-1" aria-labelledby="crearLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data" class="modal-content">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="crearLabel">Registrar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @include('productos._form')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de productos LEER/EDITAR/ELIMINAR-CRUD -->
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="table-primary">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Categoría</th>
                    <th>Descripción</th>
                    <th>Proveedor</th>
                    <th>Imagen</th>
                    <th colspan="2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($productos as $producto)
                    <tr>
                        <td>{{ $producto->id }}</td>
                        <td>{{ $producto->nombre }}</td>
                        <td>${{ number_format($producto->precio, 2) }}</td>
                        <td>{{ $producto->categoria }}/{{ $producto->tipo_articulo }}</td>
                        <td>{{ $producto->descripcion }}</td>
                        <td>{{ $producto->proveedor->nombre ?? 'Sin proveedor' }}</td>
                        <td>
                            @if($producto->foto)
                                <img src="{{ asset('storage/' . $producto->foto) }}" width="80">
                            @else
                                Sin imagen
                            @endif
                        </td>
                        <td>
                            <!-- Botón para abrir modal EDITAR -->
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editar{{ $producto->id }}">
                                Editar
                            </button>

                            <!-- Modal EDITAR -->
                            <div class="modal fade" id="editar{{ $producto->id }}" tabindex="-1" aria-labelledby="editarLabel{{ $producto->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ route('productos.update', $producto->id) }}" method="POST" enctype="multipart/form-data" class="modal-content">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title" id="editarLabel{{ $producto->id }}">Editar Producto</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            @include('productos._form', ['producto' => $producto])
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-success">Actualizar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </td>
                        <td>
                            <!-- Botón para ELIMINAR-CRUD -->
                            <form id="form-eliminar-{{ $producto->id }}" action="{{ route('productos.destroy', $producto->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger" onclick="confirmarEliminacion('{{ $producto->id }}')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</main>
<div id="flash-data" 
    data-success="{{ session('success') }}" 
    data-error="{{ session('error') }}">
</div>
@endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/script.js') }}"></script>
@endsection

@section('plugins.Select2', true)