@extends('layouts.admin')
@section('title', $area->id ? 'Editar área' : 'Nueva área')
@section('page-title', $area->id ? 'Editar área' : 'Nueva área de ayuda')

@section('content')
<div class="max-w-2xl">
    <div class="mb-4">
        <a href="{{ route('admin.areas.index') }}" class="text-sm flex items-center gap-2" style="color: var(--color-primary);">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
            Volver a áreas
        </a>
    </div>

    <form method="POST"
          action="{{ $area->id ? route('admin.areas.update', $area) : route('admin.areas.store') }}"
          class="card space-y-5">
        @csrf
        @if($area->id) @method('PUT') @endif

        <div>
            <label class="block text-sm font-medium mb-1" style="color: var(--color-brand-dark);">Título <span class="text-red-500">*</span></label>
            <input type="text" name="title" value="{{ old('title', $area->title) }}" required class="input-field" placeholder="Ej: Relaciones de pareja">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1" style="color: var(--color-brand-dark);">Descripción
                <span class="text-gray-400 font-normal text-xs ml-1">Máx. 255 caracteres — se muestra en una tarjeta corta</span>
            </label>
            <textarea id="area-description-editor" name="description" rows="3" class="input-field" placeholder="Breve descripción del área...">{{ old('description', $area->description) }}</textarea>
        </div>

        {{-- Selector de ícono --}}
        <div>
            <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Ícono</label>
            @php
            $iconOptions = [
                'shield'   => ['label' => 'Escudo',       'path' => 'M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z'],
                'heart'    => ['label' => 'Corazón',      'path' => 'M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z'],
                'users'    => ['label' => 'Personas',     'path' => 'M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2M9 7a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75'],
                'star'     => ['label' => 'Estrella',     'path' => 'M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z'],
                'home'     => ['label' => 'Hogar',        'path' => 'M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z'],
                'activity' => ['label' => 'Pulso',        'path' => 'M22 12h-4l-3 9L9 3l-3 9H2'],
                'box'      => ['label' => 'Caja',         'path' => 'M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z'],
                'check'    => ['label' => 'Check',        'path' => 'M22 11.08V12a10 10 0 1 1-5.93-9.14M22 4L12 14.01l-3-3'],
                'eye'      => ['label' => 'Ojo',          'path' => 'M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8zM12 9a3 3 0 1 0 0 6 3 3 0 0 0 0-6z'],
                'bolt'     => ['label' => 'Rayo',         'path' => 'M13 2L3 14h9l-1 8 10-12h-9l1-8z'],
                'trending' => ['label' => 'Tendencia',    'path' => 'M23 6l-9.5 9.5-5-5L1 18'],
                'sun'      => ['label' => 'Sol',          'path' => 'M12 2v2M12 20v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M2 12h2M20 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42M12 6a6 6 0 1 0 0 12A6 6 0 0 0 12 6z'],
            ];
            $currentIcon = old('icon', $area->icon ?? '');
            @endphp
            <div class="grid grid-cols-4 sm:grid-cols-6 gap-2">
                @foreach($iconOptions as $key => $ico)
                <label class="flex flex-col items-center gap-1 cursor-pointer p-2 rounded-lg border-2 transition-colors text-center
                    icon-option {{ $currentIcon === $key ? 'is-selected' : '' }}"
                    style="font-size:0.65rem;color:#666;">
                    <input type="radio" name="icon" value="{{ $key }}"
                           {{ $currentIcon === $key ? 'checked' : '' }}
                           class="sr-only"
                           onchange="this.closest('.grid').querySelectorAll('label').forEach(l=>l.classList.remove('is-selected'));this.closest('label').classList.add('is-selected')">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="{{ $ico['path'] }}"/>
                    </svg>
                    {{ $ico['label'] }}
                </label>
                @endforeach
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1" style="color: var(--color-brand-dark);">Orden</label>
                <input type="number" name="order" value="{{ old('order', $area->order ?? 0) }}" class="input-field">
            </div>
            <div class="flex items-end pb-3">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ ($area->is_active ?? true) ? 'checked' : '' }}
                           class="w-4 h-4" style="accent-color: var(--color-primary);">
                    <span class="text-sm font-medium" style="color: var(--color-brand-dark);">Activa</span>
                </label>
            </div>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="btn-primary">Guardar</button>
            <a href="{{ route('admin.areas.index') }}" class="btn-outline">Cancelar</a>
        </div>
    </form>
</div>

@push('scripts')
<script>document.addEventListener('DOMContentLoaded', () => initRichEditor('#area-description-editor', { height: 150 }));</script>
@endpush
@endsection
