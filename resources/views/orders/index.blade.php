@extends('layouts.app')

@section('title', 'Pedidos WhatsApp - Brunett')
@section('page_title', 'Gestión de Pedidos WhatsApp')
@section('page_subtitle', 'Pedidos con reserva de inventario')

@section('content')

<div class="panel">
    <div class="panel-header">
        <h2 class="panel-title">Lista de Pedidos</h2>
        <a href="{{ route('orders.create') }}" class="btn btn-primary"><i data-lucide="plus"></i> Nuevo Pedido</a>
    </div>
    
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Fecha</th>
                <th>Total</th>
                <th>Estado</th>
                <th style="text-align: right;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>#{{ $order->id }}</td>
                <td><strong>{{ $order->customer->first_name }} {{ $order->customer->last_name }}</strong></td>
                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                <td><strong style="color: var(--brand-primary);">${{ number_format($order->total, 2) }}</strong></td>
                <td>
                    <form action="{{ route('orders.status', $order) }}" method="POST" style="display: flex; align-items: center; gap: 0.5rem;">
                        @csrf
                        <select name="status" onchange="this.form.submit()" style="padding: 0.3rem; border-radius: 4px; border: 1px solid var(--border-color); font-size: 0.85rem; background-color: #f8fafc; cursor: pointer;">
                            <option value="creado" {{ $order->status == 'creado' || $order->status == 'created' ? 'selected' : '' }}>Creado</option>
                            <option value="pendiente_pago" {{ $order->status == 'pendiente_pago' || $order->status == 'pending_payment' ? 'selected' : '' }}>Pendiente de Pago</option>
                            <option value="pagado" {{ $order->status == 'pagado' || $order->status == 'paid' ? 'selected' : '' }}>Pagado</option>
                        </select>
                    </form>
                </td>
                <td style="text-align: right;">
                    <a href="{{ route('orders.show', $order) }}" class="btn" style="padding: 0.4rem; background: transparent; color: var(--brand-primary);"><i data-lucide="eye" style="width: 18px;"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div style="margin-top: 1.5rem;">
        {{ $orders->links() }}
    </div>
</div>

@endsection
