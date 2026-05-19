@extends('layouts.app')

@section('title', 'WooCommerce - Brunett Ecuador')
@section('page_title', 'Sincronización con Tienda Online')
@section('page_subtitle', 'Integración bidireccional con Brunett Shop')

@section('content')

<div style="display: grid; grid-template-columns: 1fr 350px; gap: 2rem;">
    
    <!-- Sync Actions -->
    <div style="display: flex; flex-direction: column; gap: 2rem;">
        
        <div class="panel">
            <h3 style="margin-bottom: 1.5rem; color: var(--brand-primary);"><i data-lucide="refresh-cw" style="width: 20px; display: inline; margin-right: 8px;"></i> Sincronización Maestra</h3>
            <p style="color: var(--text-secondary); margin-bottom: 2rem;">Este proceso igualará el stock de tus productos locales con tu tienda online WooCommerce basándose en el código de barras (SKU).</p>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <form action="{{ route('sync.stock') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1.5rem; display: flex; flex-direction: column; align-items: center; gap: 0.5rem; background: var(--brand-secondary);">
                        <i data-lucide="upload-cloud" style="width: 24px;"></i>
                        <span>Subir Stock a Web</span>
                    </button>
                </form>
                
                <a href="{{ route('sync.orders') }}" class="btn btn-primary" style="width: 100%; padding: 1.5rem; display: flex; flex-direction: column; align-items: center; gap: 0.5rem; text-decoration: none; justify-content: center;">
                    <i data-lucide="download-cloud" style="width: 24px;"></i>
                    <span>Descargar Pedidos</span>
                </a>
            </div>
        </div>

        <div class="panel">
            <h3 style="margin-bottom: 1.5rem;">Estado de la Conexión</h3>
            <div style="background: #f8fafc; padding: 1.5rem; border-radius: 8px; border: 1px solid var(--border-color);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <span>WooCommerce API</span>
                    <span class="badge badge-green">Conectado</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <span>Última Sincronización</span>
                    <span style="font-size: 0.85rem; color: var(--text-secondary);">Hoy, 14:45</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span>Productos enlazados</span>
                    <span style="font-weight: 600;">{{ \App\Models\Product::where('available_online', true)->count() }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Credentials / Config Side -->
    <div class="panel">
        <h3 style="margin-bottom: 1.5rem;">Configuración API</h3>
        <p style="font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 1.5rem;">Las credenciales deben ser Consumer Key y Consumer Secret con permisos de Lectura/Escritura.</p>
        
        <div style="margin-bottom: 1rem;">
            <label style="display: block; font-size: 0.8rem; font-weight: 600; margin-bottom: 0.4rem;">URL de la Tienda</label>
            <input type="text" value="{{ config('services.woocommerce.url') }}" readonly style="width: 100%; padding: 0.6rem; background: var(--bg-main); border: 1px solid var(--border-color); border-radius: 4px; font-size: 0.85rem;">
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-size: 0.8rem; font-weight: 600; margin-bottom: 0.4rem;">API Key</label>
            <input type="password" value="************************" readonly style="width: 100%; padding: 0.6rem; background: var(--bg-main); border: 1px solid var(--border-color); border-radius: 4px; font-size: 0.85rem;">
        </div>

        <div style="padding-top: 1rem; border-top: 1px solid var(--border-color); text-align: center;">
            <p style="font-size: 0.75rem; color: var(--text-muted);">Para cambiar las credenciales, edita el archivo .env del sistema.</p>
        </div>
    </div>

</div>

@endsection
