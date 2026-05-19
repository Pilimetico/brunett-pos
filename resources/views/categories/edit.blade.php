@extends('layouts.app')

@section('title', 'Editar Categoría - Brunett')
@section('page_title', 'Editar Categoría')

@section('content')

<div style="max-width: 600px; margin: 0 auto;">
    <div class="panel">
        <form action="{{ route('categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Nombre *</label>
                <input type="text" name="name" value="{{ $category->name }}" required class="form-control" style="width: 100%;">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Descripción</label>
                <textarea name="description" class="form-control" style="width: 100%; min-height: 100px;">{{ $category->description }}</textarea>
            </div>

            <div style="border-top: 1px solid var(--border-color); padding-top: 1.5rem; display: flex; justify-content: flex-end; gap: 1rem;">
                <a href="{{ route('categories.index') }}" class="btn">Cancelar</a>
                <button type="submit" class="btn btn-primary">Actualizar Categoría</button>
            </div>
        </form>
    </div>
</div>

@endsection
