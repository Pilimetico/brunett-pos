@extends('layouts.app')

@section('title', 'Valoración de Inventario - Brunett')
@section('page_title', 'Valoración de Inventario')
@section('page_subtitle', 'Cálculo de capital invertido y proyección de ventas')

@section('content')

<div class="kpi-grid" style="margin-bottom: 2rem;">
    <div class="kpi-card">
        <div class="kpi-title">Inversión Total (Costo)</div>
        <div class="kpi-value">${{ number_format($totalCost, 2) }}</div>
        <p style="font-size: 0.8rem; color: var(--text-secondary); margin-top: 0.5rem;">Capital actualmente en bodega.</p>
    </div>
    <div class="kpi-card success">
        <div class="kpi-title">Valor en Venta (PVP1)</div>
        <div class="kpi-value">${{ number_format($totalValue, 2) }}</div>
        <p style="font-size: 0.8rem; color: var(--text-secondary); margin-top: 0.5rem;">Venta proyectada al público.</p>
    </div>
    <div class="kpi-card warning">
        <div class="kpi-title">Margen Potencial</div>
        <div class="kpi-value">${{ number_format($totalValue - $totalCost, 2) }}</div>
        <p style="font-size: 0.8rem; color: var(--text-secondary); margin-top: 0.5rem;">Diferencia bruta proyectada.</p>
    </div>
</div>

<div class="panel">
    <table class="data-table">
        <thead>
            <tr>
                <th>Código</th>
                <th>Producto</th>
                <th>Stock</th>
                <th>Costo Total</th>
                <th style="text-align: right;">Valor Venta Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $p)
            <tr>
                <td>{{ $p->code }}</td>
                <td>{{ $p->name }}</td>
                <td><span class="badge badge-gray">{{ $p->stock }}</span></td>
                <td>${{ number_format($p->cost * $p->stock, 2) }}</td>
                <td style="text-align: right; font-weight: 600; color: var(--brand-primary);">${{ number_format($p->pvp1 * $p->stock, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
