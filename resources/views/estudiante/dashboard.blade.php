<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Control - Estudiante</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-dark: #0f172a; --bg-card: #1e293b; --accent-celeste: #38bdf8;
            --text-main: #f1f5f9; --text-dim: #94a3b8; --verde: #22c55e;
        }
        body {
            margin: 0; font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-dark); color: var(--text-main);
            padding: 30px 15px;
        }
        .container { max-width: 1000px; margin: 0 auto; }
        .welcome-header { margin-bottom: 40px; }
        .welcome-header h1 { font-size: 2rem; margin: 0; }
        
        /* Grid de Carreras */
        .section-title { font-size: 1.1rem; font-weight: 700; margin-bottom: 20px; color: var(--accent-celeste); text-transform: uppercase; }
        .exam-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; }
        
        .exam-card {
            background: var(--bg-card); border-radius: 20px; padding: 25px;
            border: 1px solid rgba(255,255,255,0.05); transition: 0.3s;
            display: flex; flex-direction: column; justify-content: space-between;
        }
        .exam-card:hover { transform: translateY(-5px); border-color: var(--accent-celeste); }
        .exam-card h3 { margin: 0 0 10px; font-size: 1.3rem; }
        .meta { font-size: 0.8rem; color: var(--text-dim); margin-bottom: 20px; line-height: 1.5; }
        
        .btn-start { 
            background: var(--accent-celeste); color: var(--bg-dark); border: none; 
            padding: 12px; border-radius: 12px; font-weight: 700; cursor: pointer; 
            text-decoration: none; text-align: center;
        }

        .quick-nav { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 40px; }
        .nav-item {
            background: linear-gradient(135deg, #334155, #1e293b);
            padding: 20px; border-radius: 20px; text-align: center;
            text-decoration: none; color: white; font-weight: 700; border: 1px solid rgba(255,255,255,0.05);
        }
    </style>
</head>
<body>

<div class="container">
    <div class="welcome-header">
        <h1>Hola, <span style="color: var(--accent-celeste)">{{ Auth::user()->name ?? 'Estudiante' }}</span> 👋</h1>
        <p>¿Qué carrera vamos a practicar hoy?</p>
    </div>

    <div class="quick-nav">
        <a href="#" class="nav-item">📊 Ver Mis Notas</a>
        <a href="#" class="nav-item">📈 Mi Rendimiento</a>
    </div>

    <div class="section-title">📝 EXÁMENES POR CARRERA DISPONIBLES</div>
    
    <div class="exam-grid">
        @foreach($carreras as $carrera)
            <div class="exam-card">
                <div>
                    <h3>{{ $carrera->nombre_carrera }}</h3>
                    <p class="meta">
                        <b>Gestión:</b> {{ $carrera->gestion_carrera }}<br>
                        Prepárate para el ingreso a la facultad con preguntas actualizadas.
                    </p>
                </div>
                {{-- Aquí iría la ruta para comenzar el examen --}}
                <a href="#" class="btn-start">Iniciar Examen</a>
            </div>
        @endforeach
    </div>
</div>

</body>
</html>