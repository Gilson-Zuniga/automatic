@extends('adminlte::page')

@section('title', 'Categorías')

@section('content')
@if (session('success') || session('error'))
    <div id="flash-data"
        data-success="{{ session('success') }}"
        data-error="{{ session('error') }}">
    </div>
@endif

<main class="container-fluid">
    <h1>Gestión de Categorías</h1>

    <form method="GET" action="{{ route('categorias.index') }}" class="mb-3">
        <div class="row align-items-center g-2">
            <!-- Columna izquierda: botón "Nuevo Producto" -->
            <div class="col-md-6">
                <div class="d-flex">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearCategoria">
                        Nuevo Categoría
                    </button>
                    <button type="button" class="btn btn-secondary ml-1 S" onclick="window.location.href='{{ route('tipoArticulos.index') }}'">
                        Artículos
                    </button>
                </div>
            </div>
            


            <!-- Columna derecha: filtros -->
            <div class="col-md-6">
                <div class="d-flex justify-content-end align-items-center gap-2">
                    <!-- Select de paginación -->
                    <select name="perPage" class="form-select w-auto" onchange="this.form.submit()">
                        <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
                        <option value="20" {{ request('perPage') == 20 ? 'selected' : '' }}>20</option>
                        <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50</option>
                    </select>

                    <!-- Input de búsqueda -->
                    <input type="text" name="buscar" class="form-control w-auto" style="min-width: 250px;" placeholder="Buscar por ID, Nombre o Categoría" value="{{ request('buscar') }}">

                    <!-- Botón buscar -->
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </div>
            </div>
        </div>
    </form>

    <!-- Modal CREAR Categoría -->
    <div class="modal fade" id="crearCategoria" tabindex="-1" aria-labelledby="crearCategoriaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('categorias.store') }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="crearCategoriaLabel">Nueva Categoría</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @include('categorias._form')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de Categorías con Tipos -->
    <div class="table-responsive">
        <table class="table ">
            <thead class="table-primary">
                <tr>
                    <th>Nombre </th>
                    <th>Tipo Artículos </th>
                    <th colspan="2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categorias as $categoria)
                    <tr>
                        <td><strong>{{ $categoria->nombre }}</strong></td>
                        <td>
                            <ul>
                                @foreach($categoria->tipoArticulos as $tipo)
                                    <li>{{ $tipo->nombre }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            <!-- Botón Editar -->
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editarCategoria{{ $categoria->id }}">
                                Editar
                            </button>

                            <!-- Modal Editar -->
                            <div class="modal fade" id="editarCategoria{{ $categoria->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <form action="{{ route('categorias.update', $categoria->id) }}" method="POST" class="modal-content">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title">Editar Categoría</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            @include('categorias._formEditar', ['categoria' => $categoria])
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-success">Actualizar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- Botón Eliminar -->
                            <form id="form-eliminar-{{ $categoria->id }}" action="{{ route('categorias.destroy', $categoria->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmarEliminacion({{ $categoria->id }})">
                                Eliminar
                            </button>
                        </form>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $categorias->links() }}
    </div>
</main>
@endsection
@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css">
@section('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/categorias.js') }}"></script>
<script src="{{ asset('js/categoriaArticulos.js') }}"></script>

@endsection
