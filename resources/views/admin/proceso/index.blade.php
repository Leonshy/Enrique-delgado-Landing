@extends('layouts.admin')
@section('title', 'Proceso de cambio')
@section('page-title', 'El proceso de cambio')

@section('content')
@include('admin.partials.section-url', ['anchor' => 'proceso'])

@if(session('success'))
<div class="p-4 rounded-xl text-sm font-medium mb-4" style="background:#d1fae5;color:#065f46;">
    {{ session('success') }}
</div>
@endif

@php
    $extra = json_decode($section?->extra ?? '{}', true) ?: [];
@endphp

{{-- ── Encabezado de sección ── --}}
<div class="card space-y-5 mb-6">
    <h2 class="font-semibold text-base" style="color:var(--color-brand-dark);">Encabezado de la sección</h2>
    <form method="POST" action="{{ route('admin.proceso.section.update') }}" class="space-y-4">
        @csrf @method('PUT')
        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">
                    Etiqueta pequeña
                    <span class="text-gray-400 font-normal text-xs ml-1">Ej: Cómo trabajamos</span>
                </label>
                <input type="text" name="label"
                       value="{{ old('label', $extra['label'] ?? 'Cómo trabajamos') }}"
                       class="input-field">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">Título principal</label>
                <input type="text" name="title"
                       value="{{ old('title', $section?->title ?? 'El proceso de cambio') }}"
                       class="input-field">
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">Descripción</label>
            <textarea id="proceso-subtitle-editor" name="subtitle" rows="2" class="input-field"
                      placeholder="Un camino claro, paso a paso...">{{ old('subtitle', $section?->subtitle) }}</textarea>
        </div>
        <label class="flex items-center gap-2 cursor-pointer">
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $section?->is_active ?? true) ? 'checked' : '' }}
                   class="w-4 h-4" style="accent-color: var(--color-primary);">
            <span class="text-sm font-medium" style="color: var(--color-brand-dark);">Sección activa (visible en el sitio)</span>
        </label>
        <button type="submit" class="btn-primary text-sm py-2.5 px-5">Guardar encabezado</button>
    </form>
</div>

{{-- ── Lista de pasos ── --}}
<div class="flex items-center justify-between mb-4">
    <h2 class="font-semibold text-base" style="color:var(--color-brand-dark);">Pasos ({{ $steps->count() }})</h2>
    <a href="{{ route('admin.proceso.create') }}" class="btn-primary text-sm py-2.5 px-5">+ Nuevo paso</a>
</div>

@php
$iconPaths = [
    'message'  => 'M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z',
    'calendar' => 'M9 3H5a2 2 0 0 0-2 2v4m6-6h10a2 2 0 0 1 2 2v4M9 3v18m0 0h10a2 2 0 0 0 2-2V9M9 21H5a2 2 0 0 1-2-2V9m0 0h18',
    'check'    => 'M22 11.08V12a10 10 0 1 1-5.93-9.14M22 4L12 14.01l-3-3',
    'bolt'     => 'M13 2L3 14h9l-1 8 10-12h-9l1-8z',
    'heart'    => 'M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z',
    'users'    => 'M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2M9 7a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75',
    'star'     => 'M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z',
    'shield'   => 'M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z',
    'activity' => 'M22 12h-4l-3 9L9 3l-3 9H2',
    'trending' => 'M23 6l-9.5 9.5-5-5L1 18',
    'sun'      => 'M12 2v2M12 20v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M2 12h2M20 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42M12 6a6 6 0 1 0 0 12A6 6 0 0 0 12 6z',
    'eye'      => 'M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8zM12 9a3 3 0 1 0 0 6 3 3 0 0 0 0-6z',
];
@endphp

<div class="card overflow-hidden p-0">
    <table class="w-full">
        <thead>
            <tr class="border-b border-gray-100">
                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-400 uppercase">Paso</th>
                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-400 uppercase">Ícono</th>
                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-400 uppercase">Título</th>
                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-400 uppercase">Estado</th>
                <th class="px-6 py-4"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($steps as $step)
            <tr class="border-b border-gray-50 hover:bg-gray-50">
                <td class="px-6 py-4">
                    <span class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold text-white" style="background:var(--color-primary);">
                        {{ str_pad($step->step_number, 2, '0', STR_PAD_LEFT) }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    @if($step->icon && isset($iconPaths[$step->icon]))
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:var(--color-brand-muted);">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--color-primary)" stroke-width="1.8">
                            <path d="{{ $iconPaths[$step->icon] }}"/>
                        </svg>
                    </div>
                    @else
                    <span class="text-xs text-gray-300">—</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-sm font-medium" style="color:var(--color-brand-dark);">{{ $step->title }}</td>
                <td class="px-6 py-4">
                    <span class="text-xs px-2 py-1 rounded-full {{ $step->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $step->is_active ? 'Activo' : 'Inactivo' }}
                    </span>
                </td>
                <td class="px-6 py-4 flex items-center gap-3 justify-end">
                    <a href="{{ route('admin.proceso.edit', $step) }}" class="text-sm font-medium" style="color:var(--color-primary);">Editar</a>
                    <form method="POST" action="{{ route('admin.proceso.destroy', $step) }}" onsubmit="return confirm('¿Eliminar este paso?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-sm text-red-500">Eliminar</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-6 py-10 text-center text-gray-400">No hay pasos. Crea el primero.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@push('scripts')
<script>document.addEventListener('DOMContentLoaded', () => initRichEditor('#proceso-subtitle-editor', { height: 150 }));</script>
@endpush
@endsection
