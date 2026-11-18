<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Usuario extends Authenticatable
{
    protected $table = 'usuarios';

    protected $fillable = ['nombre', 'email', 'password', 'rol', 'telefono'];

    protected $hidden = [
        'password',
    ];


    public function empresaGestora(): HasOne
    {
        return $this->hasOne(EmpresaGestora::class, 'usuario_id');
    }

    public function tecnico(): HasOne
    {
        return $this->hasOne(Tecnico::class, 'usuario_id');
    }

    public function incidencias(): HasMany
    {
        return $this->hasMany(Incidencia::class, 'cliente_id');
    }

    public function historialCambios(): HasMany
    {
        return $this->hasMany(HistorialEstado::class, 'usuario_id');
    }
}