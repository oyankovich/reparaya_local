<?php

namespace App\Http\Controllers;

use App\Models\Comision;
use App\Models\HistorialEstado;
use App\Models\Incidencia;
use App\Models\Tecnico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TecnicoIncidenciaController extends Controller
{
    public function index()
    {
        $tecnico = Tecnico::where('usuario_id', Auth::id())->first();

        if (!$tecnico) {
            return view('tecnico.dashboard', [
                'tecnico' => null,
                'incidencias' => collect(),
            ]);
        }

        $incidencias = Incidencia::with(['especialidad', 'zona', 'cliente', 'comunidad'])
            ->where('tecnico_id', $tecnico->id)
            ->orderByRaw("FIELD(estado, 'En curso', 'Asignada', 'Finalizada', 'Pendiente', 'Cancelada')")
            ->orderBy('fecha_servicio', 'asc')
            ->get();

        return view('tecnico.dashboard', compact('tecnico', 'incidencias'));
    }

    public function show(Incidencia $incidencia)
    {
        $tecnico = Tecnico::where('usuario_id', Auth::id())->firstOrFail();

        if ($incidencia->tecnico_id !== $tecnico->id) {
            abort(403, 'No tienes permiso para acceder a esta incidencia.');
        }

        $incidencia->load(['especialidad', 'zona', 'cliente', 'comunidad.empresaGestora', 'comision']);

        $historial = HistorialEstado::with('usuario')
            ->where('incidencia_id', $incidencia->id)
            ->orderBy('fecha_cambio', 'asc')
            ->get();

        return view('tecnico.show', compact('incidencia', 'historial'));
    }

    public function actualizarEstado(Request $request, Incidencia $incidencia)
    {
        $tecnico = Tecnico::where('usuario_id', Auth::id())->firstOrFail();

        if ($incidencia->tecnico_id !== $tecnico->id) {
            abort(403, 'No tienes permiso para modificar esta incidencia.');
        }

        if (!in_array($incidencia->estado, ['Asignada', 'En curso'])) {
            return back()->with('error', 'Solo se pueden actualizar incidencias en estado Asignada o En curso.');
        }

        $datos = $request->validate([
            'estado' => ['required', 'in:En curso,Finalizada'],
            'observaciones' => ['nullable', 'string', 'max:500'],
        ]);

        if ($incidencia->estado === 'En curso' && $datos['estado'] === 'En curso') {
            return back()->with('error', 'La incidencia ya se encuentra en estado En curso.');
        }

        $comisionGenerada = false;

        DB::transaction(function () use ($incidencia, $tecnico, $datos, &$comisionGenerada) {
            $estadoAnterior = $incidencia->estado;
            $nuevoEstado = $datos['estado'];

            $incidencia->update([
                'estado' => $nuevoEstado,
            ]);

            HistorialEstado::create([
                'incidencia_id' => $incidencia->id,
                'estado_anterior' => $estadoAnterior,
                'estado_nuevo' => $nuevoEstado,
                'usuario_id' => Auth::id(),
                'fecha_cambio' => now(),
                'observaciones' => $datos['observaciones'] ?: "Estado actualizado a {$nuevoEstado} por el técnico.",
            ]);

            if ($nuevoEstado === 'Finalizada') {
                // Liberar disponibilidad del técnico si no tiene otras incidencias activas
                $tieneOtrasActivas = Incidencia::where('tecnico_id', $tecnico->id)
                    ->whereIn('estado', ['Asignada', 'En curso'])
                    ->exists();

                if (!$tieneOtrasActivas) {
                    $tecnico->update(['disponible' => true]);
                }

                // Generar comisión automáticamente si la incidencia pertenece a una comunidad B2B
                if ($incidencia->comunidad_id !== null) {
                    $incidencia->load(['comunidad.empresaGestora', 'especialidad']);

                    $empresaGestora = $incidencia->comunidad?->empresaGestora;
                    $yaExisteComision = Comision::where('incidencia_id', $incidencia->id)->exists();

                    if ($empresaGestora && !$yaExisteComision) {
                        $precioBase = (float) ($incidencia->especialidad->precio_base ?? 0);
                        $porcentaje = (float) $empresaGestora->porcentaje_comision;
                        $importeComision = round(($precioBase * $porcentaje) / 100, 2);

                        Comision::create([
                            'incidencia_id' => $incidencia->id,
                            'empresa_gestora_id' => $empresaGestora->id,
                            'precio_base_aplicado' => $precioBase,
                            'porcentaje_aplicado' => $porcentaje,
                            'importe_comision' => $importeComision,
                            'fecha_generacion' => now(),
                        ]);

                        $comisionGenerada = true;
                    }
                }
            }
        });

        $mensaje = "Estado de la incidencia {$incidencia->localizador} actualizado a {$datos['estado']}.";
        if ($comisionGenerada) {
            $mensaje .= ' Se ha generado automáticamente la comisión correspondiente para la empresa gestora.';
        }

        return redirect()->route('tecnico.incidencias.show', $incidencia)
            ->with('success', $mensaje);
    }
}