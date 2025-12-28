<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = 'area';
    protected $primaryKey = 'id_area';
    public $timestamps = false;

    protected $fillable = [
        'nombre_area',
        'n_preguntas',
        'estado_area',
        'id_carrera'
    ];

    /**
     * RELACIÓN: Una área pertenece a una carrera.
     */
    public function carrera()
    {
        return $this->belongsTo(Carrera::class, 'id_carrera', 'id_carrera');
    }

    /**
     * RELACIÓN: Una área tiene muchas preguntas.
     * ESTA ES LA FUNCIÓN QUE DEBES AGREGAR:
     */
    public function preguntas()
    {
        return $this->hasMany(Pregunta::class, 'id_area', 'id_area');
    }
}