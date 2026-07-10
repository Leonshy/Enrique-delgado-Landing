@extends('layouts.admin')
@section('title', 'Enfoque')
@section('page-title', 'Sección Enfoque')

@section('content')
<form method="POST" action="{{ route('admin.enfoque.update') }}" class="space-y-6 max-w-3xl">
    @csrf @method('PUT')

    {{-- ── VISIBILIDAD ── --}}
    <div class="card flex items-center justify-between">
        <div>
            <h2 class="font-semibold text-base" style="color:var(--color-brand-dark);">Visibilidad de la sección</h2>
            <p class="text-sm text-gray-400 mt-1">Si la desactivas, esta sección desaparece completamente de la página.</p>
        </div>
        <label class="flex items-center gap-2 cursor-pointer shrink-0">
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $enfoque->is_active) ? 'checked' : '' }}
                   class="w-4 h-4" style="accent-color: var(--color-primary);">
            <span class="text-sm font-medium" style="color: var(--color-brand-dark);">Sección activa</span>
        </label>
    </div>

    {{-- ── TEXTOS ── --}}
    <div class="card space-y-5">
        <h2 class="font-semibold text-base" style="color:var(--color-brand-dark);">Textos</h2>

        <div>
            <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">
                Etiqueta pequeña
                <span class="text-gray-400 font-normal ml-1 text-xs">La que aparece encima del título grande. Ej: Mi enfoque</span>
            </label>
            <input type="text" name="label" value="{{ old('label', $extra['label']) }}" class="input-field">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">
                Título principal
                <span class="text-gray-400 font-normal ml-1 text-xs">El encabezado grande. Ej: Mi Enfoque</span>
            </label>
            <input type="text" name="title" value="{{ old('title', $enfoque->title) }}" class="input-field">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">Descripción</label>
            <textarea id="enfoque-description-editor" name="description" rows="6" class="input-field">{{ old('description', $enfoque->unified_desc) }}</textarea>
        </div>
    </div>

    {{-- ── PILARES ── --}}
    <div class="card space-y-4">
        <h2 class="font-semibold text-base" style="color:var(--color-brand-dark);">Los tres pilares del enfoque</h2>
        <p class="text-sm text-gray-400">Cada ítem aparece con un ícono de check y dos líneas de texto.</p>

        @foreach($extra['pillars'] as $i => $pillar)
        <div class="p-4 rounded-xl space-y-3" style="background:var(--color-brand-muted);border:1px solid color-mix(in srgb, var(--color-brand-dark) 17%, white);">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Pilar {{ $i + 1 }}</p>
            <div>
                <label class="block text-xs font-medium mb-1 text-gray-500">Título del pilar</label>
                <input type="text" name="pillars[{{ $i }}][title]"
                       value="{{ old("pillars.$i.title", $pillar['title']) }}"
                       class="input-field" placeholder="Alianza terapéutica sólida">
            </div>
            <div>
                <label class="block text-xs font-medium mb-1 text-gray-500">Descripción</label>
                <textarea name="pillars[{{ $i }}][desc]" rows="2" class="input-field"
                          placeholder="Un espacio seguro y confidencial...">{{ old("pillars.$i.desc", $pillar['desc']) }}</textarea>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ── IMAGEN ── --}}
    <div class="card space-y-4"
         x-data="mediaPicker(
             '{{ $enfoque->image_path ?? '' }}',
             '{{ $enfoque->image_path ? asset('storage/'.$enfoque->image_path) : '' }}',
             '{{ route('admin.media.list') }}',
             '{{ route('admin.media.upload') }}',
             '{{ csrf_token() }}'
         )">
        <h2 class="font-semibold text-base" style="color:var(--color-brand-dark);">Imagen lateral</h2>
        <p class="text-sm text-gray-400">Foto que aparece a la izquierda de la sección.</p>

        <input type="hidden" name="image_path" x-model="selectedPath">

        <div x-show="selectedUrl" class="flex items-start gap-4 p-4 rounded-xl" style="background:var(--color-brand-muted);">
            <img :src="selectedUrl" alt="Imagen seleccionada"
                 class="h-36 w-auto rounded-xl object-cover">
            <div class="flex-1">
                <p class="text-sm font-medium" style="color:var(--color-brand-dark);">Imagen seleccionada</p>
                <p class="text-xs text-gray-400 mt-1 break-all" x-text="selectedPath"></p>
                <button type="button" @click="selectedPath='';selectedUrl=''" class="text-xs text-red-500 mt-2 hover:underline">Quitar imagen</button>
            </div>
        </div>

        <div x-show="!selectedUrl" class="p-4 rounded-xl flex items-center gap-3" style="background:#fff3cd;border:1px solid #ffc107;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#856404" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <p class="text-sm" style="color:#856404;">Sin imagen — se usará la foto por defecto.</p>
        </div>

        <button type="button" @click="openPicker()" class="btn-outline flex items-center gap-2 text-sm">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
            Seleccionar de biblioteca o subir nueva
        </button>

        <div>
            <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">Texto alternativo (SEO)</label>
            <input type="text" name="image_alt" value="{{ old('image_alt', $enfoque->image_alt ?? 'Enrique Delgado — psicólogo del cambio') }}" class="input-field">
        </div>

        {{-- Modal --}}
        <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4"
             style="background:rgba(0,0,0,0.6);" @keydown.escape.window="open=false">
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
                        <input type="file" accept="image/*" @change="uploadFile($event)" class="input-field py-1.5 text-sm flex-1" :disabled="uploading">
                        <span x-show="uploading" class="text-sm text-gray-400">Subiendo...</span>
                    </div>
                    <p x-show="uploadError" x-text="uploadError" class="text-xs text-red-500 mt-1"></p>
                </div>
                <div class="flex-1 overflow-y-auto p-4">
                    <div x-show="loading" class="text-center py-8 text-gray-400 text-sm">Cargando imágenes...</div>
                    <div x-show="!loading && assets.length === 0" class="text-center py-8 text-gray-400 text-sm">No hay imágenes en la biblioteca.</div>
                    <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-3">
                        <template x-for="asset in assets" :key="asset.id">
                            <button type="button" @click="select(asset)"
                                    class="relative rounded-xl overflow-hidden border-2 transition-all aspect-square media-thumb" :class="selectedPath === asset.path ? 'is-selected border-transparent' : 'border-transparent'">
                                <img :src="asset.url" :alt="asset.alt" class="w-full h-full object-cover">
                                <div x-show="selectedPath === asset.path" class="absolute inset-0 flex items-center justify-center" style="background:color-mix(in srgb, var(--color-primary) 35%, transparent);">
                                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                                </div>
                                <p class="absolute bottom-0 left-0 right-0 text-white text-xs px-1 py-1 truncate" style="background:linear-gradient(transparent,rgba(0,0,0,0.6));" x-text="asset.name"></p>
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
        <button type="submit" class="btn-primary">Guardar cambios</button>
        <a href="{{ route('home') }}" target="_blank" class="btn-outline">Ver sitio</a>
    </div>
</form>

@push('scripts')
<script>document.addEventListener('DOMContentLoaded', () => initRichEditor('#enfoque-description-editor'));</script>
@endpush
@endsection
