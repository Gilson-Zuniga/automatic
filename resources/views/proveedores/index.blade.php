@extends('adminlte::page')

@section('title', 'Proveedores')

@section('content')

<main class="container-fluid">
    <h1>Registro Proveedores</h1>
    <form method="GET" action="{{ route('proveedores.index') }}" class="mb-3">
        <div class="row align-items-center g-2">
            <!-- Columna izquierda: botón "Nuevo Producto" -->
            <div class="col-md-6">
                <div class="d-flex">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crear">
                        Nuevo Provedor
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

    <!-- Modal CREAR-CRUD -->
    <div class="modal fade" id="crear" tabindex="-1" aria-labelledby="crearLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('proveedores.store') }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="crearLabel">Registrar Proveedor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @include('proveedores._form')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de proveedores LEER/EDITAR/ELIMINAR-CRUD -->
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="table-primary">
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
                            <!-- Botón para abrir modal EDITAR -->
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editar{{ $proveedor->nit }}">
                                Editar
                            </button>

                            <!-- Modal EDITAR -->
                            <div class="modal fade" id="editar{{ $proveedor->nit }}" tabindex="-1" aria-labelledby="editarLabel{{ $proveedor->nit }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ route('proveedores.update', $proveedor->nit) }}" method="POST" class="modal-content">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title" id="editarLabel{{ $proveedor->nit }}">Editar Proveedor</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            @include('proveedores._form', ['proveedor' => $proveedor])
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
                            <form id="form-eliminar-{{ $proveedor->nit }}" action="{{ route('proveedores.destroy', $proveedor->nit) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger" onclick="confirmarEliminacion('{{ $proveedor->nit }}')">Eliminar</button>
                            </form>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <!-- Paginación -->
        <div>
            {{ $proveedores->appends(request()->query())->links() }}
        </div>
    </div>
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
    <script src="{{ asset('js/proveedores.js') }}"></script>
@endsection

@section('plugins.Select2', true)
