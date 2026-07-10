@extends('layouts.admin')
@section('title', 'Planes de acompañamiento')
@section('page-title', 'Planes de acompañamiento')

@section('content')

@if(session('success'))
<div class="p-4 rounded-xl text-sm font-medium mb-4" style="background:#d1fae5;color:#065f46;">
    {{ session('success') }}
</div>
@endif

@php $extra = json_decode($section?->extra ?? '{}', true) ?: []; @endphp

{{-- ── Encabezado de sección ── --}}
<div class="card space-y-5 mb-6">
    <h2 class="font-semibold text-base" style="color:var(--color-brand-dark);">Encabezado de la sección</h2>
    <form method="POST" action="{{ route('admin.planes.section.update') }}" class="space-y-4">
        @csrf @method('PUT')
        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">
                    Etiqueta pequeña
                    <span class="text-gray-400 font-normal text-xs ml-1">Ej: Inversión en ti</span>
                </label>
                <input type="text" name="label"
                       value="{{ old('label', $extra['label'] ?? 'Inversión en ti') }}"
                       class="input-field">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">Título principal</label>
                <input type="text" name="title"
                       value="{{ old('title', $section?->title ?? 'Planes de acompañamiento') }}"
                       class="input-field">
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">Descripción</label>
            <textarea name="subtitle" rows="2" class="input-field">{{ old('subtitle', $section?->subtitle) }}</textarea>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">
                Nota al pie
                <span class="text-gray-400 font-normal text-xs ml-1">Texto pequeño bajo los planes</span>
            </label>
            <input type="text" name="footer_note"
                   value="{{ old('footer_note', $extra['footer_note'] ?? 'Los precios se informan en la consulta inicial. Primera sesión gratuita y sin compromiso.') }}"
                   class="input-field">
        </div>
        <label class="flex items-center gap-2 cursor-pointer">
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $section?->is_active ?? true) ? 'checked' : '' }}
                   class="w-4 h-4" style="accent-color: var(--color-primary);">
            <span class="text-sm font-medium" style="color: var(--color-brand-dark);">Sección activa (visible en el sitio)</span>
        </label>
        <button type="submit" class="btn-primary text-sm py-2.5 px-5">Guardar encabezado</button>
    </form>
</div>

{{-- ── Lista de planes ── --}}
<div class="flex items-center justify-between mb-4">
    <h2 class="font-semibold text-base" style="color:var(--color-brand-dark);">Planes ({{ $plans->count() }})</h2>
    <a href="{{ route('admin.planes.create') }}" class="btn-primary text-sm py-2.5 px-5">+ Nuevo plan</a>
</div>

<div class="card overflow-hidden p-0">
    <table class="w-full">
        <thead>
            <tr class="border-b border-gray-100">
                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-400 uppercase">Orden</th>
                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-400 uppercase">Plan</th>
                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-400 uppercase">Precio</th>
                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-400 uppercase">Más elegido</th>
                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-400 uppercase">Estado</th>
                <th class="px-6 py-4"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($plans as $plan)
            <tr class="border-b border-gray-50 hover:bg-gray-50">
                <td class="px-6 py-4 text-sm text-gray-400">{{ $plan->order }}</td>
                <td class="px-6 py-4">
                    <p class="text-sm font-medium" style="color:var(--color-brand-dark);">{{ $plan->name }}</p>
                    @if($plan->subtitle)
                    <p class="text-xs text-gray-400 mt-0.5">{{ $plan->subtitle }}</p>
                    @endif
                </td>
                <td class="px-6 py-4 text-sm text-gray-600">
                    @if($plan->price)
                        {{ $plan->price }}@if($plan->period) / {{ $plan->period }}@endif
                    @else
                        <span class="text-gray-300">—</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    @if($plan->is_featured)
                    <span class="text-xs px-2 py-1 rounded-full font-medium" style="background:var(--color-brand-muted);color:var(--color-primary);">★ Sí</span>
                    @else
                    <span class="text-xs text-gray-300">—</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <span class="text-xs px-2 py-1 rounded-full {{ $plan->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $plan->is_active ? 'Activo' : 'Inactivo' }}
                    </span>
                </td>
                <td class="px-6 py-4 flex items-center gap-3 justify-end">
                    <a href="{{ route('admin.planes.edit', $plan) }}" class="text-sm font-medium" style="color:var(--color-primary);">Editar</a>
                    <form method="POST" action="{{ route('admin.planes.destroy', $plan) }}" onsubmit="return confirm('¿Eliminar este plan?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-sm text-red-500">Eliminar</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-6 py-10 text-center text-gray-400">No hay planes. Crea el primero.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
