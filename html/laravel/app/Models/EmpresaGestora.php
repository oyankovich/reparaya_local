<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EmpresaGestora extends Model
{
    protected $table = 'empresas_gestoras';

    protected $fillable = [
        'usuario_id',
        'nombre_empresa',
        'cif',
        'telefono',
        'porcentaje_comision',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function comunidades(): HasMany
    {
        return $this->hasMany(Comunidad::class, 'empresa_gestora_id');
    }

    public function comisiones(): HasMany
    {
        return $this->hasMany(Comision::class, 'empresa_gestora_id');
    }
}