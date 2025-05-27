@extends('adminlte::page')

@section('title', 'Crear Factura Proveedor')

@section('content')
<div class="container-fluid">
    <h1>Registrar Factura Proveedor</h1>

    <form action="{{ route('facturas_proveedores.store') }}" method="POST" id="factura-form">
        @csrf

        <div class="row">
            <div class="col-md-6">
                <label>Número de Factura</label>
                <input type="text" name="numero_factura" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label>Fecha</label>
                <input type="date" name="fecha" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label>Proveedor</label>
                <select name="proveedor_nit" class="form-control" required>
                    <option value="">Seleccione</option>
                    @foreach($proveedores as $proveedor)
                        <option value="{{ $proveedor->nit }}">{{ $proveedor->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label>Empresa (Cliente)</label>
                <select name="cliente_nit" class="form-control" required>
                    <option value="">Seleccione</option>
                    @foreach($clientes as $cliente)
                        <option value="{{ $cliente->nit }}">{{ $cliente->nombre }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <hr>

        <h4>Ítems</h4>
        <table class="table table-bordered" id="items-table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Subtotal</th>
                    <th><button type="button" class="btn btn-success btn-sm" id="add-item">+</button></th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
        <div class="row justify-content-end" style="max-width: 400px; margin-left: auto;">
            <div class="col-6">
                <label>Subtotal</label>
                <input type="number" id="subtotal-general" class="form-control" readonly value="0">
            </div>
            <div class="col-6">
                <label>IVA (19%)</label>
                <input type="number" id="impuesto-general" class="form-control" readonly value="0">
            </div>
            <div class="col-6 mt-2">
                <label>Total</label>
                <input type="number" id="total-general" class="form-control" readonly value="0">
            </div>
        </div>



        <input type="hidden" name="items_json" id="items-json">

        <button type="submit" class="btn btn-success">Guardar Factura</button>
        <a href="{{ route('facturas_proveedores.index') }}" class="btn btn-danger">Cancelar</a>
    </form>
</div>
@endsection

@section('js')
<script>
    const productos = @json($productos);
</script>
<script src="{{ asset('js/factura.js') }}"></script>

@endsection
