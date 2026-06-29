@extends('layouts.admin')
@section('title', $step->id ? 'Editar paso' : 'Nuevo paso')
@section('page-title', $step->id ? 'Editar paso del proceso' : 'Nuevo paso del proceso')

@section('content')
<div class="max-w-lg">
    <div class="mb-4">
        <a href="{{ route('admin.proceso.index') }}" class="text-sm flex items-center gap-2" style="color: var(--color-primary);">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
            Volver
        </a>
    </div>
    <form method="POST"
          action="{{ $step->id ? route('admin.proceso.update', $step) : route('admin.proceso.store') }}"
          class="card space-y-5">
        @csrf
        @if($step->id) @method('PUT') @endif

        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Número de paso <span class="text-red-500">*</span></label>
                <input type="number" name="step_number" value="{{ old('step_number', $step->step_number ?? 1) }}" required class="input-field" min="1">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Orden</label>
                <input type="number" name="order" value="{{ old('order', $step->order ?? 0) }}" class="input-field">
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Título <span class="text-red-500">*</span></label>
            <input type="text" name="title" value="{{ old('title', $step->title) }}" required class="input-field">
        </div>
        <div>
            <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Descripción <span class="text-red-500">*</span></label>
            <textarea name="description" rows="4" required class="input-field">{{ old('description', $step->description) }}</textarea>
        </div>
        <div class="flex items-center gap-2">
            <input type="checkbox" name="is_active" value="1" {{ ($step->is_active ?? true) ? 'checked' : '' }}
                   class="w-4 h-4" style="accent-color: var(--color-primary);">
            <label class="text-sm font-medium" style="color: var(--color-brand-dark);">Activo</label>
        </div>
        <div class="flex gap-4">
            <button type="submit" class="btn-primary">Guardar</button>
            <a href="{{ route('admin.proceso.index') }}" class="btn-outline">Cancelar</a>
        </div>
    </form>
</div>
@endsection
