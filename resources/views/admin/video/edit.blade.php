@extends('layouts.admin')
@section('title', 'Video')
@section('page-title', 'Sección Video')

@section('content')
<form method="POST" action="{{ route('admin.video.update') }}" class="space-y-6 max-w-3xl">
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
            <p class="text-sm text-gray-400 mt-1">Aunque esté activa, si no cargás una URL de YouTube válida la sección no aparece en el sitio.</p>
        </div>
        <label class="flex items-center gap-2 cursor-pointer shrink-0">
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $section->is_active) ? 'checked' : '' }}
                   class="w-4 h-4" style="accent-color: var(--color-primary);">
            <span class="text-sm font-medium" style="color: var(--color-brand-dark);">Sección activa</span>
        </label>
    </div>

    {{-- ── VIDEO ── --}}
    <div class="card space-y-4">
        <h2 class="font-semibold text-base" style="color:var(--color-brand-dark);">Video de YouTube</h2>

        <div>
            <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">
                URL del video
                <span class="text-gray-400 font-normal ml-1 text-xs">Ej: https://www.youtube.com/watch?v=XXXXXXXXXXX</span>
            </label>
            <input type="text" name="video_url"
                   value="{{ old('video_url', $extra['video_url'] ?? '') }}"
                   class="input-field font-mono text-sm"
                   placeholder="https://www.youtube.com/watch?v=...">
            @error('video_url')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror

            @if(!\App\Helpers\YoutubeHelper::extractId($extra['video_url'] ?? null))
            <div class="p-3 rounded-xl text-sm mt-3 bg-amber-50" style="color:#856404;border:1px solid #ffc107;">
                Sin una URL de YouTube válida, esta sección no se muestra en el sitio — aunque esté marcada como activa.
            </div>
            @endif
        </div>
    </div>

    {{-- ── TEXTOS ── --}}
    <div class="card space-y-4">
        <h2 class="font-semibold text-base" style="color:var(--color-brand-dark);">Textos</h2>

        <div>
            <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">
                Etiqueta pequeña
                <span class="text-gray-400 font-normal ml-1 text-xs">Ej: Video</span>
            </label>
            <input type="text" name="label" value="{{ old('label', $extra['label'] ?? '') }}" class="input-field" placeholder="Video">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">Título</label>
            <input type="text" name="title" value="{{ old('title', $section->title) }}" class="input-field" placeholder="Mirá cómo trabajo">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">Descripción</label>
            <textarea name="subtitle" rows="2" class="input-field">{{ old('subtitle', $section->subtitle) }}</textarea>
        </div>
    </div>

    <div class="flex gap-4 pb-8">
        <button type="submit" class="btn-primary">Guardar cambios</button>
        <a href="{{ route('home') }}#video" target="_blank" class="btn-outline">Ver sitio</a>
    </div>
</form>
@endsection
