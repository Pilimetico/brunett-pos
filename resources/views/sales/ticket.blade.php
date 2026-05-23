<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ticket #{{ $sale->invoice_number }}</title>
    <style>
        body { font-family: 'Courier New', Courier, monospace; font-size: 12px; margin: 0; padding: 20px; width: 80mm; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 16px; font-weight: bold; }
        .header p { margin: 5px 0 0 0; font-size: 11px; line-height: 1.3; }
        .details { margin-bottom: 15px; border-bottom: 1px dashed #000; padding-bottom: 10px; font-size: 11px; }
        .details p { margin: 3px 0; }
        .table { width: 100%; margin-bottom: 15px; border-collapse: collapse; font-size: 11px; }
        .table th { text-align: left; border-bottom: 1px solid #000; padding-bottom: 3px; }
        .table td { padding: 4px 0; }
        .totals { text-align: right; margin-top: 10px; border-top: 1px dashed #000; padding-top: 10px; font-size: 11px; }
        .totals p { margin: 4px 0; }
        .footer { text-align: center; margin-top: 20px; font-size: 10px; line-height: 1.4; }
        @media print {
            body { padding: 0; width: 80mm; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    @php
        $companyName = \App\Models\Setting::getValue('company_name', 'BRUNETT ECUADOR');
        $companyRuc = \App\Models\Setting::getValue('company_ruc', '0195159092001');
        $companyRazonSocial = \App\Models\Setting::getValue('company_razon_social', 'ATGU S.A.S');
        $companyAddress = \App\Models\Setting::getValue('company_address', 'GRAN COLOMBIA ENTRE OCTAVIO CORDERO Y ABRAHAM SARMIENTO');
        $companyPhone = \App\Models\Setting::getValue('company_phone', '0962918108');
        $companyCity = \App\Models\Setting::getValue('company_city', 'CUENCA');
        $companyCountry = \App\Models\Setting::getValue('company_country', 'ECUADOR');
        $companyObligado = \App\Models\Setting::getValue('company_obligado_contabilidad', 'SI');
        $companyRimpeRegime = \App\Models\Setting::getValue('company_rimpe_regime', 'SI');
        $companyRimpeType = \App\Models\Setting::getValue('company_rimpe_type', 'RIMPE para emprendedores');
        $companyRetentionAgent = \App\Models\Setting::getValue('company_retention_agent', 'NO');
        $companyRetentionResolution = \App\Models\Setting::getValue('company_retention_resolution', 'NAC-DNCRASC20-00000001');
        $companyTicketLegend = \App\Models\Setting::getValue('company_ticket_legend', '');
    @endphp

    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; cursor: pointer; font-weight: bold; border-radius: 4px; border: 1px solid #000; background: #eee;">Imprimir Ticket</button>
        <a href="{{ route('pos.index') }}" style="margin-left: 10px; font-size: 12px; text-decoration: none; color: blue;">Volver al POS</a>
    </div>

    <div class="header">
        <h1>{{ $companyRazonSocial }}</h1>
        <p>
            <strong>{{ $companyName }}</strong><br>
            RUC: {{ $companyRuc }}<br>
            DIR: {{ $companyAddress }}<br>
            TELF: {{ $companyPhone }}<br>
            {{ $companyCity }} - {{ $companyCountry }}
        </p>
        <p style="font-size: 10px; margin-top: 8px; font-weight: bold;">
            @if($companyObligado === 'SI')
                OBLIGADO A LLEVAR CONTABILIDAD<br>
            @endif
            @if($companyRimpeRegime === 'SI')
                Contribuyente régimen RIMPE - {{ $companyRimpeType }}<br>
            @endif
            @if($companyRetentionAgent === 'SI')
                Agente de Retención - Res: {{ $companyRetentionResolution }}<br>
            @endif
        </p>
    </div>

    <div class="details">
        <p><strong>Factura:</strong> {{ $sale->invoice_number }}</p>
        <p><strong>Fecha:</strong> {{ $sale->created_at->format('d/m/Y H:i') }}</p>
        <p><strong>Cliente:</strong> {{ $sale->customer->first_name ?? 'Consumidor Final' }} {{ $sale->customer->last_name ?? '' }}</p>
        @if(isset($sale->customer->ruc) || isset($sale->customer->dni))
            <p><strong>R.U.C./C.I.:</strong> {{ $sale->customer->ruc ?? $sale->customer->dni ?? '' }}</p>
        @endif
        <p><strong>Vendedor:</strong> {{ $sale->user->name ?? 'Admin' }}</p>
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
        <p>IVA ({{ number_format($sale->iva_percentage ?? 15, 0) }}%): ${{ number_format($sale->iva, 2) }}</p>
        <p><strong>TOTAL: ${{ number_format($sale->total, 2) }}</strong></p>
    </div>

    @if($companyTicketLegend)
    <div class="ticket-legend" style="margin-top: 20px; font-size: 9px; text-align: justify; line-height: 1.3; border-top: 1px dashed #000; padding-top: 10px;">
        {!! nl2br(e($companyTicketLegend)) !!}
    </div>
    @endif

    <div class="signature-section" style="margin-top: 45px; text-align: center; font-size: 11px;">
        <div style="border-top: 1px solid #000; width: 80%; margin: 0 auto 5px auto;"></div>
        <strong>FIRMA CLIENTE</strong>
        <p style="margin: 8px 0 0 0; text-align: left; padding-left: 10%;">C.I.: ________________________</p>
    </div>

    <div class="print-meta" style="margin-top: 20px; font-size: 9px; text-align: center; border-top: 1px dashed #000; padding-top: 8px; color: #555;">
        Fecha / Hora Impresión: {{ now()->format('Y-m-d / H:i:s') }}
    </div>

    <script>
        // window.print(); // Auto print if desired
    </script>
</body>
</html>
