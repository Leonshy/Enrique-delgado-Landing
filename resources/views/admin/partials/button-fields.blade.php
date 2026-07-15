{{--
    Bloque reusable: ícono + tipo de acción (URL / Correo / WhatsApp) + campos condicionales.
    Params:
    - $uid:    string único para esta instancia (ids de los paneles a togglear).
    - $fields: mapa nombre lógico => nombre real del input, ej.
               ['icon'=>'btn1_icon','action_type'=>'btn1_action_type','url'=>'btn1_url',
                'url_target'=>'btn1_url_target','email_to'=>'btn1_email_to',
                'email_subject'=>'btn1_email_subject','email_body'=>'btn1_email_body',
                'whatsapp_message'=>'btn1_whatsapp_message']
    - $cfg:    valores actuales, claves lógicas (icon, action_type, url, url_target,
               email_to, email_subject, email_body, whatsapp_message).
    - $lockIconOnWhatsapp: (default true) si es false, el ícono queda libre aunque el
               tipo de acción sea WhatsApp (excepción usada en Planes).
--}}
@php
    $currentIcon = old($fields['icon'], $cfg['icon'] ?? 'none');
    $currentType = old($fields['action_type'], $cfg['action_type'] ?? 'url');
    $lockIcon    = $lockIconOnWhatsapp ?? true;
    $iconLocked  = $lockIcon && $currentType === 'whatsapp';
@endphp

<div id="icon-wrap-{{ $uid }}" style="{{ $iconLocked ? 'opacity:.45;pointer-events:none;' : '' }}">
    <label class="block text-xs font-medium mb-2 text-gray-500">Ícono</label>
    @if($lockIcon)
    <p class="text-xs text-gray-400 mb-2" style="{{ $iconLocked ? '' : 'display:none;' }}" data-icon-locked-note="{{ $uid }}">
        El botón de WhatsApp siempre usa su propio ícono — no se puede cambiar.
    </p>
    @endif
    <div class="grid grid-cols-5 sm:grid-cols-9 gap-2">
        @foreach(\App\Helpers\IconHelper::options() as $key => $ico)
        <label class="flex flex-col items-center gap-1 cursor-pointer p-2 rounded-lg border-2 transition-colors text-center icon-option {{ $currentIcon === $key ? 'is-selected' : '' }}"
               style="font-size:0.6rem;color:#666;">
            <input type="radio" name="{{ $fields['icon'] }}" value="{{ $key }}"
                   {{ $currentIcon === $key ? 'checked' : '' }}
                   {{ $iconLocked && $key !== 'whatsapp' ? 'disabled' : '' }}
                   class="sr-only"
                   onchange="this.closest('.grid').querySelectorAll('label').forEach(l=>l.classList.remove('is-selected'));this.closest('label').classList.add('is-selected')">
            @if($key === 'none')
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="9"/><line x1="5" y1="19" x2="19" y2="5"/></svg>
            @else
            {!! \App\Helpers\IconHelper::render($key, 18) !!}
            @endif
            {{ $ico['label'] }}
        </label>
        @endforeach
    </div>
</div>

