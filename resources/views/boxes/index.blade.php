@extends('layouts.app')

@section('title', 'Caja - Brunett Ecuador')
@section('page_title', 'Caja y Bancos')
@section('page_subtitle', 'Control de efectivo y cierres de jornada')

@section('content')

<div x-data="{ showMovementModal: false, movementType: 'out' }">
    
    <div style="display: grid; grid-template-columns: 1fr 320px; gap: 2rem;">
        
        <!-- Left: Current Box Status or Open Form -->
        <div>
            @if(!$currentBox)
                <div class="panel" style="text-align: center; padding: 4rem 2rem;">
                    <div style="color: var(--text-muted); margin-bottom: 1.5rem;">
                        <i data-lucide="lock" style="width: 64px; height: 64px;"></i>
                    </div>
                    <h2 style="margin-bottom: 1rem;">La caja está cerrada</h2>
                    <p style="color: var(--text-secondary); margin-bottom: 2rem;">Para comenzar a vender en el POS, debes realizar la apertura de caja.</p>
                    
                    <form action="{{ route('boxes.open') }}" method="POST" style="max-width: 400px; margin: 0 auto;">
                        @csrf
                        <div style="margin-bottom: 1.5rem; text-align: left;">
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Monto de Apertura ($)</label>
                            <input type="number" step="0.01" name="opening_balance" required class="form-control" style="width: 100%; padding: 1rem; border: 2px solid var(--brand-secondary); border-radius: 8px; font-size: 1.2rem; font-weight: bold;" value="0.00">
                        </div>
                        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem; font-size: 1.1rem;">Abrir Caja de Hoy</button>
                    </form>
                </div>
            @else
                <!-- Active Box Info -->
                <div class="panel" style="margin-bottom: 2rem; border-left: 5px solid var(--brand-accent);">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                        <div>
                            <h2 style="font-size: 1.4rem;">Caja Activa</h2>
                            <p style="color: var(--text-secondary); font-size: 0.9rem;">Abierta el {{ $currentBox->opened_at }}</p>
                        </div>
                        <span class="badge badge-green" style="font-size: 1rem; padding: 0.5rem 1rem;">ABIERTAS</span>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem;">
                        <div class="kpi-card" style="box-shadow: none; border: 1px solid var(--border-color); background: var(--bg-main);">
                            <div class="kpi-title">Monto Inicial</div>
                            <div class="kpi-value" style="font-size: 1.5rem;">${{ number_format($currentBox->opening_balance, 2) }}</div>
                        </div>
                        <div class="kpi-card" style="box-shadow: none; border: 1px solid var(--border-color); background: var(--bg-main);">
                            <div class="kpi-title">Salidas / Gastos</div>
                            <div class="kpi-value" style="font-size: 1.5rem; color: var(--brand-danger);">-${{ number_format(\App\Models\BoxMovement::where('box_id', $currentBox->id)->where('type', 'out')->sum('amount'), 2) }}</div>
                        </div>
                        <div class="kpi-card" style="box-shadow: none; border: 1px solid var(--brand-accent); background: rgba(0, 208, 156, 0.05);">
                            <div class="kpi-title">Efectivo Estimado</div>
                            <div class="kpi-value" style="font-size: 1.8rem; color: var(--brand-primary);">${{ number_format($currentBox->opening_balance + \App\Models\Sale::where('created_at', '>=', $currentBox->opened_at)->sum('total') - \App\Models\BoxMovement::where('box_id', $currentBox->id)->where('type', 'out')->sum('amount'), 2) }}</div>
                        </div>
                    </div>
                </div>

                <!-- Recent Movements -->
                <div class="panel">
                    <div class="panel-header">
                        <h2 class="panel-title">Movimientos de esta Caja</h2>
                        <div style="display: flex; gap: 0.5rem;">
                            <button @click="showMovementModal = true; movementType = 'in'" class="btn" style="background: rgba(0, 208, 156, 0.1); color: #009973;"><i data-lucide="plus"></i> Ingreso</button>
                            <button @click="showMovementModal = true; movementType = 'out'" class="btn" style="background: rgba(209, 67, 67, 0.1); color: var(--brand-danger);"><i data-lucide="minus"></i> Gasto / Salida</button>
                        </div>
                    </div>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Hora</th>
                                <th>Tipo</th>
                                <th>Motivo / Razón</th>
                                <th>Involucrado</th>
                                <th style="text-align: right;">Monto</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(\App\Models\BoxMovement::where('box_id', $currentBox->id)->orderBy('created_at', 'desc')->get() as $m)
                                <tr>
                                    <td>{{ $m->created_at->format('H:i') }}</td>
                                    <td><span class="badge {{ $m->type == 'in' ? 'badge-green' : 'badge-gray' }}" style="{{ $m->type == 'out' ? 'color: var(--brand-danger); background: rgba(209, 67, 67, 0.1);' : '' }}">{{ strtoupper($m->type) }}</span></td>
                                    <td>{{ $m->reason }}</td>
                                    <td>{{ $m->person_involved ?? '-' }}</td>
                                    <td style="text-align: right; font-weight: 600;">{{ $m->type == 'out' ? '-' : '' }}${{ number_format($m->amount, 2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="5" style="text-align: center; color: var(--text-muted); padding: 2rem;">No hay movimientos manuales registrados.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- Right: Close Box Form (If Open) -->
        <div>
            @if($currentBox)
                <div class="panel" style="border-top: 5px solid var(--brand-primary);">
                    <h3 style="margin-bottom: 1.5rem;">Cerrar Jornada</h3>
                    <form action="{{ route('boxes.close', $currentBox) }}" method="POST">
                        @csrf
                        <div style="margin-bottom: 1.5rem;">
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Efectivo contado físico ($)</label>
                            <input type="number" step="0.01" name="closing_balance" required style="width: 100%; padding: 0.8rem; border: 1px solid var(--border-color); border-radius: 6px; font-size: 1.2rem; font-weight: 700;" placeholder="0.00">
                            <p style="font-size: 0.8rem; color: var(--text-secondary); margin-top: 0.5rem;">Cuenta todo el dinero de la gaveta al final del turno.</p>
                        </div>
                        <div style="margin-bottom: 1.5rem;">
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Notas de cierre</label>
                            <textarea name="notes" rows="3" style="width: 100%; padding: 0.8rem; border: 1px solid var(--border-color); border-radius: 6px; font-family: var(--font-body);"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem; background: var(--brand-primary);">Finalizar Turno</button>
                    </form>
                </div>
            @endif
            
            <div class="panel" style="margin-top: 1.5rem; background: var(--brand-primary); color: white;">
                <h3 style="color: white; font-size: 1rem; margin-bottom: 1rem;">Ayuda</h3>
                <p style="font-size: 0.85rem; opacity: 0.8;">Recuerda que todas las ventas realizadas en el POS se suman automáticamente al flujo de caja.</p>
            </div>
        </div>

    </div>

    <!-- Movement Modal (AlpineJS) -->
    <div x-show="showMovementModal" style="position: fixed; inset: 0; background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; z-index: 100;" x-cloak>
        <div class="panel" style="width: 450px; padding: 2rem;">
            <h2 x-text="movementType === 'in' ? 'Registrar Ingreso' : 'Registrar Gasto / Salida'" style="margin-bottom: 1.5rem;"></h2>
            
            <form action="{{ route('boxes.movement') }}" method="POST">
                @csrf
                <input type="hidden" name="box_id" value="{{ $currentBox ? $currentBox->id : '' }}">
                <input type="hidden" name="type" :value="movementType">
                
                <div style="margin-bottom: 1.2rem;">
                    <label style="display: block; margin-bottom: 0.4rem; font-weight: 500;">Monto ($)</label>
                    <input type="number" step="0.01" name="amount" required style="width: 100%; padding: 0.8rem; border: 1px solid var(--border-color); border-radius: 6px;">
                </div>
                
                <div style="margin-bottom: 1.2rem;">
                    <label style="display: block; margin-bottom: 0.4rem; font-weight: 500;">Motivo / Razón</label>
                    <input type="text" name="reason" required placeholder="Ej. Pago transporte, Almuerzo, etc." style="width: 100%; padding: 0.8rem; border: 1px solid var(--border-color); border-radius: 6px;">
                </div>

                <div style="margin-bottom: 1.2rem;">
                    <label style="display: block; margin-bottom: 0.4rem; font-weight: 500;">Persona involucrada</label>
                    <input type="text" name="person_involved" placeholder="Ej. Nombre del proveedor o empleado" style="width: 100%; padding: 0.8rem; border: 1px solid var(--border-color); border-radius: 6px;">
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                    <button type="button" @click="showMovementModal = false" class="btn" style="flex: 1; border: 1px solid var(--border-color);">Cancelar</button>
                    <button type="submit" class="btn btn-primary" style="flex: 1;" :style="movementType === 'out' ? 'background: var(--brand-danger);' : ''">Registrar</button>
                </div>
            </form>
        </div>
    </div>

</div>

@endsection
