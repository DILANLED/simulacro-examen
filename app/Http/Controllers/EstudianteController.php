<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use App\Models\Area;
use App\Models\Examen;
use App\Models\Opcion;
use Illuminate\Http\Request;

class EstudianteController extends Controller
{
    public function index()
    {
        $carreras = Carrera::where('estado_carrera', 1)
            ->orderBy('nombre_carrera', 'asc')
            ->get();

        return view('estudiante.index', compact('carreras'));
    }

    // ... dentro de EstudianteController ...

            public function iniciarExamen($id)
            {
                $carrera = Carrera::where('id_carrera', $id)->firstOrFail();

                $areas = Area::where('id_carrera', $id)
                    ->where('estado_area', 1)
                    ->get()
                    ->map(function ($area) {
                        $area->setRelation('preguntas', 
                            $area->preguntas()
                                ->where('estado_pregunta', 1)
                                ->inRandomOrder()
                                ->take($area->n_preguntas)
                                ->with(['opciones' => function($o) {
                                    $o->where('estado_opcion', 1)
                                    ->inRandomOrder()
                                    ->take(4);
                                }])
                                ->get()
                        );
                        return $area;
                    });

                $examen = Examen::create([
                    'puntaje_examen' => 0,
                    'duracion' => 0,
                    'fecha_examen' => now(),
                    'estado_examen' => 1,
                    'id_carrera' => $id,
                    'id_usuario' => auth()->user()->id_usuario
                ]);

                // ✅ GUARDAMOS LAS ÁREAS Y PREGUNTAS GENERADAS EN LA SESIÓN
                // Esto garantiza que el resultado muestre las mismas preguntas aleatorias.
                session(['preguntas_examen_' . $examen->id_examen => $areas]);

                return view('estudiante.examen', compact('carrera', 'areas', 'examen'));
            }

            public function mostrarResultado($id)
            {
                $examen = Examen::with('carrera')->findOrFail($id);
                
                if ($examen->id_usuario !== auth()->user()->id_usuario) {
                    return redirect()->route('estudiante.index');
                }

                // ✅ RECUPERAMOS LAS PREGUNTAS ESPECÍFICAS DE LA SESIÓN
                $areasGeneradas = session('preguntas_examen_' . $id, []);
                $respuestasUser = session('respuestas_examen_' . $id, []);

                return view('estudiante.resultado', compact('examen', 'areasGeneradas', 'respuestasUser'));
            }

    public function finalizarExamen(Request $request)
    {
        $id_examen = $request->id_examen;
        $respuestas = $request->respuestas; 
        $puntos = 0;

        // 1. Guardamos las respuestas en sesión para que la vista de resultados las compare
        session(['respuestas_examen_' . $id_examen => $respuestas]);

        foreach ($respuestas as $area) {
            if (is_array($area)) {
                foreach ($area as $id_opcion) {
                    if ($id_opcion) {
                        $correcta = Opcion::where('id_opcion', $id_opcion)
                            ->where('es_correcta', 1)
                            ->exists();
                        
                        if ($correcta) $puntos++;
                    }
                }
            }
        }

        $examen = Examen::findOrFail($id_examen);
        $examen->update([
            'puntaje_examen' => $puntos,
            'estado_examen' => 0, 
            'duracion' => 7200 - $request->tiempo_restante
        ]);

        return response()->json([
            'success' => true, 
            'redirect_url' => route('examen.resultado', $id_examen)
        ]);
    }

    public function misNotas()
    {
        $notas = Examen::where('id_usuario', auth()->user()->id_usuario)
            ->where('estado_examen', 0)
            ->with('carrera')
            ->orderBy('fecha_examen', 'desc')
            ->get();

        return view('estudiante.notas', compact('notas'));
    }
    public function rendimiento()
{
    $usuario_id = auth()->user()->id_usuario;

    $examenes = Examen::where('id_usuario', $usuario_id)
        ->where('estado_examen', 0)
        ->with('carrera')
        ->orderBy('fecha_examen', 'asc')
        ->get();

    // Agrupamos por carrera para generar una gráfica independiente por cada una
    $rendimientoPorCarrera = $examenes->groupBy('id_carrera');

    return view('estudiante.rendimiento', compact('rendimientoPorCarrera'));
}
}