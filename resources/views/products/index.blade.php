@extends('layouts.app')

@section('title', 'Inventario - Brunett Ecuador')
@section('page_title', 'Inventario y Artículos')
@section('page_subtitle', 'Gestión de catálogo, precios y stock')

@section('content')

<div class="panel" style="margin-bottom: 2rem;">
    <div class="panel-header" style="margin-bottom: 0;">
        <div style="display: flex; gap: 1rem; flex: 1;">
            <input type="text" placeholder="Buscar por código, nombre o SKU..." style="padding: 0.75rem 1rem; border-radius: 8px; border: 1px solid var(--border-color); flex: 1; font-family: var(--font-body); font-size: 0.95rem;">
            <button class="btn btn-primary" style="background-color: var(--bg-surface); color: var(--text-primary); border: 1px solid var(--border-color); box-shadow: none;">
                <i data-lucide="filter" style="width: 18px; margin-right: 8px;"></i> Filtros
            </button>
        </div>
        <div style="margin-left: 1rem;">
            <a href="{{ route('products.create') }}" class="btn btn-success" style="color: white; text-decoration: none;">
                <i data-lucide="plus" style="width: 18px; margin-right: 8px;"></i> Nuevo Artículo
            </a>
        </div>
    </div>
</div>

<div class="panel">
    <table class="data-table">
        <thead>
            <tr>
                <th>Img</th>
                <th>Código/SKU</th>
                <th>Nombre</th>
                <th>Marca/Cat.</th>
                <th style="text-align: right;">Costo</th>
                <th style="text-align: right;">PVP(1)</th>
                <th style="text-align: right;">Stock</th>
                <th style="text-align: right;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
            <tr>
                <td>
                    @if($product->image_path)
                        <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px; border: 1px solid var(--border-color);">
                    @else
                        <div style="width: 40px; height: 40px; background: #e2e8f0; border-radius: 4px; display: flex; align-items: center; justify-content: center; color: var(--text-muted);">
                            <i data-lucide="image" style="width: 20px;"></i>
                        </div>
                    @endif
                </td>
                <td><strong>{{ $product->code }}</strong></td>
                <td>
                    <div style="font-weight: 500;">{{ $product->name }}</div>
                    <div style="font-size: 0.8rem; color: var(--text-secondary);">{{ $product->category ?? 'Sin categoría' }}</div>
                </td>
                <td>{{ $product->brand ?? '-' }}</td>
                <td style="text-align: right;">${{ number_format($product->cost, 2) }}</td>
                <td style="text-align: right;"><strong style="color: var(--brand-primary);">${{ number_format($product->pvp1, 2) }}</strong></td>
                <td style="text-align: right;">
                    @if($product->stock <= $product->min_stock)
                        <span class="badge badge-gray" style="background: rgba(209, 67, 67, 0.1); color: var(--brand-danger);">{{ $product->stock }} (Bajo)</span>
                    @else
                        <span class="badge badge-green">{{ $product->stock }}</span>
                    @endif
                </td>

                <td style="text-align: right;">
                    <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                        <a href="{{ route('products.edit', $product) }}" class="btn-icon" title="Editar"><i data-lucide="edit-2" style="width: 16px;"></i></a>
                        <a href="{{ route('inventory.kardex', ['product_id' => $product->id]) }}" class="btn-icon" title="Kardex" style="color: var(--brand-secondary);"><i data-lucide="clipboard-list" style="width: 16px;"></i></a>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; padding: 3rem 1rem; color: var(--text-muted);">
                    <i data-lucide="package-search" style="width: 48px; height: 48px; opacity: 0.5; margin-bottom: 1rem;"></i>
                    <p>No hay productos registrados en el inventario.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div style="margin-top: 1.5rem;">
        {{ $products->links() }}
    </div>
</div>

@endsection
