@extends('adminlte::page')

@section('title', 'Perfil de Empresa')

@section('content')
<main class="container-fluid">
    <h1 class="mb-4">Perfil de Empresa</h1>

    <form method="GET" action="{{ route('perfilEmpresas.index') }}" class="mb-3">
        <div class="row">
            <div class="col-md-6">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crear">
                    Crear Empresa
                </button>
            </div>
        </div>
    </form>

    {{-- Modal CREAR --}}
    <div class="modal fade" id="crear" tabindex="-1" aria-labelledby="crearLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('perfilEmpresas.store') }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="crearLabel">Registrar Empresa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    @include('perfilEmpresas._form')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabla --}}
    <div class="table-responsive mt-4">
        <table class="table table-bordered">
            <thead class="table-primary">
                <tr>
                    <th>NIT</th>
                    <th>Nombre</th>
                    <th>Dirección</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Ciudad</th>
                    <th colspan="2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($empresas as $empresa)
                    <tr>
                        <td>{{ $empresa->nit }}</td>
                        <td>{{ $empresa->nombre }}</td>
                        <td>{{ $empresa->direccion }}</td>
                        <td>{{ $empresa->email }}</td>
                        <td>{{ $empresa->telefono }}</td>
                        <td>{{ $empresa->ciudad }}</td>
                        <td>
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editar{{ $empresa->nit }}">
                                Editar
                            </button>

                            {{-- Modal EDITAR --}}
                            <div class="modal fade" id="editar{{ $empresa->nit }}" tabindex="-1" aria-labelledby="editarLabel{{ $empresa->nit }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ route('perfilEmpresas.update', $empresa->nit) }}" method="POST" class="modal-content">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title" id="editarLabel{{ $empresa->nit }}">Editar Empresa</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            @include('perfilEmpresas._form', ['empresa' => $empresa])
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-success">Actualizar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </td>
                        <td>
                            <form id="form-eliminar-{{ $empresa->nit }}" action="{{ route('perfilEmpresas.destroy', $empresa->nit) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmarEliminacion('{{ $empresa->nit }}')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Paginación --}}
        {{ $empresas->links() }}
    </div>
</main>

{{-- Alertas con SweetAlert --}}
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
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)