<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Rendimiento Pro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #0b0f1a; --card: rgba(30, 41, 59, 0.7); --accent: #38bdf8;
        }
        body { 
            background: radial-gradient(circle at top right, #1e293b, #0b0f1a);
            color: #f1f5f9; font-family: 'Plus Jakarta Sans', sans-serif;
            margin: 0; padding: 20px 10px; /* Padding reducido para móviles */
            min-height: 100vh;
        }
        .container { 
            width: 100%;
            max-width: 1100px; 
            margin: 0 auto; 
            box-sizing: border-box;
        }
        
        /* Ajustes de Título Responsive */
        .title-section { text-align: center; margin-bottom: 30px; padding: 0 10px; }
        .title-section h1 { 
            font-size: clamp(1.8rem, 5vw, 2.5rem); 
            margin: 10px 0;
            background: linear-gradient(to right, #38bdf8, #818cf8); 
            -webkit-background-clip: text; 
            -webkit-text-fill-color: transparent; 
        }

        /* Tarjetas Adaptables */
        .carrera-card {
            background: var(--card);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 20px; /* Radio ligeramente menor para móviles */
            padding: clamp(15px, 4vw, 30px);
            margin-bottom: 30px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.4);
            /* El efecto 3D se suaviza en móviles para evitar cortes visuales */
            transform: perspective(1000px) rotateX(1deg);
            transition: transform 0.4s ease, box-shadow 0.4s ease;
            animation: slideIn 0.8s ease-out forwards;
            overflow: hidden;
        }
        
        @media (min-width: 768px) {
            .carrera-card { 
                border-radius: 30px;
                margin-bottom: 50px;
                transform: perspective(1000px) rotateX(2deg);
            }
            .carrera-card:hover {
                transform: perspective(1000px) rotateX(0deg) translateY(-10px);
                box-shadow: 0 30px 60px rgba(56, 189, 248, 0.2);
            }
        }

        /* Títulos de carrera */
        .carrera-card h2 {
            font-size: clamp(1.1rem, 4vw, 1.5rem);
            margin-bottom: 20px;
        }

        /* Stats Flexbox Responsive */
        .stats-mini { 
            display: flex; 
            flex-wrap: wrap; /* Permite que bajen si no hay espacio */
            gap: 10px; 
            margin-bottom: 25px; 
        }
        .stat-item { 
            flex: 1; /* Crecen igualitariamente */
            min-width: 120px; /* Evita que se vuelvan demasiado delgados */
            background: rgba(0,0,0,0.2); 
            padding: 12px 15px; 
            border-radius: 15px; 
            border: 1px solid rgba(56,189,248,0.2); 
        }

        /* Contenedor de Gráfica */
        .chart-wrapper { 
            height: clamp(250px, 50vh, 350px); /* Altura dinámica */
            width: 100%; 
            position: relative; 
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(20px) scale(0.98); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* Botón Regresar */
        .btn-back {
            display: inline-block;
            margin-bottom: 15px;
            color: var(--accent);
            text-decoration: none;
            font-weight: bold;
            font-size: 0.9rem;
            transition: 0.3s;
        }
        .btn-back:hover { opacity: 0.7; transform: translateX(-5px); }
    </style>
</head>
<body>

<div class="container">
    <div class="title-section">
        <a href="{{ route('estudiante.index') }}" class="btn-back">← REGRESAR</a>
        <h1>Análisis de Rendimiento</h1>
        <p style="color: #94a3b8; font-size: 0.9rem;">Progreso histórico detallado</p>
    </div>

    @foreach($rendimientoPorCarrera as $idCarrera => $examenes)
        <div class="carrera-card">
            <h2 style="margin-top:0; display:flex; align-items:center; gap:10px;">
                <span style="width:10px; height:10px; background:var(--accent); border-radius:50%; box-shadow:0 0 10px var(--accent);"></span>
                {{ $examenes->first()->carrera->nombre_carrera }}
            </h2>

            <div class="stats-mini">
                <div class="stat-item">
                    <small style="color:#94a3b8; display:block; font-size: 0.75rem;">Promedio</small>
                    <b style="font-size:1.1rem;">{{ round($examenes->avg('puntaje_examen'), 1) }}</b>
                </div>
                <div class="stat-item">
                    <small style="color:#94a3b8; display:block; font-size: 0.75rem;">Máximo</small>
                    <b style="font-size:1.1rem; color:#4ade80;">{{ $examenes->max('puntaje_examen') }}</b>
                </div>
            </div>

            <div class="chart-wrapper">
                <canvas id="chart-{{ $idCarrera }}"></canvas>
            </div>
        </div>
    @endforeach
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const dataSet = @json($rendimientoPorCarrera);

        Object.keys(dataSet).forEach(id => {
            const canvas = document.getElementById(`chart-${id}`);
            if(!canvas) return;
            
            const ctx = canvas.getContext('2d');
            
            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(56, 189, 248, 0.4)');
            gradient.addColorStop(1, 'rgba(56, 189, 248, 0)');

            const labels = dataSet[id].map(ex => {
                const date = new Date(ex.fecha_examen);
                // Formato corto para móviles (DD/MM)
                return window.innerWidth < 768 
                    ? `${date.getDate()}/${date.getMonth() + 1}`
                    : date.toLocaleDateString();
            });
            
            const scores = dataSet[id].map(ex => ex.puntaje_examen);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Puntaje',
                        data: scores,
                        borderColor: '#38bdf8',
                        borderWidth: window.innerWidth < 768 ? 2 : 4,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#38bdf8',
                        pointRadius: window.innerWidth < 768 ? 3 : 5,
                        fill: true,
                        backgroundColor: gradient,
                        tension: 0.4 
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { 
                            beginAtZero: true, 
                            grid: { color: 'rgba(255,255,255,0.05)' },
                            ticks: { 
                                color: '#64748b',
                                font: { size: 10 }
                            }
                        },
                        x: { 
                            grid: { display: false },
                            ticks: { 
                                color: '#64748b',
                                font: { size: 10 },
                                maxRotation: 45,
                                minRotation: 45
                            }
                        }
                    }
                }
            });
        });
    });
</script>

</body>
</html>