@extends('layouts.admin')
@section('title', 'Integraciones')
@section('page-title', 'Integraciones externas')

@section('content')
<div class="max-w-2xl">
    <form method="POST" action="{{ route('admin.settings.integrations.update') }}" class="space-y-6">
        @csrf

        {{-- hCaptcha --}}
        <div class="card space-y-4">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: var(--color-brand-muted);">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--color-primary);"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                </div>
                <h2 class="font-semibold" style="color: var(--color-brand-dark);">hCaptcha</h2>
            </div>
            <p class="text-sm text-gray-400">
                Protege tus formularios públicos contra spam y bots. Necesitás una cuenta gratuita en
                <a href="https://dashboard.hcaptcha.com/signup" target="_blank" rel="noopener" class="font-medium" style="color: var(--color-primary);">hcaptcha.com</a> —
                creá un sitio ahí, agregá tu dominio (y <code>localhost</code> para pruebas), y copiá la Site Key y la Secret Key acá abajo.
            </p>
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="hcaptcha_enabled" value="1" {{ ($settings['hcaptcha_enabled']->value ?? '0') === '1' ? 'checked' : '' }}
                       class="w-4 h-4" style="accent-color: var(--color-primary);">
                <span class="text-sm font-medium" style="color: var(--color-brand-dark);">Activar hCaptcha</span>
            </label>
            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Site Key</label>
                <input id="hcaptcha_site_key" type="text" name="hcaptcha_site_key" value="{{ old('hcaptcha_site_key', $settings['hcaptcha_site_key']->value ?? '') }}" class="input-field font-mono text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Secret Key</label>
                <input id="hcaptcha_secret_key" type="text" name="hcaptcha_secret_key" value="{{ old('hcaptcha_secret_key', $settings['hcaptcha_secret_key']->value ?? '') }}" class="input-field font-mono text-sm">
            </div>

            <div class="p-4 rounded-xl" style="background:var(--color-brand-muted);">
                <p class="text-xs text-gray-500 mb-3">
                    Para probar la integración de verdad hay que resolver un desafío real: cargá el widget con la Site Key de arriba,
                    resolvé el desafío, y verificá el resultado contra la Secret Key.
                </p>
                <button type="button" id="hcaptcha-load-btn" class="btn-outline text-sm">Cargar widget de prueba</button>

                <div id="hcaptcha-test-widget" class="mt-3"></div>

                <button type="button" id="hcaptcha-verify-btn" class="btn-primary text-sm mt-3" style="display:none;">Verificar</button>
                <p id="hcaptcha-test-result" class="text-sm mt-2 font-medium"></p>
            </div>

            <div class="pt-4 border-t border-gray-100">
                <p class="text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Formularios donde debe aparecer</p>
                <div class="space-y-2">
                    @foreach($hcaptchaForms as $key => $label)
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="hcaptcha_forms[]" value="{{ $key }}"
                               {{ in_array($key, old('hcaptcha_forms', $enabledForms)) ? 'checked' : '' }}
                               class="w-4 h-4" style="accent-color: var(--color-primary);">
                        <span class="text-sm" style="color: var(--color-brand-dark);">{{ $label }}</span>
                    </label>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Google Analytics --}}
        <div class="card space-y-4">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: var(--color-brand-muted);">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--color-primary);"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                </div>
                <h2 class="font-semibold" style="color: var(--color-brand-dark);">Google Analytics 4</h2>
            </div>
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="ga_enabled" value="1" {{ ($settings['ga_enabled']->value ?? '0') === '1' ? 'checked' : '' }}
                       class="w-4 h-4" style="accent-color: var(--color-primary);">
                <span class="text-sm font-medium" style="color: var(--color-brand-dark);">Activar Google Analytics</span>
            </label>
            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Measurement ID (G-XXXXXXXXXX)</label>
                <input type="text" name="ga_measurement_id" value="{{ old('ga_measurement_id', $settings['ga_measurement_id']->value ?? '') }}" class="input-field font-mono text-sm" placeholder="G-XXXXXXXXXX">
            </div>
        </div>

        {{-- Meta Pixel --}}
        <div class="card space-y-4">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: var(--color-brand-muted);">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--color-primary);"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
                </div>
                <h2 class="font-semibold" style="color: var(--color-brand-dark);">Meta Pixel (Facebook)</h2>
            </div>
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="pixel_enabled" value="1" {{ ($settings['pixel_enabled']->value ?? '0') === '1' ? 'checked' : '' }}
                       class="w-4 h-4" style="accent-color: var(--color-primary);">
                <span class="text-sm font-medium" style="color: var(--color-brand-dark);">Activar Meta Pixel</span>
            </label>
            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Pixel ID</label>
                <input type="text" name="pixel_id" value="{{ old('pixel_id', $settings['pixel_id']->value ?? '') }}" class="input-field font-mono text-sm" placeholder="1234567890">
            </div>
        </div>

        {{-- TinyMCE (editor de texto enriquecido) --}}
        <div class="card space-y-4">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: var(--color-brand-muted);">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--color-primary);"><path d="M4 7V4h16v3M9 20h6M12 4v16"/></svg>
                </div>
                <h2 class="font-semibold" style="color: var(--color-brand-dark);">TinyMCE (editor de texto enriquecido)</h2>
            </div>
            <p class="text-sm text-gray-400">
                Se usa en las descripciones, respuestas de preguntas frecuentes y contenido de las páginas legales.
                Necesitás una API key gratuita de
                <a href="https://www.tiny.cloud/auth/signup/" target="_blank" rel="noopener" class="font-medium" style="color: var(--color-primary);">tiny.cloud</a>.
            </p>
            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">API Key</label>
                <input type="text" id="tinymce_api_key" name="tinymce_api_key" value="{{ old('tinymce_api_key', $settings['tinymce_api_key']->value ?? '') }}" class="input-field font-mono text-sm" placeholder="ej: abc123def456...">
            </div>
            <div class="p-3 rounded-xl text-sm bg-amber-50 text-amber-700 border border-amber-200">
                Pasos: 1) creá una cuenta gratuita en tiny.cloud → 2) copiá tu API key desde el dashboard → 3) agregá el dominio de este sitio (y <code>localhost</code> para pruebas) en la sección "Approved Domains" de tu cuenta → 4) pegá la key acá y guardá.
                Sin key configurada, el editor funciona igual pero muestra un aviso de "modo de evaluación".
            </div>

            <div class="p-4 rounded-xl" style="background:var(--color-brand-muted);">
                <p class="text-xs text-gray-500 mb-3">
                    Carga el editor de verdad con la key de arriba (aunque todavía no la hayas guardado) y revisa si TinyMCE
                    muestra el aviso de "dominio no registrado" — la única forma real de confirmar que el dominio quedó bien aprobado en tu cuenta.
                </p>
                <button type="button" id="tinymce-test-btn" class="btn-outline text-sm">Probar editor con esta key</button>
                <div id="tinymce-test-preview" class="mt-3"></div>
                <p id="tinymce-test-result" class="text-sm mt-2 font-medium"></p>
            </div>
        </div>

        {{-- Sentry (monitoreo de errores) --}}
        <div class="card space-y-4">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: var(--color-brand-muted);">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--color-primary);"><path d="M12 9v4M12 17h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
                </div>
                <h2 class="font-semibold" style="color: var(--color-brand-dark);">Sentry (monitoreo de errores)</h2>
            </div>
            <p class="text-sm text-gray-400">
                Te avisa apenas algo se rompe en el sitio en producción, en vez de enterarte cuando un usuario se queja.
                Creá una cuenta gratuita en <a href="https://sentry.io/signup/" target="_blank" rel="noopener" class="font-medium" style="color: var(--color-primary);">sentry.io</a>,
                armá un proyecto de tipo "Laravel", y copiá el DSN que te da (Settings → Client Keys / DSN).
            </p>
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="sentry_enabled" value="1" {{ ($settings['sentry_enabled']->value ?? '0') === '1' ? 'checked' : '' }}
                       class="w-4 h-4" style="accent-color: var(--color-primary);">
                <span class="text-sm font-medium" style="color: var(--color-brand-dark);">Activar Sentry</span>
            </label>
            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">DSN</label>
                <input id="sentry_dsn" type="text" name="sentry_dsn" value="{{ old('sentry_dsn', $settings['sentry_dsn']->value ?? '') }}"
                       class="input-field font-mono text-sm" placeholder="https://xxxxx@xxxxx.ingest.sentry.io/xxxxx">
            </div>
            <div class="p-4 rounded-xl" style="background:var(--color-brand-muted);">
                <p class="text-xs text-gray-500 mb-3">Manda un evento real a Sentry con el DSN de arriba (aunque todavía no lo hayas guardado) y confirma que se entregó.</p>
                <button type="button" id="sentry-test-btn" class="btn-outline text-sm">Enviar evento de prueba</button>
                <p id="sentry-test-result" class="text-sm mt-2 font-medium"></p>
            </div>
        </div>

        {{-- UptimeRobot (monitoreo de disponibilidad) --}}
        <div class="card space-y-4">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: var(--color-brand-muted);">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--color-primary);"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <h2 class="font-semibold" style="color: var(--color-brand-dark);">UptimeRobot (¿el sitio está caído?)</h2>
            </div>
            <p class="text-sm text-gray-400">
                Chequea el sitio cada 5 minutos desde afuera y te avisa por email si deja de responder.
                Creá una cuenta gratuita en <a href="https://uptimerobot.com/signUp" target="_blank" rel="noopener" class="font-medium" style="color: var(--color-primary);">uptimerobot.com</a>
                y copiá tu API key (Main API Key) desde "My Settings" → "API Settings".
            </p>
            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">API Key</label>
                <input id="uptimerobot_api_key" type="text" name="uptimerobot_api_key" value="{{ old('uptimerobot_api_key', $settings['uptimerobot_api_key']->value ?? '') }}"
                       class="input-field font-mono text-sm">
            </div>

            @if($uptimeSettings['monitor_id'])
            <div class="p-4 rounded-xl" style="background:var(--color-brand-muted);">
                <p class="text-sm" style="color: var(--color-brand-dark);">Ya tenés un monitor activo para este sitio (ID: {{ $uptimeSettings['monitor_id'] }}).</p>
                <button type="button" id="uptimerobot-status-btn" class="btn-outline text-sm mt-2">Ver estado actual</button>
                <p id="uptimerobot-status-result" class="text-sm mt-2 font-medium"></p>
            </div>
            @else
            <div class="p-4 rounded-xl" style="background:var(--color-brand-muted);">
                <p class="text-xs text-gray-500 mb-3">Probá la API key primero, y después creá el monitor apuntado a este sitio (<code>{{ config('app.url') }}</code>) con un solo clic.</p>
                <div class="flex flex-wrap gap-2">
                    <button type="button" id="uptimerobot-test-btn" class="btn-outline text-sm">Probar API key</button>
                    <button type="button" id="uptimerobot-create-btn" class="btn-primary text-sm">Crear monitor para este sitio</button>
                </div>
                <p id="uptimerobot-test-result" class="text-sm mt-2 font-medium"></p>
            </div>
            @endif
        </div>

        {{-- Scripts personalizados --}}
        <div class="card space-y-4">
            <h2 class="font-semibold" style="color: var(--color-brand-dark);">Scripts personalizados</h2>
            <div class="p-3 rounded-xl text-sm bg-amber-50 text-amber-700 border border-amber-200">
                ⚠️ Usa esta opción con responsabilidad. Scripts mal configurados pueden afectar la seguridad y el rendimiento del sitio.
            </div>
            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Scripts en &lt;head&gt;</label>
                <textarea name="custom_head_scripts" rows="5" class="input-field font-mono text-xs">{{ old('custom_head_scripts', $settings['custom_head_scripts']->value ?? '') }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Scripts antes de &lt;/body&gt;</label>
                <textarea name="custom_body_scripts" rows="5" class="input-field font-mono text-xs">{{ old('custom_body_scripts', $settings['custom_body_scripts']->value ?? '') }}</textarea>
            </div>
        </div>

        <button type="submit" class="btn-primary">Guardar integraciones</button>
    </form>
</div>

@push('scripts')
<script>
(function () {
    const loadBtn   = document.getElementById('hcaptcha-load-btn');
    const verifyBtn = document.getElementById('hcaptcha-verify-btn');
    const widgetBox = document.getElementById('hcaptcha-test-widget');
    const result    = document.getElementById('hcaptcha-test-result');
    let widgetId = null;

    function setResult(text, ok) {
        result.textContent = text;
        result.style.color = ok === null ? '#b45309' : (ok ? '#047857' : '#b91c1c');
    }

    loadBtn.addEventListener('click', function () {
        const siteKey = document.getElementById('hcaptcha_site_key').value.trim();
        if (!siteKey) {
            setResult('Ingresá la Site Key primero.', null);
            return;
        }

        setResult('', null);
        widgetBox.innerHTML = '';
        verifyBtn.style.display = 'none';
        widgetId = null;

        function render() {
            widgetId = window.hcaptcha.render(widgetBox, {
                sitekey: siteKey,
                callback: function () { verifyBtn.style.display = 'inline-flex'; },
            });
        }

        if (window.hcaptcha) {
            render();
            return;
        }

        window.__onHcaptchaAdminLoad = render;
        const script = document.createElement('script');
        script.src = 'https://js.hcaptcha.com/1/api.js?onload=__onHcaptchaAdminLoad&render=explicit';
        script.async = true;
        script.defer = true;
        document.head.appendChild(script);
    });

    verifyBtn.addEventListener('click', async function () {
        const secretKey = document.getElementById('hcaptcha_secret_key').value.trim();
        const token = window.hcaptcha && widgetId !== null ? window.hcaptcha.getResponse(widgetId) : '';

        if (!secretKey) {
            setResult('Ingresá la Secret Key primero.', null);
            return;
        }
        if (!token) {
            setResult('Resolvé el desafío del widget primero.', null);
            return;
        }

        verifyBtn.disabled = true;
        const original = verifyBtn.textContent;
        verifyBtn.textContent = 'Verificando...';

        try {
            const res = await fetch(@json(route('admin.settings.integrations.hcaptcha.test')), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                        || document.querySelector('input[name=_token]').value,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ secret_key: secretKey, token: token }),
            });
            const data = await res.json();
            setResult(data.message, data.ok);
            if (window.hcaptcha && widgetId !== null) window.hcaptcha.reset(widgetId);
            verifyBtn.style.display = 'none';
        } catch (e) {
            setResult('Error al verificar. Revisá la conexión.', false);
        } finally {
            verifyBtn.disabled = false;
            verifyBtn.textContent = original;
        }
    });
})();

