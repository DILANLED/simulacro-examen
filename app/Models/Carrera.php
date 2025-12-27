<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    protected $table = 'carrera';
    protected $primaryKey = 'id_carrera';
    public $timestamps = false;

    protected $fillable = [
        'nombre_carrera',
        'gestion_carrera',
        'estado_carrera'
    ];

    // RELACIÓN: Una carrera tiene muchas áreas
    public function areas()
    {
        return $this->hasMany(Area::class, 'id_carrera', 'id_carrera');
    }
}