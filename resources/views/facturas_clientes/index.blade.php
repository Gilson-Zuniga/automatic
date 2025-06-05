@extends('adminlte::page')

@section('title', 'Facturas de Clientes')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

@if (session('success') || session('error'))
    <div id="flash-data"
        data-success="{{ session('success') }}"
        data-error="{{ session('error') }}">
    </div>
@endif

<div class="container-fluid">
    <h1 class="mb-4">Listado de Facturas de Clientes</h1>

    <a href="{{ route('facturas_clientes.create') }}" class="btn btn-primary mb-3">+ Nueva Factura</a>

    <table class="table">
        <thead class="table-primary">
            <tr>
                <th>ID Factura</th>
                <th>Cliente</th>
                <th>Fecha</th>
                <th>Total</th>
                <th>PDF</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($facturas as $factura)
            <tr id="factura-row-{{ $factura->id }}">
                <td>{{ $factura->id }}</td>
                <td>{{ $factura->empresa->nombre ?? 'N/A' }}</td>
                <td>{{ $factura->created_at }}</td>
                <td>${{ number_format($factura->total, 2) }}</td>
                <td>
                    @if($factura->pdf && file_exists(public_path($factura->pdf)))
                        <a href="{{ route('facturas_clientes.descargarPDF', $factura) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                            Ver PDF
                        </a>
                    @else
                        <span class="text-muted">No disponible</span>
                    @endif
                </td>



                <td>
                    <form id="form-eliminar-{{ $factura->id }}" action="{{ route('facturas_clientes.destroy', $factura->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/facturas_venta_index.js') }}"></script>
@endsection