function csrfHeaders() {
    return {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
            || document.querySelector('input[name=_token]').value,
        'Accept': 'application/json',
    };
}

// --- TinyMCE ---
document.getElementById('tinymce-test-btn').addEventListener('click', function () {
    const btn = this;
    const result = document.getElementById('tinymce-test-result');
    const preview = document.getElementById('tinymce-test-preview');
    const apiKey = document.getElementById('tinymce_api_key').value.trim() || 'no-api-key';

    btn.disabled = true;
    result.textContent = '';
    result.style.color = '#6b7280';
    preview.innerHTML = '<textarea id="tinymce-probe"></textarea>';

    // Si ya hay un tinymce cargado (con otra key, desde el layout), lo sacamos para
    // forzar que se pida el script de nuevo con la key que se está probando acá.
    if (window.tinymce) {
        window.tinymce.remove('#tinymce-probe');
    }
    document.querySelectorAll('script[src*="cdn.tiny.cloud"]').forEach(s => s.remove());
    delete window.tinymce;

    const script = document.createElement('script');
    script.src = 'https://cdn.tiny.cloud/1/' + encodeURIComponent(apiKey) + '/tinymce/6/tinymce.min.js';
    script.referrerPolicy = 'origin';
    script.onerror = function () {
        btn.disabled = false;
        result.textContent = 'No se pudo cargar el script de TinyMCE. Revisá la key o la conexión.';
        result.style.color = '#b91c1c';
    };
    script.onload = function () {
        if (!window.tinymce) {
            btn.disabled = false;
            result.textContent = 'El script cargó pero TinyMCE no quedó disponible. Puede que la key tenga un formato inválido.';
            result.style.color = '#b91c1c';
            return;
        }

        window.tinymce.init({
            selector: '#tinymce-probe',
            height: 150,
            menubar: false,
            branding: false,
            plugins: 'lists link autolink',
            toolbar: 'bold italic | link',
            setup: function (editor) {
                editor.on('init', function () {
                    // Le damos ~2.5s: si la key o el dominio no está aprobado, TinyMCE
                    // deshabilita el editor (clase .tox-tinymce--disabled) y muestra un
                    // aviso aparte en el body. La clase es más confiable de detectar que
                    // buscar el aviso, que se renderiza fuera de este contenedor.
                    setTimeout(function () {
                        const disabled = preview.querySelector('.tox-tinymce--disabled');
                        btn.disabled = false;
                        if (disabled) {
                            result.textContent = 'TinyMCE deshabilitó el editor con esta key — el dominio no está aprobado o la key es inválida. Revisá "Approved Domains" en tu cuenta de tiny.cloud.';
                            result.style.color = '#b91c1c';
                        } else {
                            result.textContent = '✓ El editor cargó sin avisos — la key y el dominio están aprobados.';
                            result.style.color = '#047857';
                        }
                    }, 2500);
                });
            },
        });
    };
    document.head.appendChild(script);
});

