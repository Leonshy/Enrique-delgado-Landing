@extends('layouts.admin')
@section('title', 'Editar ' . $page->title)
@section('page-title', 'Editar: ' . $page->title)

@section('content')
<div class="max-w-3xl">
    <div class="mb-4">
        <a href="{{ route('admin.legales.index') }}" class="text-sm flex items-center gap-2" style="color: var(--color-primary);">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
            Volver
        </a>
    </div>
    <form method="POST" action="{{ route('admin.legales.update', $page) }}" class="card space-y-5">
        @csrf @method('PUT')

        <div>
            <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Título <span class="text-red-500">*</span></label>
            <input type="text" name="title" value="{{ old('title', $page->title) }}" required class="input-field">
        </div>
        <div>
            <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Contenido</label>
            <textarea id="legal-content-editor" name="content" rows="20" class="input-field">{{ old('content', $page->content) }}</textarea>
        </div>
        <div class="flex gap-6">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="show_in_footer" value="1" {{ $page->show_in_footer ? 'checked' : '' }}
                       class="w-4 h-4" style="accent-color: var(--color-primary);">
                <span class="text-sm font-medium" style="color: var(--color-brand-dark);">Mostrar en footer</span>
            </label>
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="is_active" value="1" {{ $page->is_active ? 'checked' : '' }}
                       class="w-4 h-4" style="accent-color: var(--color-primary);">
                <span class="text-sm font-medium" style="color: var(--color-brand-dark);">Activa</span>
            </label>
        </div>
        <div class="flex gap-4">
            <button type="submit" class="btn-primary">Guardar</button>
            <a href="{{ route('admin.legales.index') }}" class="btn-outline">Cancelar</a>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => initRichEditor('#legal-content-editor', {
    height: 500,
    plugins: 'lists link autolink',
    toolbar: 'blocks | bold italic underline | bullist numlist | link | removeformat | undo redo',
}));
</script>
@endpush
@endsection
