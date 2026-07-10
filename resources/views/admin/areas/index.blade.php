@extends('layouts.admin')
@section('title', 'Áreas de ayuda')
@section('page-title', 'Áreas de ayuda')

@section('content')

{{-- ── Encabezado de sección ── --}}
@php
    $extra = json_decode($section?->extra ?? '{}', true) ?: [];
@endphp
<div class="card space-y-5 mb-6">
    <h2 class="font-semibold text-base" style="color:var(--color-brand-dark);">Encabezado de la sección</h2>
    <form method="POST" action="{{ route('admin.areas.section.update') }}" class="space-y-4">
        @csrf @method('PUT')
        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">
                    Etiqueta pequeña
                    <span class="text-gray-400 font-normal text-xs ml-1">Ej: ¿En qué puedo ayudarte?</span>
                </label>
                <input type="text" name="label" value="{{ old('label', $extra['label'] ?? '¿En qué puedo ayudarte?') }}" class="input-field">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">Título principal</label>
                <input type="text" name="title" value="{{ old('title', $section?->title ?? 'Áreas de acompañamiento') }}" class="input-field">
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">Texto descriptivo</label>
            <textarea name="subtitle" rows="2" class="input-field">{{ old('subtitle', $section?->subtitle ?? 'Trabajo con personas que enfrentan distintos desafíos. Si tu situación no aparece aquí, escríbeme: seguramente podemos trabajarla.') }}</textarea>
        </div>
        <label class="flex items-center gap-2 cursor-pointer">
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $section?->is_active ?? true) ? 'checked' : '' }}
                   class="w-4 h-4" style="accent-color: var(--color-primary);">
            <span class="text-sm font-medium" style="color: var(--color-brand-dark);">Sección activa (visible en el sitio)</span>
        </label>
        <button type="submit" class="btn-primary text-sm py-2.5 px-5">Guardar encabezado</button>
    </form>
</div>

{{-- ── Lista de áreas ── --}}
<div class="flex items-center justify-between mb-4">
    <h2 class="font-semibold text-base" style="color:var(--color-brand-dark);">Áreas ({{ $areas->count() }})</h2>
    <a href="{{ route('admin.areas.create') }}" class="btn-primary text-sm py-2.5 px-5">+ Nueva área</a>
</div>

<div class="card overflow-hidden p-0">
    <table class="w-full">
        <thead>
            <tr class="border-b border-gray-100">
                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-400 uppercase">Orden</th>
                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-400 uppercase">Ícono</th>
                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-400 uppercase">Título</th>
                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-400 uppercase">Estado</th>
                <th class="px-6 py-4"></th>
            </tr>
        </thead>
        <tbody>
            @php
            $iconPaths = [
                'shield'   => 'M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z',
                'heart'    => 'M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z',
                'users'    => 'M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2M9 7a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75',
                'star'     => 'M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z',
                'home'     => 'M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z',
                'activity' => 'M22 12h-4l-3 9L9 3l-3 9H2',
                'box'      => 'M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z',
                'check'    => 'M22 11.08V12a10 10 0 1 1-5.93-9.14M22 4L12 14.01l-3-3',
                'eye'      => 'M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8zM12 9a3 3 0 1 0 0 6 3 3 0 0 0 0-6z',
                'bolt'     => 'M13 2L3 14h9l-1 8 10-12h-9l1-8z',
                'trending' => 'M23 6l-9.5 9.5-5-5L1 18',
                'sun'      => 'M12 2v2M12 20v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M2 12h2M20 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42M12 6a6 6 0 1 0 0 12A6 6 0 0 0 12 6z',
            ];
            @endphp
            @forelse($areas as $area)
            <tr class="border-b border-gray-50 hover:bg-gray-50">
                <td class="px-6 py-4 text-sm text-gray-400">{{ $area->order }}</td>
                <td class="px-6 py-4">
                    @if($area->icon && isset($iconPaths[$area->icon]))
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:var(--color-brand-muted);">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--color-primary)" stroke-width="1.8">
                            <path d="{{ $iconPaths[$area->icon] }}"/>
                        </svg>
                    </div>
                    @else
                    <span class="text-xs text-gray-300">—</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-sm font-medium" style="color: var(--color-brand-dark);">{{ $area->title }}</td>
                <td class="px-6 py-4">
                    <span class="text-xs px-2 py-1 rounded-full {{ $area->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $area->is_active ? 'Activa' : 'Inactiva' }}
                    </span>
                </td>
                <td class="px-6 py-4 flex items-center gap-3 justify-end">
                    <a href="{{ route('admin.areas.edit', $area) }}" class="text-sm font-medium" style="color: var(--color-primary);">Editar</a>
                    <form method="POST" action="{{ route('admin.areas.destroy', $area) }}" onsubmit="return confirm('¿Eliminar?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-sm text-red-500">Eliminar</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-6 py-10 text-center text-gray-400">No hay áreas. Crea la primera.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
