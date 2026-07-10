@extends('layouts.admin')
@section('title', $step->id ? 'Editar paso' : 'Nuevo paso')
@section('page-title', $step->id ? 'Editar paso del proceso' : 'Nuevo paso del proceso')

@section('content')
<div class="max-w-2xl">
    <div class="mb-4">
        <a href="{{ route('admin.proceso.index') }}" class="text-sm flex items-center gap-2" style="color:var(--color-primary);">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
            Volver a proceso
        </a>
    </div>

    <form method="POST"
          action="{{ $step->id ? route('admin.proceso.update', $step) : route('admin.proceso.store') }}"
          class="card space-y-5">
        @csrf
        @if($step->id) @method('PUT') @endif

        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">Número de paso <span class="text-red-500">*</span></label>
                <input type="number" name="step_number"
                       value="{{ old('step_number', $step->step_number ?? 1) }}"
                       required class="input-field" min="1">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">Orden (en lista)</label>
                <input type="number" name="order"
                       value="{{ old('order', $step->order ?? 0) }}"
                       class="input-field">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">Título <span class="text-red-500">*</span></label>
            <input type="text" name="title"
                   value="{{ old('title', $step->title) }}"
                   required class="input-field"
                   placeholder="Ej: Primer contacto por WhatsApp">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">Descripción <span class="text-red-500">*</span></label>
            <textarea name="description" rows="3" required class="input-field"
                      placeholder="Breve descripción de este paso...">{{ old('description', $step->description) }}</textarea>
        </div>

        {{-- Selector de ícono --}}
        <div>
            <label class="block text-sm font-medium mb-2" style="color:var(--color-brand-dark);">Ícono</label>
            @php
            $iconOptions = [
                'message'  => ['label' => 'Mensaje',    'path' => 'M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z'],
                'calendar' => ['label' => 'Calendario', 'path' => 'M9 3H5a2 2 0 0 0-2 2v4m6-6h10a2 2 0 0 1 2 2v4M9 3v18m0 0h10a2 2 0 0 0 2-2V9M9 21H5a2 2 0 0 1-2-2V9m0 0h18'],
                'check'    => ['label' => 'Check',      'path' => 'M22 11.08V12a10 10 0 1 1-5.93-9.14M22 4L12 14.01l-3-3'],
                'bolt'     => ['label' => 'Rayo',       'path' => 'M13 2L3 14h9l-1 8 10-12h-9l1-8z'],
                'heart'    => ['label' => 'Corazón',    'path' => 'M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z'],
                'users'    => ['label' => 'Personas',   'path' => 'M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2M9 7a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75'],
                'star'     => ['label' => 'Estrella',   'path' => 'M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z'],
                'shield'   => ['label' => 'Escudo',     'path' => 'M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z'],
                'activity' => ['label' => 'Pulso',      'path' => 'M22 12h-4l-3 9L9 3l-3 9H2'],
                'trending' => ['label' => 'Tendencia',  'path' => 'M23 6l-9.5 9.5-5-5L1 18'],
                'sun'      => ['label' => 'Sol',        'path' => 'M12 2v2M12 20v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M2 12h2M20 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42M12 6a6 6 0 1 0 0 12A6 6 0 0 0 12 6z'],
                'eye'      => ['label' => 'Ojo',        'path' => 'M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8zM12 9a3 3 0 1 0 0 6 3 3 0 0 0 0-6z'],
            ];
            $currentIcon = old('icon', $step->icon ?? '');
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

        <div class="flex items-center gap-2">
            <input type="checkbox" name="is_active" value="1"
                   {{ ($step->is_active ?? true) ? 'checked' : '' }}
                   class="w-4 h-4" style="accent-color:var(--color-primary);">
            <label class="text-sm font-medium" style="color:var(--color-brand-dark);">Activo</label>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="btn-primary">Guardar paso</button>
            <a href="{{ route('admin.proceso.index') }}" class="btn-outline">Cancelar</a>
        </div>
    </form>
</div>
@endsection
