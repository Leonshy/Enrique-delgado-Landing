@extends('layouts.admin')
@section('title', 'Tipografía')
@section('page-title', 'Tipografía del sitio')

@section('content')
<div class="max-w-3xl">
    <p class="text-sm text-gray-400 mb-6">
        Elegí las fuentes de Google Fonts para títulos y texto general, o subí tu propia tipografía.
        También podés ajustar una escala de tamaño general. Se aplica a todo el sitio público y al panel admin.
    </p>

    @error('font_heading')<p class="text-sm text-red-500 mb-4">{{ $message }}</p>@enderror
    @error('font_body')<p class="text-sm text-red-500 mb-4">{{ $message }}</p>@enderror

    <form method="POST" action="{{ route('admin.settings.typography.update') }}" class="space-y-6">
        @csrf

        <div class="card space-y-5">
            <div>
                <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">Fuente de títulos</label>
                <p class="text-xs text-gray-400 mb-2">Se usa en encabezados y textos destacados.</p>
                <select name="font_heading" id="font_heading" class="input-field">
                    <optgroup label="Serif">
                        @foreach($headingFonts as $key => $font)
                        @continue($font['category'] !== 'serif')
                        <option value="{{ $key }}" data-query="{{ $font['query'] }}" data-category="{{ $font['category'] }}"
                                {{ $selected['headingKey'] === $key ? 'selected' : '' }}>{{ $font['label'] }}</option>
                        @endforeach
                    </optgroup>
                    <optgroup label="Sans / display">
                        @foreach($headingFonts as $key => $font)
                        @continue($font['category'] !== 'sans')
                        <option value="{{ $key }}" data-query="{{ $font['query'] }}" data-category="{{ $font['category'] }}"
                                {{ $selected['headingKey'] === $key ? 'selected' : '' }}>{{ $font['label'] }}</option>
                        @endforeach
                    </optgroup>
                    @if($customHeading)
                    <optgroup label="Personalizada">
                        <option value="custom_heading" data-query="" data-category="custom"
                                {{ $selected['headingKey'] === 'custom_heading' ? 'selected' : '' }}>
                            {{ $customHeading['label'] }} (subida)
                        </option>
                    </optgroup>
                    @endif
                </select>
            </div>

            <div class="pt-5 border-t border-gray-100">
                <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">Fuente de texto</label>
                <p class="text-xs text-gray-400 mb-2">Se usa en párrafos, menú, botones y el resto del contenido.</p>
                <select name="font_body" id="font_body" class="input-field">
                    @foreach($bodyFonts as $key => $font)
                    <option value="{{ $key }}" data-query="{{ $font['query'] }}" data-category="{{ $font['category'] }}"
                            {{ $selected['bodyKey'] === $key ? 'selected' : '' }}>{{ $font['label'] }}</option>
                    @endforeach
                    @if($customBody)
                    <option value="custom_body" data-query="" data-category="custom"
                            {{ $selected['bodyKey'] === 'custom_body' ? 'selected' : '' }}>
                        {{ $customBody['label'] }} (subida)
                    </option>
                    @endif
                </select>
            </div>

            <div class="pt-5 border-t border-gray-100">
                <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">Tamaño general del texto</label>
                <p class="text-xs text-gray-400 mb-2">Escala proporcionalmente todos los tamaños de texto (y espaciados) del sitio.</p>
                <select name="font_scale" id="font_scale" class="input-field">
                    @foreach($sizeScales as $value => $label)
                    <option value="{{ $value }}" {{ (string) $selected['scale'] === (string) $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Vista previa en vivo --}}
        <div class="card">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-3">Vista previa</p>
            <div id="font-preview" class="rounded-xl p-6" style="background:var(--color-brand-muted);">
                <h2 id="preview-heading" style="font-size:1.75rem;font-weight:600;color:var(--color-brand-dark);margin-bottom:.5rem;">
                    El Psicólogo del Cambio
                </h2>
                <p id="preview-body" style="font-size:1rem;line-height:1.6;color:var(--color-brand-dark);">
                    Los cambios que transforman nuestra calidad de vida comienzan con una meta clara y se construyen mediante acciones concretas.
                </p>
            </div>
        </div>

        <button type="submit" class="btn-primary">Guardar tipografía</button>
    </form>

    <form method="POST" action="{{ route('admin.settings.typography.reset') }}"
          onsubmit="return confirm('¿Restaurar la tipografía original (Playfair Display + Inter, tamaño normal)? Las tipografías subidas no se borran, solo se dejan de usar.')"
          class="mt-4">
        @csrf
        <button type="submit" class="btn-outline text-sm">Restaurar tipografía por defecto</button>
    </form>

    {{-- ── TIPOGRAFÍAS PROPIAS ── --}}
    <div class="card space-y-5 mt-6">
        <div>
            <h2 class="font-semibold text-base" style="color:var(--color-brand-dark);">Tipografías propias</h2>
            <p class="text-xs text-gray-400 mt-1">
                Subí tu propia tipografía si no está en la lista de Google Fonts. Formatos aceptados: WOFF2, WOFF, TTF, OTF (máx. 5MB).
                WOFF2 es el más liviano y se ve igual en todos los navegadores modernos (Chrome, Firefox, Safari, Edge).
            </p>
        </div>

        <div class="grid md:grid-cols-2 gap-5">
            {{-- Títulos --}}
            <div class="p-4 rounded-xl" style="background:var(--color-brand-muted);">
                <p class="text-sm font-semibold mb-3" style="color:var(--color-brand-dark);">Para títulos</p>
                @if($customHeading)
                <p class="text-sm mb-3" style="color:var(--color-brand-dark);">
                    <strong>{{ $customHeading['label'] }}</strong>
                    <span class="text-xs text-gray-400">({{ strtoupper($customHeading['format']) }})</span>
                </p>
                <form method="POST" action="{{ route('admin.settings.typography.custom.remove', 'heading') }}"
                      onsubmit="return confirm('¿Eliminar esta tipografía personalizada?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-xs text-red-500 hover:underline">Quitar</button>
                </form>
                @else
                <form method="POST" action="{{ route('admin.settings.typography.custom.upload', 'heading') }}" enctype="multipart/form-data" class="space-y-2">
                    @csrf
                    <input type="text" name="font_label" class="input-field text-sm" placeholder="Nombre (opcional)">
                    <input type="file" name="font_file" accept=".woff2,.woff,.ttf,.otf" required class="input-field text-sm py-1.5">
                    @error('font_file')<p class="text-xs text-red-500">{{ $message }}</p>@enderror
                    <button type="submit" class="btn-outline text-sm w-full">Subir</button>
                </form>
                @endif
            </div>

            {{-- Texto --}}
            <div class="p-4 rounded-xl" style="background:var(--color-brand-muted);">
                <p class="text-sm font-semibold mb-3" style="color:var(--color-brand-dark);">Para texto general</p>
                @if($customBody)
                <p class="text-sm mb-3" style="color:var(--color-brand-dark);">
                    <strong>{{ $customBody['label'] }}</strong>
                    <span class="text-xs text-gray-400">({{ strtoupper($customBody['format']) }})</span>
                </p>
                <form method="POST" action="{{ route('admin.settings.typography.custom.remove', 'body') }}"
                      onsubmit="return confirm('¿Eliminar esta tipografía personalizada?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-xs text-red-500 hover:underline">Quitar</button>
                </form>
                @else
                <form method="POST" action="{{ route('admin.settings.typography.custom.upload', 'body') }}" enctype="multipart/form-data" class="space-y-2">
                    @csrf
                    <input type="text" name="font_label" class="input-field text-sm" placeholder="Nombre (opcional)">
                    <input type="file" name="font_file" accept=".woff2,.woff,.ttf,.otf" required class="input-field text-sm py-1.5">
                    @error('font_file')<p class="text-xs text-red-500">{{ $message }}</p>@enderror
                    <button type="submit" class="btn-outline text-sm w-full">Subir</button>
                </form>
                @endif
            </div>
        </div>

        @if($customHeading || $customBody)
        <p class="text-xs text-gray-400">
            Una vez subida, elegila en el desplegable correspondiente de arriba ("{{ $customHeading['label'] ?? '' }}"{{ $customHeading && $customBody ? ' / ' : '' }}{{ $customBody['label'] ?? '' }}) y guardá la tipografía para activarla.
        </p>
        @endif
    </div>
