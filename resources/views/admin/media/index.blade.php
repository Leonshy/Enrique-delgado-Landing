@extends('layouts.admin')
@section('title', 'Multimedia')
@section('page-title', 'Gestión de Multimedia')

@section('content')

{{-- Upload form --}}
<div class="card mb-6">
    <h2 class="font-semibold mb-4" style="color: var(--color-brand-dark);">Subir imagen(es)</h2>
    <form method="POST" action="{{ route('admin.media.store') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Archivos (máx 5MB c/u, formatos: jpg, png, webp, gif, svg)</label>
            <input type="file" name="files[]" multiple accept="image/*,.svg" required class="input-field py-2">
        </div>
        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Colección</label>
                <select name="collection" class="input-field">
                    <option value="">Sin categoría</option>
                    <option value="logo">Logo</option>
                    <option value="hero">Hero</option>
                    <option value="sobre-mi">Sobre mí</option>
                    <option value="urbana">Fotos urbanas</option>
                    <option value="general">General</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Alt / descripción</label>
                <input type="text" name="alt" class="input-field" placeholder="Descripción de las imágenes">
            </div>
        </div>
        <button type="submit" class="btn-primary text-sm py-2.5 px-5">Subir</button>
    </form>
</div>

{{-- Gallery --}}
@if($assets->isNotEmpty())
<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
    @foreach($assets as $asset)
    <div class="group relative card p-2">
        @if(str_starts_with($asset->mime_type ?? '', 'image/'))
        <img src="{{ asset('storage/'.$asset->path) }}"
             alt="{{ $asset->alt }}"
             class="w-full h-28 object-cover rounded-lg mb-2">
        @else
        <div class="w-full h-28 rounded-lg mb-2 flex items-center justify-center" style="background: var(--color-brand-muted);">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="color: var(--color-primary);"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
        </div>
        @endif
        <p class="text-xs text-gray-500 truncate">{{ $asset->name }}</p>
        @if($asset->collection)
        <span class="text-xs px-1.5 py-0.5 rounded" style="background: var(--color-brand-muted); color: var(--color-primary);">{{ $asset->collection }}</span>
        @endif
        <div class="flex items-center gap-2 mt-2">
            <a href="{{ asset('storage/'.$asset->path) }}" target="_blank" class="text-xs" style="color: var(--color-primary);">Ver</a>
            <span class="text-gray-300">|</span>
            <form method="POST" action="{{ route('admin.media.destroy', $asset) }}" onsubmit="return confirm('¿Eliminar imagen?')">
                @csrf @method('DELETE')
                <button type="submit" class="text-xs text-red-500">Eliminar</button>
            </form>
        </div>
    </div>
    @endforeach
</div>
<div class="mt-4">{{ $assets->links() }}</div>
@else
<div class="text-center py-16 text-gray-400">
    <svg class="mx-auto mb-4" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
    <p>No hay imágenes. Sube las primeras.</p>
</div>
@endif

@endsection
