@extends('adminlte::page')

@section('title', 'Tipos de Artículos')

@section('content')
@if (session('success') || session('error'))
    <div id="flash-data"
        data-success="{{ session('success') }}"
        data-error="{{ session('error') }}">
    </div>
@endif

<main class="container-fluid">
    <h1>Gestión de Tipos de Artículos</h1>

    <form method="GET" action="{{ route('tipoArticulos.index') }}" class="mb-3">
        <div class="row align-items-center g-2">
            <div class="col-md-6">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#creartipoArticulo">
                    Nuevo Tipo de Artículo
                </button>
                <button type="button" class="btn btn-secondary ml-1 S" onclick="window.location.href='{{ route('categorias.index') }}'">
                        Categorias
                    </button>
            </div>
            <div class="col-md-6 d-flex justify-content-end align-items-center gap-2">
                <select name="perPage" class="form-select w-auto" onchange="this.form.submit()">
                    <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
                    <option value="20" {{ request('perPage') == 20 ? 'selected' : '' }}>20</option>
                    <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50</option>
                </select>
                <input type="text" name="buscar" class="form-control w-auto" style="min-width: 250px;" placeholder="Buscar por nombre" value="{{ request('buscar') }}">
                <button type="submit" class="btn btn-primary">Buscar</button>
            </div>
        </div>
    </form>

    <!-- Modal CREAR Tipo Articulo -->
    <div class="modal fade" id="creartipoArticulo" tabindex="-1" aria-labelledby="crearArticuloLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('tipoArticulos.store') }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Nuevo Tipo de Artículo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @include('tipoArticulos._form')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla -->
    <div class="table-responsive mt-3">
        <table class="table">
            <thead class="table-primary">
                <tr>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th colspan="2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tipoArticulos as $tipoArticulo)
                    <tr>
                        <td>{{ $tipoArticulo->nombre }}</td>
                        <td>{{ $tipoArticulo->categoria->nombre ?? '-' }}</td>
                        <td>
                            <!-- Botón Editar -->
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editartipoArticulo{{ $tipoArticulo->id }}">
                                Editar
                            </button>

                            <!-- Modal Editar -->
                            <div class="modal fade" id="editartipoArticulo{{ $tipoArticulo->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <form action="{{ route('tipoArticulos.update', $tipoArticulo->id) }}" method="POST" class="modal-content">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title">Editar Tipo de Artículo</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            @include('tipoArticulos._form', ['tipoArticulo' => $tipoArticulo])
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
                            <form action="{{ route('tipoArticulos.destroy', $tipoArticulo->id) }}" method="POST" class="d-inline eliminar-formulario">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-center">
            {{ $tipoArticulos->links('pagination::bootstrap-5') }}
        </div>
    </div>
</main>
@endsection

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<style>
    .pagination .page-link {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
    }
</style>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/tipoArticulos.js') }}"></script>
@endsection
