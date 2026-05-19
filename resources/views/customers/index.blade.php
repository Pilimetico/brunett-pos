@extends('layouts.app')

@section('title', 'Clientes - Brunett Ecuador')
@section('page_title', 'Gestión de Clientes')
@section('page_subtitle', 'Socio Brunett y Base de Datos General')

@section('content')

<div class="panel" style="margin-bottom: 2rem;">
    <div class="panel-header" style="margin-bottom: 0;">
        <div style="display: flex; gap: 1rem; flex: 1;">
            <input type="text" placeholder="Buscar por nombre, documento o teléfono..." style="padding: 0.75rem 1rem; border-radius: 8px; border: 1px solid var(--border-color); flex: 1; font-family: var(--font-body); font-size: 0.95rem;">
        </div>
        <div style="margin-left: 1rem;">
            <a href="{{ route('customers.create') }}" class="btn btn-primary">
                <i data-lucide="user-plus" style="width: 18px; margin-right: 8px;"></i> Registrar Nuevo
            </a>
        </div>
    </div>
</div>

<div class="panel">
    <table class="data-table">
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Cédula/RUC</th>
                <th>Tipo</th>
                <th>Teléfono</th>
                <th>Socio Brunett</th>
                <th>Estado</th>
                <th style="text-align: right;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($customers as $customer)
            <tr>
                <td>
                    <div style="font-weight: 600; color: var(--brand-primary);">{{ $customer->first_name }} {{ $customer->last_name }}</div>
                    <div style="font-size: 0.85rem; color: var(--text-secondary);">{{ $customer->email }}</div>
                </td>
                <td>{{ $customer->document_number }}</td>
                <td>
                    <span class="badge {{ $customer->type == 'socio_brunett' ? 'badge-blue' : 'badge-gray' }}">
                        {{ $customer->type == 'socio_brunett' ? 'Socio' : 'Normal' }}
                    </span>
                </td>
                <td>{{ $customer->phone }}</td>
                <td>
                    @if($customer->type == 'socio_brunett')
                        <div style="display: flex; align-items: center; gap: 0.5rem; color: var(--brand-accent);">
                            <i data-lucide="check-circle" style="width: 14px;"></i>
                            <span style="font-size: 0.85rem; font-weight: 500;">Activo</span>
                        </div>
                    @else
                        <span style="color: var(--text-muted); font-size: 0.85rem;">No aplica</span>
                    @endif
                </td>
                <td>
                    @if($customer->is_active)
                        <span class="badge badge-green">Habilitado</span>
                    @else
                        <span class="badge badge-gray" style="background: rgba(209, 67, 67, 0.1); color: var(--brand-danger);">Bloqueado</span>
                    @endif
                </td>
                <td style="text-align: right;">
                    <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                        <a href="{{ route('customers.edit', $customer) }}" class="btn-icon" title="Ver Perfil CRM"><i data-lucide="eye" style="width: 16px;"></i></a>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; padding: 3rem; color: var(--text-muted);">No hay clientes registrados.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div style="margin-top: 1.5rem;">
        {{ $customers->links() }}
    </div>
</div>

@endsection
