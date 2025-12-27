<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'usuario';
    protected $primaryKey = 'id_usuario';

    // si tu tabla sí tiene created_at/updated_at, deja true.
    public $timestamps = true;

    protected $fillable = [
        'nombre_usuario',
        'nombre_login_usuario',
        'password_usuario',
        'estado_usuario',
        'id_rol',
    ];

    protected $hidden = [
        'password_usuario',
    ];
}
