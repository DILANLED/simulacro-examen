<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Examen extends Model
{
    protected $table = 'examen';
    protected $primaryKey = 'id_examen';
    public $timestamps = false; 

    protected $fillable = [
        'puntaje_examen',
        'duracion', // Verifica si en tu BD es 'duracion' o 'duracion_segundos_examen'
        'fecha_examen',
        'estado_examen',
        'id_carrera',
        'id_usuario'
    ];

    // ESTA ES LA FUNCIÓN QUE SOLUCIONA EL ERROR "Call to undefined relationship"
    public function carrera()
    {
        return $this->belongsTo(Carrera::class, 'id_carrera', 'id_carrera');
    }

    // Opcional: Relación con el usuario para saber de quién es el examen
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id_usuario');
    }
}