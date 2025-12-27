<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CarreraController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q', ''));

        $carreras = Carrera::query()
            ->when($q, fn ($qq) =>
                $qq->where('nombre_carrera', 'ilike', "%{$q}%")
            )
            ->orderByDesc('id_carrera')
            ->paginate(10)
            ->withQueryString();

        return view('carreras.index', compact('carreras', 'q'));
    }

    public function create()
    {
        return view('carreras.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre_carrera' => ['required', 'string', 'max:150', 'unique:carrera,nombre_carrera'],
            'gestion_carrera' => ['required', 'string', 'max:50'],
            'estado_carrera' => ['required', 'integer', 'in:0,1'],
        ]);

        Carrera::create($data);

        return redirect()->route('carreras.index')
            ->with('ok', 'Carrera creada correctamente.');
    }

    public function show(string $id)
    {
        $carrera = Carrera::where('id_carrera', $id)->firstOrFail();
        return redirect()->route('carreras.edit', $carrera->id_carrera);
    }

    public function edit(string $id)
    {
        $carrera = Carrera::where('id_carrera', $id)->firstOrFail();
        return view('carreras.edit', compact('carrera'));
    }

    public function update(Request $request, string $id)
    {
        $carrera = Carrera::where('id_carrera', $id)->firstOrFail();

        $data = $request->validate([
            'nombre_carrera' => [
                'required', 'string', 'max:150',
                Rule::unique('carrera', 'nombre_carrera')
                    ->ignore($carrera->id_carrera, 'id_carrera')
            ],
            'gestion_carrera' => ['required', 'string', 'max:50'],
            'estado_carrera' => ['required', 'integer', 'in:0,1'],
        ]);

        $carrera->update($data);

        return redirect()->route('carreras.index')
            ->with('ok', 'Carrera actualizada correctamente.');
    }

    public function destroy(string $id)
    {
        $carrera = Carrera::where('id_carrera', $id)->firstOrFail();

        $carrera->delete();

        return redirect()->route('carreras.index')
            ->with('ok', 'Carrera eliminada correctamente.');
    }

    public function cambiarEstado(string $id)
    {
        $carrera = Carrera::where('id_carrera', $id)->firstOrFail();
        $carrera->estado_carrera = $carrera->estado_carrera == 1 ? 0 : 1;
        $carrera->save();

        return redirect()->route('carreras.index')
            ->with('ok', 'Estado de la carrera actualizado.');
    }

    public function reportePDF(Request $request)
    {
        // Implementar con DomPDF o Snappy
        return redirect()->route('carreras.index')
            ->with('ok', 'Reporte PDF de carreras (pendiente).');
    }
}
