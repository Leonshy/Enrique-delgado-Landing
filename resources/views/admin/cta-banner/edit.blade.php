@extends('layouts.admin')
@section('title', 'CTA / Llamado a acción')
@section('page-title', 'CTA — Llamado a acción')

@section('content')
@include('admin.partials.section-url', ['anchor' => 'primer-paso'])
<form method="POST" action="{{ route('admin.cta-banner.update') }}" class="space-y-6 max-w-2xl">
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

    {{-- ── Textos ── --}}
    <div class="card space-y-5">
        <h2 class="font-semibold text-base" style="color:var(--color-brand-dark);">Textos</h2>

        <div>
            <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">
                Etiqueta pequeña
                <span class="text-gray-400 font-normal text-xs ml-1">Ej: El primer paso</span>
            </label>
            <input type="text" name="label"
                   value="{{ old('label', $extra['label']) }}"
                   class="input-field">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">Título</label>
            <input type="text" name="title"
                   value="{{ old('title', $section->title) }}"
                   class="input-field"
                   placeholder="¿Listo para comenzar tu proceso de cambio?">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">Descripción</label>
            <textarea name="subtitle" rows="3" class="input-field"
                      placeholder="La primera sesión es gratuita. Sin compromisos...">{{ old('subtitle', $section->subtitle) }}</textarea>
        </div>
    </div>

    {{-- ── Botones ── --}}
    <div class="card space-y-5">
        <h2 class="font-semibold text-base" style="color:var(--color-brand-dark);">Botones</h2>

        {{-- Botón 1 --}}
        <div class="p-4 rounded-xl space-y-3" style="background:var(--color-brand-muted);">
            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Botón principal (blanco)</p>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-medium mb-1 text-gray-500">Texto</label>
                    <input type="text" name="btn1_text"
                           value="{{ old('btn1_text', $extra['btn1_text']) }}"
                           class="input-field text-sm"
                           placeholder="Solicitar sesión gratuita">
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1 text-gray-500">
                        Destino
                        <span class="font-normal text-gray-400 ml-1">URL o ancla (#contacto)</span>
                    </label>
                    <input type="text" name="btn1_url"
                           value="{{ old('btn1_url', $extra['btn1_url']) }}"
                           class="input-field text-sm"
                           placeholder="#contacto">
                </div>
            </div>
        </div>

        {{-- Botón 2 --}}
        <div class="p-4 rounded-xl space-y-3" style="background:var(--color-brand-muted);">
            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Botón secundario (WhatsApp — borde blanco)</p>
            <p class="text-xs text-gray-400">El destino usa automáticamente el número de WhatsApp configurado en Ajustes.</p>
            <div>
                <label class="block text-xs font-medium mb-1 text-gray-500">Texto del botón</label>
                <input type="text" name="btn2_text"
                       value="{{ old('btn2_text', $extra['btn2_text']) }}"
                       class="input-field text-sm"
                       placeholder="Escribir por WhatsApp">
            </div>
        </div>
    </div>

    <div class="flex gap-4 pb-8">
        <button type="submit" class="btn-primary">Guardar cambios</button>
        <a href="{{ route('home') }}#contacto" target="_blank" class="btn-outline">Ver en el sitio</a>
    </div>
</form>
@endsection
