<?php

namespace App\Http\Controllers;

use App\Models\Pregunta;
use App\Models\Opcion;
use App\Models\Area;
use Illuminate\Http\Request;

class PreguntaController extends Controller
{
    // Listado de preguntas
    public function index(Request $request)
    {
        $q = trim((string)$request->get('q', ''));

        $preguntas = Pregunta::with('area')
            ->when($q, fn($query) => $query->where('texto_pregunta', 'ilike', "%{$q}%"))
            ->orderByDesc('id_pregunta')
            ->paginate(10)
            ->withQueryString();

        return view('preguntas.index', compact('preguntas', 'q'));
    }

    // Formulario para crear
    public function create()
    {
        $areas = Area::where('estado_area', 1)->get();
        return view('preguntas.create', compact('areas'));
    }

    // Guardar pregunta + opciones
    public function store(Request $request)
    {
        $data = $request->validate([
            'id_area' => 'required|exists:area,id_area',
            'texto_pregunta' => 'required|string|max:255',
            'estado_pregunta' => 'required|in:0,1',
            'opciones.*.texto_opcion' => 'required|string|max:255',
            'opciones.*.es_correcta' => 'nullable|in:1',
            'opciones.*.estado_opcion' => 'required|in:0,1',
        ]);

        // Crear pregunta
        $pregunta = Pregunta::create([
            'id_area' => $data['id_area'],
            'texto_pregunta' => $data['texto_pregunta'],
            'estado_pregunta' => $data['estado_pregunta'],
        ]);

        // Crear opciones
        if (!empty($data['opciones'])) {
            foreach ($data['opciones'] as $op) {
                $pregunta->opciones()->create([
                    'texto_opcion' => $op['texto_opcion'],
                    'es_correcta' => isset($op['es_correcta']) ? 1 : 0,
                    'estado_opcion' => $op['estado_opcion'],
                ]);
            }
        }

        return redirect()->route('preguntas.index')->with('ok', 'Pregunta y opciones creadas correctamente.');
    }

    // Editar pregunta
    public function edit(string $id)
    {
        $pregunta = Pregunta::with('opciones')->findOrFail($id);
        $areas = Area::where('estado_area', 1)->get();
        return view('preguntas.edit', compact('pregunta', 'areas'));
    }

    // Actualizar pregunta + opciones
    public function update(Request $request, string $id)
    {
        $pregunta = Pregunta::findOrFail($id);

        $data = $request->validate([
            'id_area' => 'required|exists:area,id_area',
            'texto_pregunta' => 'required|string|max:255',
            'estado_pregunta' => 'required|in:0,1',
            // Opciones existentes
            'opciones.*.id_opcion' => 'nullable|exists:opcion,id_opcion',
            'opciones.*.texto_opcion' => 'required|string|max:255',
            'opciones.*.es_correcta' => 'nullable|in:1',
            'opciones.*.estado_opcion' => 'required|in:0,1',
            // Nuevas opciones (pueden estar vacías)
            'opciones_nuevas.*.texto_opcion' => 'nullable|string|max:255',
            'opciones_nuevas.*.es_correcta' => 'nullable|in:1',
            'opciones_nuevas.*.estado_opcion' => 'nullable|in:0,1',
        ]);

        // Actualizar pregunta
        $pregunta->update([
            'id_area' => $data['id_area'],
            'texto_pregunta' => $data['texto_pregunta'],
            'estado_pregunta' => $data['estado_pregunta'],
        ]);

        // Actualizar opciones existentes
        if (!empty($data['opciones'])) {
            foreach ($data['opciones'] as $op) {
                if (!empty($op['id_opcion'])) {
                    $opcion = Opcion::find($op['id_opcion']);
                    if ($opcion) {
                        $opcion->update([
                            'texto_opcion' => $op['texto_opcion'],
                            'es_correcta' => isset($op['es_correcta']) ? 1 : 0,
                            'estado_opcion' => $op['estado_opcion'],
                        ]);
                    }
                }
            }
        }

        // Agregar nuevas opciones
        if (!empty($data['opciones_nuevas'])) {
            foreach ($data['opciones_nuevas'] as $op) {
                if (!empty($op['texto_opcion'])) {
                    $pregunta->opciones()->create([
                        'texto_opcion' => $op['texto_opcion'],
                        'es_correcta' => isset($op['es_correcta']) ? 1 : 0,
                        'estado_opcion' => $op['estado_opcion'] ?? 1,
                    ]);
                }
            }
        }

        return redirect()->route('preguntas.index')->with('ok', 'Pregunta y opciones actualizadas correctamente.');
    }

    // Eliminar pregunta
    public function destroy(string $id)
    {
        $pregunta = Pregunta::findOrFail($id);
        $pregunta->opciones()->delete();
        $pregunta->delete();

        return redirect()->route('preguntas.index')->with('ok', 'Pregunta eliminada correctamente.');
    }

    // Cambiar estado de la pregunta
    public function cambiarEstado(string $id)
    {
        $pregunta = Pregunta::findOrFail($id);
        $pregunta->estado_pregunta = $pregunta->estado_pregunta == 1 ? 0 : 1;
        $pregunta->save();

        return redirect()->route('preguntas.index')->with('ok', 'Estado de la pregunta actualizado.');
    }

    // Reporte PDF
    public function reportePDF()
    {
        return redirect()->route('preguntas.index')->with('ok', 'Reporte PDF (pendiente).');
    }
}
