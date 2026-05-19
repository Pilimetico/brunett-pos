@extends('layouts.app')

@section('title', 'Marcas - Brunett')
@section('page_title', 'Gestión de Marcas')

@section('content')

<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 2rem;">
    <!-- Formulario -->
    <div class="panel">
        <h3 style="margin-bottom: 1.5rem;">Nueva Marca</h3>
        <form action="{{ route('brands.store') }}" method="POST">
            @csrf
            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem;">Nombre de la Marca</label>
                <input type="text" name="name" required style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;">
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%;">Crear Marca</button>
        </form>
    </div>

    <!-- Lista -->
    <div class="panel">
        <h3 style="margin-bottom: 1.5rem;">Lista de Marcas</h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Slug</th>
                    <th style="text-align: right;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($brands as $brand)
                <tr>
                    <td><strong>{{ $brand->name }}</strong></td>
                    <td><code>{{ $brand->slug }}</code></td>
                    <td style="text-align: right;">
                        <a href="{{ route('brands.edit', $brand) }}" class="btn-icon" title="Editar" style="color: var(--brand-primary); margin-right: 0.5rem;"><i data-lucide="edit-2" style="width: 18px;"></i></a>
                        <form action="{{ route('brands.destroy', $brand) }}" method="POST" style="display: inline;">
                            @csrf @method('DELETE')
                            <button type="submit" style="background: transparent; border: none; color: #dc2626; cursor: pointer;"><i data-lucide="trash-2" style="width: 18px;"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </tbody>
    </table>
</div>

@endsection
