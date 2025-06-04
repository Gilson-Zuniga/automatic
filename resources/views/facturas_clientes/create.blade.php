@extends('adminlte::page')

@section('title', 'Crear Factura de Cliente')

@section('content')
<div class="container-fluid">
    <h1>Crear Factura de Cliente</h1>

    <form id="factura-form" method="POST" action="{{ route('facturas_clientes.store') }}">
        @csrf
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="empresa_id">Empresa (Cliente)</label>
                <select name="empresa_id" id="empresa_id" class="form-control" required>
                    <option value="" disabled selected>Seleccione una empresa</option>
                    @foreach ($empresas as $empresa)
                        <option value="{{ $empresa->nit }}">{{ $empresa->nombre }}</option>
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
                <input type="text" id="subtotal-general" class="form-control" readonly value="0">
                <label>Impuesto (19%)</label>
                <input type="text" id="impuesto-general" class="form-control" readonly value="0">
                <label>Total</label>
                <input type="text" id="total-general" class="form-control" readonly value="0">
            </div>
        </div>

        <input type="hidden" name="items_json" id="items-json">

        <div class="text-end">
            <button type="submit" class="btn btn-primary">Guardar Factura</button>
        </div>
    </form>
</div>
@endsection

@section('js')
<script>
    const catalogo = @json($catalogo); 
</script>
<script src="{{ asset('js/factura_venta.js') }}"></script>
@endsection
