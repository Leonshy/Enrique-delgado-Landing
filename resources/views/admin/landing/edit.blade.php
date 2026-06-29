@extends('layouts.admin')
@section('title', 'Editar sección')
@section('page-title', 'Editar sección: ' . $section->slug)

@section('content')
<div class="max-w-2xl">
    <div class="mb-4">
        <a href="{{ route('admin.landing.index') }}" class="text-sm flex items-center gap-2" style="color: var(--color-primary);">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
            Volver a secciones
        </a>
    </div>

    <form method="POST" action="{{ route('admin.landing.update', $section) }}" enctype="multipart/form-data" class="card space-y-5">
        @csrf @method('PUT')

        <div>
            <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Título</label>
            <input type="text" name="title" value="{{ old('title', $section->title) }}" class="input-field">
        </div>
        <div>
            <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Subtítulo</label>
            <input type="text" name="subtitle" value="{{ old('subtitle', $section->subtitle) }}" class="input-field">
        </div>
        <div>
            <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Cuerpo (texto principal)</label>
            <textarea name="body" rows="8" class="input-field">{{ old('body', $section->body) }}</textarea>
            <p class="text-xs text-gray-400 mt-1">Separa párrafos con una línea en blanco.</p>
        </div>
        <div>
            <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Texto extra / destacado</label>
            <textarea name="extra" rows="3" class="input-field">{{ old('extra', $section->extra) }}</textarea>
        </div>
        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Texto del botón CTA</label>
                <input type="text" name="cta_text" value="{{ old('cta_text', $section->cta_text) }}" class="input-field">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">URL del CTA</label>
                <input type="text" name="cta_url" value="{{ old('cta_url', $section->cta_url) }}" class="input-field" placeholder="#contacto">
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Imagen</label>
            @if($section->image_path)
            <div class="mb-3">
                <img src="{{ asset('storage/'.$section->image_path) }}" class="h-32 rounded-xl object-cover" alt="">
                <p class="text-xs text-gray-400 mt-1">Imagen actual</p>
            </div>
            @endif
            <input type="file" name="image" accept="image/*" class="input-field py-2">
        </div>
        <div>
            <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Alt de la imagen (SEO)</label>
            <input type="text" name="image_alt" value="{{ old('image_alt', $section->image_alt) }}" class="input-field">
        </div>
        <div class="flex items-center gap-3">
            <input type="checkbox" name="is_active" id="is_active" value="1" {{ $section->is_active ? 'checked' : '' }}
                   class="w-4 h-4 rounded" style="accent-color: var(--color-primary);">
            <label for="is_active" class="text-sm font-medium" style="color: var(--color-brand-dark);">Sección activa</label>
        </div>
        <div class="flex gap-4 pt-2">
            <button type="submit" class="btn-primary">Guardar cambios</button>
            <a href="{{ route('admin.landing.index') }}" class="btn-outline">Cancelar</a>
        </div>
    </form>
</div>
@endsection
