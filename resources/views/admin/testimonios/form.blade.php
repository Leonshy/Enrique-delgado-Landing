@extends('layouts.admin')
@section('title', isset($testimonial->id) ? 'Editar testimonio' : 'Nuevo testimonio')
@section('page-title', isset($testimonial->id) ? 'Editar testimonio' : 'Nuevo testimonio')

@section('content')
<div class="max-w-2xl">
    <div class="mb-4">
        <a href="{{ route('admin.testimonios.index') }}" class="text-sm flex items-center gap-2" style="color:var(--color-primary);">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
            Volver a testimonios
        </a>
    </div>

    <form method="POST"
          action="{{ isset($testimonial->id) ? route('admin.testimonios.update', $testimonial) : route('admin.testimonios.store') }}"
          class="card space-y-5">
        @csrf
        @if(isset($testimonial->id)) @method('PUT') @endif

        <div>
            <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">
                Testimonio <span class="text-red-500">*</span>
                <span class="text-gray-400 font-normal text-xs ml-1">Escribe el texto tal como aparecerá en el sitio, sin comillas</span>
            </label>
            <textarea name="quote" rows="5" required class="input-field text-sm leading-relaxed"
                      placeholder="Llegué sin esperanza de que algo pudiera cambiar. Hoy tengo herramientas reales...">{{ old('quote', $testimonial->quote ?? '') }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">
                Atribución
                <span class="text-gray-400 font-normal text-xs ml-1">Nombre o referencia del paciente</span>
            </label>
            <input type="text" name="author"
                   value="{{ old('author', $testimonial->author ?? '') }}"
                   class="input-field"
                   placeholder="Ej: Paciente anónimo — proceso de 6 meses">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">Orden</label>
                <input type="number" name="order"
                       value="{{ old('order', $testimonial->order ?? 0) }}"
                       class="input-field" min="0">
            </div>
            <div class="flex items-end pb-3">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1"
                           {{ ($testimonial->is_active ?? true) ? 'checked' : '' }}
                           class="w-4 h-4" style="accent-color:var(--color-primary);">
                    <span class="text-sm font-medium" style="color:var(--color-brand-dark);">Activo (visible en el sitio)</span>
                </label>
            </div>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="btn-primary">Guardar testimonio</button>
            <a href="{{ route('admin.testimonios.index') }}" class="btn-outline">Cancelar</a>
        </div>
    </form>
</div>
@endsection
