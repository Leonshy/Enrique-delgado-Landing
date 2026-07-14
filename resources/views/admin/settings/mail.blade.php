@extends('layouts.admin')
@section('title', 'Email')
@section('page-title', 'Configuración de Email (SMTP)')

@section('content')
<div class="max-w-2xl">
    <p class="text-sm text-gray-400 mb-6">
        Datos del servidor SMTP que usa el sitio para mandar los emails de las consultas del formulario de contacto.
        @if($isConfigured)
            Ahora mismo está usando esta configuración en vez de la del archivo <code>.env</code>.
        @else
            Todavía no está cargada — el sitio sigue usando la configuración del archivo <code>.env</code> del servidor.
        @endif
    </p>

    <form method="POST" action="{{ route('admin.settings.mail.update') }}" class="space-y-6">
        @csrf

        <div class="card space-y-5">
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Servidor SMTP (host)</label>
                    <input type="text" id="mail_host" name="mail_host" value="{{ old('mail_host', $settings['host']) }}"
                           class="input-field" placeholder="mail.enriquedelgado.com" required>
                    @error('mail_host')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Puerto</label>
                    <input type="number" id="mail_port" name="mail_port" value="{{ old('mail_port', $settings['port']) }}"
                           class="input-field" placeholder="465" required>
                    @error('mail_port')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Seguridad</label>
                <select id="mail_encryption" name="mail_encryption" class="input-field">
                    @foreach($encryptionOptions as $key => $opt)
                    <option value="{{ $key }}" data-port="{{ $opt['default_port'] }}"
                            {{ old('mail_encryption', $settings['encryption']) === $key ? 'selected' : '' }}>
                        {{ $opt['label'] }}
                    </option>
                    @endforeach
                </select>
                <p class="text-xs text-gray-400 mt-1">SSL/TLS (puerto 465) es lo más común y lo más seguro. Usá STARTTLS solo si tu proveedor de correo lo pide explícitamente.</p>
                @error('mail_encryption')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Usuario</label>
                    <input type="text" id="mail_username" name="mail_username" value="{{ old('mail_username', $settings['username']) }}"
                           class="input-field" placeholder="contacto@enriquedelgado.com" required>
                    @error('mail_username')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Contraseña</label>
                    <input type="password" id="mail_password" name="mail_password" autocomplete="new-password"
                           class="input-field" placeholder="{{ $settings['password'] ? '••••••••  (dejar vacío para no cambiarla)' : '' }}">
                    @error('mail_password')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Email remitente</label>
                    <input type="email" id="mail_from_address" name="mail_from_address" value="{{ old('mail_from_address', $settings['from_address']) }}"
                           class="input-field" placeholder="contacto@enriquedelgado.com" required>
                    @error('mail_from_address')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Nombre remitente</label>
                    <input type="text" id="mail_from_name" name="mail_from_name" value="{{ old('mail_from_name', $settings['from_name']) }}"
                           class="input-field" placeholder="Enrique Delgado">
                </div>
            </div>
        </div>

        {{-- Prueba de conexión --}}
        <div class="card space-y-3">
            <p class="text-sm font-medium" style="color: var(--color-brand-dark);">Probar esta configuración</p>
            <p class="text-xs text-gray-400">
                Manda un email real de prueba con los datos de arriba (aunque todavía no los hayas guardado), así confirmás que la conexión y las credenciales funcionan antes de dejarlo en producción.
            </p>
            <div class="flex flex-wrap items-end gap-3">
                <div class="flex-1 min-w-[220px]">
                    <label class="block text-xs font-medium mb-1 text-gray-500">Mandar la prueba a</label>
                    <input type="email" id="mail_test_to" class="input-field text-sm" placeholder="tu-email@ejemplo.com">
                </div>
                <button type="button" id="mail-test-btn" class="btn-outline text-sm">Enviar email de prueba</button>
            </div>
            <p id="mail-test-result" class="text-sm font-medium"></p>
        </div>

        <button type="submit" class="btn-primary">Guardar configuración de email</button>
    </form>
</div>

@push('scripts')
<script>
document.getElementById('mail_encryption').addEventListener('change', function () {
    const opt = this.options[this.selectedIndex];
    const portField = document.getElementById('mail_port');
    // Solo sugiere el puerto típico si el campo está vacío o todavía tiene el valor por defecto anterior.
    if (!portField.value) portField.value = opt.dataset.port;
});

document.getElementById('mail-test-btn').addEventListener('click', async function () {
    const btn = this;
    const result = document.getElementById('mail-test-result');
    const to = document.getElementById('mail_test_to').value.trim();

    const payload = {
        mail_host: document.getElementById('mail_host').value.trim(),
        mail_port: document.getElementById('mail_port').value.trim(),
        mail_encryption: document.getElementById('mail_encryption').value,
        mail_username: document.getElementById('mail_username').value.trim(),
        mail_password: document.getElementById('mail_password').value,
        mail_from_address: document.getElementById('mail_from_address').value.trim(),
        to: to,
    };

    if (!payload.mail_host || !payload.mail_username || !payload.mail_from_address) {
        result.textContent = 'Completá al menos servidor, usuario y email remitente.';
        result.style.color = '#b45309';
        return;
    }
    if (!to) {
        result.textContent = 'Ingresá un email de destino para la prueba.';
        result.style.color = '#b45309';
        return;
    }

    btn.disabled = true;
    const original = btn.textContent;
    btn.textContent = 'Enviando...';
    result.textContent = '';

    try {
        const res = await fetch(@json(route('admin.settings.mail.test')), {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                    || document.querySelector('input[name=_token]').value,
                'Accept': 'application/json',
            },
            body: JSON.stringify(payload),
        });
        const data = await res.json();
        result.textContent = data.message;
        result.style.color = data.ok ? '#047857' : '#b91c1c';
    } catch (e) {
        result.textContent = 'Error al probar la conexión.';
        result.style.color = '#b91c1c';
    } finally {
        btn.disabled = false;
        btn.textContent = original;
    }
});
</script>
@endpush
@endsection
