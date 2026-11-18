<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comision extends Model
{
    protected $table = 'comisiones';

    protected $fillable = [
        'incidencia_id',
        'empresa_gestora_id',
        'precio_base_aplicado',
        'porcentaje_aplicado',
        'importe_comision',
        'fecha_generacion',
    ];

    protected function casts(): array
    {
        return [
            'fecha_generacion' => 'datetime',
        ];
    }

    public function incidencia(): BelongsTo
    {
        return $this->belongsTo(Incidencia::class, 'incidencia_id');
    }

    public function empresaGestora(): BelongsTo
    {
        return $this->belongsTo(EmpresaGestora::class, 'empresa_gestora_id');
    }
}