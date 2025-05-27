@extends('adminlte::page')

@section('title', 'Crear Factura de Venta')

@section('content')
<div class="container-fluid">
    <h1>Crear Factura de Venta</h1>

    <form id="factura-form" method="POST" action="{{ route('facturas_ventas.store') }}">
        @csrf



            <div class="col-md-6">
                <label for="empresa_id">Empresa</label>
                <select name="empresa_id" class="form-control" required>
                    <option value="" disabled selected>Seleccione una empresa</option>
                    @foreach ($empresas as $empresa)
                        <option value="{{ $empresa->id }}">{{ $empresa->nombre }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <hr>

        <table class="table table-bordered" id="items-table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Descuento</th>
                    <th>Subtotal</th>
                    <th>
                        <button type="button" id="add-item" class="btn btn-success btn-sm">+</button>
                    </th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>

        <div class="row mb-3">
            <div class="col-md-4 offset-md-8">
                <label>Subtotal</label>
                <input type="text" id="subtotal-general" class="form-control" readonly>
                <label>Impuesto (19%)</label>
                <input type="text" id="impuesto-general" class="form-control" readonly>
                <label>Total</label>
                <input type="text" id="total-general" class="form-control" readonly>
            </div>
        </div>

        <input type="hidden" name="items_json" id="items-json">

        <div class="text-end">
            <button type="submit" class="btn btn-primary">Guardar Factura</button>
        </div>
    </form>
</div>
@stop

@section('js')
<script>
    const catalogo = @json($catalogo); // ← ¡CORRECTO!
</script>
<script src="{{ asset('js/factura_venta.js') }}"></script>
@stop

