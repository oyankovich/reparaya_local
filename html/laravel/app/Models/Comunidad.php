<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comunidad extends Model
{
    protected $table = 'comunidades';

    protected $fillable = [
        'empresa_gestora_id',
        'zona_id',
        'nombre',
        'direccion',
    ];

    public function empresaGestora(): BelongsTo
    {
        return $this->belongsTo(EmpresaGestora::class, 'empresa_gestora_id');
    }

    public function zona(): BelongsTo
    {
        return $this->belongsTo(Zona::class, 'zona_id');
    }

    public function incidencias(): HasMany
    {
        return $this->hasMany(Incidencia::class, 'comunidad_id');
    }
}