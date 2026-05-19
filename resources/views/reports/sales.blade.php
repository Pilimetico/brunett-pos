@extends('layouts.app')

@section('title', 'Reporte de Ventas - Brunett')
@section('page_title', 'Reporte de Ventas')
@section('page_subtitle', 'Periodo: ' . $from . ' al ' . $to)

@section('content')

<div class="kpi-grid" style="margin-bottom: 2rem;">
    <div class="kpi-card">
        <div class="kpi-title">Total Ventas</div>
        <div class="kpi-value">${{ number_format($summary['total'], 2) }}</div>
    </div>
    <div class="kpi-card success">
        <div class="kpi-title">Utilidad Bruta</div>
        <div class="kpi-value">${{ number_format($summary['profit'], 2) }}</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-title">Transacciones</div>
        <div class="kpi-value">{{ $summary['count'] }}</div>
    </div>
    <div class="kpi-card" style="display: flex; align-items: center; justify-content: center; padding: 0;">
        <a href="{{ request()->fullUrlWithQuery(['export' => 'pdf']) }}" class="btn btn-primary" style="width: 80%; background: var(--brand-danger);">
            <i data-lucide="file-text" style="width: 18px; margin-right: 8px;"></i> Exportar a PDF
        </a>
    </div>
</div>

<div class="panel">
    <table class="data-table">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Factura</th>
                <th>Cliente</th>
                <th>Costo</th>
                <th>Total Venta</th>
                <th style="text-align: right;">Utilidad</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)
            <tr>
                <td>{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                <td><strong>#{{ $sale->invoice_number }}</strong></td>
                <td>{{ $sale->customer->first_name ?? 'Consumidor Final' }}</td>
                <td style="color: var(--text-secondary);">${{ number_format($sale->cost_total, 2) }}</td>
                <td style="font-weight: 600; color: var(--brand-primary);">${{ number_format($sale->total, 2) }}</td>
                <td style="text-align: right; color: var(--brand-accent); font-weight: 600;">
                    ${{ number_format($sale->total - $sale->cost_total, 2) }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
