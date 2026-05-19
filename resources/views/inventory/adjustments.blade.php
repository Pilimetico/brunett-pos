@extends('layouts.app')

@section('title', 'Ajustes de Inventario - Brunett')
@section('page_title', 'Ajustes Manuales de Inventario')

@section('content')

<div style="max-width: 600px; margin: 0 auto;">
    <div class="panel">
        <h3 style="margin-bottom: 2rem; color: var(--brand-primary);">Registrar Nuevo Ajuste</h3>
        <form action="{{ route('inventory.adjustments.store') }}" method="POST">
            @csrf
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Producto</label>
                <select name="product_id" class="form-control" style="width: 100%;" required>
                    <option value="">Seleccione un producto...</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">
                            {{ $product->name }} (Código: {{ $product->code }}) - Stock Actual: {{ $product->stock }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Tipo de Ajuste</label>
                    <select name="type" class="form-control" style="width: 100%;" required>
                        <option value="in">Ingreso (+)</option>
                        <option value="out">Egreso (-)</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Cantidad</label>
                    <input type="number" name="quantity" step="0.01" class="form-control" style="width: 100%;" required>
                </div>
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Motivo del Ajuste</label>
                <textarea name="reason" class="form-control" style="width: 100%; height: 100px;" placeholder="Ej. Producto dañado, error en conteo, etc." required></textarea>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem;">Guardar Ajuste y Actualizar Stock</button>
        </form>
    </div>
</div>

@endsection
