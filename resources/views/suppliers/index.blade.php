@extends('layouts.app')

@section('title', 'Proveedores - Brunett')
@section('page_title', 'Gestión de Proveedores')
@section('page_subtitle', 'Maestro de proveedores de mercadería y servicios')

@section('content')

<div class="panel">
    <div class="panel-header">
        <h2 class="panel-title">Lista de Proveedores</h2>
        <a href="{{ route('suppliers.create') }}" class="btn btn-primary"><i data-lucide="plus"></i> Nuevo Proveedor</a>
    </div>
    
    <table class="data-table">
        <thead>
            <tr>
                <th>Nombre / Empresa</th>
                <th>RUC / Cédula</th>
                <th>Contacto</th>
                <th>Teléfono</th>
                <th>Estado</th>
                <th style="text-align: right;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($suppliers as $supplier)
            <tr>
                <td><strong>{{ $supplier->name }}</strong></td>
                <td>{{ $supplier->document_number }}</td>
                <td>{{ $supplier->contact_person }}</td>
                <td>{{ $supplier->phone }}</td>
                <td>
                    <span style="background: {{ $supplier->is_active ? '#ecfdf5' : '#fef2f2' }}; color: {{ $supplier->is_active ? '#059669' : '#dc2626' }}; padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.75rem;">
                        {{ $supplier->is_active ? 'Activo' : 'Inactivo' }}
                    </span>
                </td>
                <td style="text-align: right;">
                    <a href="{{ route('suppliers.edit', $supplier) }}" class="btn" style="padding: 0.4rem; background: transparent; color: var(--brand-primary);"><i data-lucide="edit-2" style="width: 18px;"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div style="margin-top: 1.5rem;">
        {{ $suppliers->links() }}
    </div>
</div>

@endsection
