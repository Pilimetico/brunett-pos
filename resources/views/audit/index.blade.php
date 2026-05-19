@extends('layouts.app')

@section('title', 'Auditoría - Brunett Ecuador')
@section('page_title', 'Seguridad y Auditoría')
@section('page_subtitle', 'Registro inmutable de acciones en el sistema')

@section('content')

<div class="panel">
    <div class="panel-header">
        <h2 class="panel-title">Historial de Actividad</h2>
        <div style="display: flex; gap: 0.5rem;">
            <button class="btn btn-primary" style="background: var(--bg-main); border: 1px solid var(--border-color); color: var(--text-primary);">
                <i data-lucide="download" style="width: 16px; margin-right: 8px;"></i> Exportar Log
            </button>
        </div>
    </div>
    
    <table class="data-table">
        <thead>
            <tr>
                <th>Fecha y Hora</th>
                <th>Usuario</th>
                <th>Acción</th>
                <th>Módulo / Tabla</th>
                <th>Descripción del Cambio</th>
            </tr>
        </thead>
        <tbody>
            @forelse($activities as $activity)
            <tr>
                <td style="font-size: 0.85rem;">{{ $activity->created_at->format('d/m/Y H:i:s') }}</td>
                <td>
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <div style="width: 24px; height: 24px; border-radius: 50%; background: var(--brand-secondary); color: white; display: flex; align-items: center; justify-content: center; font-size: 0.7rem;">
                            {{ substr($activity->causer->name ?? 'S', 0, 1) }}
                        </div>
                        <span style="font-weight: 500;">{{ $activity->causer->name ?? 'Sistema' }}</span>
                    </div>
                </td>
                <td>
                    @php
                        $color = match($activity->description) {
                            'created' => 'badge-green',
                            'updated' => 'badge-blue',
                            'deleted' => 'badge-gray',
                            default => 'badge-gray'
                        };
                        $style = $activity->description == 'deleted' ? 'background: rgba(209, 67, 67, 0.1); color: var(--brand-danger);' : '';
                    @endphp
                    <span class="badge {{ $color }}" style="{{ $style }}">{{ strtoupper($activity->description) }}</span>
                </td>
                <td><span style="font-family: monospace; font-size: 0.9rem; color: var(--brand-primary);">{{ class_basename($activity->subject_type) }}</span></td>
                <td>
                    @if($activity->description == 'updated')
                        <div style="font-size: 0.85rem;">
                            @foreach($activity->changes()['attributes'] as $key => $value)
                                @if(isset($activity->changes()['old'][$key]))
                                    <div><strong>{{ $key }}:</strong> <span style="text-decoration: line-through; opacity: 0.5;">{{ is_array($value) ? json_encode($value) : $activity->changes()['old'][$key] }}</span> <i data-lucide="arrow-right" style="width: 10px; display: inline;"></i> <span style="color: var(--brand-accent);">{{ is_array($value) ? json_encode($value) : $value }}</span></div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <span style="font-size: 0.85rem; color: var(--text-secondary);">Acción de {{ $activity->description }} sobre el registro #{{ $activity->subject_id }}</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align: center; padding: 3rem; color: var(--text-muted);">No se han registrado actividades aún.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 1.5rem;">
        {{ $activities->links() }}
    </div>
</div>

@endsection
