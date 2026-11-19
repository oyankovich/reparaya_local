@extends('layouts.app')

@section('title', 'Detalle de Incidencia - ReparaYa')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="margin: 0;">Incidencia {{ $incidencia->localizador }}</h2>
        <a href="{{ route('cliente.dashboard') }}" class="btn btn-secondary">Volver al listado</a>
    </div>

    <table>
        <tr>
            <th style="width: 220px;">Localizador</th>
            <td>{{ $incidencia->localizador }}</td>
        </tr>
        <tr>
            <th>Estado actual</th>
            <td><strong>{{ $incidencia->estado }}</strong></td>
        </tr>
        <tr>
            <th>Especialidad</th>
            <td>{{ $incidencia->especialidad->nombre_especialidad ?? '-' }} ({{ number_format($incidencia->especialidad->precio_base ?? 0, 2) }} € base)</td>
        </tr>
        <tr>
            <th>Zona</th>
            <td>{{ $incidencia->zona->nombre ?? '-' }}</td>
        </tr>
        <tr>
            <th>Urgencia</th>
            <td>{{ $incidencia->tipo_urgencia }}</td>
        </tr>
        <tr>
            <th>Fecha de servicio</th>
            <td>{{ $incidencia->fecha_servicio->format('d/m/Y H:i') }}</td>
        </tr>
        <tr>
            <th>Dirección</th>
            <td>{{ $incidencia->direccion }}</td>
        </tr>
        <tr>
            <th>Técnico asignado</th>
            <td>{{ $incidencia->tecnico->nombre_completo ?? 'Pendiente de asignación' }}</td>
        </tr>
        <tr>
            <th>Descripción</th>
            <td>{{ $incidencia->descripcion }}</td>
        </tr>
    </table>

    <h3 style="margin-top: 30px;">Historial de Estados</h3>
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Estado anterior</th>
                <th>Estado nuevo</th>
                <th>Usuario</th>
                <th>Observaciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($historial as $registro)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($registro->fecha_cambio)->format('d/m/Y H:i') }}</td>
                    <td>{{ $registro->estado_anterior ?? 'Creación' }}</td>
                    <td><strong>{{ $registro->estado_nuevo }}</strong></td>
                    <td>{{ $registro->usuario->nombre ?? 'Sistema' }}</td>
                    <td>{{ $registro->observaciones ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No hay movimientos registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection