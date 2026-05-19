@extends('layouts.app')

@section('title', 'Detalle de Pedido - Brunett')
@section('page_title', 'Pedido #' . $order->id)

@section('content')

<div style="max-width: 800px; margin: 0 auto;">
    <div class="panel" style="margin-bottom: 2rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h3 style="margin: 0; color: var(--brand-primary);">Información del Cliente</h3>
            <span class="badge badge-gray" style="font-size: 0.9rem;">{{ strtoupper($order->status) }}</span>
        </div>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div>
                <p style="margin-bottom: 0.5rem;"><strong style="color: var(--text-secondary);">Nombre:</strong> {{ $order->customer->first_name }} {{ $order->customer->last_name }}</p>
                <p style="margin-bottom: 0.5rem;"><strong style="color: var(--text-secondary);">Documento:</strong> {{ $order->customer->document_number ?? 'N/A' }}</p>
            </div>
            <div>
                <p style="margin-bottom: 0.5rem;"><strong style="color: var(--text-secondary);">Teléfono:</strong> {{ $order->customer->phone ?? 'N/A' }}</p>
                <p style="margin-bottom: 0.5rem;"><strong style="color: var(--text-secondary);">Dirección:</strong> {{ $order->shipping_address ?? 'Recoge en tienda' }}</p>
            </div>
        </div>
    </div>

    <div class="panel">
        <h3 style="margin-bottom: 1.5rem; color: var(--brand-primary);">Artículos del Pedido</h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cant.</th>
                    <th>Precio Unit.</th>
                    <th style="text-align: right;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>
                        <div style="font-weight: 500;">{{ $item->product ? $item->product->name : 'Producto Eliminado' }}</div>
                        <div style="font-size: 0.8rem; color: var(--text-secondary);">{{ $item->product ? $item->product->code : '' }}</div>
                    </td>
                    <td>{{ $item->quantity }}</td>
                    <td>${{ number_format($item->price, 2) }}</td>
                    <td style="text-align: right; font-weight: 600;">${{ number_format($item->quantity * $item->price, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align: right; padding-top: 1.5rem; font-size: 1.1rem;"><strong>TOTAL:</strong></td>
                    <td style="text-align: right; padding-top: 1.5rem; font-size: 1.2rem; color: var(--brand-primary);"><strong>${{ number_format($order->total, 2) }}</strong></td>
                </tr>
            </tfoot>
        </table>
        
        <div style="margin-top: 2rem; display: flex; justify-content: flex-end; gap: 1rem;">
            <a href="{{ route('orders.index') }}" class="btn">Volver a la Lista</a>
            <a href="https://wa.me/593{{ substr(preg_replace('/[^0-9]/', '', $order->customer->phone ?? ''), -9) }}?text=Hola%20{{ urlencode($order->customer->first_name) }},%20el%20total%20de%20tu%20pedido%20es%20${{ number_format($order->total, 2) }}." target="_blank" class="btn btn-success" style="color: white; border: none; display: flex; align-items: center; gap: 0.5rem;">
                <i data-lucide="message-circle" style="width: 18px;"></i> Enviar WhatsApp
            </a>
        </div>
    </div>
</div>

@endsection
