<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura Cliente #{{ $factura->numero_factura }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        .no-border { border: none; }
        .right { text-align: right; }
        .center { text-align: center; }
    </style>
</head>
<body>
    <h2>Factura Cliente #{{ $factura->numero_factura }}</h2>
    <p><strong>Generada el:</strong> {{ $factura->created_at->format('d/m/Y H:i:s') }}</p>

    <hr>

    <h4>Información de Empresa</h4>
    <p><strong>Nombre:</strong> {{ $factura->empresa->nombre ?? 'N/A' }}</p>
    <p><strong>NIT:</strong> {{ $factura->empresa->nit ?? 'N/A' }}</p>
    <p><strong>Dirección:</strong> {{ $factura->empresa->direccion ?? 'N/A' }}</p>

    <h4>Detalles de la Factura</h4>
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Descuento</th>
                <th>Impuesto</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($factura->items as $item)
            <tr>
                <td>{{ $item->producto->nombre ?? 'N/A' }}</td>
                <td>{{ $item->cantidad }}</td>
                <td>${{ number_format($item->precio_unitario, 2) }}</td>
                <td>${{ number_format($item->descuento, 2) }}</td>
                <td>${{ number_format($item->impuesto, 2) }}</td>
                <td>${{ number_format($item->subtotal, 2) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <br>
    <table style="width: 300px; float: right;">
        @php
            $subtotal = $factura->items->sum('subtotal') - $factura->items->sum('impuesto');
            $impuesto = $factura->items->sum('impuesto');
            $total = $factura->items->sum('subtotal');
        @endphp
        <tr>
            <td class="right"><strong>Subtotal:</strong></td>
            <td class="right">${{ number_format($subtotal, 2) }}</td>
        </tr>
        <tr>
            <td class="right"><strong>IVA (19%):</strong></td>
            <td class="right">${{ number_format($impuesto, 2) }}</td>
        </tr>
        <tr>
            <td class="right"><strong>Total:</strong></td>
            <td class="right"><strong>${{ number_format($total, 2) }}</strong></td>
        </tr>
    </table>

    <div style="clear: both;"></div>
    <p class="center" style="margin-top: 50px;">Gracias por su compra</p>
</body>
</html>
