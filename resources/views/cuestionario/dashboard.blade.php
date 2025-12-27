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
            --naranja: #f59e0b; --plomo: #334155;
        }

        body {
            margin: 0; font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-dark); color: var(--text-main);
            padding: 30px 15px;
        }

        .container { max-width: 1000px; margin: 0 auto; }

        /* BIENVENIDA */
        .welcome-header { margin-bottom: 40px; }
        .welcome-header h1 { font-size: 2rem; margin: 0; }
        .welcome-header p { color: var(--text-dim); margin: 5px 0 0; }

        /* REJILLA DE EXÁMENES */
        .section-title { font-size: 1.1rem; font-weight: 700; margin-bottom: 20px; color: var(--accent-celeste); display: flex; align-items: center; gap: 10px; }
        
        .exam-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 40px; }
        
        .exam-card {
            background: var(--bg-card); border-radius: 20px; padding: 25px;
            border: 1px solid rgba(255,255,255,0.05); transition: 0.3s; cursor: pointer;
            display: flex; flex-direction: column; justify-content: space-between;
        }
        .exam-card:hover { transform: translateY(-5px); border-color: var(--accent-celeste); box-shadow: 0 15px 30px rgba(0,0,0,0.3); }
        
        .exam-card h3 { margin: 0 0 10px; font-size: 1.3rem; }
        .exam-card .meta { font-size: 0.8rem; color: var(--text-dim); margin-bottom: 20px; }
        .btn-start { 
            background: var(--accent-celeste); color: var(--bg-dark); border: none; 
            padding: 12px; border-radius: 12px; font-weight: 700; cursor: pointer; 
        }

        /* ACCESOS RÁPIDOS (Notas y Rendimiento) */
        .quick-nav { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 40px; }
        .nav-item {
            background: linear-gradient(135deg, #334155, #1e293b);
            padding: 20px; border-radius: 20px; text-align: center;
            text-decoration: none; color: white; font-weight: 700; border: 1px solid rgba(255,255,255,0.05);
        }
        .nav-item:hover { background: var(--accent-celeste); color: var(--bg-dark); }

        /* RECOMENDACIONES */
        .rec-box {
            background: rgba(56, 189, 248, 0.05); border: 1px dashed var(--accent-celeste);
            padding: 25px; border-radius: 24px;
        }
        .rec-item { display: flex; gap: 15px; align-items: flex-start; margin-bottom: 15px; }
        .icon-rec { background: var(--accent-celeste); color: var(--bg-dark); padding: 5px 10px; border-radius: 8px; font-weight: 800; font-size: 0.8rem; }
        .rec-text b { color: var(--accent-celeste); }

        @media (max-width: 600px) { .quick-nav { grid-template-columns: 1fr; } }
    </style>
</head>
<body>

<div class="container">
    <div class="welcome-header">
        <h1>Hola, <span style="color: var(--accent-celeste)">Estudiante</span> 👋</h1>
        <p>¿Qué vamos a practicar hoy?</p>
    </div>

    <div class="quick-nav">
        <a href="historial.html" class="nav-item">📊 Ver Mis Notas</a>
        <a href="#" class="nav-item" onclick="alert('Próximamente: Gráficas de rendimiento')">📈 Mi Rendimiento</a>
    </div>

    <div class="section-title">📝 EXÁMENES DISPONIBLES</div>
    <div class="exam-grid">
        <div class="exam-card">
            <div>
                <h3>Simulacro General</h3>
                <p class="meta">100 Preguntas • 2 Horas<br>Matemáticas, Lenguaje, Ciencias e Historia.</p>
            </div>
            <button class="btn-start" onclick="location.href='examen.html'">Empezar Ahora</button>
        </div>

        <div class="exam-card">
            <div>
                <h3>Área: Matemáticas</h3>
                <p class="meta">25 Preguntas • 45 Minutos<br>Enfoque exclusivo en álgebra y geometría.</p>
            </div>
            <button class="btn-start" onclick="alert('Cargando examen específico...')">Empezar Ahora</button>
        </div>

        <div class="exam-card">
            <div>
                <h3>Repaso Rápido</h3>
                <p class="meta">10 Preguntas • 15 Minutos<br>Ideal para practicar entre clases.</p>
            </div>
            <button class="btn-start">Empezar Ahora</button>
        </div>
    </div>

    <div class="section-title">💡 RECOMENDACIONES PARA TI</div>
    <div class="rec-box">
        <div class="rec-item">
            <div class="icon-rec">TIP</div>
            <div class="rec-text">Tu rendimiento en <b>Matemáticas</b> ha bajado un 10%. Te recomendamos practicar el simulacro específico de esta área.</div>
        </div>
        <div class="rec-item">
            <div class="icon-rec">INFO</div>
            <div class="rec-text">Has completado el 80% de tus metas semanales. ¡Sigue así para llegar al examen real con confianza!</div>
        </div>
    </div>
</div>

</body>
</html>