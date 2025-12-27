<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\Rol;

class UsuarioController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string)$request->get('q', ''));

        $usuarios = Usuario::query()
            ->when($q, function ($query) use ($q) {
                $query->where('nombre_usuario', 'ilike', "%{$q}%")
                      ->orWhere('nombre_login_usuario', 'ilike', "%{$q}%");
            })
            ->orderByDesc('id_usuario')
            ->paginate(10)
            ->withQueryString();

        return view('usuarios.index', compact('usuarios', 'q'));
    }

    public function create()
    {
        $roles = Rol::orderBy('nombre_rol')->get();
        return view('usuarios.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre_usuario' => ['required', 'string', 'max:150'],
            'nombre_login_usuario' => ['required', 'string', 'max:100', 'unique:usuario,nombre_login_usuario'],
            'password_usuario' => ['required', 'string', 'min:6'],
            'estado_usuario' => ['required', 'integer', 'in:0,1'],
            'id_rol' => ['required', 'integer', 'exists:rol,id_rol'],
        ]);

        $data['password_usuario'] = Hash::make($data['password_usuario']);

        Usuario::create($data);

        return redirect()->route('usuarios.index')->with('ok', 'Usuario creado correctamente.');
    }

    public function show(string $id)
    {
        $usuario = Usuario::where('id_usuario', $id)->firstOrFail();
        // Si no usarás show, puedes redirigir a edit:
        return redirect()->route('usuarios.edit', $usuario->id_usuario);
    }

    public function edit($id)
    {
        $usuario = Usuario::where('id_usuario', $id)->firstOrFail();
        $roles = Rol::orderBy('nombre_rol')->get();
        return view('usuarios.edit', compact('usuario', 'roles'));
    }

    public function update(Request $request, string $id)
    {
        $usuario = Usuario::where('id_usuario', $id)->firstOrFail();

        $data = $request->validate([
            'nombre_usuario' => ['required', 'string', 'max:150'],
            'nombre_login_usuario' => [
                'required','string','max:100',
                Rule::unique('usuario','nombre_login_usuario')->ignore($usuario->id_usuario,'id_usuario')
            ],
            'password_usuario' => ['nullable', 'string', 'min:6'],
            'estado_usuario' => ['required', 'integer', 'in:0,1'],
            'id_rol' => ['required', 'integer', 'exists:rol,id_rol'],
        ]);


        if (!empty($data['password_usuario'])) {
            $data['password_usuario'] = Hash::make($data['password_usuario']);
        } else {
            unset($data['password_usuario']);
        }

        $usuario->update($data);

        return redirect()->route('usuarios.index')->with('ok', 'Usuario actualizado correctamente.');
    }

    public function destroy(string $id)
    {
        $usuario = Usuario::where('id_usuario', $id)->firstOrFail();
        $usuario->delete();

        return redirect()->route('usuarios.index')->with('ok', 'Usuario eliminado correctamente.');
    }

    // ✅ EXTRA: cambiar estado (1/0)
    public function cambiarEstado(string $id)
    {
        $usuario = Usuario::where('id_usuario', $id)->firstOrFail();
        $usuario->estado_usuario = ($usuario->estado_usuario == 1) ? 0 : 1;
        $usuario->save();

        return redirect()->route('usuarios.index')->with('ok', 'Estado actualizado.');
    }

    // ✅ EXTRA: reporte PDF (lo dejamos listo, implementamos luego)
    public function reportePDF(Request $request)
    {
        // Aquí luego metemos dompdf o snappy.
        // return response()->json(['ok' => true]);

        return redirect()->route('usuarios.index')->with('ok', 'Reporte PDF (pendiente de implementar).');
    }
}
