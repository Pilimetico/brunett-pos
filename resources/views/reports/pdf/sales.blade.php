<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Ventas - Brunett</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #3a58f8; padding-bottom: 10px; }
        .title { font-size: 20px; font-weight: bold; color: #3a58f8; margin-bottom: 5px; }
        .subtitle { font-size: 14px; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { background: #f3f5f9; padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
        td { padding: 10px; border-bottom: 1px solid #eee; }
        .total-box { background: #f8fafc; padding: 15px; border-radius: 8px; margin-top: 20px; }
        .text-right { text-align: right; }
        .brand-color { color: #3a58f8; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">BRUNETT ECUADOR</div>
        <div class="subtitle">Reporte Detallado de Ventas</div>
        <p>Periodo: {{ $from }} al {{ $to }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Factura</th>
                <th>Cliente</th>
                <th class="text-right">Costo</th>
                <th class="text-right">Total</th>
                <th class="text-right">Utilidad</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)
            <tr>
                <td>{{ $sale->created_at->format('d/m/Y') }}</td>
                <td>#{{ $sale->invoice_number }}</td>
                <td>{{ $sale->customer->first_name ?? 'C. Final' }}</td>
                <td class="text-right">${{ number_format($sale->cost_total, 2) }}</td>
                <td class="text-right">${{ number_format($sale->total, 2) }}</td>
                <td class="text-right brand-color">${{ number_format($sale->total - $sale->cost_total, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-box">
        <table style="margin-bottom: 0;">
            <tr>
                <td><strong>Total Ventas:</strong></td>
                <td class="text-right"><strong style="font-size: 16px;">${{ number_format($summary['total'], 2) }}</strong></td>
            </tr>
            <tr>
                <td><strong>Utilidad Neta Estimada:</strong></td>
                <td class="text-right"><strong style="font-size: 16px; color: #00d09c;">${{ number_format($summary['profit'], 2) }}</strong></td>
            </tr>
        </table>
    </div>

    <div style="margin-top: 50px; text-align: center; font-size: 10px; color: #999;">
        Documento generado automáticamente por Sistema Brunett POS el {{ date('d/m/Y H:i') }}
    </div>
</body>
</html>
