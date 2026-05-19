@extends('layouts.app')

@section('title', 'Usuarios - Brunett Ecuador')
@section('page_title', 'Gestión de Usuarios')
@section('page_subtitle', 'Cajeros, vendedores y administradores')

@section('content')

<div class="panel" style="margin-bottom: 2rem;">
    <div class="panel-header" style="margin-bottom: 0;">
        <div style="display: flex; gap: 1rem; flex: 1;">
            <input type="text" placeholder="Buscar usuario..." style="padding: 0.75rem 1rem; border-radius: 8px; border: 1px solid var(--border-color); flex: 1;">
        </div>
        <div style="margin-left: 1rem;">
            <a href="{{ route('users.create') }}" class="btn btn-primary">
                <i data-lucide="user-plus" style="width: 18px; margin-right: 8px;"></i> Crear Usuario
            </a>
        </div>
    </div>
</div>

<div class="panel">
    <table class="data-table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Estado</th>
                <th style="text-align: right;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td><strong>{{ $user->name }}</strong></td>
                <td>{{ $user->email }}</td>
                <td>
                    @foreach($user->roles as $role)
                        <span class="badge badge-blue">{{ $role->name }}</span>
                    @endforeach
                    @if($user->roles->isEmpty())
                        <span class="badge badge-gray">Sin Rol</span>
                    @endif
                </td>
                <td>
                    <span class="badge badge-green">Activo</span>
                </td>
                <td style="text-align: right;">
                    <a href="{{ route('users.edit', $user) }}" class="btn-icon" title="Editar"><i data-lucide="edit-2" style="width: 16px;"></i></a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; padding: 2rem; color: var(--text-muted);">No hay usuarios registrados.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
