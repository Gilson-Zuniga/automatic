@extends('adminlte::page')

@section('title', 'Facturas de Proveedores')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

@if (session('success') || session('error'))
    <div id="flash-data"
        data-success="{{ session('success') }}"
        data-error="{{ session('error') }}">
    </div>
@endif

<div class="container-fluid">
    <h1 class="mb-4">Listado de Facturas de Proveedores</h1>

    <a href="{{ route('facturas_proveedores.create') }}" class="btn btn-primary mb-3">+ Nueva Factura</a>

    <table class="table ">
        <thead class="table-primary">
            <tr>
                <th>ID</th>
                <th>Número</th>
                <th>Fecha</th>
                <th>Proveedor</th>
                <th>Total</th>
                <th>PDF</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($facturas as $factura)
            <tr id="factura-row-{{ $factura->id }}">
                <td>{{ $factura->id }}</td>
                <td>{{ $factura->numero_factura }}</td>
                <td>{{ $factura->fecha }}</td>
                <td>{{ $factura->proveedor->nombre ?? 'N/A' }}</td>
                <td>${{ number_format($factura->total, 2) }}</td>
                <td>
                    @if($factura->pdf_path)
                        <a href="{{ route('facturas_proveedores.pdf', $factura) }}" class="btn btn-sm btn-secondary" target="_blank">
                            Ver PDF
                        </a>
                    @else
                        <span class="text-muted">No disponible</span>
                    @endif
                </td>
                <td>
                    <!-- Botón para ELIMINAR-CRUD -->
                            <form id="form-eliminar-{{ $factura->id }}" action="{{ route('facturas_proveedores.destroy', $factura->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" >Eliminar</button>
                            </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="mt-3">
        {{ $facturas->links() }}
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/facturas_index.js') }}"></script>
@endsection
