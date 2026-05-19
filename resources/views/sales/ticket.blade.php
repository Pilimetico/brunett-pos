<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ticket #{{ $sale->invoice_number }}</title>
    <style>
        body { font-family: 'Courier New', Courier, monospace; font-size: 12px; margin: 0; padding: 20px; width: 80mm; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 18px; }
        .details { margin-bottom: 15px; border-bottom: 1px dashed #000; padding-bottom: 10px; }
        .table { width: 100%; margin-bottom: 15px; }
        .table th { text-align: left; border-bottom: 1px solid #000; }
        .totals { text-align: right; margin-top: 10px; border-top: 1px dashed #000; padding-top: 10px; }
        .footer { text-align: center; margin-top: 30px; font-size: 10px; }
        @media print {
            body { padding: 0; width: 80mm; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; cursor: pointer;">Imprimir Ticket</button>
        <a href="{{ route('pos.index') }}" style="margin-left: 10px;">Volver al POS</a>
    </div>

    <div class="header">
        <h1>BRUNETT ECUADOR</h1>
        <p>ATGU SAS<br>RUC: 1793084323001<br>Quito, Ecuador</p>
    </div>

    <div class="details">
        <p><strong>Factura:</strong> {{ $sale->invoice_number }}</p>
        <p><strong>Fecha:</strong> {{ $sale->created_at->format('d/m/Y H:i') }}</p>
        <p><strong>Cliente:</strong> {{ $sale->customer->first_name ?? 'Consumidor Final' }} {{ $sale->customer->last_name ?? '' }}</p>
        <p><strong>Vendedor:</strong> Admin</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Cant</th>
                <th>Producto</th>
                <th style="text-align: right;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sale->items as $item)
            <tr>
                <td>{{ $item->quantity }}</td>
                <td>{{ $item->product_name }}</td>
                <td style="text-align: right;">${{ number_format($item->total, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <p>SUBTOTAL: ${{ number_format($sale->subtotal, 2) }}</p>
        <p>IVA (15%): ${{ number_format($sale->iva, 2) }}</p>
        <p><strong>TOTAL: ${{ number_format($sale->total, 2) }}</strong></p>
    </div>

    <div class="footer">
        <p>¡Gracias por su compra!</p>
        <p>Siguenos en redes: @brunettecuador</p>
        <p>Este documento no tiene validez tributaria.</p>
    </div>

    <script>
        // window.print(); // Auto print if desired
    </script>
</body>
</html>
