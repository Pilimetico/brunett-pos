@extends('layouts.app')

@section('title', 'Nuevo Proveedor - Brunett')
@section('page_title', 'Registrar Proveedor')

@section('content')

<div class="panel">
    <form action="{{ route('suppliers.store') }}" method="POST">
        @csrf
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
            <div>
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Nombre Comercial / Razón Social *</label>
                    <input type="text" name="name" required style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;">
                </div>
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">RUC / Identificación</label>
                    <input type="text" name="document_number" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;">
                </div>
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Persona de Contacto</label>
                    <input type="text" name="contact_person" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;">
                </div>
            </div>
            <div>
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Correo Electrónico</label>
                    <input type="email" name="email" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;">
                </div>
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Teléfono / WhatsApp</label>
                    <input type="text" name="phone" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;">
                </div>
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Dirección</label>
                    <input type="text" name="address" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;">
                </div>
            </div>
        </div>
        
        <div style="border-top: 1px solid var(--border-color); padding-top: 1.5rem; display: flex; justify-content: flex-end; gap: 1rem;">
            <a href="{{ route('suppliers.index') }}" class="btn">Cancelar</a>
            <button type="submit" class="btn btn-primary">Guardar Proveedor</button>
        </div>
    </form>
</div>

@endsection
