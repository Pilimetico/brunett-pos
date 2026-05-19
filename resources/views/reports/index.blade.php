@extends('layouts.app')

@section('title', 'Reportes - Brunett Ecuador')
@section('page_title', 'Centro de Reportes')
@section('page_subtitle', 'Inteligencia de negocios y contabilidad')

@section('content')

<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 2rem;">
    
    <!-- Sales Report Card -->
    <div class="panel" style="display: flex; flex-direction: column; justify-content: space-between;">
        <div>
            <div style="width: 48px; height: 48px; background: rgba(0, 208, 156, 0.1); color: var(--brand-accent); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;">
                <i data-lucide="trending-up"></i>
            </div>
            <h3 style="margin-bottom: 0.5rem;">Reporte de Ventas</h3>
            <p style="color: var(--text-secondary); font-size: 0.9rem; margin-bottom: 1.5rem;">Detalle exhaustivo de ventas, márgenes de ganancia y métodos de pago por rango de fechas.</p>
        </div>
        <form action="{{ route('reports.sales') }}" method="GET">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem; margin-bottom: 1rem;">
                <input type="date" name="from" value="{{ date('Y-m-01') }}" class="form-control" style="font-size: 0.85rem; padding: 0.5rem;">
                <input type="date" name="to" value="{{ date('Y-m-d') }}" class="form-control" style="font-size: 0.85rem; padding: 0.5rem;">
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%;">Generar Reporte</button>
        </form>
    </div>

    <!-- Inventory Report Card -->
    <div class="panel" style="display: flex; flex-direction: column; justify-content: space-between;">
        <div>
            <div style="width: 48px; height: 48px; background: rgba(58, 88, 248, 0.1); color: var(--brand-primary); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;">
                <i data-lucide="package"></i>
            </div>
            <h3 style="margin-bottom: 0.5rem;">Valoración de Inventario</h3>
            <p style="color: var(--text-secondary); font-size: 0.9rem; margin-bottom: 1.5rem;">Conoce el valor total de tu mercadería actual a precio de costo y precio de venta (PVP1).</p>
        </div>
        <a href="{{ route('reports.inventory') }}" class="btn btn-primary" style="background: var(--brand-secondary); color: white; text-decoration: none; text-align: center;">Ver Inventario</a>
    </div>

    <!-- Box History Card -->
    <div class="panel" style="display: flex; flex-direction: column; justify-content: space-between;">
        <div>
            <div style="width: 48px; height: 48px; background: rgba(255, 178, 0, 0.1); color: var(--brand-warning); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;">
                <i data-lucide="wallet"></i>
            </div>
            <h3 style="margin-bottom: 0.5rem;">Historial de Cajas</h3>
            <p style="color: var(--text-secondary); font-size: 0.9rem; margin-bottom: 1.5rem;">Revisión de cierres diarios, diferencias de dinero y responsables de caja.</p>
        </div>
        <a href="{{ route('boxes.index') }}" class="btn" style="border: 1px solid var(--border-color); text-align: center; text-decoration: none;">Ir a Cajas</a>
    </div>

</div>

@endsection
