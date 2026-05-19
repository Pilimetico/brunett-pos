@extends('layouts.app')

@section('title', 'Perfil de Cliente - Brunett Ecuador')
@section('page_title', 'Perfil del Cliente')
@section('page_subtitle', 'CRM y Seguimiento de Socio Brunett')

@section('content')

<div style="display: grid; grid-template-columns: 1fr 350px; gap: 2rem;">
    
    <!-- Left Column: Edit Form & History -->
    <div style="display: flex; flex-direction: column; gap: 2rem;">
        
        <!-- Edit Form -->
        <div class="panel">
            <form action="{{ route('customers.update', $customer) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
                    <div>
                        <h3 style="margin-bottom: 1rem; color: var(--brand-primary); font-size: 1.1rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.5rem;">Datos Personales</h3>
                        
                        <div style="margin-bottom: 1rem;">
                            <label style="display: block; margin-bottom: 0.4rem; font-weight: 500;">Nombres *</label>
                            <input type="text" name="first_name" value="{{ $customer->first_name }}" required style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;">
                        </div>
                        <div style="margin-bottom: 1rem;">
                            <label style="display: block; margin-bottom: 0.4rem; font-weight: 500;">Apellidos</label>
                            <input type="text" name="last_name" value="{{ $customer->last_name }}" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;">
                        </div>
                        <div style="margin-bottom: 1rem;">
                            <label style="display: block; margin-bottom: 0.4rem; font-weight: 500;">Cédula / RUC</label>
                            <input type="text" name="document_number" value="{{ $customer->document_number }}" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;">
                        </div>
                    </div>
                    
                    <div>
                        <h3 style="margin-bottom: 1rem; color: var(--brand-primary); font-size: 1.1rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.5rem;">Socio & Crédito</h3>
                        
                        <div style="margin-bottom: 1rem;">
                            <label style="display: block; margin-bottom: 0.4rem; font-weight: 500;">Tipo de Cliente</label>
                            <select name="type" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;">
                                <option value="normal" {{ $customer->type == 'normal' ? 'selected' : '' }}>Normal</option>
                                <option value="socio_brunett" {{ $customer->type == 'socio_brunett' ? 'selected' : '' }}>Socio Brunett</option>
                            </select>
                        </div>
                        
                        <div style="margin-bottom: 1rem;">
                            <label style="display: block; margin-bottom: 0.4rem; font-weight: 500;">Límite de Crédito ($)</label>
                            <input type="number" step="0.01" name="credit_limit" value="{{ $customer->credit_limit }}" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;">
                        </div>

                        <div style="margin-bottom: 1rem;">
                            <label style="display: block; margin-bottom: 0.4rem; font-weight: 500;">Estado</label>
                            <select name="is_active" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;">
                                <option value="1" {{ $customer->is_active ? 'selected' : '' }}>Habilitado</option>
                                <option value="0" {{ !$customer->is_active ? 'selected' : '' }}>Bloqueado</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div style="border-top: 1px solid var(--border-color); padding-top: 1.5rem; display: flex; justify-content: flex-end; gap: 1rem;">
                    <button type="submit" class="btn btn-primary"><i data-lucide="save" style="width: 18px; margin-right: 8px;"></i> Guardar Cambios</button>
                </div>
            </form>
        </div>

    </div>

    <!-- Right Column: Socio & Credit Stats (Visible for everyone) -->
    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        <div class="panel" style="background: var(--brand-primary); color: white;">
            <div style="text-align: center; padding: 1rem 0;">
                <div style="width: 60px; height: 60px; border-radius: 50%; background: rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                    <i data-lucide="user" style="width: 30px; height: 30px; color: white;"></i>
                </div>
                <h2 style="color: white; font-size: 1.3rem;">{{ $customer->first_name }}</h2>
                <p style="opacity: 0.7; font-size: 0.9rem;">Registrado el {{ $customer->created_at->format('d/m/Y') }}</p>
            </div>
        </div>

        <div class="kpi-card" style="box-shadow: none; border: 1px solid var(--border-color); border-left: 5px solid {{ $customer->type == 'socio_brunett' ? 'var(--brand-accent)' : 'var(--border-color)' }}">
            <div class="kpi-title">Estatus Socio</div>
            @if($customer->type == 'socio_brunett')
                <div class="kpi-value" style="font-size: 1.5rem; color: var(--brand-accent);">ACTIVO</div>
                <div style="font-size: 0.85rem; color: var(--text-secondary); margin-top: 0.5rem;">
                    Membresía: <span style="font-weight: 600;">Vigente</span>
                </div>
            @else
                <div class="kpi-value" style="font-size: 1.5rem; color: var(--text-muted);">NO ES SOCIO</div>
                <form action="{{ route('customers.make-socio', $customer) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem; background: var(--brand-accent); color: var(--brand-primary); border: none;">Activar Membresía</button>
                </form>
            @endif
        </div>

        <div class="kpi-card" style="box-shadow: none; border: 1px solid var(--border-color);">
            <div class="kpi-title">Crédito Disponible</div>
            <div class="kpi-value" style="font-size: 1.8rem; color: var(--brand-secondary);">${{ number_format($customer->credit_limit - $customer->credit_used, 2) }}</div>
            <div style="width: 100%; height: 8px; background: var(--bg-main); border-radius: 4px; margin-top: 1rem; overflow: hidden;">
                <div style="width: {{ $customer->credit_limit > 0 ? ($customer->credit_used / $customer->credit_limit) * 100 : 0 }}%; height: 100%; background: var(--brand-secondary);"></div>
            </div>
            <p style="font-size: 0.8rem; color: var(--text-secondary); margin-top: 0.5rem;">Cupo Total: ${{ number_format($customer->credit_limit, 2) }}</p>
        </div>
    </div>
