<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Control - Simulacro Master</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-dark: #0f172a; --bg-card: #1e293b; --accent-celeste: #38bdf8;
            --text-main: #f1f5f9; --text-dim: #94a3b8; --verde: #22c55e;
            --danger: #f43f5e;
        }

        body {
            margin: 0; font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-dark); color: var(--text-main);
            padding: 30px 15px;
        }

        .container { max-width: 1000px; margin: 0 auto; }

        /* HEADER AJUSTADO PARA LOGOUT */
        .welcome-header { 
            display: flex; 
            justify-content: space-between; 
            align-items: flex-start; 
            margin-bottom: 40px; 
            gap: 20px;
        }
        .header-content h1 { font-size: 2rem; margin: 0; }
        .header-content p { color: var(--text-dim); margin: 5px 0 0; }

        /* BOTÓN DE LOGOUT */
        .btn-logout {
            background: rgba(244, 63, 94, 0.1);
            color: var(--danger);
            border: 1px solid var(--danger);
            padding: 10px 18px;
            border-radius: 12px;
            font-weight: 700;
            text-decoration: none;
            font-size: 0.9rem;
            transition: 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }
        .btn-logout:hover {
            background: var(--danger);
            color: white;
        }

        .section-title { font-size: 1.1rem; font-weight: 700; margin-bottom: 20px; color: var(--accent-celeste); display: flex; align-items: center; gap: 10px; }
        
        .exam-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 40px; }
        
        .exam-card {
            background: var(--bg-card); border-radius: 20px; padding: 25px;
            border: 1px solid rgba(255,255,255,0.05); transition: 0.3s;
            display: flex; flex-direction: column; justify-content: space-between;
        }
        .exam-card:hover { transform: translateY(-5px); border-color: var(--accent-celeste); box-shadow: 0 15px 30px rgba(0,0,0,0.3); }
        
        .exam-card h3 { margin: 0 0 10px; font-size: 1.3rem; }
        .exam-card .meta { font-size: 0.8rem; color: var(--text-dim); margin-bottom: 20px; }
        
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
            transition: 0.3s;
        }
        .nav-item:hover { border-color: var(--accent-celeste); transform: scale(1.02); }

        /* RESPONSIVE */
        @media (max-width: 600px) { 
            .welcome-header { flex-direction: column; align-items: flex-start; }
            .quick-nav { grid-template-columns: 1fr; } 
            .btn-logout { width: 100%; justify-content: center; }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="welcome-header">
        <div class="header-content">
            <h1>Hola, <span style="color: var(--accent-celeste)">{{ Auth::user()->nombre_usuario ?? 'Estudiante' }}</span> 👋</h1>
            <p>¿Qué carrera vamos a practicar hoy?</p>
        </div>
        
        <form action="{{ route('logout') }}" method="POST" id="logout-form">
            @csrf
            <button type="submit" class="btn-logout">
                <span>🚪</span> Cerrar Sesión
            </button>
        </form>
    </div>

    <div class="quick-nav">
        <a href="{{ route('estudiante.notas') }}" class="nav-item">
            <span>📊</span> Ver Mis Notas
        </a>
        <a href="{{ route('estudiante.rendimiento') }}" class="nav-item">
            <span>📈</span> Mi Rendimiento
        </a>
    </div>

    <div class="section-title">📝 EXÁMENES DISPONIBLES POR CARRERA</div>
    
    <div class="exam-grid">
        @forelse($carreras as $carrera)
            <div class="exam-card">
                <div>
                    <h3>{{ $carrera->nombre_carrera }}</h3>
                    <p class="meta">
                        <b>Gestión:</b> {{ $carrera->gestion_carrera }}<br>
                        Prepárate para el examen de admisión de esta carrera.
                    </p>
                </div>
                <a href="{{ route('examen.iniciar', $carrera->id_carrera) }}" class="btn-start">
                    Iniciar Examen
                </a>
            </div>
        @empty
            <div style="grid-column: 1/-1; text-align: center; padding: 40px; color: var(--text-dim);">
                <p>No hay carreras disponibles en este momento.</p>
            </div>
        @endforelse
    </div>
</div>

</body>
</html>