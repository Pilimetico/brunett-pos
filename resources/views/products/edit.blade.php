@extends('layouts.app')

@section('title', 'Editar Artículo - Brunett Ecuador')
@section('page_title', 'Editar Artículo')
@section('page_subtitle', 'Modificar producto en el inventario maestro')

@section('content')

<div class="panel">
    <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
            <!-- Información Básica -->
            <div>
                <h3 style="margin-bottom: 1rem; color: var(--brand-primary); font-size: 1.1rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.5rem;">Información Básica</h3>
                
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; font-size: 0.9rem;">Nombre del Artículo *</label>
                    <input type="text" name="name" value="{{ $product->name }}" required style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; font-size: 0.9rem;">Código de Barras *</label>
                        <input type="text" name="code" value="{{ $product->code }}" required style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; font-size: 0.9rem;">SKU interno</label>
                        <input type="text" name="sku" value="{{ $product->sku }}" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;">
                    </div>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; font-size: 0.9rem;">Categoría</label>
                        <select name="category" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;">
                            <option value="">-- Seleccionar --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->name }}" {{ $product->category == $cat->name ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; font-size: 0.9rem;">Marca</label>
                        <select name="brand" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;">
                            <option value="">-- Seleccionar --</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->name }}" {{ $product->brand == $brand->name ? 'selected' : '' }}>{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; font-size: 0.9rem;">Descripción</label>
                    <textarea name="description" rows="3" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;">{{ $product->description }}</textarea>
                </div>

                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; font-size: 0.9rem;">Imagen del Producto</label>
                    <input type="file" name="image" accept="image/*" style="width: 100%; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 6px; background: #f8fafc;">
                    @if($product->image_path)
                        <div style="margin-top: 1rem;">
                            <img src="{{ asset('storage/' . $product->image_path) }}" alt="Imagen actual" style="max-height: 100px; border-radius: 6px; border: 1px solid var(--border-color);">
                            <p style="font-size: 0.8rem; color: var(--text-secondary); margin-top: 0.5rem;">Imagen actual (Sube una nueva para reemplazarla)</p>
                        </div>
                    @endif
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
                            <input type="number" step="0.01" name="cost" value="{{ $product->cost }}" required style="width: 100%; padding: 0.75rem 0.75rem 0.75rem 1.5rem; border: 1px solid var(--border-color); border-radius: 6px; font-weight: 600;">
                        </div>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.9rem; color: var(--brand-primary);">PVP Normal (1) *</label>
                        <div style="position: relative;">
                            <span style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--text-muted);">$</span>
                            <input type="number" step="0.01" name="pvp1" value="{{ $product->pvp1 }}" required style="width: 100%; padding: 0.75rem 0.75rem 0.75rem 1.5rem; border: 1px solid var(--brand-secondary); border-radius: 6px; font-weight: 600;">
                        </div>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; font-size: 0.9rem;">PVP Cantidad (2)</label>
                        <input type="number" step="0.01" name="pvp2" value="{{ $product->pvp2 }}" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; font-size: 0.9rem;">PVP Mayorista (3)</label>
                        <input type="number" step="0.01" name="pvp3" value="{{ $product->pvp3 }}" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;">
                    </div>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; font-size: 0.9rem; color: #4b0082;">PVP Socio Brunett (4)</label>
                        <input type="number" step="0.01" name="pvp4" value="{{ $product->pvp4 }}" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; font-size: 0.9rem;">PVP Distribuidor (5)</label>
                        <input type="number" step="0.01" name="pvp5" value="{{ $product->pvp5 }}" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; font-size: 0.9rem;">Stock Actual</label>
                        <input type="number" name="stock" value="{{ $product->stock }}" required style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px; background: #e2e8f0;" readonly>
                        <small style="color: var(--text-secondary); display: block; margin-top: 0.25rem;">El stock se modifica desde Kardex.</small>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; font-size: 0.9rem;">Stock Mínimo (Alerta)</label>
                        <input type="number" name="min_stock" value="{{ $product->min_stock }}" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;">
                    </div>
                </div>

                <h3 style="margin-bottom: 1rem; color: var(--brand-primary); font-size: 1.1rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.5rem;">Configuraciones</h3>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                    <div style="background: #f8fafc; padding: 1rem; border-radius: 6px; border: 1px solid var(--border-color);">
                        <label style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem; cursor: pointer;">
                            <input type="checkbox" name="is_active" value="1" {{ $product->is_active ? 'checked' : '' }}> 
                            <strong>Producto Activo</strong>
                        </label>
                        <label style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem; cursor: pointer;">
                            <input type="checkbox" name="available_local" value="1" {{ $product->available_local ? 'checked' : '' }}> 
                            Venta Local (POS)
                        </label>
                        <label style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem; cursor: pointer;">
                            <input type="checkbox" name="available_whatsapp" value="1" {{ $product->available_whatsapp ? 'checked' : '' }}> 
                            Venta WhatsApp
                        </label>
                        <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                            <input type="checkbox" name="available_online" value="1" {{ $product->available_online ? 'checked' : '' }}> 
                            Venta Online
                        </label>
                    </div>
                    
                    <div style="background: #f8fafc; padding: 1rem; border-radius: 6px; border: 1px solid var(--border-color);">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; font-size: 0.9rem;">Estado WooCommerce</label>
                        <select name="woocommerce_status" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;">
                            <option value="borrador" {{ $product->woocommerce_status == 'borrador' ? 'selected' : '' }}>Borrador</option>
                            <option value="publicado" {{ $product->woocommerce_status == 'publicado' ? 'selected' : '' }}>Publicado</option>
                        </select>
                    </div>
                </div>

            </div>
        </div>

        <div style="border-top: 1px solid var(--border-color); padding-top: 1.5rem; display: flex; justify-content: flex-end; gap: 1rem;">
            <a href="{{ route('products.index') }}" class="btn" style="background: white; border: 1px solid var(--border-color); color: var(--text-primary);">Cancelar</a>
            <button type="submit" class="btn btn-primary"><i data-lucide="save" style="width: 18px; margin-right: 8px;"></i> Guardar Cambios</button>
        </div>
    </form>
</div>

@endsection
