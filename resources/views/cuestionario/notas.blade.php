<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Resultados - Historial</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-dark: #0f172a;
            --bg-card: #1e293b;
            --accent-celeste: #38bdf8;
            --text-main: #f1f5f9;
            --text-dim: #94a3b8;
            --verde-select: #22c55e;
            --plomo-unselect: #334155;
            --danger: #f43f5e;
        }

        body {
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-dark);
            color: var(--text-main);
            min-height: 100vh;
            padding: 40px 15px;
            display: flex;
            justify-content: center;
        }

        .container {
            width: 100%;
            max-width: 900px;
        }

        /* HEADER DE LA PÁGINA */
        .header-history {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .header-history h1 {
            font-size: 1.8rem;
            margin: 0;
            background: linear-gradient(90deg, #fff, var(--accent-celeste));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .btn-new-exam {
            background: var(--accent-celeste);
            color: var(--bg-dark);
            padding: 12px 20px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.9rem;
            transition: 0.3s;
        }

        .btn-new-exam:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(56, 189, 248, 0.2);
        }

        /* TABLA DE RESULTADOS */
        .card-table {
            background: var(--bg-card);
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        th {
            background: rgba(255, 255, 255, 0.02);
            padding: 20px;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-dim);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        td {
            padding: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            font-size: 0.95rem;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover {
            background: rgba(56, 189, 248, 0.02);
        }

        /* ESTADOS Y BOTONES */
        .score-badge {
            background: rgba(34, 197, 94, 0.1);
            color: var(--verde-select);
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 700;
            border: 1px solid rgba(34, 197, 94, 0.2);
        }

        .btn-action-view {
            background: var(--plomo-unselect);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.8rem;
            transition: 0.2s;
        }

        .btn-action-view:hover {
            background: var(--accent-celeste);
            color: var(--bg-dark);
        }

        .date-text {
            color: var(--text-dim);
            font-size: 0.85rem;
        }

        /* RESPONSIVE */
        @media (max-width: 600px) {
            th:nth-child(2), td:nth-child(2) { display: none; } /* Oculta fecha en móviles si es muy pequeña */
            .header-history { flex-direction: column; gap: 15px; align-items: flex-start; }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header-history">
        <div>
            <h1>Historial de Notas</h1>
            <p style="color: var(--text-dim); margin-top: 5px;">Revisa tu progreso y desempeño por área.</p>
        </div>
        <a href="index.html" class="btn-new-exam">+ Nuevo Simulacro</a>
    </div>

    <div class="card-table">
        <table>
            <thead>
                <tr>
                    <th>Examen</th>
                    <th>Fecha y Hora</th>
                    <th>Nota Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tabla-body">
                <tr>
                    <td><b>Simulacro General #1</b></td>
                    <td class="date-text">26 Dic, 2025 • 21:30</td>
                    <td><span class="score-badge">85 / 100</span></td>
                    <td><button class="btn-action-view" onclick="verDetalle(1)">Ver Examen</button></td>
                </tr>
                <tr>
                    <td><b>Simulacro General #2</b></td>
                    <td class="date-text">24 Dic, 2025 • 18:15</td>
                    <td><span class="score-badge">92 / 100</span></td>
                    <td><button class="btn-action-view" onclick="verDetalle(2)">Ver Examen</button></td>
                </tr>
                </tbody>
        </table>
    </div>
</div>

<script>
    function verDetalle(id) {
        // Lógica para abrir la revisión del examen
        alert("Cargando revisión del examen ID: " + id);
    }

    // Opcional: Cargar desde localStorage si los guardaste en la otra página
    window.onload = function() {
        const historialGuardado = JSON.parse(localStorage.getItem('historialExamenes')) || [];
        if(historialGuardado.length > 0) {
            const body = document.getElementById('tabla-body');
            // Aquí podrías generar las filas dinámicamente
        }
    }
</script>

</body>
</html>