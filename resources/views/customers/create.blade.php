@extends('layouts.app')

@section('title', 'Nuevo Cliente - Brunett Ecuador')
@section('page_title', 'Registrar Nuevo Cliente')
@section('page_subtitle', 'Añadir cliente a la base de datos maestra')

@section('content')

<div class="panel">
    <form action="{{ route('customers.store') }}" method="POST">
        @csrf
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
            <!-- Información Básica -->
            <div>
                <h3 style="margin-bottom: 1rem; color: var(--brand-primary); font-size: 1.1rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.5rem;">Información Personal</h3>
                
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Nombres *</label>
                    <input type="text" name="first_name" required style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;">
                </div>
                
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Apellidos</label>
                    <input type="text" name="last_name" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;">
                </div>
                
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Cédula / RUC</label>
                    <input type="text" name="document_number" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;">
                </div>

                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Correo Electrónico</label>
                    <input type="email" name="email" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;">
                </div>
            </div>
            
            <!-- Contacto y Membresía -->
            <div>
                <h3 style="margin-bottom: 1rem; color: var(--brand-primary); font-size: 1.1rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.5rem;">Contacto y Tipo</h3>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Teléfono</label>
                        <input type="text" name="phone" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">WhatsApp</label>
                        <input type="text" name="whatsapp" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;">
                    </div>
                </div>

                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Tipo de Cliente</label>
                    <select name="type" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;">
                        <option value="normal">Normal</option>
                        <option value="socio_brunett">Socio Brunett</option>
                    </select>
                </div>

                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Ciudad</label>
                    <input type="text" name="city" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;">
                </div>
                
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Dirección</label>
                    <input type="text" name="address" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;">
                </div>
                <div class="membership-fields" style="display: none; background: #f0fdf4; padding: 1rem; border-radius: 6px; border: 1px solid #bbf7d0; margin-bottom: 1rem;">
                    <h4 style="margin-bottom: 0.5rem; color: #166534;">Configuración de Socio</h4>
                    <div style="margin-bottom: 0.5rem;">
                        <label style="display: block; margin-bottom: 0.25rem;">Vencimiento de Membresía</label>
                        <input type="date" name="membership_expires_at" class="form-control" style="width: 100%;">
                    </div>
                    <label style="display: flex; align-items: center; gap: 0.5rem;">
                        <input type="checkbox" name="is_member_active" value="1" checked> Membresía Activa (Pagada)
                    </label>
                </div>

                <div style="margin-bottom: 1rem; padding-top: 1rem; border-top: 1px solid var(--border-color);">
                    <label style="display: flex; align-items: center; gap: 0.5rem; font-weight: 500;">
                        <input type="checkbox" name="has_credit" id="has_credit_toggle" value="1"> 
                        ¿Cliente con Crédito Autorizado?
                    </label>
                </div>

                <div class="credit-fields" style="display: none; background: #fffbeb; padding: 1rem; border-radius: 6px; border: 1px solid #fde68a; margin-bottom: 1rem;">
                    <h4 style="margin-bottom: 0.5rem; color: #92400e;">Configuración de Crédito</h4>
                    <label style="display: block; margin-bottom: 0.25rem;">Límite de Crédito Autorizado ($)</label>
                    <input type="number" step="0.01" name="credit_limit" class="form-control" style="width: 100%;" placeholder="Ej. 100.00">
                    <small style="color: #92400e; display: block; margin-top: 0.5rem;"><i data-lucide="alert-triangle" style="width: 12px;"></i> Solo el administrador puede autorizar créditos.</small>
                </div>
            </div>
        </div>

        <script>
            document.querySelector('select[name="type"]').addEventListener('change', function() {
                document.querySelector('.membership-fields').style.display = this.value === 'socio_brunett' ? 'block' : 'none';
            });
            document.getElementById('has_credit_toggle').addEventListener('change', function() {
                document.querySelector('.credit-fields').style.display = this.checked ? 'block' : 'none';
            });
        </script>

        <div style="border-top: 1px solid var(--border-color); padding-top: 1.5rem; display: flex; justify-content: flex-end; gap: 1rem;">
            <a href="{{ route('customers.index') }}" class="btn" style="background: white; border: 1px solid var(--border-color); color: var(--text-primary);">Cancelar</a>
            <button type="submit" class="btn btn-primary"><i data-lucide="save" style="width: 18px; margin-right: 8px;"></i> Registrar Cliente</button>
        </div>
    </form>
</div>

@endsection
