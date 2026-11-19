@extends('layouts.app')

@section('title', 'Gestionar Incidencia - ReparaYa')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="margin: 0;">Gestión de Incidencia {{ $incidencia->localizador }}</h2>
        <a href="{{ route('tecnico.dashboard') }}" class="btn btn-secondary">Volver al listado</a>
    </div>

    <table>
        <tr>
            <th style="width: 230px;">Localizador</th>
            <td>{{ $incidencia->localizador }}</td>
        </tr>
        <tr>
            <th>Estado actual</th>
            <td><strong>{{ $incidencia->estado }}</strong></td>
        </tr>
        <tr>
            <th>Tipo de cliente</th>
            <td>
                @if($incidencia->comunidad)
                    <strong>Comunidad (B2B):</strong> {{ $incidencia->comunidad->nombre }}
                    ({{ $incidencia->comunidad->empresaGestora->nombre_empresa ?? 'Sin gestora' }})
                @else
                    <strong>Particular:</strong> {{ $incidencia->cliente->nombre ?? '-' }} ({{ $incidencia->cliente->telefono ?? 'Sin teléfono' }})
                @endif
            </td>
        </tr>
        <tr>
            <th>Especialidad y tarifa base</th>
            <td>{{ $incidencia->especialidad->nombre_especialidad ?? '-' }} ({{ number_format($incidencia->especialidad->precio_base ?? 0, 2) }} €)</td>
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
            <th>Descripción de la avería</th>
            <td>{{ $incidencia->descripcion }}</td>
        </tr>
    </table>

    @if(in_array($incidencia->estado, ['Asignada', 'En curso']))
        <div style="margin-top: 25px; padding: 20px; background-color: #f8fafc; border: 1px solid #cbd5e1; border-radius: 6px; max-width: 550px;">
            <h3 style="margin-top: 0;">Actualizar estado del servicio</h3>
            <form action="{{ route('tecnico.incidencias.actualizarEstado', $incidencia) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="form-group">
                    <label for="estado">Nuevo estado</label>
                    <select id="estado" name="estado" required>
                        @if($incidencia->estado === 'Asignada')
                            <option value="En curso">En curso (técnico desplazado / trabajando)</option>
                        @endif
                        <option value="Finalizada">Finalizada (trabajo completado)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="observaciones">Observaciones técnicas (opcional)</label>
                    <textarea id="observaciones" name="observaciones" rows="3" placeholder="Detalle de la reparación realizada..."></textarea>
                </div>

                <button type="submit" class="btn">Guardar cambio de estado</button>
            </form>
        </div>
    @endif

    @if($incidencia->comision)
        <div style="margin-top: 25px; padding: 15px; background-color: #eff6ff; border: 1px solid #93c5fd; border-radius: 6px;">
            <h3 style="margin-top: 0; color: #1e40af;">Comisión B2B Generada</h3>
            <p style="margin: 5px 0;">
                <strong>Empresa Gestora:</strong> {{ $incidencia->comunidad->empresaGestora->nombre_empresa ?? '-' }} |
                <strong>Precio base aplicado:</strong> {{ number_format($incidencia->comision->precio_base_aplicado, 2) }} € |
                <strong>Porcentaje:</strong> {{ number_format($incidencia->comision->porcentaje_aplicado, 2) }} % |
                <strong>Importe comisión:</strong> {{ number_format($incidencia->comision->importe_comision, 2) }} €
            </p>
        </div>
    @endif

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