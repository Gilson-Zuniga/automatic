<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura Venta #{{ $factura->numero_factura }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        .header, .footer { text-align: center; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table, .table th, .table td { border: 1px solid black; }
        .table th, .table td { padding: 8px; text-align: center; }
        .totales { margin-top: 20px; width: 100%; text-align: right; }
        .totales td { padding: 5px; }
    </style>
</head>
<body>

<div class="header">
    <h2>Factura de Venta</h2>
    <p><strong>Número:</strong> {{ $factura->numero_factura }}</p>
    <p><strong>Fecha:</strong> {{ $factura->fecha }} &nbsp;&nbsp; <strong>Hora:</strong> {{ $factura->hora }}</p>
</div>

<hr>

<p><strong>Cliente:</strong> {{ $factura->empresa->nombre }}</p>

<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio Unitario</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @php $subtotal = 0; @endphp
        @foreach($factura->items as $index => $item)
            @php
                $itemSubtotal = $item->cantidad * $item->precio_unitario;
                $subtotal += $itemSubtotal;
            @endphp
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->catalogo->producto->nombre ?? 'N/A' }}</td>
                <td>{{ $item->cantidad }}</td>
                <td>${{ number_format($item->precio_unitario, 2) }}</td>
                <td>${{ number_format($itemSubtotal, 2) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<table class="totales">
    <tr>
        <td><strong>Subtotal:</strong> ${{ number_format($subtotal, 2) }}</td>
    </tr>
    <tr>
        <td><strong>IVA (19%):</strong> ${{ number_format($subtotal * 0.19, 2) }}</td>
    </tr>
    <tr>
        <td><strong>Total:</strong> ${{ number_format($subtotal * 1.19, 2) }}</td>
    </tr>
</table>

</body>
</html>
