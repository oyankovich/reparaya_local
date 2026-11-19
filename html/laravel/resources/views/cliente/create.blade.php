@extends('layouts.app')

@section('title', 'Nueva Incidencia - ReparaYa')

@section('content')
    <h2>Registrar Nueva Incidencia</h2>
    <p style="color: #475569; font-size: 14px;">
        Recuerda: los servicios de tipo <strong>Estándar</strong> requieren al menos 24 horas de antelación y los de tipo <strong>Urgente</strong> al menos 2 horas.
    </p>

    <form action="{{ route('cliente.incidencias.store') }}" method="POST" style="max-width: 600px;">
        @csrf

        <div class="form-group">
            <label for="especialidad_id">Especialidad</label>
            <select id="especialidad_id" name="especialidad_id" required>
                <option value="">-- Selecciona una especialidad --</option>
                @foreach($especialidades as $especialidad)
                    <option value="{{ $especialidad->id }}" {{ old('especialidad_id') == $especialidad->id ? 'selected' : '' }}>
                        {{ $especialidad->nombre_especialidad }} ({{ number_format($especialidad->precio_base, 2) }} € base)
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="zona_id">Zona</label>
            <select id="zona_id" name="zona_id" required>
                <option value="">-- Selecciona una zona --</option>
                @foreach($zonas as $zona)
                    <option value="{{ $zona->id }}" {{ old('zona_id') == $zona->id ? 'selected' : '' }}>
                        {{ $zona->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="tipo_urgencia">Tipo de urgencia</label>
            <select id="tipo_urgencia" name="tipo_urgencia" required>
                <option value="Estándar" {{ old('tipo_urgencia') === 'Estándar' ? 'selected' : '' }}>Estándar (mínimo 24h de antelación)</option>
                <option value="Urgente" {{ old('tipo_urgencia') === 'Urgente' ? 'selected' : '' }}>Urgente (mínimo 2h de antelación)</option>
            </select>
        </div>

        <div class="form-group">
            <label for="fecha_servicio">Fecha y hora del servicio</label>
            <input type="datetime-local" id="fecha_servicio" name="fecha_servicio" value="{{ old('fecha_servicio') }}" required>
        </div>

        <div class="form-group">
            <label for="direccion">Dirección del servicio</label>
            <input type="text" id="direccion" name="direccion" value="{{ old('direccion') }}" placeholder="Calle, número, piso..." required>
        </div>

        <div class="form-group">
            <label for="descripcion">Descripción de la avería</label>
            <textarea id="descripcion" name="descripcion" rows="4" required>{{ old('descripcion') }}</textarea>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn">Guardar Incidencia</button>
            <a href="{{ route('cliente.dashboard') }}" class="btn btn-secondary">Volver</a>
        </div>
    </form>
@endsection