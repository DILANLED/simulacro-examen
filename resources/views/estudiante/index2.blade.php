<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Simulacro Master - Scroll & Scalable</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-dark: #0f172a; --bg-card: #1e293b; --accent-celeste: #38bdf8;
            --text-main: #f1f5f9; --text-dim: #94a3b8; --verde-select: #22c55e;
            --plomo-unselect: #334155; --danger: #f43f5e;
            --opt-a: #3498db; --opt-b: #9b59b6; --opt-c: #e67e22; --opt-d: #1abc9c;
        }

        body {
            margin: 0; font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-dark); color: var(--text-main);
            min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 15px;
        }

        .container {
            width: 100%; max-width: 850px; background: var(--bg-card);
            border-radius: 28px; padding: 30px; box-shadow: 0 25px 50px rgba(0,0,0,0.6);
            border: 1px solid rgba(255,255,255,0.05);
        }

        /* HEADER: RELOJ Y PROGRESO */
        .header-meta { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; gap: 20px; }
        
        .timer-box {
            background: rgba(244, 63, 94, 0.1); border: 1px solid var(--danger);
            color: var(--danger); padding: 10px 15px; border-radius: 12px;
            font-weight: 700; font-family: monospace; font-size: 1.2rem; min-width: 100px; text-align: center;
        }

        .prog-bar-container { flex-grow: 1; }
        .prog-bar-bg { width: 100%; height: 10px; background: var(--plomo-unselect); border-radius: 10px; overflow: hidden; }
        .prog-bar-fill { width: 0%; height: 100%; background: var(--accent-celeste); transition: width 0.4s ease; }

        /* NAVEGACIÓN DE ÁREAS */
        .areas-container { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-bottom: 30px; }
        .area-wrapper { position: relative; }
        .area-btn { 
            width: 100%; background: var(--plomo-unselect); border: 1px solid rgba(255,255,255,0.1); 
            color: white; padding: 15px 5px; border-radius: 12px; cursor: pointer; 
            font-weight: 700; font-size: 0.7rem; transition: 0.3s;
        }
        .area-btn.active { background: var(--accent-celeste); color: var(--bg-dark); }

        /* DROPDOWN CON SCROLL */
        .q-dropdown {
            position: absolute; top: 110%; left: 0; width: 250px; 
            max-height: 250px; /* Altura máxima antes de activar scroll */
            overflow-y: auto;  /* Activa scroll vertical */
            background: #1e293b; border: 2px solid var(--accent-celeste);
            border-radius: 15px; padding: 15px; display: none;
            grid-template-columns: repeat(5, 1fr); gap: 8px; z-index: 100;
            box-shadow: 0 15px 35px rgba(0,0,0,0.7);
        }

        /* Estilo del Scrollbar (Chrome/Safari) */
        .q-dropdown::-webkit-scrollbar { width: 6px; }
        .q-dropdown::-webkit-scrollbar-track { background: var(--bg-dark); border-radius: 10px; }
        .q-dropdown::-webkit-scrollbar-thumb { background: var(--accent-celeste); border-radius: 10px; }

        .area-wrapper:nth-child(n+3) .q-dropdown { left: auto; right: 0; }

        .q-item {
            aspect-ratio: 1/1; border-radius: 8px; background: #334155;
            border: none; color: white; font-weight: 700; cursor: pointer; transition: 0.2s;
        }
        .q-item:hover { background: #475569; }
        .q-item.answered { background: var(--verde-select) !important; }
        .q-item.current { outline: 2px solid var(--accent-celeste); background: #1e293b; }

        /* PREGUNTA Y OPCIONES */
        .question-box { text-align: center; margin-bottom: 35px; min-height: 120px; }
        .options-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; }
        .option {
            padding: 25px; border-radius: 18px; cursor: pointer; transition: 0.3s;
            font-size: 1.1rem; font-weight: 700; color: white; border: none;
        }
        .option.selected { background-color: var(--verde-select) !important; transform: scale(1.02); }
        .option.not-selected { background-color: var(--plomo-unselect) !important; opacity: 0.3; filter: grayscale(1); }

        /* FOOTER */
        .footer { display: flex; flex-direction: column; margin-top: 35px; gap: 15px; }
        .nav-buttons { display: flex; gap: 15px; }
        .btn-nav { padding: 16px 25px; border-radius: 14px; border: none; font-weight: 700; cursor: pointer; flex: 1; transition: 0.2s; }
        
        .btn-finish {
            background: linear-gradient(135deg, #f43f5e, #e11d48);
            color: white; padding: 18px; border-radius: 15px; font-size: 1rem;
            text-transform: uppercase; letter-spacing: 1px; box-shadow: 0 10px 20px rgba(244, 63, 94, 0.3);
        }

        @media (max-width: 600px) { .options-grid { grid-template-columns: 1fr; } .areas-container { grid-template-columns: repeat(2, 1fr); } }
    </style>
</head>
<body>

<div class="container" id="main-ui">
    <div class="header-meta">
        <div class="timer-box" id="timer">02:00:00</div>
        <div class="prog-bar-container">
            <div style="font-size: 0.7rem; margin-bottom: 4px; font-weight: 700; color: var(--text-dim);">PROGRESO EXAMEN: <span id="prog-txt">0%</span></div>
            <div class="prog-bar-bg"><div class="prog-bar-fill" id="prog-fill"></div></div>
        </div>
    </div>

    <div class="areas-container">
        <div class="area-wrapper"><button class="area-btn active" onclick="toggleDropdown(0)">MATEMÁTICAS</button><div class="q-dropdown" id="drop-0"></div></div>
        <div class="area-wrapper"><button class="area-btn" onclick="toggleDropdown(1)">LENGUAJE</button><div class="q-dropdown" id="drop-1"></div></div>
        <div class="area-wrapper"><button class="area-btn" onclick="toggleDropdown(2)">CIENCIAS</button><div class="q-dropdown" id="drop-2"></div></div>
        <div class="area-wrapper"><button class="area-btn" onclick="toggleDropdown(3)">HISTORIA</button><div class="q-dropdown" id="drop-3"></div></div>
    </div>

    <div class="question-box">
        <p id="info-tag" style="color: var(--accent-celeste); font-weight: 800; font-size: 0.8rem; text-transform: uppercase;"></p>
        <h2 id="q-text">Cargando...</h2>
    </div>

    <div class="options-grid" id="options-grid"></div>

    <div class="footer">
        <div class="nav-buttons">
            <button class="btn-nav" style="background:#334155; color:white" onclick="move(-1)">Anterior</button>
            <button class="btn-nav" style="background:var(--accent-celeste); color:var(--bg-dark)" onclick="move(1)">Siguiente →</button>
        </div>
        <button class="btn-nav btn-finish" onclick="finishExam()">Finalizar Examen</button>
    </div>
</div>

<script>
    const areaNames = ["Matemáticas", "Lenguaje", "Ciencias", "Historia"];
    const QUESTIONS_PER_AREA = 25; // Cambia este número a 50 o 100 y el código seguirá funcionando
    
    let curArea = 0, curQ = 0;
    let results = Array.from({ length: 4 }, () => Array(QUESTIONS_PER_AREA).fill(null));
    let timeLeft = 2 * 60 * 60;
    let timerInterval;

    function startTimer() {
        const timerElement = document.getElementById('timer');
        timerInterval = setInterval(() => {
            if (timeLeft <= 0) { clearInterval(timerInterval); finishExam(true); return; }
            timeLeft--;
            let h = Math.floor(timeLeft / 3600), m = Math.floor((timeLeft % 3600) / 60), s = timeLeft % 60;
            timerElement.innerText = `${h.toString().padStart(2,'0')}:${m.toString().padStart(2,'0')}:${s.toString().padStart(2,'0')}`;
        }, 1000);
    }

    function render() {
        document.getElementById('info-tag').innerText = `${areaNames[curArea]} • Pregunta ${curQ + 1}`;
        document.getElementById('q-text').innerText = `¿Pregunta de ejemplo ${curQ + 1} de ${areaNames[curArea]}?`;
        
        const grid = document.getElementById('options-grid'); 
        grid.innerHTML = '';
        const colors = ['var(--opt-a)', 'var(--opt-b)', 'var(--opt-c)', 'var(--opt-d)'];
        
        ['A', 'B', 'C', 'D'].forEach((t, i) => {
            const b = document.createElement('button');
            b.className = 'option'; b.innerText = `Opción ${t}`; b.style.backgroundColor = colors[i];
            const ans = results[curArea][curQ];
            if (ans !== null) { if (ans === i) b.classList.add('selected'); else b.classList.add('not-selected'); }
            b.onclick = () => { results[curArea][curQ] = i; updateAll(); };
            grid.appendChild(b);
        });
        
        document.querySelectorAll('.area-btn').forEach((btn, i) => btn.classList.toggle('active', i === curArea));
        renderDropdowns();
    }

    function renderDropdowns() {
        for (let a = 0; a < 4; a++) {
            const drop = document.getElementById(`drop-${a}`); 
            drop.innerHTML = '';
            for (let q = 0; q < QUESTIONS_PER_AREA; q++) {
                const item = document.createElement('button');
                item.className = 'q-item'; item.innerText = q + 1;
                if (results[a][q] !== null) item.classList.add('answered');
                if (a === curArea && q === curQ) item.classList.add('current');
                item.onclick = (e) => { e.stopPropagation(); curArea = a; curQ = q; closeAll(); render(); };
                drop.appendChild(item);
            }
        }
    }

    function toggleDropdown(idx) { 
        const drop = document.getElementById(`drop-${idx}`); 
        const open = drop.style.display === 'grid'; 
        closeAll(); if (!open) drop.style.display = 'grid'; 
    }

    function closeAll() { document.querySelectorAll('.q-dropdown').forEach(d => d.style.display = 'none'); }

    function updateAll() {
        let count = 0; 
        results.forEach(a => a.forEach(q => { if(q !== null) count++; }));
        const totalPossible = 4 * QUESTIONS_PER_AREA;
        const percent = (count / totalPossible) * 100;
        document.getElementById('prog-fill').style.width = percent + '%';
        document.getElementById('prog-txt').innerText = Math.round(percent) + '%';
        render();
    }

    function move(step) {
        curQ += step;
        if (curQ >= QUESTIONS_PER_AREA) { if(curArea < 3) { curArea++; curQ = 0; } else curQ = QUESTIONS_PER_AREA - 1; }
        else if (curQ < 0) { if(curArea > 0) { curArea--; curQ = QUESTIONS_PER_AREA - 1; } else curQ = 0; }
        closeAll(); render();
    }

    function finishExam(auto = false) {
        let totalAnswered = 0;
        results.forEach(a => totalAnswered += a.filter(r => r !== null).length);

        if (auto || confirm(`¿Estás seguro de finalizar? Has respondido ${totalAnswered} preguntas.`)) {
            clearInterval(timerInterval);
            document.getElementById('main-ui').innerHTML = `
                <div style="text-align:center; padding:20px;">
                    <h1 style="color:var(--verde-select)">¡Simulacro Completado!</h1>
                    <p>Has respondido ${totalAnswered} de ${4 * QUESTIONS_PER_AREA} preguntas.</p>
                    <button class="btn-nav" style="background:var(--accent-celeste); width:100%; margin-top:20px;" onclick="location.reload()">Nuevo Intento</button>
                </div>
            `;
        }
    }

    document.onclick = (e) => { if(!e.target.classList.contains('area-btn')) closeAll(); };
    startTimer();
    render();
</script>
</body>
</html>