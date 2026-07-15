@extends('layouts.admin')
@section('title', $faq->id ? 'Editar FAQ' : 'Nueva FAQ')
@section('page-title', $faq->id ? 'Editar pregunta' : 'Nueva pregunta')

@section('content')
<div class="max-w-2xl">
    <div class="mb-4">
        <a href="{{ route('admin.faqs.index') }}" class="text-sm flex items-center gap-2" style="color: var(--color-primary);">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
            Volver
        </a>
    </div>
    <form method="POST"
          action="{{ $faq->id ? route('admin.faqs.update', $faq) : route('admin.faqs.store') }}"
          class="card space-y-5">
        @csrf
        @if($faq->id) @method('PUT') @endif

        <div>
            <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Pregunta <span class="text-red-500">*</span></label>
            <textarea name="question" rows="2" required class="input-field">{{ old('question', $faq->question) }}</textarea>
        </div>
        <div>
            <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Respuesta <span class="text-red-500">*</span></label>
            <textarea id="faq-answer-editor" name="answer" rows="5" class="input-field">{{ old('answer', $faq->answer) }}</textarea>
        </div>
        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Orden</label>
                <input type="number" name="order" value="{{ old('order', $faq->order ?? 0) }}" class="input-field">
            </div>
            <div class="flex items-end pb-3">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ ($faq->is_active ?? true) ? 'checked' : '' }}
                           class="w-4 h-4 rounded" style="accent-color: var(--color-primary);">
                    <span class="text-sm font-medium" style="color: var(--color-brand-dark);">Activa</span>
                </label>
            </div>
        </div>
        <div class="flex gap-4">
            <button type="submit" class="btn-primary">Guardar</button>
            <a href="{{ route('admin.faqs.index') }}" class="btn-outline">Cancelar</a>
        </div>
    </form>
</div>

@push('scripts')
<script>document.addEventListener('DOMContentLoaded', () => initRichEditor('#faq-answer-editor', { height: 220, toolbar: 'blocks | bold italic | bullist numlist | link | removeformat | undo redo' }));</script>
@endpush
@endsection
