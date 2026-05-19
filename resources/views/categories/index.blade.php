@extends('layouts.app')

@section('title', 'Categorías - Brunett')
@section('page_title', 'Gestión de Categorías')

@section('content')

<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 2rem;">
    <!-- Formulario -->
    <div class="panel">
        <h3 style="margin-bottom: 1.5rem;">Nueva Categoría</h3>
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem;">Nombre</label>
                <input type="text" name="name" required style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;">
            </div>
            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem;">Descripción</label>
                <textarea name="description" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;"></textarea>
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%;">Crear Categoría</button>
        </form>
    </div>

    <!-- Lista -->
    <div class="panel">
        <h3 style="margin-bottom: 1.5rem;">Lista de Categorías</h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Slug</th>
                    <th style="text-align: right;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                <tr>
                    <td><strong>{{ $category->name }}</strong></td>
                    <td><code>{{ $category->slug }}</code></td>
                    <td style="text-align: right;">
                        <a href="{{ route('categories.edit', $category) }}" class="btn-icon" title="Editar" style="color: var(--brand-primary); margin-right: 0.5rem;"><i data-lucide="edit-2" style="width: 18px;"></i></a>
                        <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display: inline;">
                            @csrf @method('DELETE')
                            <button type="submit" style="background: transparent; border: none; color: #dc2626; cursor: pointer;"><i data-lucide="trash-2" style="width: 18px;"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
