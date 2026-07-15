@extends('layouts.admin')
@section('title', 'Contacto')
@section('page-title', 'Formulario de Contacto')

@section('content')
@include('admin.partials.section-url', ['anchor' => 'contacto'])
<form method="POST" action="{{ route('admin.contacto.update') }}" class="space-y-6 max-w-2xl">
    @csrf @method('PUT')

    @if(session('success'))
    <div class="p-4 rounded-xl text-sm font-medium" style="background:#d1fae5;color:#065f46;">
        {{ session('success') }}
    </div>
    @endif

    {{-- ── Encabezado ── --}}
    <div class="card space-y-5">
        <h2 class="font-semibold text-base" style="color:var(--color-brand-dark);">Encabezado de la sección</h2>

        <div>
            <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">
                Etiqueta pequeña
                <span class="text-gray-400 font-normal text-xs ml-1">Ej: Hablemos</span>
            </label>
            <input type="text" name="label"
                   value="{{ old('label', $extra['label']) }}"
                   class="input-field">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">Título</label>
            <input type="text" name="title"
                   value="{{ old('title', $section->title) }}"
                   class="input-field"
                   placeholder="Ej: Formulario de Contacto">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">Descripción</label>
            <textarea id="contacto-subtitle-editor" name="subtitle" rows="3" class="input-field"
                      placeholder="Completa el siguiente formulario y me pondré en contacto...">{{ old('subtitle', $section->subtitle) }}</textarea>
        </div>
    </div>

    {{-- ── Box destacado ── --}}
    <div class="card space-y-5">
        <div>
            <h2 class="font-semibold text-base" style="color:var(--color-brand-dark);">Cuadro informativo (inferior derecha)</h2>
            <p class="text-sm text-gray-400 mt-1">Aparece bajo los datos de contacto — ideal para destacar la primera sesión gratuita u otra información clave.</p>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">Título del cuadro</label>
            <input type="text" name="box_title"
                   value="{{ old('box_title', $extra['box_title']) }}"
                   class="input-field"
                   placeholder="Ej: Primera sesión">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">
                Texto del cuadro
                <span class="text-gray-400 font-normal text-xs ml-1">Podés usar **negrita** encerrando palabras entre asteriscos dobles</span>
            </label>
            <textarea name="box_body" rows="4" class="input-field"
                      placeholder="La primera sesión es **gratuita y sin compromiso**...">{{ old('box_body', $extra['box_body']) }}</textarea>
        </div>
    </div>

    <p class="text-xs text-gray-400">
        El email, WhatsApp, ubicación, horarios y redes sociales se configuran en
        <a href="{{ route('admin.settings.general') }}" style="color:var(--color-primary);">Ajustes generales</a>.
    </p>

    <div class="flex gap-4 pb-8">
        <button type="submit" class="btn-primary">Guardar cambios</button>
        <a href="{{ route('home') }}#contacto" target="_blank" class="btn-outline">Ver sección</a>
    </div>
</form>

@push('scripts')
<script>document.addEventListener('DOMContentLoaded', () => initRichEditor('#contacto-subtitle-editor', { height: 150 }));</script>
@endpush
@endsection