// --- Sentry ---
document.getElementById('sentry-test-btn').addEventListener('click', async function () {
    const btn = this;
    const result = document.getElementById('sentry-test-result');
    const dsn = document.getElementById('sentry_dsn').value.trim();

    if (!dsn) {
        result.textContent = 'Ingresá el DSN primero.';
        result.style.color = '#b45309';
        return;
    }

    btn.disabled = true;
    const original = btn.textContent;
    btn.textContent = 'Enviando...';
    result.textContent = '';

    try {
        const res = await fetch(@json(route('admin.settings.integrations.sentry.test')), {
            method: 'POST', headers: csrfHeaders(), body: JSON.stringify({ dsn }),
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

// --- UptimeRobot ---
const uptimeTestBtn = document.getElementById('uptimerobot-test-btn');
if (uptimeTestBtn) {
    uptimeTestBtn.addEventListener('click', async function () {
        const btn = this;
        const result = document.getElementById('uptimerobot-test-result');
        const apiKey = document.getElementById('uptimerobot_api_key').value.trim();

        if (!apiKey) {
            result.textContent = 'Ingresá la API key primero.';
            result.style.color = '#b45309';
            return;
        }

        btn.disabled = true;
        result.textContent = 'Probando...';
        result.style.color = '#6b7280';

        try {
            const res = await fetch(@json(route('admin.settings.integrations.uptimerobot.test')), {
                method: 'POST', headers: csrfHeaders(), body: JSON.stringify({ api_key: apiKey }),
            });
            const data = await res.json();
            result.textContent = data.message;
            result.style.color = data.ok ? '#047857' : '#b91c1c';
        } catch (e) {
            result.textContent = 'Error al probar la conexión.';
            result.style.color = '#b91c1c';
        } finally {
            btn.disabled = false;
        }
    });
}

const uptimeCreateBtn = document.getElementById('uptimerobot-create-btn');
if (uptimeCreateBtn) {
    uptimeCreateBtn.addEventListener('click', async function () {
        const btn = this;
        const result = document.getElementById('uptimerobot-test-result');
        const apiKey = document.getElementById('uptimerobot_api_key').value.trim();

        if (!apiKey) {
            result.textContent = 'Ingresá la API key primero.';
            result.style.color = '#b45309';
            return;
        }

        btn.disabled = true;
        result.textContent = 'Creando monitor...';
        result.style.color = '#6b7280';

        try {
            const res = await fetch(@json(route('admin.settings.integrations.uptimerobot.create')), {
                method: 'POST', headers: csrfHeaders(), body: JSON.stringify({ api_key: apiKey }),
            });
            const data = await res.json();
            result.textContent = data.message;
            result.style.color = data.ok ? '#047857' : '#b91c1c';
            if (data.ok) {
                setTimeout(() => window.location.reload(), 1500);
            }
        } catch (e) {
            result.textContent = 'Error al crear el monitor.';
            result.style.color = '#b91c1c';
        } finally {
            btn.disabled = false;
        }
    });
}

const uptimeStatusBtn = document.getElementById('uptimerobot-status-btn');
if (uptimeStatusBtn) {
    uptimeStatusBtn.addEventListener('click', async function () {
        const btn = this;
        const result = document.getElementById('uptimerobot-status-result');
        btn.disabled = true;
        result.textContent = 'Consultando...';
        result.style.color = '#6b7280';

        try {
            const res = await fetch(@json(route('admin.settings.integrations.uptimerobot.status')), {
                headers: { 'Accept': 'application/json' },
            });
            const data = await res.json();
            result.textContent = data.message;
            result.style.color = data.ok ? '#047857' : '#b91c1c';
        } catch (e) {
            result.textContent = 'Error al consultar el estado.';
            result.style.color = '#b91c1c';
        } finally {
            btn.disabled = false;
        }
    });
}
</script>
@endpush
@endsection
