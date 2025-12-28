<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use App\Models\Carrera;
use Illuminate\Http\Request;

class SimulacroController extends Controller
{
    public function index()
    {
        // Solo traemos carreras activas (estado_carrera = 1)
        $carreras = Carrera::where('estado_carrera', 1)
            ->orderBy('nombre_carrera', 'asc')
            ->get();

        return view('estudiante.index', compact('carreras'));
    }
}