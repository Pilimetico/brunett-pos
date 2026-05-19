@extends('layouts.app')

@section('title', 'Compras - Brunett')
@section('page_title', 'Compras e Ingresos')
@section('page_subtitle', 'Registro de entrada de mercadería')

@section('content')

<div class="panel">
    <div class="panel-header">
        <h2 class="panel-title">Historial de Compras</h2>
        <a href="{{ route('purchases.create') }}" class="btn btn-primary"><i data-lucide="plus"></i> Nueva Compra</a>
    </div>
    
    <table class="data-table">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Factura #</th>
                <th>Proveedor</th>
                <th>Total</th>
                <th>Estado</th>
                <th style="text-align: right;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($purchases as $purchase)
            <tr>
                <td>{{ $purchase->purchase_date }}</td>
                <td><strong>{{ $purchase->invoice_number }}</strong></td>
                <td>{{ $purchase->supplier->name }}</td>
                <td><strong style="color: var(--brand-primary);">${{ number_format($purchase->total, 2) }}</strong></td>
                <td>
                    <span style="background: #ecfdf5; color: #059669; padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.75rem;">
                        {{ strtoupper($purchase->status) }}
                    </span>
                </td>
                <td style="text-align: right;">
                    <button class="btn" style="padding: 0.4rem; background: transparent; color: var(--brand-primary);"><i data-lucide="eye" style="width: 18px;"></i></button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div style="margin-top: 1.5rem;">
        {{ $purchases->links() }}
    </div>
</div>

@endsection
