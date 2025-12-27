<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RolController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string)$request->get('q', ''));

        $roles = Rol::query()
            ->when($q, fn($qq) => $qq->where('nombre_rol', 'ilike', "%{$q}%"))
            ->orderByDesc('id_rol')
            ->paginate(10)
            ->withQueryString();

        return view('roles.index', compact('roles', 'q'));
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre_rol' => ['required', 'string', 'max:120', 'unique:rol,nombre_rol'],
            'estado_rol' => ['required', 'integer', 'in:0,1'],
        ]);

        Rol::create($data);

        return redirect()->route('roles.index')->with('ok', 'Rol creado correctamente.');
    }

    public function show(string $id)
    {
        $rol = Rol::where('id_rol', $id)->firstOrFail();
        return redirect()->route('roles.edit', $rol->id_rol);
    }

    public function edit(string $id)
    {
        $rol = Rol::where('id_rol', $id)->firstOrFail();
        return view('roles.edit', compact('rol'));
    }

    public function update(Request $request, string $id)
    {
        $rol = Rol::where('id_rol', $id)->firstOrFail();

        $data = $request->validate([
            'nombre_rol' => [
                'required', 'string', 'max:120',
                Rule::unique('rol', 'nombre_rol')->ignore($rol->id_rol, 'id_rol')
            ],
            'estado_rol' => ['required', 'integer', 'in:0,1'],
        ]);

        $rol->update($data);

        return redirect()->route('roles.index')->with('ok', 'Rol actualizado correctamente.');
    }

    public function destroy(string $id)
    {
        $rol = Rol::where('id_rol', $id)->firstOrFail();

        // OJO: si tu FK usuario.id_rol tiene restrict, esto fallará si hay usuarios con ese rol.
        $rol->delete();

        return redirect()->route('roles.index')->with('ok', 'Rol eliminado correctamente.');
    }

    public function cambiarEstado(string $id)
    {
        $rol = Rol::where('id_rol', $id)->firstOrFail();
        $rol->estado_rol = ($rol->estado_rol == 1) ? 0 : 1;
        $rol->save();

        return redirect()->route('roles.index')->with('ok', 'Estado actualizado.');
    }

    public function reportePDF(Request $request)
    {
        // Aquí luego metemos dompdf o snappy.
        return redirect()->route('roles.index')->with('ok', 'Reporte PDF (pendiente de implementar).');
    }
}
