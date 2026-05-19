@extends('layouts.app')

@section('title', 'Editar Usuario - Brunett')
@section('page_title', 'Editar Usuario')

@section('content')

<div style="max-width: 600px; margin: 0 auto;">
    <div class="panel">
        <form action="{{ route('users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Nombre Completo *</label>
                <input type="text" name="name" value="{{ $user->name }}" required class="form-control" style="width: 100%;">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Correo Electrónico *</label>
                <input type="email" name="email" value="{{ $user->email }}" required class="form-control" style="width: 100%;">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Contraseña</label>
                <input type="password" name="password" class="form-control" style="width: 100%;" minlength="6">
                <small style="color: var(--text-secondary); display: block; margin-top: 0.3rem;">Deja en blanco si no deseas cambiar la contraseña.</small>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Asignar Rol *</label>
                <select name="role" class="form-control" style="width: 100%;" required>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>

            <div style="border-top: 1px solid var(--border-color); padding-top: 1.5rem; display: flex; justify-content: flex-end; gap: 1rem;">
                <a href="{{ route('users.index') }}" class="btn">Cancelar</a>
                <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
            </div>
        </form>
    </div>
</div>

@endsection
