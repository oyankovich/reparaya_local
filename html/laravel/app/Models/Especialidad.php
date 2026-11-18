<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Especialidad extends Model
{
    protected $table = 'especialidades';

    protected $fillable = ['nombre_especialidad', 'precio_base'];

    public function tecnicos(): HasMany
    {
        return $this->hasMany(Tecnico::class, 'especialidad_id');
    }

    public function incidencias(): HasMany
    {
        return $this->hasMany(Incidencia::class, 'especialidad_id');
    }
}