@extends('layouts.app')

@section('title', 'Mis Incidencias - ReparaYa')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="margin: 0;">Mis Incidencias</h2>
        <a href="{{ route('cliente.incidencias.create') }}" class="btn">+ Nueva Incidencia</a>
    </div>

    @if($incidencias->isEmpty())
        <p>Todavía no has registrado ninguna incidencia.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Localizador</th>
                    <th>Especialidad</th>
                    <th>Zona</th>
                    <th>Urgencia</th>
                    <th>Fecha Servicio</th>
                    <th>Técnico</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($incidencias as $incidencia)
                    <tr>
                        <td><strong>{{ $incidencia->localizador }}</strong></td>
                        <td>{{ $incidencia->especialidad->nombre_especialidad ?? '-' }}</td>
                        <td>{{ $incidencia->zona->nombre ?? '-' }}</td>
                        <td>{{ $incidencia->tipo_urgencia }}</td>
                        <td>{{ $incidencia->fecha_servicio->format('d/m/Y H:i') }}</td>
                        <td>{{ $incidencia->tecnico->nombre_completo ?? 'Sin asignar' }}</td>
                        <td><strong>{{ $incidencia->estado }}</strong></td>
                        <td style="display: flex; gap: 6px;">
                            <a href="{{ route('cliente.incidencias.show', $incidencia) }}" class="btn btn-secondary">Ver</a>

                            @if(in_array($incidencia->estado, ['Pendiente', 'Asignada']))
                                <form action="{{ route('cliente.incidencias.cancelar', $incidencia) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas cancelar esta incidencia?');">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-danger">Cancelar</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection