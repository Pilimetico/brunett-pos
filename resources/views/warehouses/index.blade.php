@extends('layouts.app')

@section('title', 'Bodegas - Brunett')
@section('page_title', 'Administración de Bodegas')

@section('content')

<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 2rem;">
    <!-- Formulario -->
    <div class="panel">
        <h3 style="margin-bottom: 1.5rem;">Nueva Bodega / Sucursal</h3>
        <form action="{{ route('warehouses.store') }}" method="POST">
            @csrf
            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem;">Nombre de Bodega</label>
                <input type="text" name="name" required style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;">
            </div>
            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem;">Código Interno</label>
                <input type="text" name="code" required style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;">
            </div>
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem;">Dirección</label>
                <input type="text" name="address" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;">
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%;">Crear Bodega</button>
        </form>
    </div>

    <!-- Lista -->
    <div class="panel">
        <h3 style="margin-bottom: 1.5rem;">Bodegas Habilitadas</h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Dirección</th>
                    <th style="text-align: right;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($warehouses as $warehouse)
                <tr>
                    <td><code>{{ $warehouse->code }}</code></td>
                    <td><strong>{{ $warehouse->name }}</strong></td>
                    <td>{{ $warehouse->address }}</td>
                    <td style="text-align: right;">
                        <form action="{{ route('warehouses.destroy', $warehouse) }}" method="POST" style="display: inline;">
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
