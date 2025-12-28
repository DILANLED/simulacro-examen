<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultados - {{ $examen->carrera->nombre_carrera }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-dark: #0f172a; --bg-card: #1e293b; --accent-celeste: #38bdf8;
            --text-main: #f1f5f9; --text-dim: #94a3b8; --verde-ok: #22c55e;
            --rojo-error: #f43f5e; --plomo-neutro: #334155;
        }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: var(--bg-dark); color: var(--text-main); margin: 0; padding: 20px; }
        .container { max-width: 850px; margin: 0 auto; }
        
        /* Cabecera de Puntaje */
        .score-header { background: var(--bg-card); padding: 30px; border-radius: 24px; text-align: center; border: 1px solid rgba(56, 189, 248, 0.3); margin-bottom: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.3); }
        .puntaje-total { font-size: 3.5rem; font-weight: 800; color: var(--accent-celeste); margin: 10px 0; }
        .timer-info { font-family: monospace; font-size: 1.1rem; color: var(--text-dim); background: rgba(0,0,0,0.2); padding: 8px 15px; border-radius: 10px; display: inline-block; }

        /* Contenedores de Áreas y Preguntas */
        .area-title { color: var(--accent-celeste); text-transform: uppercase; letter-spacing: 1px; border-left: 4px solid var(--accent-celeste); padding-left: 15px; margin: 40px 0 20px; }
        .q-card { background: var(--bg-card); padding: 20px; border-radius: 18px; margin-bottom: 20px; border: 1px solid rgba(255,255,255,0.05); }
        .q-text { font-size: 1.1rem; font-weight: 600; line-height: 1.5; margin-bottom: 15px; }

        /* Opciones y Colores */
        .option-item { padding: 14px; border-radius: 12px; margin-bottom: 8px; background: var(--plomo-neutro); border: 1px solid rgba(255,255,255,0.05); display: flex; justify-content: space-between; align-items: center; transition: 0.3s; }
        
        .correct-mark { background: rgba(34, 197, 94, 0.15) !important; border: 1px solid var(--verde-ok) !important; color: #4ade80; font-weight: 700; }
        .wrong-mark { background: rgba(244, 63, 94, 0.15) !important; border: 1px solid var(--rojo-error) !important; color: #fb7185; font-weight: 700; }
        
        .status-tag { font-size: 0.75rem; text-transform: uppercase; padding: 4px 8px; border-radius: 6px; }
        .no-answer-warning { font-size: 0.85rem; color: var(--text-dim); font-style: italic; margin-top: 10px; display: block; }

        .btn-home { display: block; width: 100%; max-width: 300px; margin: 40px auto; padding: 18px; border-radius: 15px; background: var(--accent-celeste); color: var(--bg-dark); text-align: center; text-decoration: none; font-weight: 800; transition: 0.3s; }
        .btn-home:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(56, 189, 248, 0.3); }

        @media (max-width: 600px) { .puntaje-total { font-size: 2.5rem; } }
    </style>
</head>
<body>

<div class="container">
    <div class="score-header">
        <h2 style="margin:0; color: var(--text-dim);">RESULTADO FINAL</h2>
        <div class="puntaje-total">{{ $examen->puntaje_examen }} pts</div>
        <p style="margin: 5px 0 15px; font-weight: 600;">{{ $examen->carrera->nombre_carrera }}</p>
        
        <div class="timer-info">
            ⏱️ Tiempo empleado: 
            {{ floor($examen->duracion / 60) }}m {{ $examen->duracion % 60 }}s
        </div>
    </div>

    @foreach($areasGeneradas as $aIndex => $area)
        <h3 class="area-title">{{ $area->nombre_area }}</h3>
        
        @foreach($area->preguntas as $pIndex => $pregunta)
            @php
                // Recuperamos lo que el usuario marcó para esta pregunta específica
                $userSelectedId = $respuestasUser[$aIndex][$pIndex] ?? null;
            @endphp
            
            <div class="q-card">
                <div class="q-text">{{ $pIndex + 1 }}. {{ $pregunta->texto_pregunta }}</div>
                
                <div class="options-container">
                    @foreach($pregunta->opciones as $opcion)
                        @php
                            $colorClass = '';
                            $label = '';
                            
                            // Lógica de marcado: solo pintar si el usuario seleccionó ESTA opción
                            if ($userSelectedId == $opcion->id_opcion) {
                                if ($opcion->es_correcta) {
                                    $colorClass = 'correct-mark';
                                    $label = '¡Correcto!';
                                } else {
                                    $colorClass = 'wrong-mark';
                                    $label = 'Incorrecto';
                                }
                            }
                        @endphp

                        <div class="option-item {{ $colorClass }}">
                            <span>{{ $opcion->texto_opcion }}</span>
                            @if($label)
                                <span class="status-tag">{{ $label }}</span>
                            @endif
                        </div>
                    @endforeach
                </div>

                @if($userSelectedId === null)
                    <span class="no-answer-warning">⚠️ No seleccionaste ninguna respuesta.</span>
                @endif
            </div>
        @endforeach
    @endforeach

    <a href="{{ route('estudiante.index') }}" class="btn-home">VOLVER AL INICIO</a>
</div>

</body>
</html>