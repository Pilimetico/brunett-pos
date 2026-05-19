@extends('layouts.app')

@section('title', 'Transferencias entre Bodegas - Brunett')
@section('page_title', 'Transferencias de Mercadería')

@section('content')

<div style="max-width: 600px; margin: 0 auto;">
    <div class="panel">
        <h3 style="margin-bottom: 2rem; color: var(--brand-primary);">Registrar Nueva Transferencia</h3>
        <form action="{{ route('inventory.transfers.store') }}" method="POST">
            @csrf
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Producto</label>
                <select name="product_id" class="form-control" style="width: 100%;" required>
                    <option value="">Seleccione un producto...</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">
                            {{ $product->name }} (Stock Global: {{ $product->stock }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Desde (Origen)</label>
                    <select name="from_warehouse_id" class="form-control" style="width: 100%;" required>
                        @foreach($warehouses as $w)
                            <option value="{{ $w->id }}">{{ $w->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Hacia (Destino)</label>
                    <select name="to_warehouse_id" class="form-control" style="width: 100%;" required>
                        @foreach($warehouses as $w)
                            <option value="{{ $w->id }}">{{ $w->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Cantidad a Mover</label>
                <input type="number" name="quantity" step="0.01" class="form-control" style="width: 100%;" required>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem;">Procesar Transferencia</button>
        </form>
    </div>
</div>

@endsection
