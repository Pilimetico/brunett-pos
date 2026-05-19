@extends('layouts.app')

@section('title', 'Editar Proveedor - Brunett')
@section('page_title', 'Editar Proveedor')

@section('content')

<div style="max-width: 600px; margin: 0 auto;">
    <div class="panel">
        <form action="{{ route('suppliers.update', $supplier) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Nombre o Razón Social *</label>
                <input type="text" name="name" value="{{ $supplier->name }}" required class="form-control" style="width: 100%;">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">RUC / Documento</label>
                <input type="text" name="document_number" value="{{ $supplier->document_number }}" class="form-control" style="width: 100%;">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Teléfono</label>
                <input type="text" name="phone" value="{{ $supplier->phone }}" class="form-control" style="width: 100%;">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Correo Electrónico</label>
                <input type="email" name="email" value="{{ $supplier->email }}" class="form-control" style="width: 100%;">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Estado</label>
                <select name="is_active" class="form-control" style="width: 100%;">
                    <option value="1" {{ $supplier->is_active ? 'selected' : '' }}>Activo</option>
                    <option value="0" {{ !$supplier->is_active ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>

            <div style="border-top: 1px solid var(--border-color); padding-top: 1.5rem; display: flex; justify-content: flex-end; gap: 1rem;">
                <a href="{{ route('suppliers.index') }}" class="btn">Cancelar</a>
                <button type="submit" class="btn btn-primary">Actualizar Proveedor</button>
            </div>
        </form>
    </div>
</div>

@endsection
