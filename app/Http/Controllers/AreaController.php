<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Carrera;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string)$request->get('q', ''));

        $areas = Area::with('carrera')
            ->when($q, fn($qq) => $qq->where('nombre_area', 'ilike', "%{$q}%"))
            ->orderByDesc('id_area')
            ->paginate(10)
            ->withQueryString();

        return view('areas.index', compact('areas', 'q'));
    }

    public function create()
    {
        $carreras = Carrera::orderBy('nombre_carrera')->get();
        return view('areas.create', compact('carreras'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre_area' => ['required', 'string', 'max:150'],
            'n_preguntas' => ['required', 'integer', 'min:1'], // <- nombre actualizado
            'estado_area' => ['required', 'integer', 'in:0,1'],
            'id_carrera' => ['required', 'exists:carrera,id_carrera'],
        ]);

        Area::create($data);

        return redirect()->route('areas.index')->with('ok', 'Área creada correctamente.');
    }

    public function edit(string $id)
    {
        $area = Area::findOrFail($id);
        $carreras = Carrera::orderBy('nombre_carrera')->get();
        return view('areas.edit', compact('area', 'carreras'));
    }

    public function update(Request $request, string $id)
    {
        $area = Area::findOrFail($id);

        $data = $request->validate([
            'nombre_area' => ['required', 'string', 'max:150'],
            'n_preguntas' => ['required', 'integer', 'min:1'], // <- nombre actualizado
            'estado_area' => ['required', 'integer', 'in:0,1'],
            'id_carrera' => ['required', 'exists:carrera,id_carrera'],
        ]);

        $area->update($data);

        return redirect()->route('areas.index')->with('ok', 'Área actualizada correctamente.');
    }

    public function destroy(string $id)
    {
        $area = Area::findOrFail($id);
        $area->delete();

        return redirect()->route('areas.index')->with('ok', 'Área eliminada correctamente.');
    }

    public function cambiarEstado(string $id)
    {
        $area = Area::findOrFail($id);
        $area->estado_area = $area->estado_area == 1 ? 0 : 1;
        $area->save();

        return redirect()->route('areas.index')->with('ok', 'Estado actualizado.');
    }

    public function reportePDF()
    {
        return redirect()->route('areas.index')->with('ok', 'Reporte PDF (pendiente de implementar).');
    }
}
