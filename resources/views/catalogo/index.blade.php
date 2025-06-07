@extends('adminlte::page')

@section('title', 'Catálogo')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Gestión del Catálogo</h1>

    <form method="GET" action="{{ route('catalogo.index') }}" class="row mb-3">
        <div class="col-md-2">
            <input type="text" name="id" class="form-control" placeholder="ID" value="{{ request('id') }}">
        </div>
        <div class="col-md-2">
            <input type="text" name="proveedor" class="form-control" placeholder="Proveedor" value="{{ request('proveedor') }}">
        </div>
        <div class="col-md-2">
            <input type="text" name="categoria" class="form-control" placeholder="Categoría" value="{{ request('categoria') }}">
        </div>
        <div class="col-md-2">
            <input type="text" name="tipo" class="form-control" placeholder="Tipo Artículo" value="{{ request('tipo') }}">
        </div>
        <div class="col-md-2">
            <input type="text" name="nombre" class="form-control" placeholder="Nombre Producto" value="{{ request('nombre') }}">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-info w-100">Buscar</button>
        </div>
    </form>

    <table class="table ">
        <thead class="table-primary">
            <tr>
                <th>ID</th>
                <th>Producto</th>
                <th>Proveedor</th>
                <th>Categoría</th>
                <th>Tipo de Artículo</th>
                <th>Foto</th>
                <th>Cantidad</th>
                <th>Precio Venta <small>(IVA Incluido)</small></th>
                <th>Descuento</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($catalogos as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->producto->nombre }}</td>
                    <td>{{ $item->proveedor->nombre }}</td>
                    <td>{{ $item->categoria->nombre }}</td>
                    <td>{{ $item->tipoArticulo->nombre }}</td>
                    <td>
                        @if($item->foto)
                            <img src="{{ asset('storage/' . $item->foto) }}" alt="foto" width="50">
                        @endif
                    </td>
                    <td>{{ $item->cantidad }}</td>
                    <td>${{ number_format($item->valor, 2) }}</td>
                    <td>{{ $item->descuento ? $item->descuento . '%' : '—' }}</td>
                    <td>
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editarModal{{ $item->id }}">
                            Editar
                        </button>
                    </td>
                </tr>

                {{-- Modal de edición --}}
                <div class="modal fade" id="editarModal{{ $item->id }}" tabindex="-1" aria-labelledby="editarModalLabel{{ $item->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="{{ route('catalogo.update', $item->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title">Editar Catálogo: {{ $item->producto->nombre }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    @include('catalogo._form', ['item' => $item])
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Guardar</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $catalogos->appends(request()->query())->links() }}
    </div>
</div>
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
@endsection
@section('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
