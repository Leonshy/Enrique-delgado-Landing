@extends('layouts.admin')
@section('title', $plan->id ? 'Editar plan' : 'Nuevo plan')
@section('page-title', $plan->id ? 'Editar plan' : 'Nuevo plan de sesiones')

@section('content')
<div class="max-w-lg">
    <div class="mb-4">
        <a href="{{ route('admin.planes.index') }}" class="text-sm flex items-center gap-2" style="color: var(--color-primary);">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
            Volver
        </a>
    </div>
    <form method="POST"
          action="{{ $plan->id ? route('admin.planes.update', $plan) : route('admin.planes.store') }}"
          class="card space-y-5">
        @csrf
        @if($plan->id) @method('PUT') @endif

        <div>
            <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Nombre <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ old('name', $plan->name) }}" required class="input-field">
        </div>
        <div>
            <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Subtítulo (ej: 5 sesiones)</label>
            <input type="text" name="subtitle" value="{{ old('subtitle', $plan->subtitle) }}" class="input-field">
        </div>
        <div>
            <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Descripción <span class="text-red-500">*</span></label>
            <textarea name="description" rows="4" required class="input-field">{{ old('description', $plan->description) }}</textarea>
        </div>
        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Orden</label>
                <input type="number" name="order" value="{{ old('order', $plan->order ?? 0) }}" class="input-field">
            </div>
            <div class="flex flex-col gap-3 pt-2">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ ($plan->is_active ?? true) ? 'checked' : '' }}
                           class="w-4 h-4" style="accent-color: var(--color-primary);">
                    <span class="text-sm font-medium" style="color: var(--color-brand-dark);">Activo</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_featured" value="1" {{ ($plan->is_featured ?? false) ? 'checked' : '' }}
                           class="w-4 h-4" style="accent-color: var(--color-primary);">
                    <span class="text-sm font-medium" style="color: var(--color-brand-dark);">Destacado (más elegido)</span>
                </label>
            </div>
        </div>
        <div class="flex gap-4">
            <button type="submit" class="btn-primary">Guardar</button>
            <a href="{{ route('admin.planes.index') }}" class="btn-outline">Cancelar</a>
        </div>
    </form>
</div>
@endsection
