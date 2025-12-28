<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Simulacro - {{ $carrera->nombre_carrera }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-dark: #0f172a; --bg-card: #1e293b; --accent-celeste: #38bdf8;
            --text-main: #f1f5f9; --text-dim: #94a3b8; --verde-select: #22c55e;
            --plomo-unselect: #334155; --danger: #f43f5e;
            --opt-a: #3498db; --opt-b: #9b59b6; --opt-c: #e67e22; --opt-d: #1abc9c;
        }
        body { margin: 0; font-family: 'Plus Jakarta Sans', sans-serif; background-color: var(--bg-dark); color: var(--text-main); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 15px; overflow-x: hidden; }
        
        /* --- OVERLAY DE CARGA PANTALLA COMPLETA --- */
        #loadingOverlay {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(15, 23, 42, 0.95); /* Color oscuro semi-transparente */
            z-index: 9999; /* Por encima de todo */
            flex-direction: column;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(8px);
        }

        .loader-box {
            text-align: center;
            padding: 20px;
        }

        .main-spinner {
            width: 70px;
            height: 70px;
            border: 5px solid rgba(56, 189, 248, 0.1);
            border-top: 5px solid var(--accent-celeste);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
            box-shadow: 0 0 20px rgba(56, 189, 248, 0.2);
        }

        .loading-text {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--accent-celeste);
            letter-spacing: 1px;
            margin-bottom: 10px;
        }

        .loading-subtext {
            color: var(--text-dim);
            font-size: 0.9rem;
        }

        @keyframes spin { to { transform: rotate(360deg); } }

        /* Estilos del Modal Normal */
        #finishModal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.9); z-index: 2000; align-items: center; justify-content: center; backdrop-filter: blur(5px); }
        .modal-content { background: var(--bg-card); padding: 40px; border-radius: 28px; border: 1px solid var(--accent-celeste); text-align: center; max-width: 450px; width: 90%; box-shadow: 0 0 30px rgba(56, 189, 248, 0.2); }

        /* Contenedor Principal */
        .container { width: 100%; max-width: 850px; background: var(--bg-card); border-radius: 28px; padding: 30px; box-shadow: 0 25px 50px rgba(0,0,0,0.6); border: 1px solid rgba(255,255,255,0.05); position: relative; }
        .header-meta { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; gap: 20px; }
        .timer-box { background: rgba(244, 63, 94, 0.1); border: 1px solid var(--danger); color: var(--danger); padding: 10px 15px; border-radius: 12px; font-weight: 700; font-family: monospace; font-size: 1.2rem; min-width: 100px; text-align: center; }
        .prog-bar-bg { width: 100%; height: 10px; background: var(--plomo-unselect); border-radius: 10px; overflow: hidden; }
        .prog-bar-fill { width: 0%; height: 100%; background: var(--accent-celeste); transition: width 0.4s ease; }
        .areas-container { display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 10px; margin-bottom: 30px; }
        .area-btn { width: 100%; background: var(--plomo-unselect); border: 1px solid rgba(255,255,255,0.1); color: white; padding: 12px 5px; border-radius: 12px; cursor: pointer; font-weight: 700; font-size: 0.75rem; transition: 0.3s; }
        .area-btn.active { background: var(--accent-celeste); color: var(--bg-dark); border-color: var(--accent-celeste); }
        .q-dropdown { position: absolute; top: 110%; left: 0; width: 250px; max-height: 250px; overflow-y: auto; background: #1e293b; border: 2px solid var(--accent-celeste); border-radius: 15px; padding: 15px; display: none; grid-template-columns: repeat(5, 1fr); gap: 8px; z-index: 100; box-shadow: 0 15px 35px rgba(0,0,0,0.7); }
        .area-wrapper { position: relative; }
        .q-item { aspect-ratio: 1/1; border-radius: 8px; background: #334155; border: none; color: white; font-weight: 700; cursor: pointer; }
        .q-item.answered { background: var(--verde-select) !important; }
        .q-item.current { outline: 2px solid white; }
        .question-box { text-align: center; margin-bottom: 35px; min-height: 120px; }
        .options-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; }
        .option { padding: 25px; border-radius: 18px; cursor: pointer; transition: 0.3s; font-size: 1.1rem; font-weight: 700; color: white; border: none; text-align: left; }
        .option.selected { outline: 4px solid white; transform: scale(1.02); box-shadow: 0 10px 20px rgba(0,0,0,0.3); }
        .option.not-selected { opacity: 0.4; filter: grayscale(0.5); }
        .footer { display: flex; flex-direction: column; margin-top: 35px; gap: 15px; }
        .nav-buttons { display: flex; gap: 15px; }
        .btn-nav { padding: 16px 25px; border-radius: 14px; border: none; font-weight: 700; cursor: pointer; flex: 1; transition: 0.2s; }
        .btn-finish { background: linear-gradient(135deg, #f43f5e, #e11d48); color: white; }
        
        @media (max-width: 600px) { 
            .options-grid { grid-template-columns: 1fr; } 
            .loading-text { font-size: 1.2rem; }
        }
    </style>
</head>
<body>

<div id="loadingOverlay">
    <div class="loader-box">
        <div class="main-spinner"></div>
        <div class="loading-text">CALCULANDO RESULTADOS</div>
        <div class="loading-subtext">Por favor, no cierres esta ventana...</div>
    </div>
</div>

<div id="finishModal">
    <div class="modal-content">
        <h2 style="color:var(--accent-celeste); margin-top:0;">¿Finalizar Examen?</h2>
        <p style="color:var(--text-dim); line-height: 1.5;">Has completado <span id="modal-prog">0%</span> del examen.</p>
        <div style="display:flex; gap:15px; margin-top:30px;">
            <button onclick="closeModal()" style="flex:1; padding:15px; border-radius:12px; border:none; background:var(--plomo-unselect); color:white; cursor:pointer; font-weight:700;">REGRESAR</button>
            <button onclick="processFinish()" style="flex:1; padding:15px; border-radius:12px; border:none; background:var(--accent-celeste); color:var(--bg-dark); cursor:pointer; font-weight:700;">SÍ, TERMINAR</button>
        </div>
    </div>
</div>

<div class="container" id="main-ui">
    <div class="header-meta">
        <div class="timer-box" id="timer">02:00:00</div>
        <div class="prog-bar-container" style="flex-grow:1">
            <div style="font-size: 0.7rem; margin-bottom: 4px; font-weight: 700; color: var(--text-dim);">PROGRESO TOTAL: <span id="prog-txt">0%</span></div>
            <div class="prog-bar-bg"><div class="prog-bar-fill" id="prog-fill"></div></div>
        </div>
    </div>

    <div class="areas-container">
        @foreach($areas as $index => $area)
        <div class="area-wrapper">
            <button class="area-btn {{ $index === 0 ? 'active' : '' }}" onclick="toggleDropdown({{ $index }})">
                {{ strtoupper($area->nombre_area) }} ({{ count($area->preguntas) }})
            </button>
            <div class="q-dropdown" id="drop-{{ $index }}"></div>
        </div>
        @endforeach
    </div>

    <div class="question-box">
        <p id="info-tag" style="color: var(--accent-celeste); font-weight: 800; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px;"></p>
        <h2 id="q-text" style="line-height: 1.4;">Cargando pregunta...</h2>
    </div>

    <div id="options-grid" class="options-grid"></div>

    <div class="footer">
        <div class="nav-buttons">
            <button class="btn-nav" style="background:#334155; color:white" onclick="move(-1)">← Anterior</button>
            <button class="btn-nav" style="background:var(--accent-celeste); color:var(--bg-dark)" onclick="move(1)">Siguiente →</button>
        </div>
        <button class="btn-nav btn-finish" onclick="openModal()">Finalizar Examen</button>
    </div>
</div>

<script>
    const EXAM_DATA = @json($areas);
    const EXAM_ID = {{ $examen->id_examen }};
    
    let curArea = 0, curQ = 0;
    let results = EXAM_DATA.map(area => area.preguntas.map(() => null));
    let timeLeft = 2 * 60 * 60; 
    let timerInterval;

    function startTimer() {
        const timerElement = document.getElementById('timer');
        timerInterval = setInterval(() => {
            if (timeLeft <= 0) {
                clearInterval(timerInterval);
                processFinish();
                return;
            }
            timeLeft--;
            let h = Math.floor(timeLeft / 3600), m = Math.floor((timeLeft % 3600) / 60), s = timeLeft % 60;
            timerElement.innerText = `${h.toString().padStart(2,'0')}:${m.toString().padStart(2,'0')}:${s.toString().padStart(2,'0')}`;
        }, 1000);
    }

    function render() {
        const area = EXAM_DATA[curArea];
        const pregunta = area.preguntas[curQ];
        if (!pregunta) return;

        document.getElementById('info-tag').innerText = `${area.nombre_area} • Pregunta ${curQ + 1} de ${area.preguntas.length}`;
        document.getElementById('q-text').innerText = pregunta.texto_pregunta;
        
        const grid = document.getElementById('options-grid'); 
        grid.innerHTML = '';
        const colors = ['var(--opt-a)', 'var(--opt-b)', 'var(--opt-c)', 'var(--opt-d)'];
        
        pregunta.opciones.forEach((opc, i) => {
            const b = document.createElement('button');
            b.className = 'option';
            b.innerText = opc.texto_opcion;
            b.style.backgroundColor = colors[i] || '#6c757d';
            
            if (results[curArea][curQ] === opc.id_opcion) b.classList.add('selected');
            else if (results[curArea][curQ] !== null) b.classList.add('not-selected');

            b.onclick = () => { 
                results[curArea][curQ] = opc.id_opcion; 
                updateAll(); 
            };
            grid.appendChild(b);
        });

        document.querySelectorAll('.area-btn').forEach((btn, i) => btn.classList.toggle('active', i === curArea));
        renderDropdowns();
    }

    function renderDropdowns() {
        EXAM_DATA.forEach((area, a) => {
            const drop = document.getElementById(`drop-${a}`);
            drop.innerHTML = '';
            area.preguntas.forEach((p, q) => {
                const item = document.createElement('button');
                item.className = 'q-item';
                item.innerText = q + 1;
                if (results[a][q] !== null) item.classList.add('answered');
                if (a === curArea && q === curQ) item.classList.add('current');
                item.onclick = (e) => { 
                    e.stopPropagation(); 
                    curArea = a; curQ = q; 
                    closeAll(); render(); 
                };
                drop.appendChild(item);
            });
        });
    }

    function updateAll() {
        let count = 0, total = 0;
        results.forEach(a => { total += a.length; a.forEach(q => { if(q !== null) count++; })});
        let prog = Math.round((count/total) * 100);
        document.getElementById('prog-fill').style.width = prog + '%';
        document.getElementById('prog-txt').innerText = prog + '%';
        document.getElementById('modal-prog').innerText = prog + '%';
        render();
    }

    function move(step) {
        curQ += step;
        if (curQ >= EXAM_DATA[curArea].preguntas.length) {
            if (curArea < EXAM_DATA.length - 1) { curArea++; curQ = 0; } 
            else curQ = EXAM_DATA[curArea].preguntas.length - 1;
        } else if (curQ < 0) {
            if (curArea > 0) { curArea--; curQ = EXAM_DATA[curArea].preguntas.length - 1; }
            else curQ = 0;
        }
        render();
    }

    function toggleDropdown(i) { 
        const d = document.getElementById(`drop-${i}`); 
        const isVisible = d.style.display === 'grid';
        closeAll(); 
        if(!isVisible) d.style.display = 'grid'; 
    }

    function closeAll() { document.querySelectorAll('.q-dropdown').forEach(d => d.style.display = 'none'); }
    function openModal() { document.getElementById('finishModal').style.display = 'flex'; }
    function closeModal() { document.getElementById('finishModal').style.display = 'none'; }

    // --- FUNCIÓN PARA PROCESAR EL FINAL CON EL OVERLAY ---
    function processFinish() {
        // Cierra el modal de confirmación
        closeModal();
        
        // Muestra el Overlay de carga a pantalla completa
        document.getElementById('loadingOverlay').style.display = 'flex';
        
        clearInterval(timerInterval);
        
        const data = {
            id_examen: EXAM_ID,
            respuestas: results,
            tiempo_restante: timeLeft
        };

        fetch("{{ route('examen.finalizar') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify(data)
        })
        .then(res => res.json())
        .then(res => {
            if(res.success) {
                // Pequeña espera de 0.5s para que se vea la animación si la respuesta es muy rápida
                setTimeout(() => {
                    window.location.href = res.redirect_url;
                }, 500);
            } else {
                document.getElementById('loadingOverlay').style.display = 'none';
                alert("Error al guardar el examen.");
            }
        })
        .catch(err => {
            console.error("Error:", err);
            document.getElementById('loadingOverlay').style.display = 'none';
            alert("Ocurrió un error inesperado.");
        });
    }

    startTimer();
    render();
</script>
</body>
</html>