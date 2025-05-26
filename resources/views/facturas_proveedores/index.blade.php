@extends('adminlte::page')

@section('title', 'Facturas de Proveedores')

@section('content')
@if (session('success') || session('error'))
    <div id="flash-data"
        data-success="{{ session('success') }}"
        data-error="{{ session('error') }}">
    </div>
@endif

<div class="container-fluid">
    <h1 class="mb-4">Listado de Facturas de Proveedores</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('facturas_proveedores.create') }}" class="btn btn-primary mb-3">+ Nueva Factura</a>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
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
            <tr>
                <td>{{ $factura->id }}</td>
                <td>{{ $factura->numero_factura }}</td>
                <td>{{ $factura->fecha }}</td>
                <td>{{ $factura->proveedor->nombre ?? 'N/A' }}</td>
                <td>${{ number_format($factura->total, 2) }}</td>
                <td>
                    @if($factura->pdf_path)
                        <a href="{{ route('facturas_proveedores.pdf', $factura) }}" class="btn btn-sm btn-outline-secondary" target="_blank">
                            Ver PDF
                        </a>
                    @else
                        <span class="text-muted">No disponible</span>
                    @endif
                </td>
                <td>
                    
                    <button class="btn btn-sm btn-danger btn-eliminar" 
    data-id="{{ $factura->id }}" 
    data-nombre="{{ $factura->numero_factura }}">
    Eliminar
</button>

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
<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/factura.js') }}"></script>

