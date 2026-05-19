@extends('layouts.app')

@section('title', 'Dashboard Gerencial - Brunett Ecuador')
@section('page_title', 'Dashboard Gerencial')
@section('page_subtitle', 'Control y Analítica General del Negocio')

@section('content')

<!-- 1. FILTROS SUPERIORES -->
<div class="panel" style="margin-bottom: 2rem; padding: 1rem 1.5rem; display: flex; flex-wrap: wrap; gap: 1rem; align-items: flex-end; background: linear-gradient(to right, var(--bg-surface), #f8fafc);">
    <form action="{{ route('dashboard') }}" method="GET" style="display: flex; gap: 1rem; width: 100%; flex-wrap: wrap; align-items: flex-end;">
        <div style="flex: 1; min-width: 150px;">
            <label>Fecha Desde</label>
            <input type="date" name="from" value="{{ $from }}" class="form-control">
        </div>
        <div style="flex: 1; min-width: 150px;">
            <label>Fecha Hasta</label>
            <input type="date" name="to" value="{{ $to }}" class="form-control">
        </div>
        <div style="flex: 1; min-width: 150px;">
            <label>Bodega</label>
            <select name="warehouse" class="form-control">
                <option value="">Todas las bodegas</option>
                <!-- Opciones dinámicas irían aquí -->
            </select>
        </div>
        <div style="flex: 1; min-width: 150px;">
            <label>Canal</label>
            <select name="channel" class="form-control">
                <option value="">Todos los canales</option>
                <option value="local">Local</option>
                <option value="whatsapp">WhatsApp</option>
                <option value="online">Online</option>
            </select>
        </div>
        <div>
            <button type="submit" class="btn btn-primary" style="height: 42px;"><i data-lucide="refresh-cw" style="width: 16px; margin-right: 6px;"></i> Actualizar</button>
        </div>
    </form>
</div>

<!-- 2. METAS Y DESEMPEÑO -->
<div class="panel" style="margin-bottom: 2rem; background: var(--brand-primary); color: white; padding: 2rem;">
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
        <div>
            <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 0.5rem;">
                <h3 style="color: white; font-size: 1.1rem;">Cumplimiento Meta Diaria</h3>
                <span style="font-size: 1.5rem; font-weight: 700;">{{ number_format($avanceDiario, 1) }}%</span>
            </div>
            <p style="color: rgba(255,255,255,0.7); font-size: 0.9rem; margin-bottom: 1rem;">Vendido: ${{ number_format($totalVentas, 2) }} / Meta: ${{ number_format($metaDiaria, 2) }}</p>
            <div style="height: 8px; background: rgba(255,255,255,0.1); border-radius: 4px; overflow: hidden;">
                <div style="width: {{ min(100, $avanceDiario) }}%; height: 100%; background: var(--brand-accent);"></div>
            </div>
        </div>
        <div>
            <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 0.5rem;">
                <h3 style="color: white; font-size: 1.1rem;">Cumplimiento Meta Anual</h3>
                <span style="font-size: 1.5rem; font-weight: 700;">{{ number_format($avanceAnual, 1) }}%</span>
            </div>
            <p style="color: rgba(255,255,255,0.7); font-size: 0.9rem; margin-bottom: 1rem;">Vendido: ${{ number_format($totalVentasAnual, 2) }} / Meta: ${{ number_format($metaAnual, 2) }}</p>
            <div style="height: 8px; background: rgba(255,255,255,0.1); border-radius: 4px; overflow: hidden;">
                <div style="width: {{ min(100, $avanceAnual) }}%; height: 100%; background: var(--brand-secondary);"></div>
            </div>
        </div>
    </div>
</div>

<!-- 3. RESUMEN GENERAL (PRIMERA FILA) -->
<h2 class="panel-title" style="margin-bottom: 1rem;">Resumen Financiero del Período</h2>
<div class="kpi-grid">
    <div class="kpi-card">
        <div class="kpi-title">Total Vendido</div>
        <div class="kpi-value">${{ number_format($totalVentas, 2) }}</div>
        <div class="kpi-trend trend-up"><i data-lucide="shopping-cart" style="width: 14px;"></i> {{ $countVentas }} ventas ({{ $productosVendidos }} prod.)</div>
    </div>
    
    <div class="kpi-card success">
        <div class="kpi-title">Ganancia Obtenida (Utilidad Bruta)</div>
        <div class="kpi-value">${{ number_format($gananciaObtenida, 2) }}</div>
        <div class="kpi-trend" style="color: var(--text-secondary); background: transparent; padding: 0;">Costo mercadería: -${{ number_format($totalCostos, 2) }}</div>
    </div>

    <div class="kpi-card success">
        <div class="kpi-title">Margen de Ganancia</div>
        <div class="kpi-value">{{ number_format($margenGeneral, 1) }}%</div>
        <div class="kpi-trend trend-up"><i data-lucide="percent" style="width: 14px;"></i> Excelente rentabilidad</div>
    </div>

    <div class="kpi-card warning">
        <div class="kpi-title">Utilidad Neta Estimada</div>
        <div class="kpi-value">${{ number_format($utilidadNetaEstimada, 2) }}</div>
        <div class="kpi-trend" style="color: var(--text-secondary); background: transparent; padding: 0;">Gastos periodo: -${{ number_format($expensesToday, 2) }}</div>
    </div>
