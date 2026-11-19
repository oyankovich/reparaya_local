<?php

namespace App\Http\Controllers;

use App\Models\Especialidad;
use App\Models\HistorialEstado;
use App\Models\Incidencia;
use App\Models\Zona;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ClienteIncidenciaController extends Controller
{
    public function index()
    {
        $incidencias = Incidencia::with(['especialidad', 'zona', 'tecnico'])
            ->where('cliente_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();

        return view('cliente.dashboard', compact('incidencias'));
    }

    public function create()
    {
        $especialidades = Especialidad::orderBy('nombre_especialidad')->get();
        $zonas = Zona::orderBy('nombre')->get();

        return view('cliente.create', compact('especialidades', 'zonas'));
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'especialidad_id' => ['required', 'exists:especialidades,id'],
            'zona_id' => ['required', 'exists:zonas,id'],
            'direccion' => ['required', 'string', 'max:255'],
            'descripcion' => ['required', 'string'],
            'fecha_servicio' => ['required', 'date'],
            'tipo_urgencia' => ['required', 'in:Estándar,Urgente'],
        ]);

        // Regla de negocio migrada del Producto 2: antelación mínima según urgencia
        $fechaServicio = Carbon::parse($datos['fecha_servicio']);
        $horasMinimas = $datos['tipo_urgencia'] === 'Urgente' ? 2 : 24;

        if ($fechaServicio->lt(now()->addHours($horasMinimas))) {
            return back()
                ->withErrors([
                    'fecha_servicio' => "Para una incidencia {$datos['tipo_urgencia']}, la fecha de servicio debe tener al menos {$horasMinimas} horas de antelación.",
                ])
                ->withInput();
        }

        DB::transaction(function () use ($datos, $fechaServicio) {
            // Generar localizador único con el mismo formato REP-XXXXXXXX del Producto 2
            do {
                $localizador = 'REP-' . strtoupper(Str::random(8));
            } while (Incidencia::where('localizador', $localizador)->exists());

            $incidencia = Incidencia::create([
                'localizador' => $localizador,
                'cliente_id' => Auth::id(),
                'tecnico_id' => null,
                'especialidad_id' => $datos['especialidad_id'],
                'comunidad_id' => null,
                'zona_id' => $datos['zona_id'],
                'descripcion' => $datos['descripcion'],
                'direccion' => $datos['direccion'],
                'fecha_servicio' => $fechaServicio,
                'tipo_urgencia' => $datos['tipo_urgencia'],
                'estado' => 'Pendiente',
            ]);

            HistorialEstado::create([
                'incidencia_id' => $incidencia->id,
                'estado_anterior' => null,
                'estado_nuevo' => 'Pendiente',
                'usuario_id' => Auth::id(),
                'fecha_cambio' => now(),
                'observaciones' => 'Incidencia creada por el cliente particular.',
            ]);
        });

        return redirect()->route('cliente.dashboard')
            ->with('success', 'Incidencia registrada correctamente.');
    }

    public function show(Incidencia $incidencia)
    {
        if ($incidencia->cliente_id !== Auth::id()) {
            abort(403, 'No tienes permiso para ver esta incidencia.');
        }

        $incidencia->load(['especialidad', 'zona', 'tecnico']);

        $historial = HistorialEstado::with('usuario')
            ->where('incidencia_id', $incidencia->id)
            ->orderBy('fecha_cambio', 'asc')
            ->get();

        return view('cliente.show', compact('incidencia', 'historial'));
    }

    public function cancelar(Incidencia $incidencia)
    {
        if ($incidencia->cliente_id !== Auth::id()) {
            abort(403, 'No tienes permiso para modificar esta incidencia.');
        }

        if (!in_array($incidencia->estado, ['Pendiente', 'Asignada'])) {
            return back()->with('error', 'Solo se pueden cancelar incidencias en estado Pendiente o Asignada.');
        }

        DB::transaction(function () use ($incidencia) {
            $estadoAnterior = $incidencia->estado;

            $incidencia->update([
                'estado' => 'Cancelada',
            ]);

            HistorialEstado::create([
                'incidencia_id' => $incidencia->id,
                'estado_anterior' => $estadoAnterior,
                'estado_nuevo' => 'Cancelada',
                'usuario_id' => Auth::id(),
                'fecha_cambio' => now(),
                'observaciones' => 'Incidencia cancelada por el cliente.',
            ]);
        });

        return redirect()->route('cliente.dashboard')
            ->with('success', "La incidencia {$incidencia->localizador} ha sido cancelada.");
    }
}