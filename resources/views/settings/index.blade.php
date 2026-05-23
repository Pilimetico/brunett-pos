@extends('layouts.app')

@section('title', 'Configuración del Sistema - Brunett')
@section('page_title', 'Configuración del Sistema')

@section('content')

@php
    $company = isset($settings['company']) ? $settings['company']->keyBy('key') : collect();
@endphp

<div x-data="{ tab: 'general' }">
    <!-- Tabs Navigation -->
    <div style="display: flex; gap: 1rem; margin-bottom: 2rem; border-bottom: 1px solid var(--border-color);">
        <button @click="tab = 'general'" :class="{'active': tab === 'general'}" class="tab-btn">General y Empresa</button>
        <button @click="tab = 'payments'" :class="{'active': tab === 'payments'}" class="tab-btn">Formas de Pago</button>
        <button @click="tab = 'membership'" :class="{'active': tab === 'membership'}" class="tab-btn">Socio Brunett</button>
    </div>

    <style>
        .tab-btn { padding: 1rem 1.5rem; border: none; background: none; cursor: pointer; color: var(--text-secondary); font-weight: 600; border-bottom: 3px solid transparent; transition: all 0.2s; }
        .tab-btn.active { color: var(--brand-primary); border-bottom-color: var(--brand-primary); }
        
        .settings-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .settings-full {
            grid-column: span 2;
        }
        .settings-section-title {
            grid-column: span 2;
            margin-top: 2rem;
            margin-bottom: 1rem;
            border-bottom: 2px solid var(--bg-main);
            padding-bottom: 0.5rem;
            color: var(--brand-primary);
            font-size: 1.2rem;
            font-weight: 600;
        }
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        .form-group label {
            font-weight: 600;
            color: var(--text-primary);
            font-size: 0.9rem;
        }
        .form-group input, .form-group select, .form-group textarea {
            padding: 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            background-color: var(--bg-card);
            color: var(--text-primary);
            transition: border-color 0.2s;
            font-size: 0.95rem;
        }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
            border-color: var(--brand-primary);
            outline: none;
        }
        .checkbox-row {
            display: flex;
            align-items: center;
            gap: 2rem;
            padding: 1rem;
            background-color: var(--bg-main);
            border-radius: 8px;
            border: 1px solid var(--border-color);
        }
        .checkbox-container {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            cursor: pointer;
            user-select: none;
            font-weight: 600;
        }
        .checkbox-container input {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }
        .btn-search-sri {
            padding: 0.75rem 1rem;
            background-color: var(--brand-primary);
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            transition: opacity 0.2s;
        }
        .btn-search-sri:hover {
            opacity: 0.9;
        }
        .setting-row { display: grid; grid-template-columns: 1fr 2fr; gap: 2rem; padding: 1.5rem 0; border-bottom: 1px solid var(--bg-main); }
    </style>

    <!-- General Settings -->
    <div x-show="tab === 'general'" class="panel" style="padding: 2rem;">
        <form action="{{ route('settings.update') }}" method="POST">
            @csrf
            
            <div class="settings-grid">
                <div class="settings-section-title" style="margin-top: 0;">Parámetros de la Empresa</div>

                <!-- RUC y Búsqueda -->
                <div class="form-group settings-full">
                    <label>RUC</label>
                    <div style="display: flex; gap: 0.5rem; width: 100%;">
                        <input type="text" name="settings[company_ruc]" value="{{ $company->get('company_ruc')?->value }}" style="flex-grow: 1;">
                        <button type="button" class="btn-search-sri" onclick="alert('Búsqueda en SRI simulada. RUC encontrado.')">Presione ENTER para buscar en SRI</button>
                    </div>
                </div>

                <!-- Razón Social -->
                <div class="form-group settings-full">
                    <label>Razón Social</label>
                    <input type="text" name="settings[company_razon_social]" value="{{ $company->get('company_razon_social')?->value }}">
                </div>

                <!-- Nombre Comercial -->
                <div class="form-group settings-full">
                    <label>Nombre Comercial</label>
                    <input type="text" name="settings[company_name]" value="{{ $company->get('company_name')?->value }}">
                </div>

                <!-- Dirección -->
                <div class="form-group settings-full">
                    <label>Dirección</label>
                    <input type="text" name="settings[company_address]" value="{{ $company->get('company_address')?->value }}">
                </div>

                <!-- Teléfono y Teléfono Atención Cliente -->
                <div class="form-group">
                    <label>Teléfono</label>
                    <input type="text" name="settings[company_phone]" value="{{ $company->get('company_phone')?->value }}">
                </div>

                <div class="form-group">
                    <label>Teléfono Atención al Cliente</label>
                    <input type="text" name="settings[company_customer_service_phone]" value="{{ $company->get('company_customer_service_phone')?->value }}">
                </div>

                <!-- Ciudad y País -->
                <div class="form-group">
                    <label>Ciudad</label>
                    <input type="text" name="settings[company_city]" value="{{ $company->get('company_city')?->value }}">
                </div>

                <div class="form-group">
                    <label>País</label>
                    <input type="text" name="settings[company_country]" value="{{ $company->get('company_country')?->value }}">
                </div>

                <!-- Email -->
                <div class="form-group settings-full">
                    <label>Email</label>
                    <input type="email" name="settings[company_email]" value="{{ $company->get('company_email')?->value }}">
                </div>

                <!-- Representante Legal y Cédula -->
                <div class="form-group">
                    <label>Representante Legal</label>
                    <input type="text" name="settings[company_legal_representative]" value="{{ $company->get('company_legal_representative')?->value }}">
                </div>

                <div class="form-group">
                    <label>Cédula Rep. Legal</label>
                    <input type="text" name="settings[company_legal_rep_id]" value="{{ $company->get('company_legal_rep_id')?->value }}">
                </div>

                <!-- Contador y RUC Contador -->
                <div class="form-group">
                    <label>Contador</label>
                    <input type="text" name="settings[company_accountant]" value="{{ $company->get('company_accountant')?->value }}">
                </div>

                <div class="form-group">
                    <label>RUC Contador</label>
                    <input type="text" name="settings[company_accountant_ruc]" value="{{ $company->get('company_accountant_ruc')?->value }}">
                </div>

                <!-- Cont. Esp # y Desde -->
                <div class="form-group">
                    <label>Cont. Esp. #</label>
                    <input type="text" name="settings[company_special_contributor_num]" value="{{ $company->get('company_special_contributor_num')?->value }}">
                </div>

                <div class="form-group">
                    <label>Cont. Esp. Desde</label>
                    <input type="text" name="settings[company_special_contributor_since]" value="{{ $company->get('company_special_contributor_since')?->value }}">
                </div>

                <!-- Calif. Artesanal -->
                <div class="form-group settings-full">
                    <label>Calif. Artesanal</label>
                    <input type="text" name="settings[company_artisan_qualification]" value="{{ $company->get('company_artisan_qualification')?->value }}">
                </div>

                <!-- Checkbox: Obligado a llevar contabilidad -->
                <div class="settings-full checkbox-row">
                    <input type="hidden" name="settings[company_obligado_contabilidad]" value="NO">
                    <label class="checkbox-container">
                        <input type="checkbox" name="settings[company_obligado_contabilidad]" value="SI" {{ $company->get('company_obligado_contabilidad')?->value === 'SI' ? 'checked' : '' }}>
                        Obligado a llevar contabilidad
                    </label>
                </div>

                <!-- Checkbox: Contribuyente régimen RIMPE y dropdown -->
                <div class="settings-full checkbox-row" style="display: flex; justify-content: space-between; align-items: center;">
                    <div style="display: flex; align-items: center;">
                        <input type="hidden" name="settings[company_rimpe_regime]" value="NO">
                        <label class="checkbox-container">
                            <input type="checkbox" name="settings[company_rimpe_regime]" value="SI" {{ $company->get('company_rimpe_regime')?->value === 'SI' ? 'checked' : '' }}>
                            Contribuyente régimen RIMPE
                        </label>
                    </div>
                    <div style="width: 300px;">
                        <select name="settings[company_rimpe_type]" style="width: 100%; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 6px; background-color: var(--bg-card);">
                            <option value="RIMPE para emprendedores" {{ $company->get('company_rimpe_type')?->value === 'RIMPE para emprendedores' ? 'selected' : '' }}>RIMPE para emprendedores</option>
                            <option value="RIMPE popular" {{ $company->get('company_rimpe_type')?->value === 'RIMPE popular' ? 'selected' : '' }}>RIMPE popular</option>
                        </select>
                    </div>
                </div>

                <!-- Checkbox: Resolución Agente de retención y text-input -->
                <div class="settings-full checkbox-row" style="display: flex; justify-content: space-between; align-items: center;">
                    <div style="display: flex; align-items: center;">
                        <input type="hidden" name="settings[company_retention_agent]" value="NO">
                        <label class="checkbox-container">
                            <input type="checkbox" name="settings[company_retention_agent]" value="SI" {{ $company->get('company_retention_agent')?->value === 'SI' ? 'checked' : '' }}>
                            Resolución Agente de retención
                        </label>
                    </div>
                    <div style="width: 300px;">
                        <input type="text" name="settings[company_retention_resolution]" value="{{ $company->get('company_retention_resolution')?->value }}" placeholder="Número de resolución" style="width: 100%; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 6px; background-color: var(--bg-card);">
                    </div>
                </div>

                <div class="settings-section-title">Configuración de Tickets de Impresión</div>

                <!-- Leyenda del Ticket -->
                <div class="form-group settings-full">
                    <label>Leyenda del Ticket (Términos, condiciones y firmas en la impresión del ticket)</label>
                    <textarea name="settings[company_ticket_legend]" rows="8" style="font-family: monospace; font-size: 0.9rem;">{{ $company->get('company_ticket_legend')?->value }}</textarea>
                    <p style="font-size: 0.8rem; color: var(--text-secondary);">Esta leyenda se imprimirá en el pie de página de la factura o ticket de venta físico, simulando el estilo de Servientrega.</p>
                </div>

                <div class="settings-section-title">Metas Comerciales</div>

                <!-- Metas Comerciales -->
                @foreach($settings['goals'] ?? [] as $s)
                <div class="form-group">
                    <label>{{ $s->description }} (Clave: {{ $s->key }})</label>
                    <input type="text" name="settings[{{ $s->key }}]" value="{{ $s->value }}">
                </div>
                @endforeach
            </div>

            <div style="margin-top: 2rem; text-align: right; border-top: 1px solid var(--border-color); padding-top: 1.5rem;">
                <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2rem; font-size: 1rem; border-radius: 6px; font-weight: 600;">Guardar Cambios</button>
            </div>
        </form>
    </div>

    <!-- Payment Methods -->
    <div x-show="tab === 'payments'" class="panel" style="padding: 2rem;">
        <h3 style="margin-bottom: 1.5rem; color: var(--brand-primary);">Gestión de Comisiones y Recargos</h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Método</th>
                    <th>Comisión (%)</th>
                    <th>Recargo Cliente (%)</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($paymentMethods as $m)
                <tr>
                    <form action="{{ route('settings.payments.update', $m) }}" method="POST">
                        @csrf
                        <td><strong>{{ $m->name }}</strong></td>
                        <td><input type="number" name="commission_percentage" value="{{ $m->commission_percentage }}" step="0.01" style="width: 80px; padding: 0.4rem; border: 1px solid var(--border-color); border-radius: 4px;"></td>
                        <td><input type="number" name="charge_percentage" value="{{ $m->charge_percentage }}" step="0.01" style="width: 80px; padding: 0.4rem; border: 1px solid var(--border-color); border-radius: 4px;"></td>
                        <td>
                            <select name="is_active" style="padding: 0.4rem; border: 1px solid var(--border-color); border-radius: 4px;">
                                <option value="1" {{ $m->is_active ? 'selected' : '' }}>Activo</option>
                                <option value="0" {{ !$m->is_active ? 'selected' : '' }}>Inactivo</option>
                            </select>
                        </td>
                        <td style="text-align: right;">
                            <button type="submit" class="btn" style="padding: 0.4rem 0.8rem; font-size: 0.85rem;">Actualizar</button>
                        </td>
                    </form>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Membership -->
    <div x-show="tab === 'membership'" class="panel" style="padding: 2rem;">
        <form action="{{ route('settings.update') }}" method="POST">
            @csrf
            <h3 style="margin-bottom: 1.5rem; color: var(--brand-primary);">Parámetros Socio Brunett</h3>
            @foreach($settings['membership'] ?? [] as $s)
            <div class="setting-row">
                <div>
                    <label style="font-weight: 600;">{{ $s->description }}</label>
                    <p style="font-size: 0.8rem; color: var(--text-secondary);">Clave: {{ $s->key }}</p>
                </div>
                <input type="text" name="settings[{{ $s->key }}]" value="{{ $s->value }}" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;">
            </div>
            @endforeach
            <div style="margin-top: 2rem; text-align: right;">
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </div>
        </form>
    </div>
</div>

@endsection
