@extends('layouts.app')

@section('title', 'Panel Técnico - ReparaYa')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div>
            <h2 style="margin: 0;">Panel de Servicios Asignados</h2>
            @if($tecnico)
                <p style="margin: 5px 0 0; color: #475569; font-size: 14px;">
                    Técnico: <strong>{{ $tecnico->nombre_completo }}</strong> |
                    Estado de disponibilidad: <strong>{{ $tecnico->disponible ? 'Disponible' : 'Ocupado' }}</strong>
                </p>
            @endif
        </div>
    </div>

    @if(!$tecnico)
        <div class="alert-error">Tu usuario no tiene un perfil de técnico asociado en la base de datos.</div>
    @elseif($incidencias->isEmpty())
        <p>No tienes incidencias asignadas actualmente.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Localizador</th>
                    <th>Origen</th>
                    <th>Especialidad</th>
                    <th>Zona</th>
                    <th>Urgencia</th>
                    <th>Fecha Servicio</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($incidencias as $incidencia)
                    <tr>
                        <td><strong>{{ $incidencia->localizador }}</strong></td>
                        <td>
                            @if($incidencia->comunidad)
                                Comunidad: {{ $incidencia->comunidad->nombre }}
                            @else
                                Particular: {{ $incidencia->cliente->nombre ?? '-' }}
                            @endif
                        </td>
                        <td>{{ $incidencia->especialidad->nombre_especialidad ?? '-' }}</td>
                        <td>{{ $incidencia->zona->nombre ?? '-' }}</td>
                        <td>{{ $incidencia->tipo_urgencia }}</td>
                        <td>{{ $incidencia->fecha_servicio->format('d/m/Y H:i') }}</td>
                        <td><strong>{{ $incidencia->estado }}</strong></td>
                        <td>
                            <a href="{{ route('tecnico.incidencias.show', $incidencia) }}" class="btn">Gestionar</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection