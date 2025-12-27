<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function show()
    {
        return view('auth.login'); // tu login.blade.php
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'nombre_login_usuario' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // Intento de login
        if (!Auth::attempt([
            'nombre_login_usuario' => $data['nombre_login_usuario'],
            'password' => $data['password'],
        ])) {
            return back()->withErrors(['login' => 'Usuario o contraseña incorrectos.'])->withInput();
        }

        $request->session()->regenerate();

        // Seguridad: estado_usuario
        $user = Auth::user();
        if ((int)$user->estado_usuario !== 1) {
            Auth::logout();
            return back()->withErrors(['login' => 'Tu cuenta está desactivada.']);
        }

        // ✅ Redirección por rol (por nombre o por id)
        return redirect()->route('home');

    }

    private function routeByRole($user): string
{
    $SUPER_ADMIN_ID = 1; // ajusta
    $ESTUDIANTE_ID  = 2; // ajusta

    return match ((int)$user->id_rol) {
        $SUPER_ADMIN_ID => 'admin.dashboard',
        $ESTUDIANTE_ID  => 'estudiante.dashboard',
        default => 'estudiante.dashboard',
    };
}


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.form');
    }
}
