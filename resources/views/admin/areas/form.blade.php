@extends('layouts.admin')
@section('title', $area->id ? 'Editar área' : 'Nueva área')
@section('page-title', $area->id ? 'Editar área' : 'Nueva área de ayuda')

@section('content')
<div class="max-w-lg">
    <div class="mb-4">
        <a href="{{ route('admin.areas.index') }}" class="text-sm flex items-center gap-2" style="color: var(--color-primary);">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
            Volver
        </a>
    </div>
    <form method="POST"
          action="{{ $area->id ? route('admin.areas.update', $area) : route('admin.areas.store') }}"
          class="card space-y-5">
        @csrf
        @if($area->id) @method('PUT') @endif

        <div>
            <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Título <span class="text-red-500">*</span></label>
            <input type="text" name="title" value="{{ old('title', $area->title) }}" required class="input-field" placeholder="Ej: Relaciones de pareja">
        </div>
        <div>
            <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Descripción (opcional)</label>
            <textarea name="description" rows="3" class="input-field">{{ old('description', $area->description) }}</textarea>
        </div>
        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Orden</label>
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
@endsection