</div>

@if(auth()->user() && auth()->user()->hasRole('Administrador'))
<div style="margin-top: 2rem;">
    <h3 style="margin-bottom: 1.5rem; color: var(--brand-primary);"><i data-lucide="bar-chart-2" style="width: 20px; display: inline-block; vertical-align: middle;"></i> Mini Dashboard Financiero (Solo Admin)</h3>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        
        <div class="kpi-card" style="box-shadow: none; border: 1px solid var(--border-color);">
            <div class="kpi-title">Total Comprado</div>
            <div class="kpi-value" style="font-size: 1.8rem;">${{ number_format($totalSpent, 2) }}</div>
            <p style="font-size: 0.8rem; color: var(--text-secondary); margin-top: 0.5rem;">En {{ $numberOfPurchases }} compras.</p>
        </div>

        <div class="kpi-card" style="box-shadow: none; border: 1px solid var(--border-color);">
            <div class="kpi-title">Ticket Promedio</div>
            <div class="kpi-value" style="font-size: 1.8rem; color: #0284c7;">${{ number_format($ticketPromedio, 2) }}</div>
            <p style="font-size: 0.8rem; color: var(--text-secondary); margin-top: 0.5rem;">Canal favorito: <strong>{{ $canalFavorito }}</strong></p>
        </div>

        <div class="kpi-card" style="box-shadow: none; border: 1px solid var(--border-color);">
            <div class="kpi-title">Ganancia Neta</div>
            <div class="kpi-value" style="font-size: 1.8rem; color: #16a34a;">${{ number_format($ganancia, 2) }}</div>
            <p style="font-size: 0.8rem; color: var(--text-secondary); margin-top: 0.5rem;">Margen promedio: <strong>{{ number_format($margen, 1) }}%</strong></p>
        </div>

        <div class="kpi-card" style="box-shadow: none; border: 1px solid var(--border-color); border-left: 5px solid {{ $saldoPendiente > 0 ? '#dc2626' : '#16a34a' }};">
            <div class="kpi-title">Deuda / Saldo Pendiente</div>
            <div class="kpi-value" style="font-size: 1.8rem; color: {{ $saldoPendiente > 0 ? '#dc2626' : '#16a34a' }};">${{ number_format($saldoPendiente, 2) }}</div>
            <p style="font-size: 0.8rem; color: var(--text-secondary); margin-top: 0.5rem;">Crédito Usado / Vencido.</p>
        </div>

    </div>
</div>
@endif

<div class="panel" style="margin-top: 2rem;">
    <h3 style="margin-bottom: 1.5rem; color: var(--brand-primary);">Historial de Compras (Últimas 10)</h3>
    <table class="data-table">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Factura</th>
                <th>Canal</th>
                <th style="text-align: right;">Total</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            @forelse($salesHistory as $sale)
            <tr>
                <td>{{ $sale->created_at->format('d/m/Y') }}</td>
                <td><strong>#{{ $sale->invoice_number }}</strong></td>
                <td><span class="badge badge-gray">{{ ucfirst($sale->channel) }}</span></td>
                <td style="text-align: right; font-weight: 600;">${{ number_format($sale->total, 2) }}</td>
                <td><button class="btn-icon"><i data-lucide="file-text" style="width: 16px;"></i></button></td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align: center; padding: 2rem;">Este cliente aún no registra compras.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

</div>

@endsection
