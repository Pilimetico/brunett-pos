@extends('layouts.app')

@section('title', 'Pedidos Web - Brunett')
@section('page_title', 'Pedidos desde WooCommerce')
@section('page_subtitle', 'Sincronización de ventas online')

@section('content')

<div class="panel">
    <div class="panel-header">
        <h2 class="panel-title">Pedidos en Estado 'Procesando'</h2>
        <a href="{{ route('sync.index') }}" class="btn">Volver al Panel</a>
    </div>
    
    <table class="data-table">
        <thead>
            <tr>
                <th>Orden #</th>
                <th>Fecha Web</th>
                <th>Cliente</th>
                <th>Items</th>
                <th>Total Web</th>
                <th style="text-align: right;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            <tr>
                <td><strong>#{{ $order->number }}</strong></td>
                <td>{{ date('d/m/Y H:i', strtotime($order->date_created)) }}</td>
                <td>{{ $order->billing->first_name }} {{ $order->billing->last_name }}</td>
                <td>{{ count($order->line_items) }} productos</td>
                <td><strong style="color: var(--brand-primary);">${{ number_format($order->total, 2) }}</strong></td>
                <td style="text-align: right;">
                    <button class="btn btn-primary" style="padding: 0.4rem 0.8rem; font-size: 0.85rem;">Facturar en Local</button>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align: center; padding: 3rem;">No hay pedidos nuevos en WooCommerce.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
