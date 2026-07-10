<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sitio en mantenimiento</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #f8f7f4;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1a1a2e;
        }
        .container {
            text-align: center;
            max-width: 480px;
            padding: 2rem;
        }
        .icon {
            width: 72px;
            height: 72px;
            background: #2d6a4f;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
        }
        h1 {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: #1a1a2e;
        }
        p {
            color: #6b7280;
            line-height: 1.6;
            font-size: 1rem;
        }
        .dots {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 2.5rem;
        }
        .dot {
            width: 8px;
            height: 8px;
            background: #2d6a4f;
            border-radius: 50%;
            animation: pulse 1.5s ease-in-out infinite;
        }
        .dot:nth-child(2) { animation-delay: 0.3s; }
        .dot:nth-child(3) { animation-delay: 0.6s; }
        @keyframes pulse {
            0%, 100% { opacity: 0.3; transform: scale(0.8); }
            50% { opacity: 1; transform: scale(1); }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                <path d="M2 17l10 5 10-5"/>
                <path d="M2 12l10 5 10-5"/>
            </svg>
        </div>
        <h1>Sitio en mantenimiento</h1>
        <p>Estamos realizando mejoras en el sitio. Volveremos en breve.</p>
        <div class="dots">
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
        </div>
    </div>
</body>
</html>
