<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Notas - Simulacro Master</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-dark: #0f172a; --bg-card: #1e293b; --accent: #38bdf8;
            --text-main: #f1f5f9; --text-dim: #94a3b8;
        }
        body { 
            margin: 0; font-family: 'Plus Jakarta Sans', sans-serif; 
            background: var(--bg-dark); color: var(--text-main); padding: 20px 15px;
            min-height: 100vh;
        }
        .container { max-width: 900px; margin: 0 auto; }
        
        .header { 
            margin-bottom: 30px; 
            display: flex; 
            justify-content: space-between; 
            align-items: center;
            gap: 15px;
        }
        .header h1 { font-size: clamp(1.4rem, 5vw, 1.8rem); margin: 0; }
        
        .notas-table {
            width: 100%; border-collapse: collapse; background: var(--bg-card);
            border-radius: 20px; overflow: hidden; border: 1px solid rgba(255,255,255,0.05);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .notas-table th {
            background: rgba(56, 189, 248, 0.1); color: var(--accent);
            text-align: left; padding: 18px; font-size: 0.85rem;
            text-transform: uppercase; letter-spacing: 1px;
        }
        .notas-table td {
            padding: 18px; border-bottom: 1px solid rgba(255,255,255,0.05);
            font-size: 0.95rem;
        }
        .notas-table tr:hover { background: rgba(255,255,255,0.02); }
        
        .badge-puntaje {
            background: rgba(34, 197, 94, 0.15); color: #4ade80; padding: 5px 12px;
            border-radius: 8px; font-weight: 700; border: 1px solid rgba(34, 197, 94, 0.3);
        }
        .btn-volver {
            text-decoration: none; color: var(--accent); font-weight: 700;
            display: inline-flex; align-items: center; gap: 8px; font-size: 0.9rem;
        }

        /* --- MOBILE RESPONSIVE OPTIMIZATION --- */
        @media (max-width: 600px) {
            body { padding: 15px 10px; }
            
            .header { flex-direction: column; align-items: flex-start; gap: 10px; }
            
            /* Convertimos la tabla en bloques */
            .notas-table, .notas-table thead, .notas-table tbody, .notas-table th, .notas-table td, .notas-table tr { 
                display: block; 
            }

            .notas-table thead { display: none; } /* Escondemos el header original */

            .notas-table tr {
                margin-bottom: 15px;
                border: 1px solid rgba(255,255,255,0.1);
                border-radius: 15px;
                background: rgba(255,255,255,0.02);
            }

            .notas-table td {
                text-align: right;
                padding: 12px 15px;
                position: relative;
                border-bottom: 1px solid rgba(255,255,255,0.05);
            }

            .notas-table td:last-child { border-bottom: none; }

            /* Insertamos el nombre de la columna usando data-label */
            .notas-table td::before {
                content: attr(data-label);
                position: absolute;
                left: 15px;
                width: 45%;
                text-align: left;
                font-weight: 700;
                color: var(--accent);
                font-size: 0.75rem;
                text-transform: uppercase;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>📊 Mis Calificaciones</h1>
        <a href="{{ route('estudiante.index') }}" class="btn-volver">← Volver al Panel</a>
    </div>

    <table class="notas-table">
        <thead>
            <tr>
                <th>CARRERA</th>
                <th>FECHA</th>
                <th>TIEMPO</th>
                <th>PUNTAJE</th>
            </tr>
        </thead>
        <tbody>
            @forelse($notas as $nota)
            <tr>
                <td data-label="CARRERA"><strong>{{ $nota->carrera->nombre_carrera }}</strong></td>
                <td data-label="FECHA">{{ \Carbon\Carbon::parse($nota->fecha_examen)->format('d/m/Y H:i') }}</td>
                <td data-label="TIEMPO">{{ gmdate("H:i:s", $nota->duracion) }}</td>
                <td data-label="PUNTAJE"><span class="badge-puntaje">{{ $nota->puntaje_examen }} pts</span></td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align: center; color: var(--text-dim); padding: 40px;">
                    Aún no has realizado ningún simulacro.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
</body>
</html>