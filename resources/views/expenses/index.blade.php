@extends('layouts.app')

@section('title', 'Gastos - Brunett')
@section('page_title', 'Control de Gastos Operativos')

@section('content')

<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 2rem;">
    <!-- Formulario -->
    <div class="panel">
        <h3 style="margin-bottom: 1.5rem;">Registrar Gasto</h3>
        <form action="{{ route('expenses.store') }}" method="POST">
            @csrf
            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem;">Categoría *</label>
                <select name="expense_category_id" required style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem;">Monto ($) *</label>
                <input type="number" name="amount" step="0.01" required style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;">
            </div>
            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem;">Fecha *</label>
                <input type="date" name="expense_date" value="{{ date('Y-m-d') }}" required style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;">
            </div>
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem;">Descripción / Justificación *</label>
                <textarea name="description" required style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;"></textarea>
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%;">Registrar Gasto</button>
        </form>
    </div>

    <!-- Lista -->
    <div class="panel">
        <h3 style="margin-bottom: 1.5rem;">Historial de Egresos</h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Categoría</th>
                    <th>Descripción</th>
                    <th>Monto</th>
                    <th style="text-align: right;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($expenses as $expense)
                <tr>
                    <td>{{ $expense->expense_date }}</td>
                    <td><span class="badge badge-gray">{{ $expense->category->name }}</span></td>
                    <td>{{ $expense->description }}</td>
                    <td><strong style="color: #dc2626;">-${{ number_format($expense->amount, 2) }}</strong></td>
                    <td style="text-align: right;">
                        <form action="{{ route('expenses.destroy', $expense) }}" method="POST" style="display: inline;">
                            @csrf @method('DELETE')
                            <button type="submit" style="background: transparent; border: none; color: #dc2626; cursor: pointer;"><i data-lucide="trash-2" style="width: 18px;"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div style="margin-top: 1.5rem;">
            {{ $expenses->links() }}
        </div>
    </div>
</div>

@endsection