</div>

@push('scripts')
<script>
(function () {
    const loadedFonts = new Set();

    function loadGoogleFont(query) {
        if (!query || loadedFonts.has(query)) return;
        loadedFonts.add(query);
        const link = document.createElement('link');
        link.rel = 'stylesheet';
        link.href = 'https://fonts.googleapis.com/css2?family=' + query + '&display=swap';
        document.head.appendChild(link);
    }

    const headingSelect  = document.getElementById('font_heading');
    const bodySelect     = document.getElementById('font_body');
    const scaleSelect    = document.getElementById('font_scale');
    const previewHeading = document.getElementById('preview-heading');
    const previewBody    = document.getElementById('preview-body');
    const previewBox     = document.getElementById('font-preview');

    function fallbackFor(category) {
        return category === 'serif' ? 'serif' : 'sans-serif';
    }

    function updateHeadingPreview() {
        const opt = headingSelect.options[headingSelect.selectedIndex];
        if (opt.dataset.category === 'custom') {
            // @font-face ya está declarado globalmente en el <head> (theme-vars) si hay una subida.
            previewHeading.style.fontFamily = "'CustomHeadingFont', serif";
            return;
        }
        loadGoogleFont(opt.dataset.query);
        previewHeading.style.fontFamily = "'" + opt.textContent.trim() + "', " + fallbackFor(opt.dataset.category);
    }
    function updateBodyPreview() {
        const opt = bodySelect.options[bodySelect.selectedIndex];
        if (opt.dataset.category === 'custom') {
            previewBody.style.fontFamily = "'CustomBodyFont', sans-serif";
            return;
        }
        loadGoogleFont(opt.dataset.query);
        previewBody.style.fontFamily = "'" + opt.textContent.trim() + "', " + fallbackFor(opt.dataset.category);
    }
    function updateScalePreview() {
        previewBox.style.fontSize = scaleSelect.value + '%';
    }

    headingSelect.addEventListener('change', updateHeadingPreview);
    bodySelect.addEventListener('change', updateBodyPreview);
    scaleSelect.addEventListener('change', updateScalePreview);

    updateHeadingPreview();
    updateBodyPreview();
    updateScalePreview();
})();
</script>
@endpush
@endsection
