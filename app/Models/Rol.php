<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'rol';
    protected $primaryKey = 'id_rol';
    public $timestamps = true;

    protected $fillable = [
        'nombre_rol',
        'estado_rol',
    ];
}