</div>

<div class="kpi-grid" style="grid-template-columns: repeat(4, 1fr);">
    <div class="kpi-card" style="padding: 1rem;">
        <div class="kpi-title">Ticket Promedio</div>
        <div style="font-size: 1.5rem; font-weight: 700;">${{ number_format($ticketPromedio, 2) }}</div>
    </div>
    <div class="kpi-card" style="padding: 1rem;">
        <div class="kpi-title">Salidas de Caja</div>
        <div style="font-size: 1.5rem; font-weight: 700; color: var(--brand-danger);">${{ number_format($salidasCaja, 2) }}</div>
    </div>
    <div class="kpi-card" style="padding: 1rem;">
        <div class="kpi-title">Pedidos Pendientes</div>
        <div style="font-size: 1.5rem; font-weight: 700; color: var(--brand-warning);">{{ $pedidosPendientes }}</div>
    </div>
    <div class="kpi-card" style="padding: 1rem;">
        <div class="kpi-title">Estado de Caja</div>
        <div style="font-size: 1.5rem; font-weight: 700; color: {{ $currentBox ? 'var(--brand-accent)' : 'var(--brand-danger)' }};">
            {{ $currentBox ? 'Abierta' : 'Cerrada' }}
        </div>
    </div>
</div>

<!-- 4. VENTAS POR CANAL E INVENTARIO -->
<div class="data-grid" style="grid-template-columns: 1fr 1.5fr; margin-bottom: 2rem;">
    <!-- Sales by Channel -->
    <div class="panel">
        <div class="panel-header">
            <h2 class="panel-title">Rendimiento por Canal</h2>
        </div>
        <div style="display: flex; flex-direction: column; gap: 1.5rem; padding: 1rem 0;">
            @foreach($salesByChannel as $channel => $amount)
            <div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem; font-weight: 500;">
                    <span style="text-transform: capitalize;"><i data-lucide="{{ $channel == 'local' ? 'store' : ($channel == 'whatsapp' ? 'message-circle' : 'globe') }}" style="width: 16px; display: inline-block; vertical-align: text-bottom; margin-right: 4px;"></i> {{ $channel }}</span>
                    <span>${{ number_format($amount, 2) }}</span>
                </div>
                <div style="height: 8px; background: var(--bg-main); border-radius: 4px; overflow: hidden;">
                    <div style="width: {{ $totalVentas > 0 ? ($amount / $totalVentas) * 100 : 0 }}%; height: 100%; background: var(--brand-secondary);"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    
    <!-- Alerts Panel -->
    <div class="panel">
        <div class="panel-header">
            <h2 class="panel-title">Alertas Principales (Bajo Stock)</h2>
            <a href="{{ route('products.index') }}" class="btn-icon"><i data-lucide="external-link"></i></a>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>SKU / Código</th>
                    <th>Stock Restante</th>
                    <th>Acción Sugerida</th>
                </tr>
            </thead>
            <tbody>
                @forelse($lowStockProducts as $lp)
                <tr>
                    <td><strong>{{ $lp->name }}</strong></td>
                    <td>{{ $lp->barcode ?? 'N/A' }}</td>
                    <td><span class="badge" style="background: rgba(209, 67, 67, 0.1); color: var(--brand-danger);">{{ $lp->stock }} Unidades</span></td>
                    <td><a href="{{ route('purchases.create') }}" style="color: var(--brand-secondary); text-decoration: none; font-size: 0.85rem;">Crear Compra</a></td>
                </tr>
                @empty
                <tr><td colspan="4" style="text-align: center; padding: 2rem; color: var(--text-muted);">El inventario está en niveles óptimos.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- 5. TABLA DE ÚLTIMAS VENTAS -->
<div class="panel">
    <div class="panel-header">
        <h2 class="panel-title">Últimas Transacciones (Todos los canales)</h2>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Comprobante</th>
                <th>Cliente</th>
                <th>Canal</th>
                <th>Estado</th>
                <th style="text-align: right;">Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentSales as $sale)
            <tr>
                <td>{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                <td><strong>#{{ $sale->invoice_number }}</strong></td>
                <td>{{ $sale->customer ? $sale->customer->first_name . ' ' . $sale->customer->last_name : 'Consumidor Final' }}</td>
                <td>
                    <span class="badge badge-gray" style="text-transform: capitalize;">{{ $sale->channel }}</span>
                </td>
                <td>
                    @if($sale->status == 'paid')
                        <span class="badge badge-green">Pagado</span>
                    @elseif($sale->status == 'pending')
                        <span class="badge badge-warning">Pendiente</span>
                    @else
                        <span class="badge badge-gray">{{ ucfirst($sale->status) }}</span>
                    @endif
                </td>
                <td style="text-align: right;"><strong style="color: var(--brand-primary);">${{ number_format($sale->total, 2) }}</strong></td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align: center; padding: 2rem; color: var(--text-muted);">No hay transacciones registradas en este período.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