<div>
    <label class="block text-xs font-medium mb-2 text-gray-500">Tipo de acción</label>
    <div class="flex gap-4">
        @foreach(['url' => 'URL', 'email' => 'Correo', 'whatsapp' => 'WhatsApp'] as $type => $typeLabel)
        <label class="flex items-center gap-1.5 text-sm cursor-pointer">
            <input type="radio" name="{{ $fields['action_type'] }}" value="{{ $type }}"
                   {{ $currentType === $type ? 'checked' : '' }}
                   style="accent-color: var(--color-primary);"
                   onchange="
                        document.querySelectorAll('[data-action-panel=&quot;{{ $uid }}&quot;]').forEach(p => p.style.display = 'none');
                        document.getElementById('action-panel-{{ $uid }}-' + this.value).style.display = 'block';

                        @if($lockIcon)
                        var iconWrap = document.getElementById('icon-wrap-{{ $uid }}');
                        var note = document.querySelector('[data-icon-locked-note=&quot;{{ $uid }}&quot;]');
                        var isWa = this.value === 'whatsapp';
                        iconWrap.style.opacity = isWa ? '.45' : '';
                        iconWrap.style.pointerEvents = isWa ? 'none' : '';
                        note.style.display = isWa ? '' : 'none';
                        iconWrap.querySelectorAll('input[type=radio]').forEach(function (r) {
                            r.disabled = isWa && r.value !== 'whatsapp';
                            if (isWa && r.value === 'whatsapp') {
                                r.checked = true;
                                r.closest('label').classList.add('is-selected');
                            } else if (isWa) {
                                r.closest('label').classList.remove('is-selected');
                            }
                        });
                        @endif
                   ">
            {{ $typeLabel }}
        </label>
        @endforeach
    </div>
</div>

<div id="action-panel-{{ $uid }}-url" data-action-panel="{{ $uid }}" class="grid grid-cols-2 gap-3" style="display: {{ $currentType === 'url' ? 'block' : 'none' }};">
    <div>
        <label class="block text-xs font-medium mb-1 text-gray-500">
            URL <span class="font-normal text-gray-400">(#ancla, /ruta o https://...)</span>
        </label>
        <input type="text" name="{{ $fields['url'] }}" value="{{ old($fields['url'], $cfg['url'] ?? '') }}" class="input-field text-sm" placeholder="#contacto">
    </div>
    <div>
        <label class="block text-xs font-medium mb-1 text-gray-500">Al hacer clic</label>
        <select name="{{ $fields['url_target'] }}" class="input-field text-sm">
            <option value="_self" {{ old($fields['url_target'], $cfg['url_target'] ?? '_self') === '_self' ? 'selected' : '' }}>Misma pestaña</option>
            <option value="_blank" {{ old($fields['url_target'], $cfg['url_target'] ?? '_self') === '_blank' ? 'selected' : '' }}>Nueva pestaña</option>
        </select>
    </div>
</div>

<div id="action-panel-{{ $uid }}-email" data-action-panel="{{ $uid }}" class="grid grid-cols-2 gap-3" style="display: {{ $currentType === 'email' ? 'block' : 'none' }};">
    <div>
        <label class="block text-xs font-medium mb-1 text-gray-500">Destinatario</label>
        <input type="email" name="{{ $fields['email_to'] }}" value="{{ old($fields['email_to'], $cfg['email_to'] ?? '') }}" class="input-field text-sm" placeholder="contacto@ejemplo.com">
    </div>
    <div>
        <label class="block text-xs font-medium mb-1 text-gray-500">Asunto</label>
        <input type="text" name="{{ $fields['email_subject'] }}" value="{{ old($fields['email_subject'], $cfg['email_subject'] ?? '') }}" class="input-field text-sm">
    </div>
    <div class="col-span-2">
        <label class="block text-xs font-medium mb-1 text-gray-500">Mensaje predeterminado</label>
        <textarea name="{{ $fields['email_body'] }}" rows="2" class="input-field text-sm">{{ old($fields['email_body'], $cfg['email_body'] ?? '') }}</textarea>
    </div>
</div>

<div id="action-panel-{{ $uid }}-whatsapp" data-action-panel="{{ $uid }}" style="display: {{ $currentType === 'whatsapp' ? 'block' : 'none' }};">
    <label class="block text-xs font-medium mb-1 text-gray-500">Mensaje de WhatsApp</label>
    <textarea name="{{ $fields['whatsapp_message'] }}" rows="2" class="input-field text-sm" placeholder="Hola, me interesa...">{{ old($fields['whatsapp_message'], $cfg['whatsapp_message'] ?? '') }}</textarea>
</div>
