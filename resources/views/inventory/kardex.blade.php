@extends('layouts.app')

@section('title', 'Kardex de Inventario - Brunett')
@section('page_title', 'Kardex de Inventario')

@section('content')

<div class="panel" style="margin-bottom: 2rem;">
    <form action="{{ route('inventory.kardex') }}" method="GET" style="display: flex; gap: 1rem; align-items: flex-end;">
        <div style="flex: 1;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Filtrar por Producto</label>
            <select name="product_id" class="form-control" style="width: 100%;">
                <option value="">Todos los productos</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>
                        {{ $product->name }} ({{ $product->code }})
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Filtrar</button>
        <a href="{{ route('inventory.kardex') }}" class="btn">Limpiar</a>
    </form>
</div>

<div class="panel">
    <div class="panel-header">
        <h2 class="panel-title">Movimientos Recientes</h2>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Fecha/Hora</th>
                <th>Producto</th>
                <th>Tipo</th>
                <th>Razón</th>
                <th style="text-align: right;">Cant.</th>
                <th style="text-align: right;">Saldo Ant.</th>
                <th style="text-align: right;">Saldo Nuevo</th>
                <th>Usuario</th>
            </tr>
        </thead>
        <tbody>
            @foreach($movements as $mov)
            <tr>
                <td>{{ $mov->created_at->format('d/m/Y H:i') }}</td>
                <td><strong>{{ $mov->product->name }}</strong><br><small style="color: var(--text-secondary);">{{ $mov->product->code }}</small></td>
                <td>
                    <span class="badge {{ $mov->type === 'in' ? 'badge-green' : ($mov->type === 'out' ? 'badge-red' : 'badge-gray') }}">
                        {{ $mov->type === 'in' ? 'Entrada' : ($mov->type === 'out' ? 'Salida' : 'Transferencia') }}
                    </span>
                </td>
                <td>{{ $mov->reason }}</td>
                <td style="text-align: right; font-weight: 700; color: {{ $mov->type === 'in' ? 'var(--brand-success)' : 'var(--brand-danger)' }};">
                    {{ $mov->type === 'in' ? '+' : '-' }}{{ number_format($mov->quantity, 2) }}
                </td>
                <td style="text-align: right; color: var(--text-secondary);">{{ number_format($mov->balance_before, 2) }}</td>
                <td style="text-align: right; font-weight: 800;">{{ number_format($mov->balance_after, 2) }}</td>
                <td><small>{{ $mov->user->name ?? 'Admin' }}</small></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div style="margin-top: 1.5rem;">
        {{ $movements->appends(request()->input())->links() }}
    </div>
</div>

@endsection
