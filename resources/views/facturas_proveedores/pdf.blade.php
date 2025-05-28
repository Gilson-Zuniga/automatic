<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura #{{ $factura->numero_factura }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header, .footer { text-align: center; }
        .total { text-align: right; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Factura de Proveedor</h2>
        <p><strong>Número:</strong> {{ $factura->numero_factura }}</p>
        <p><strong>Fecha:</strong> {{ $factura->fecha }}</p>
    </div>

    <hr>

    <p><strong>Proveedor:</strong> {{ $factura->proveedor->nombre ?? 'N/A' }}</p>
    <p><strong>NIT Proveedor:</strong> {{ $factura->proveedor_nit }}</p>
    <p><strong>Cliente:</strong> {{ $factura->cliente->nombre ?? 'N/A' }}</p>
    <p><strong>NIT Cliente:</strong> {{ $factura->cliente_nit }}</p>

    <h4>Detalle de Ítems</h4>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Impuesto</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($factura->items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->producto->nombre ?? 'Producto eliminado' }}</td>
                    <td>{{ $item->cantidad }}</td>
                    <td>${{ number_format($item->precio_unitario, 2) }}</td>
                    <td>{{ $item->impuesto }}%</td>
                    <td>${{ number_format($item->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p class="total">Total Factura: ${{ number_format($factura->total, 2) }}</p>

    <div class="footer">
        <p>Generado el {{ now()->format('d/m/Y H:i') }}</p>
    </div>
</body>
</html>
