@extends('layouts.app')

@section('title', 'Configuración del Sistema - Brunett')
@section('page_title', 'Configuración del Sistema')

@section('content')

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
        .setting-row { display: grid; grid-template-columns: 1fr 2fr; gap: 2rem; padding: 1.5rem 0; border-bottom: 1px solid var(--bg-main); }
    </style>

    <!-- General Settings -->
    <div x-show="tab === 'general'" class="panel" style="padding: 2rem;">
        <form action="{{ route('settings.update') }}" method="POST">
            @csrf
            <h3 style="margin-bottom: 1.5rem; color: var(--brand-primary);">Parámetros de Empresa</h3>
            @foreach($settings['company'] ?? [] as $s)
            <div class="setting-row">
                <div>
                    <label style="font-weight: 600;">{{ $s->description }}</label>
                    <p style="font-size: 0.8rem; color: var(--text-secondary);">Clave: {{ $s->key }}</p>
                </div>
                <input type="text" name="settings[{{ $s->key }}]" value="{{ $s->value }}" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;">
            </div>
            @endforeach

            <h3 style="margin-top: 3rem; margin-bottom: 1.5rem; color: var(--brand-primary);">Metas Comerciales</h3>
            @foreach($settings['goals'] ?? [] as $s)
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
