@extends('layouts.app')

@section('title', 'Editar Marca - Brunett')
@section('page_title', 'Editar Marca')

@section('content')

<div style="max-width: 600px; margin: 0 auto;">
    <div class="panel">
        <form action="{{ route('brands.update', $brand) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Nombre de la Marca *</label>
                <input type="text" name="name" value="{{ $brand->name }}" required class="form-control" style="width: 100%;">
            </div>

            <div style="border-top: 1px solid var(--border-color); padding-top: 1.5rem; display: flex; justify-content: flex-end; gap: 1rem;">
                <a href="{{ route('brands.index') }}" class="btn">Cancelar</a>
                <button type="submit" class="btn btn-primary">Actualizar Marca</button>
            </div>
        </form>
    </div>
</div>

@endsection
