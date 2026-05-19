@extends('layouts.app')

@section('title', 'Ciudades - Brunett')
@section('page_title', 'Configuración de Ciudades')

@section('content')

<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 2rem;">
    <!-- Formulario -->
    <div class="panel">
        <h3 style="margin-bottom: 1.5rem;">Nueva Ciudad</h3>
        <form action="{{ route('cities.store') }}" method="POST">
            @csrf
            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem;">Nombre de Ciudad</label>
                <input type="text" name="name" required style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;">
            </div>
            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem;">Provincia</label>
                <input type="text" name="province" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;">
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%;">Registrar Ciudad</button>
        </form>
    </div>

    <!-- Lista -->
    <div class="panel">
        <h3 style="margin-bottom: 1.5rem;">Ciudades Habilitadas</h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Ciudad</th>
                    <th>Provincia</th>
                    <th style="text-align: right;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cities as $city)
                <tr>
                    <td><strong>{{ $city->name }}</strong></td>
                    <td>{{ $city->province }}</td>
                    <td style="text-align: right;">
                        <form action="{{ route('cities.destroy', $city) }}" method="POST" style="display: inline;">
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
