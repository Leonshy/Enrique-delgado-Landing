<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<style>
    body { font-family: Arial, sans-serif; background: #FDF8F2; margin: 0; padding: 20px; }
    .container { max-width: 560px; margin: 0 auto; background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.08); }
    .header { background: linear-gradient(135deg, #C86432, #D68B65); color: white; padding: 32px; text-align: center; }
    .header h1 { margin: 0; font-size: 20px; font-weight: 600; }
    .header p { margin: 8px 0 0; opacity: 0.85; font-size: 14px; }
    .body { padding: 32px; }
    .field { margin-bottom: 20px; }
    .label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #C86432; margin-bottom: 4px; }
    .value { font-size: 15px; color: #3A2115; line-height: 1.6; }
    .message-box { background: #FAEFDA; border-radius: 8px; padding: 16px; }
    .footer { border-top: 1px solid #FAEFDA; padding: 20px 32px; text-align: center; font-size: 12px; color: #888; }
    .badge { display: inline-block; background: #FAEFDA; color: #C86432; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; }
</style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Nueva consulta recibida</h1>
        <p>{{ $contactMessage->created_at->format('d/m/Y H:i') }}</p>
    </div>
    <div class="body">
        <div class="field">
            <div class="label">Nombre</div>
            <div class="value">{{ $contactMessage->name }}</div>
        </div>
        <div class="field">
            <div class="label">Email</div>
            <div class="value"><a href="mailto:{{ $contactMessage->email }}" style="color: #C86432;">{{ $contactMessage->email }}</a></div>
        </div>
        <div class="field">
            <div class="label">Teléfono</div>
            <div class="value">
                <a href="tel:{{ $contactMessage->phone }}" style="color: #C86432;">{{ $contactMessage->phone }}</a>
            </div>
        </div>
        <div class="field">
            <div class="label">Mensaje</div>
            <div class="message-box value">{{ $contactMessage->message }}</div>
        </div>
    </div>
    <div class="footer">
        <p>Este mensaje fue enviado desde el formulario de contacto de <strong>enriquedelgado.com</strong></p>
        <p><a href="{{ route('admin.messages.show', $contactMessage) }}" style="color: #C86432;">Ver en el panel administrativo</a></p>
    </div>
</div>
</body>
</html>
