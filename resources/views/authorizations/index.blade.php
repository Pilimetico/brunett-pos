@extends('layouts.app')

@section('title', 'Autorizaciones - Brunett')
@section('page_title', 'Centro de Autorizaciones')
@section('page_subtitle', 'Aprobación de descuentos y operaciones especiales')

@section('content')

<div class="panel">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2 style="color: var(--brand-primary); font-size: 1.2rem;">Solicitudes Pendientes</h2>
        <span class="badge badge-warning" style="font-size: 0.9rem;">2 Pendientes</span>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th>Fecha y Hora</th>
                <th>Solicitante</th>
                <th>Tipo de Solicitud</th>
                <th>Detalle</th>
                <th style="text-align: right;">Acción</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ now()->format('Y-m-d H:i') }}</td>
                <td><strong>Juan (Cajero)</strong></td>
                <td><span class="badge badge-blue">Descuento Mayor al 10%</span></td>
                <td>Venta #VN-000045 - Solicita 15% de descuento por cliente frecuente VIP.</td>
                <td style="text-align: right;">
                    <button class="btn btn-primary" style="background: var(--brand-secondary); margin-right: 0.5rem;" onclick="alert('Autorizado exitosamente. El cajero ya puede cobrar.')">Autorizar</button>
                    <button class="btn" style="color: var(--brand-danger); border: 1px solid var(--border-color);" onclick="alert('Solicitud rechazada.')">Rechazar</button>
                </td>
            </tr>
            <tr>
                <td colspan="5" style="text-align: center; padding: 2rem; color: var(--text-muted);">
                    (Las solicitudes se sincronizan en tiempo real con el POS)
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div class="panel" style="margin-top: 2rem;">
    <h2 style="color: var(--brand-primary); font-size: 1.2rem; margin-bottom: 1.5rem;">Historial de Autorizaciones</h2>
    <table class="data-table">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Solicitante</th>
                <th>Aprobado por</th>
                <th>Detalle</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ now()->subDays(1)->format('Y-m-d') }}</td>
                <td>Maria (Cajera)</td>
                <td>Admin</td>
                <td>Anulación de factura #VN-000042</td>
                <td><span class="badge badge-green">Aprobado</span></td>
            </tr>
        </tbody>
    </table>
</div>

@endsection
