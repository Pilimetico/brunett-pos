@extends('layouts.app')

@section('title', 'Nuevo Artículo - Brunett Ecuador')
@section('page_title', 'Nuevo Artículo')
@section('page_subtitle', 'Registro de producto en el inventario maestro')

@section('content')

<div class="panel">
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
            <!-- Información Básica -->
            <div>
                <h3 style="margin-bottom: 1rem; color: var(--brand-primary); font-size: 1.1rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.5rem;">Información Básica</h3>
                
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; font-size: 0.9rem;">Nombre del Artículo *</label>
                    <input type="text" name="name" required style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;" placeholder="Nombre completo del producto">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; font-size: 0.9rem;">Código de Barras *</label>
                        <input type="text" name="code" required style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;" placeholder="Ej. 786123456789">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; font-size: 0.9rem;">SKU interno</label>
                        <input type="text" name="sku" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;" placeholder="Ej. BR-MAQ-001">
                    </div>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; font-size: 0.9rem;">Categoría</label>
                        <select name="category" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;">
                            <option value="">-- Seleccionar --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; font-size: 0.9rem;">Marca</label>
                        <select name="brand" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;">
                            <option value="">-- Seleccionar --</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->name }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; font-size: 0.9rem;">Descripción</label>
                    <textarea name="description" rows="3" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;" placeholder="Descripción del producto..."></textarea>
                </div>

                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; font-size: 0.9rem;">Imagen del Producto</label>
                    <input type="file" name="image" accept="image/*" style="width: 100%; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 6px; background: #f8fafc;">
                </div>
            </div>
            
            <!-- Precios e Impuestos -->
            <div>
                <h3 style="margin-bottom: 1rem; color: var(--brand-primary); font-size: 1.1rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.5rem;">Precios y Stock</h3>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; font-size: 0.9rem; color: var(--text-secondary);">Costo (Sin IVA) *</label>
                        <div style="position: relative;">
                            <span style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--text-muted);">$</span>
                            <input type="number" step="0.01" name="cost" required style="width: 100%; padding: 0.75rem 0.75rem 0.75rem 1.5rem; border: 1px solid var(--border-color); border-radius: 6px; font-weight: 600;" value="0.00">
                        </div>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.9rem; color: var(--brand-primary);">PVP Normal (1) *</label>
                        <div style="position: relative;">
                            <span style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--text-muted);">$</span>
                            <input type="number" step="0.01" name="pvp1" required style="width: 100%; padding: 0.75rem 0.75rem 0.75rem 1.5rem; border: 1px solid var(--brand-secondary); border-radius: 6px; font-weight: 600;" value="0.00">
                        </div>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; font-size: 0.9rem;">PVP Cantidad (2)</label>
                        <input type="number" step="0.01" name="pvp2" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;" value="0.00">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; font-size: 0.9rem;">PVP Mayorista (3)</label>
                        <input type="number" step="0.01" name="pvp3" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;" value="0.00">
                    </div>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; font-size: 0.9rem; color: #4b0082;">PVP Socio Brunett (4)</label>
                        <input type="number" step="0.01" name="pvp4" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;" value="0.00">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; font-size: 0.9rem;">PVP Distribuidor (5)</label>
                        <input type="number" step="0.01" name="pvp5" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;" value="0.00">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; font-size: 0.9rem;">Stock Inicial *</label>
                        <input type="number" name="stock" required style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;" value="0">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; font-size: 0.9rem;">Stock Mínimo (Alerta)</label>
                        <input type="number" name="min_stock" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;" value="5">
                    </div>
                </div>

                <h3 style="margin-bottom: 1rem; color: var(--brand-primary); font-size: 1.1rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.5rem;">Configuraciones</h3>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                    <div style="background: #f8fafc; padding: 1rem; border-radius: 6px; border: 1px solid var(--border-color);">
                        <label style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem; cursor: pointer;">
                            <input type="checkbox" name="is_active" value="1" checked> 
                            <strong>Producto Activo</strong>
                        </label>
                        <label style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem; cursor: pointer;">
                            <input type="checkbox" name="available_local" value="1" checked> 
                            Venta Local (POS)
                        </label>
                        <label style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem; cursor: pointer;">
                            <input type="checkbox" name="available_whatsapp" value="1" checked> 
                            Venta WhatsApp
                        </label>
                        <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                            <input type="checkbox" name="available_online" value="1" checked> 
                            Venta Online
                        </label>
                    </div>
                    
                    <div style="background: #f8fafc; padding: 1rem; border-radius: 6px; border: 1px solid var(--border-color);">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; font-size: 0.9rem;">Estado WooCommerce</label>
                        <select name="woocommerce_status" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;">
                            <option value="borrador">Borrador</option>
                            <option value="publicado">Publicado</option>
                        </select>
                    </div>
                </div>

            </div>
        </div>

        <div style="border-top: 1px solid var(--border-color); padding-top: 1.5rem; display: flex; justify-content: flex-end; gap: 1rem;">
            <a href="{{ route('products.index') }}" class="btn" style="background: white; border: 1px solid var(--border-color); color: var(--text-primary);">Cancelar</a>
            <button type="submit" class="btn btn-primary"><i data-lucide="save" style="width: 18px; margin-right: 8px;"></i> Guardar Producto</button>
        </div>
    </form>
</div>

@endsection
