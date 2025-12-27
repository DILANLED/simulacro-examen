<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    protected $table = 'pregunta';
    protected $primaryKey = 'id_pregunta';
    protected $fillable = ['texto_pregunta', 'id_area', 'estado_pregunta'];

    public function opciones()
    {
        return $this->hasMany(Opcion::class, 'id_pregunta', 'id_pregunta');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'id_area', 'id_area');
    }
}
