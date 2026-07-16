<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistorialEstado extends Model
{
    protected $table = 'historial_estados';

    protected $fillable = [
        'tipo',
        'registro_id',
        'estado_anterior',
        'estado_nuevo',
        'cambiado_por',
        'observaciones',
    ];

    public function cambiadoPor()
    {
        return $this->belongsTo(User::class, 'cambiado_por');
    }
}
