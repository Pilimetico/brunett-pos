@extends('layouts.app')

@section('title', 'Crear Rol - Brunett')
@section('page_title', 'Crear Rol')

@section('content')

<div style="max-width: 600px; margin: 0 auto;">
    <div class="panel">
        <form action="{{ route('roles.store') }}" method="POST">
            @csrf
            
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Nombre del Rol *</label>
                <input type="text" name="name" required class="form-control" style="width: 100%;" placeholder="Ej: Cajero, Superadmin, Gerente">
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="display: block; margin-bottom: 1rem; font-weight: 600;">Permisos Asignados</label>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    @foreach($permissions as $permission)
                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" style="width: 18px; height: 18px;">
                        <span>{{ str_replace('_', ' ', Str::title($permission->name)) }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <div style="border-top: 1px solid var(--border-color); padding-top: 1.5rem; display: flex; justify-content: flex-end; gap: 1rem;">
                <a href="{{ route('roles.index') }}" class="btn">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar Rol</button>
            </div>
        </form>
    </div>
</div>

@endsection
