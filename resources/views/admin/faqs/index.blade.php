@extends('layouts.admin')
@section('title', 'Preguntas frecuentes')
@section('page-title', 'Preguntas frecuentes')

@section('content')
@include('admin.partials.section-url', ['anchor' => 'faq'])

@if(session('success'))
<div class="p-4 rounded-xl text-sm font-medium mb-4" style="background:#d1fae5;color:#065f46;">
    {{ session('success') }}
</div>
@endif

@php $extra = json_decode($section?->extra ?? '{}', true) ?: []; @endphp

{{-- ── Encabezado de sección ── --}}
<div class="card space-y-5 mb-6">
    <h2 class="font-semibold text-base" style="color:var(--color-brand-dark);">Encabezado de la sección</h2>
    <form method="POST" action="{{ route('admin.faqs.section.update') }}" class="space-y-4">
        @csrf @method('PUT')
        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">
                    Etiqueta pequeña
                    <span class="text-gray-400 font-normal text-xs ml-1">Ej: Respuestas</span>
                </label>
                <input type="text" name="label"
                       value="{{ old('label', $extra['label'] ?? 'Respuestas') }}"
                       class="input-field">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">Título principal</label>
                <input type="text" name="title"
                       value="{{ old('title', $section?->title ?? 'Preguntas frecuentes') }}"
                       class="input-field">
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">Descripción</label>
            <textarea id="faq-subtitle-editor" name="subtitle" rows="2" class="input-field"
                      placeholder="Si tu pregunta no está aquí, puedes escribirme directamente...">{{ old('subtitle', $section?->subtitle) }}</textarea>
        </div>
        <label class="flex items-center gap-2 cursor-pointer">
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $section?->is_active ?? true) ? 'checked' : '' }}
                   class="w-4 h-4" style="accent-color: var(--color-primary);">
            <span class="text-sm font-medium" style="color: var(--color-brand-dark);">Sección activa (visible en el sitio)</span>
        </label>
        <button type="submit" class="btn-primary text-sm py-2.5 px-5">Guardar encabezado</button>
    </form>
</div>

{{-- ── Lista de preguntas ── --}}
<div class="flex items-center justify-between mb-4">
    <h2 class="font-semibold text-base" style="color:var(--color-brand-dark);">Preguntas ({{ $faqs->count() }})</h2>
    <a href="{{ route('admin.faqs.create') }}" class="btn-primary text-sm py-2.5 px-5">+ Nueva pregunta</a>
</div>

<div class="card overflow-hidden p-0">
    <table class="w-full">
        <thead>
            <tr class="border-b border-gray-100">
                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-400 uppercase">Orden</th>
                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-400 uppercase">Pregunta</th>
                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-400 uppercase">Estado</th>
                <th class="px-6 py-4"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($faqs as $faq)
            <tr class="border-b border-gray-50 hover:bg-gray-50">
                <td class="px-6 py-4 text-sm text-gray-400">{{ $faq->order }}</td>
                <td class="px-6 py-4 text-sm font-medium max-w-sm" style="color:var(--color-brand-dark);">
                    {{ Str::limit($faq->question, 80) }}
                </td>
                <td class="px-6 py-4">
                    <span class="text-xs px-2 py-1 rounded-full {{ $faq->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $faq->is_active ? 'Activa' : 'Inactiva' }}
                    </span>
                </td>
                <td class="px-6 py-4 flex items-center gap-3 justify-end">
                    <a href="{{ route('admin.faqs.edit', $faq) }}" class="text-sm font-medium" style="color:var(--color-primary);">Editar</a>
                    <form method="POST" action="{{ route('admin.faqs.destroy', $faq) }}" onsubmit="return confirm('¿Eliminar esta pregunta?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-sm text-red-500">Eliminar</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="px-6 py-10 text-center text-gray-400">No hay preguntas. Crea la primera.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@push('scripts')
<script>document.addEventListener('DOMContentLoaded', () => initRichEditor('#faq-subtitle-editor', { height: 150 }));</script>
@endpush
@endsection
