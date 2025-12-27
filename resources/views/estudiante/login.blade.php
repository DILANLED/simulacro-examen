<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Acceso - Simulacro Master</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-dark: #0f172a;
            --bg-card: #1e293b;
            --accent-celeste: #38bdf8;
            --text-main: #f1f5f9;
            --text-dim: #94a3b8;
            --verde-whatsapp: #25d366;
            --plomo-input: #334155;
        }

        body {
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-dark);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: radial-gradient(circle at top right, #1e293b, #0f172a);
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            background: rgba(30, 41, 59, 0.8);
            backdrop-filter: blur(15px);
            border-radius: 28px;
            padding: 40px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
            text-align: center;
        }

        .logo-area {
            font-size: 2rem;
            font-weight: 800;
            color: var(--accent-celeste);
            margin-bottom: 5px;
        }

        .subtitle {
            color: var(--text-dim);
            font-size: 0.9rem;
            margin-bottom: 30px;
        }

        /* FORMULARIO */
        .form-group { text-align: left; margin-bottom: 20px; }
        label { display: block; font-size: 0.75rem; font-weight: 700; margin-bottom: 8px; color: var(--accent-celeste); text-transform: uppercase; }
        
        input {
            width: 100%; padding: 14px 18px; border-radius: 14px;
            background: var(--plomo-input); border: 1px solid rgba(255, 255, 255, 0.05);
            color: white; font-size: 1rem; box-sizing: border-box; transition: 0.3s;
        }

        input:focus { outline: none; border-color: var(--accent-celeste); background: #3d4a5e; }

        .btn-login {
            width: 100%; padding: 16px; border-radius: 14px; border: none;
            background: var(--accent-celeste); color: var(--bg-dark);
            font-weight: 800; font-size: 1rem; cursor: pointer; transition: 0.3s;
        }

        /* SECCIÓN DE CONTACTO / PROVEEDOR */
        .provider-section {
            margin-top: 35px;
            padding-top: 25px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .provider-title {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 15px;
        }

        .qr-placeholder {
            width: 150px;
            height: 150px;
            background: white;
            margin: 0 auto 15px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px;
            box-sizing: border-box;
        }

        .qr-placeholder img {
            width: 100%;
            height: auto;
        }

        .contact-info {
            background: rgba(37, 211, 102, 0.1);
            border: 1px solid var(--verde-whatsapp);
            color: var(--verde-whatsapp);
            padding: 12px;
            border-radius: 12px;
            font-weight: 700;
            display: inline-block;
            text-decoration: none;
            font-size: 0.9rem;
            transition: 0.3s;
        }

        .contact-info:hover {
            background: var(--verde-whatsapp);
            color: white;
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="logo-area">Acceso Master</div>
    <p class="subtitle">Ingresa para realizar tus simulacros.</p>

    <form onsubmit="event.preventDefault(); window.location.href='historial.html';">
        <div class="form-group">
            <label>Nombre de Usuario</label>
            <input type="text" placeholder="Ej: JuanPerez2024" required>
        </div>

        <div class="form-group">
            <label>Contraseña</label>
            <input type="password" placeholder="••••••••" required>
        </div>

        <button type="submit" class="btn-login">Iniciar Sesión</button>
    </form>

    <div class="provider-section">
        <div class="provider-title">¿NO TIENES CUENTA? ADQUIÉRELA AQUÍ:</div>
        
        <div class="qr-placeholder">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=https://wa.me/591XXXXXXXX" alt="QR WhatsApp">
        </div>

        <a href="https://wa.me/591XXXXXXXX" class="contact-info">
            📱 WhatsApp Proveedor: +591 XXXXXXXX
        </a>
        <p style="font-size: 0.7rem; color: var(--text-dim); margin-top: 10px;">
            Escanea el QR o haz clic en el botón para contactar al soporte técnico.
        </p>
    </div>
</div>

</body>
</html>