@extends('layouts.app')

@section('title', 'Roles y Permisos - Brunett Ecuador')
@section('page_title', 'Roles y Permisos')
@section('page_subtitle', 'Niveles de acceso del sistema')

@section('content')

<div class="panel" style="margin-bottom: 2rem;">
    <div class="panel-header" style="margin-bottom: 0;">
        <div style="display: flex; gap: 1rem; flex: 1;">
        </div>
        <div style="margin-left: 1rem;">
            <a href="{{ route('roles.create') }}" class="btn btn-primary">
                <i data-lucide="shield" style="width: 18px; margin-right: 8px;"></i> Crear Rol
            </a>
        </div>
    </div>
</div>

<div class="panel">
    <table class="data-table">
        <thead>
            <tr>
                <th>Nombre del Rol</th>
                <th>Permisos Asignados</th>
                <th style="text-align: right;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($roles as $role)
            <tr>
                <td><strong>{{ $role->name }}</strong></td>
                <td>
                    @forelse($role->permissions as $permission)
                        <span class="badge badge-blue" style="margin-bottom: 4px; display: inline-block;">{{ str_replace('_', ' ', Str::title($permission->name)) }}</span>
                    @empty
                        <span class="badge badge-gray">Sin permisos específicos</span>
                    @endforelse
                </td>
                <td style="text-align: right;">
                    <a href="{{ route('roles.edit', $role) }}" class="btn-icon" title="Editar"><i data-lucide="edit-2" style="width: 16px;"></i></a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" style="text-align: center; padding: 2rem; color: var(--text-muted);">No hay roles registrados.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
