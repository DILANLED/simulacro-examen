<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class AuthUsuario extends Authenticatable
{
    protected $table = 'usuario';
    protected $primaryKey = 'id_usuario';
    public $timestamps = true;

    protected $fillable = [
        'nombre_usuario',
        'nombre_login_usuario',
        'password_usuario',
        'estado_usuario',
        'id_rol',
    ];

    protected $hidden = ['password_usuario'];

    // Laravel usará esta columna como password
    public function getAuthPassword()
    {
        return $this->password_usuario;
    }
}
