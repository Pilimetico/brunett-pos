@extends('layouts.app')

@section('title', 'Crear Usuario - Brunett')
@section('page_title', 'Crear Usuario')

@section('content')

<div style="max-width: 600px; margin: 0 auto;">
    <div class="panel">
        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Nombre Completo *</label>
                <input type="text" name="name" required class="form-control" style="width: 100%;">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Correo Electrónico *</label>
                <input type="email" name="email" required class="form-control" style="width: 100%;">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Contraseña *</label>
                <input type="password" name="password" required class="form-control" style="width: 100%;" minlength="6">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Asignar Rol *</label>
                <select name="role" class="form-control" style="width: 100%;" required>
                    <option value="">Selecciona un rol...</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                    @endforeach
                </select>
                @if($roles->isEmpty())
                    <small style="color: var(--brand-warning); display: block; margin-top: 0.5rem;"><i data-lucide="alert-triangle" style="width: 14px;"></i> Primero debes crear roles en el módulo de Roles.</small>
                @endif
            </div>

            <div style="border-top: 1px solid var(--border-color); padding-top: 1.5rem; display: flex; justify-content: flex-end; gap: 1rem;">
                <a href="{{ route('users.index') }}" class="btn">Cancelar</a>
                <button type="submit" class="btn btn-primary" {{ $roles->isEmpty() ? 'disabled' : '' }}>Guardar Usuario</button>
            </div>
        </form>
    </div>
</div>

@endsection
