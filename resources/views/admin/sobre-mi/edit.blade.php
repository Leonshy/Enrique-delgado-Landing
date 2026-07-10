@extends('layouts.admin')
@section('title', 'Sobre mí')
@section('page-title', 'Sobre mí')

@section('content')
<form method="POST" action="{{ route('admin.sobre-mi.update') }}" class="space-y-6 max-w-3xl">
    @csrf @method('PUT')

    @if(session('success'))
    <div class="p-4 rounded-xl text-sm font-medium" style="background:#d1fae5;color:#065f46;">
        {{ session('success') }}
    </div>
    @endif

    {{-- ── VISIBILIDAD ── --}}
    <div class="card flex items-center justify-between">
        <div>
            <h2 class="font-semibold text-base" style="color:var(--color-brand-dark);">Visibilidad de la sección</h2>
            <p class="text-sm text-gray-400 mt-1">Si la desactivas, esta sección desaparece completamente de la página.</p>
        </div>
        <label class="flex items-center gap-2 cursor-pointer shrink-0">
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $section->is_active) ? 'checked' : '' }}
                   class="w-4 h-4" style="accent-color: var(--color-primary);">
            <span class="text-sm font-medium" style="color: var(--color-brand-dark);">Sección activa</span>
        </label>
    </div>

    {{-- ── TEXTOS PRINCIPALES ── --}}
    <div class="card space-y-5">
        <h2 class="font-semibold text-base" style="color:var(--color-brand-dark);">Textos de la sección</h2>

        <div>
            <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">
                Etiqueta pequeña
                <span class="text-gray-400 font-normal text-xs ml-1">Ej: Sobre mí</span>
            </label>
            <input type="text" name="label"
                   value="{{ old('label', $extra['label']) }}"
                   class="input-field">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">Título principal</label>
            <input type="text" name="title"
                   value="{{ old('title', $section->title) }}"
                   class="input-field"
                   placeholder="Ej: Psicólogo clínico comprometido con tu bienestar">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">Subtítulo</label>
            <input type="text" name="subtitle"
                   value="{{ old('subtitle', $section->subtitle) }}"
                   class="input-field"
                   placeholder="Ej: Psicólogo clínico con formación en terapia sistémica.">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">Descripción</label>
            <textarea id="sobremi-body-editor" name="body" rows="7" class="input-field">{{ old('body', $section->body) }}</textarea>
        </div>
    </div>

    {{-- ── ESTADÍSTICAS ── --}}
    <div class="card space-y-4">
        <h2 class="font-semibold text-base" style="color:var(--color-brand-dark);">Estadísticas (3 valores)</h2>
        <p class="text-sm text-gray-400">Usá "+" como sufijo si querés (ej: <em>10+</em>, <em>500+</em>, <em>3</em>).</p>
        <div class="space-y-3">
            @foreach($extra['stats'] as $i => $stat)
            <div class="flex gap-3 items-start p-3 rounded-xl" style="background:var(--color-brand-muted);">
                <span class="text-xs font-bold text-gray-400 mt-2.5 w-4">{{ $i + 1 }}</span>
                <div class="flex-1 grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium mb-1 text-gray-500">Valor</label>
                        <input type="text" name="stats[{{ $i }}][value]"
                               value="{{ old("stats.$i.value", $stat['value']) }}"
                               class="input-field text-sm"
                               placeholder="Ej: 10+">
                    </div>
                    <div>
                        <label class="block text-xs font-medium mb-1 text-gray-500">Etiqueta</label>
                        <input type="text" name="stats[{{ $i }}][label]"
                               value="{{ old("stats.$i.label", $stat['label']) }}"
                               class="input-field text-sm"
                               placeholder="Ej: Años de práctica">
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- ── IMAGEN ── --}}
    <div class="card space-y-4"
         x-data="mediaPicker(
             '{{ $section->image_path ?? '' }}',
             '{{ $section->image_path ? asset('storage/'.$section->image_path) : '' }}',
             '{{ route('admin.media.list') }}',
             '{{ route('admin.media.upload') }}',
             '{{ csrf_token() }}'
         )">
        <h2 class="font-semibold text-base" style="color:var(--color-brand-dark);">Foto de perfil</h2>
        <p class="text-sm text-gray-400">PNG con fondo transparente — se muestra recortada dentro del recuadro blanco.</p>

        <input type="hidden" name="image_path" x-model="selectedPath">

        <div x-show="selectedUrl" class="flex items-start gap-4 p-4 rounded-xl" style="background:var(--color-brand-muted);">
            <img :src="selectedUrl" alt="Imagen seleccionada"
                 class="h-40 w-auto rounded-xl object-contain" style="background:color-mix(in srgb, var(--color-primary) 8%, transparent);">
            <div class="flex-1">
                <p class="text-sm font-medium" style="color:var(--color-brand-dark);">Imagen seleccionada</p>
                <p class="text-xs text-gray-400 mt-1 break-all" x-text="selectedPath"></p>
                <button type="button" @click="selectedPath='';selectedUrl=''"
                        class="text-xs text-red-500 mt-2 hover:underline">Quitar imagen</button>
            </div>
        </div>

        <div x-show="!selectedUrl" class="p-4 rounded-xl flex items-center gap-3"
             style="background:#fff3cd;border:1px solid #ffc107;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#856404" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <p class="text-sm" style="color:#856404;">Sin imagen — se usará la imagen estática por defecto.</p>
        </div>

        <button type="button" @click="openPicker()"
                class="btn-outline flex items-center gap-2 text-sm">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
            Seleccionar de biblioteca o subir nueva
        </button>

        <div>
            <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">Texto alternativo (SEO)</label>
            <input type="text" name="image_alt"
                   value="{{ old('image_alt', $section->image_alt ?? 'Enrique Delgado, psicólogo clínico') }}"
                   class="input-field">
        </div>

        {{-- ── MODAL PICKER ── --}}
        <div x-show="open" x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center p-4"
             style="background:rgba(0,0,0,0.6);"
             @keydown.escape.window="open=false">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-3xl max-h-[90vh] flex flex-col" @click.stop>

                <div class="flex items-center justify-between p-5 border-b">
                    <h3 class="font-semibold text-base" style="color:var(--color-brand-dark);">Biblioteca multimedia</h3>
                    <button type="button" @click="open=false" class="text-gray-400 hover:text-gray-600">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </button>
                </div>

                <div class="p-4 border-b" style="background:var(--color-brand-muted);">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Subir nueva imagen</p>
                    <div class="flex items-center gap-3">
                        <input type="file" accept="image/*" @change="uploadFile($event)"
                               class="input-field py-1.5 text-sm flex-1" :disabled="uploading">
                        <span x-show="uploading" class="text-sm text-gray-400">Subiendo...</span>
                    </div>
                    <p x-show="uploadError" x-text="uploadError" class="text-xs text-red-500 mt-1"></p>
                </div>

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

                <div class="flex justify-end gap-3 p-4 border-t">
                    <button type="button" @click="open=false" class="btn-outline text-sm">Cancelar</button>
                    <button type="button" @click="confirm()" class="btn-primary text-sm" :disabled="!selectedPath">Confirmar selección</button>
                </div>
            </div>
        </div>
    </div>

    <div class="flex gap-4 pb-8">
        <button type="submit" class="btn-primary">Guardar Sobre mí</button>
        <a href="{{ route('home') }}#sobre-mi" target="_blank" class="btn-outline">Ver sección</a>
    </div>
</form>

@push('scripts')
<script>document.addEventListener('DOMContentLoaded', () => initRichEditor('#sobremi-body-editor'));</script>
@endpush
@endsection
