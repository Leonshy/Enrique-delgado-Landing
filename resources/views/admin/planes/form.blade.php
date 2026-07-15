@extends('layouts.admin')
@section('title', $plan->id ? 'Editar plan' : 'Nuevo plan')
@section('page-title', $plan->id ? 'Editar plan' : 'Nuevo plan')

@section('content')
<div class="max-w-2xl">
    <div class="mb-4">
        <a href="{{ route('admin.planes.index') }}" class="text-sm flex items-center gap-2" style="color:var(--color-primary);">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
            Volver a planes
        </a>
    </div>

    <form method="POST"
          action="{{ $plan->id ? route('admin.planes.update', $plan) : route('admin.planes.store') }}"
          class="space-y-5">
        @csrf
        @if($plan->id) @method('PUT') @endif

        {{-- ── Info principal ── --}}
        <div class="card space-y-5">
            <h2 class="font-semibold text-base" style="color:var(--color-brand-dark);">Información del plan</h2>

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">Nombre del plan <span class="text-red-500">*</span></label>
                    <input type="text" name="name"
                           value="{{ old('name', $plan->name) }}"
                           required class="input-field"
                           placeholder="Ej: 5 sesiones">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">Subtítulo</label>
                    <input type="text" name="subtitle"
                           value="{{ old('subtitle', $plan->subtitle) }}"
                           class="input-field"
                           placeholder="Ej: Proceso inicial">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">Descripción</label>
                <textarea id="plan-description-editor" name="description" rows="3" class="input-field"
                          placeholder="Breve descripción del plan...">{{ old('description', $plan->description) }}</textarea>
            </div>

            <div class="grid md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">Precio</label>
                    <input type="text" name="price"
                           value="{{ old('price', $plan->price) }}"
                           class="input-field"
                           placeholder="Ej: 150.000 ₲">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">Período</label>
                    <input type="text" name="period"
                           value="{{ old('period', $plan->period) }}"
                           class="input-field"
                           placeholder="Ej: sesión">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">Orden</label>
                    <input type="number" name="order"
                           value="{{ old('order', $plan->order ?? 0) }}"
                           class="input-field">
                </div>
            </div>
        </div>

        {{-- ── Botón CTA ── --}}
        <div class="card space-y-4">
            <h2 class="font-semibold text-base" style="color:var(--color-brand-dark);">Botón "Comenzar ahora"</h2>

            <div>
                <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">Texto del botón</label>
                <input type="text" name="cta_label"
                       value="{{ old('cta_label', $plan->cta_label ?? 'Comenzar ahora') }}"
                       class="input-field"
                       placeholder="Ej: Comenzar ahora">
            </div>

            @include('admin.partials.button-fields', [
                'uid' => 'plan-' . ($plan->id ?? 'new'),
                'lockIconOnWhatsapp' => false,
                'fields' => [
                    'icon' => 'icon', 'action_type' => 'action_type',
                    'url' => 'action_url', 'url_target' => 'action_url_target',
                    'email_to' => 'action_email_to', 'email_subject' => 'action_email_subject', 'email_body' => 'action_email_body',
                    'whatsapp_message' => 'whatsapp_text',
                ],
                'cfg' => [
                    'icon' => $plan->icon ?? 'none',
                    'action_type' => $plan->action_type ?? 'whatsapp',
                    'url' => $plan->action_url ?? '',
                    'url_target' => $plan->action_url_target ?? '_blank',
                    'email_to' => $plan->action_email_to ?? '',
                    'email_subject' => $plan->action_email_subject ?? '',
                    'email_body' => $plan->action_email_body ?? '',
                    'whatsapp_message' => $plan->whatsapp_text ?? '',
                ],
            ])
        </div>

        {{-- ── Opciones ── --}}
        <div class="card">
            <h2 class="font-semibold text-base mb-4" style="color:var(--color-brand-dark);">Opciones</h2>
            <div class="flex flex-col gap-3">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_featured" value="1"
                           {{ ($plan->is_featured ?? false) ? 'checked' : '' }}
                           class="w-4 h-4" style="accent-color:var(--color-primary);">
                    <div>
                        <span class="text-sm font-medium" style="color:var(--color-brand-dark);">Marcar como "Más elegido"</span>
                        <p class="text-xs text-gray-400">Muestra el badge destacado y resalta la tarjeta visualmente.</p>
                    </div>
                </label>
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1"
                           {{ ($plan->is_active ?? true) ? 'checked' : '' }}
                           class="w-4 h-4" style="accent-color:var(--color-primary);">
                    <span class="text-sm font-medium" style="color:var(--color-brand-dark);">Plan activo (visible en el sitio)</span>
                </label>
            </div>
        </div>

        <div class="flex gap-4 pb-8">
            <button type="submit" class="btn-primary">Guardar plan</button>
            <a href="{{ route('admin.planes.index') }}" class="btn-outline">Cancelar</a>
        </div>
    </form>
</div>

@push('scripts')
<script>document.addEventListener('DOMContentLoaded', () => initRichEditor('#plan-description-editor', { height: 200, toolbar: 'blocks | bold italic | bullist numlist | link | removeformat | undo redo' }));</script>
@endpush
@endsection
