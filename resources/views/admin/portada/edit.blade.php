@extends('layouts.admin')
@section('title', 'Portada')
@section('page-title', 'Portada — Hero')

@section('content')
@include('admin.partials.section-url', ['anchor' => 'inicio'])
<form method="POST" action="{{ route('admin.portada.update') }}" enctype="multipart/form-data" class="space-y-6 max-w-3xl">
    @csrf @method('PUT')

    {{-- ── HERO TEXTO ── --}}
    <div class="card space-y-5">
        <h2 class="font-semibold text-base" style="color:var(--color-brand-dark);">Texto del Hero</h2>

        <div>
            <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">
                Título principal
                <span class="text-gray-400 font-normal ml-1 text-xs">Ej: El Psicólogo del Cambio</span>
            </label>
            <input type="text" name="title" value="{{ old('title', $hero->title) }}" class="input-field">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">
                Etiqueta (badge)
                <span class="text-gray-400 font-normal ml-1 text-xs">Ej: PSICÓLOGO CLÍNICO · PARAGUAY</span>
            </label>
            <input type="text" name="subtitle" value="{{ old('subtitle', $hero->subtitle ?? 'PSICÓLOGO CLÍNICO · PARAGUAY') }}" class="input-field">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">Descripción</label>
            <textarea name="body" rows="4" class="input-field">{{ old('body', $hero->body ?? 'Acompaño a personas que quieren transformar su vida emocional y construir una versión más plena, libre y auténtica de sí mismas.') }}</textarea>
        </div>
    </div>

    {{-- ── BOTONES ── --}}
    <div class="card space-y-5">
        <h2 class="font-semibold text-base" style="color:var(--color-brand-dark);">Botones</h2>

        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">Botón principal — texto</label>
                <input type="text" name="cta_text" value="{{ old('cta_text', $hero->cta_text ?? 'Quiero solicitar una consulta') }}" class="input-field" placeholder="Quiero solicitar una consulta">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">Botón principal — URL</label>
                <input type="text" name="cta_url" value="{{ old('cta_url', $hero->cta_url ?? '#contacto') }}" class="input-field" placeholder="#contacto o /ruta">
                <p class="text-xs text-gray-400 mt-1">Acepta <code>#ancla</code>, <code>/ruta</code> o URL completa.</p>
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">Botón WhatsApp — texto</label>
                <input type="text" name="btn2_text" value="{{ old('btn2_text', $extra['btn2_text'] ?? 'Escribir por WhatsApp') }}" class="input-field" placeholder="Escribir por WhatsApp">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">Botón WhatsApp — URL</label>
                <input type="text" name="btn2_url" value="{{ old('btn2_url', $extra['btn2_url'] ?? '') }}" class="input-field" placeholder="https://wa.me/595...">
            </div>
        </div>
    </div>

    {{-- ── SELLO DE CERTIFICACIÓN ── --}}
    <div class="card space-y-4">
        <h2 class="font-semibold text-base" style="color:var(--color-brand-dark);">Sello de certificación</h2>
        <p class="text-sm text-gray-400">La tarjeta con el ícono de check que flota sobre la foto del hero (el mismo estilo que el de "Sobre mí").</p>

        <label class="flex items-center gap-2 cursor-pointer">
            <input type="checkbox" name="cert_badge_enabled" value="1" {{ old('cert_badge_enabled', $extra['cert_badge_enabled']) ? 'checked' : '' }}
                   class="w-4 h-4" style="accent-color: var(--color-primary);">
            <span class="text-sm font-medium" style="color: var(--color-brand-dark);">Mostrar el sello</span>
        </label>

        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">Título</label>
                <input type="text" name="cert_badge_title" value="{{ old('cert_badge_title', $extra['cert_badge_title']) }}" class="input-field" placeholder="Certificado">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">Subtítulo</label>
                <input type="text" name="cert_badge_subtitle" value="{{ old('cert_badge_subtitle', $extra['cert_badge_subtitle']) }}" class="input-field" placeholder="Psicólogo Clínico">
            </div>
        </div>
    </div>

    {{-- ── IMAGEN DE PORTADA ── --}}
    <div class="card space-y-4"
         x-data="mediaPicker(
             '{{ $hero->image_path ?? '' }}',
             '{{ $hero->image_path ? asset('storage/'.$hero->image_path) : '' }}',
             '{{ route('admin.media.list') }}',
             '{{ route('admin.media.upload') }}',
             '{{ csrf_token() }}'
         )">
        <h2 class="font-semibold text-base" style="color:var(--color-brand-dark);">Imagen de portada</h2>
        <p class="text-sm text-gray-400">PNG con fondo transparente recomendado para el efecto flotante.</p>

        {{-- Hidden input que envía el path al guardar --}}
        <input type="hidden" name="image_path" x-model="selectedPath">

        {{-- Preview de la imagen seleccionada --}}
        <div x-show="selectedUrl" class="flex items-start gap-4 p-4 rounded-xl" style="background:var(--color-brand-muted);">
            <img :src="selectedUrl" alt="Imagen seleccionada"
                 class="h-40 w-auto rounded-xl object-contain" style="background:color-mix(in srgb, var(--color-primary) 8%, transparent);">
            <div class="flex-1">
                <p class="text-sm font-medium" style="color:var(--color-brand-dark);">Imagen seleccionada</p>
                <p class="text-xs text-gray-400 mt-1 break-all" x-text="selectedPath"></p>
                <button type="button" @click="selectedPath='';selectedUrl=''" class="text-xs text-red-500 mt-2 hover:underline">Quitar imagen</button>
            </div>
        </div>

        <div x-show="!selectedUrl" class="p-4 rounded-xl flex items-center gap-3" style="background:#fff3cd;border:1px solid #ffc107;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#856404" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <p class="text-sm" style="color:#856404;">Sin imagen seleccionada — el sitio usará la imagen estática por defecto.</p>
        </div>

        {{-- Botón abrir picker --}}
        <button type="button" @click="openPicker()"
                class="btn-outline flex items-center gap-2 text-sm">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
            Seleccionar de biblioteca o subir nueva
        </button>

        <div>
            <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">Texto alternativo (SEO)</label>
            <input type="text" name="image_alt" value="{{ old('image_alt', $hero->image_alt ?? 'Enrique Delgado, El Psicólogo del Cambio') }}" class="input-field">
        </div>

        {{-- ── MODAL PICKER ── --}}
        <div x-show="open" x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center p-4"
             style="background:rgba(0,0,0,0.6);"
             @keydown.escape.window="open=false">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-3xl max-h-[90vh] flex flex-col" @click.stop>

                {{-- Header --}}
                <div class="flex items-center justify-between p-5 border-b">
                    <h3 class="font-semibold text-base" style="color:var(--color-brand-dark);">Biblioteca multimedia</h3>
                    <button type="button" @click="open=false" class="text-gray-400 hover:text-gray-600">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </button>
                </div>

                {{-- Upload nueva imagen --}}
                <div class="p-4 border-b" style="background:var(--color-brand-muted);">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Subir nueva imagen</p>
                    <div class="flex items-center gap-3">
                        <input type="file" accept="image/*" @change="uploadFile($event)"
                               class="input-field py-1.5 text-sm flex-1" :disabled="uploading">
                        <span x-show="uploading" class="text-sm text-gray-400">Subiendo...</span>
                    </div>
                    <p x-show="uploadError" x-text="uploadError" class="text-xs text-red-500 mt-1"></p>
                </div>

                {{-- Galería --}}
                <div class="flex-1 overflow-y-auto p-4">
                    <div x-show="loading" class="text-center py-8 text-gray-400 text-sm">Cargando imágenes...</div>
                    <div x-show="!loading && assets.length === 0" class="text-center py-8 text-gray-400 text-sm">No hay imágenes en la biblioteca.</div>
                    <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-3">
                        <template x-for="asset in assets" :key="asset.id">
                            <button type="button"
                                    @click="select(asset)"
                                    class="relative rounded-xl overflow-hidden border-2 transition-all aspect-square media-thumb" :class="selectedPath === asset.path ? 'is-selected border-transparent' : 'border-transparent'">
                                <img :src="asset.url" :alt="asset.alt" class="w-full h-full object-cover">
                                <div x-show="selectedPath === asset.path"
                                     class="absolute inset-0 flex items-center justify-center"
                                     style="background:color-mix(in srgb, var(--color-primary) 35%, transparent);">
                                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                                </div>
                                <p class="absolute bottom-0 left-0 right-0 text-white text-xs px-1 py-1 truncate"
                                   style="background:linear-gradient(transparent,rgba(0,0,0,0.6));" x-text="asset.name"></p>
                            </button>
                        </template>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="flex justify-end gap-3 p-4 border-t">
                    <button type="button" @click="open=false" class="btn-outline text-sm">Cancelar</button>
                    <button type="button" @click="confirm()" class="btn-primary text-sm" :disabled="!selectedPath">Confirmar selección</button>
                </div>
            </div>
        </div>
    </div>


    <div class="flex gap-4 pb-8">
        <button type="submit" class="btn-primary">Guardar portada</button>
        <a href="{{ route('home') }}" target="_blank" class="btn-outline">Ver sitio</a>
    </div>
</form>
@endsection
