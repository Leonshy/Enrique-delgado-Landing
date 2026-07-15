@extends('layouts.admin')
@section('title', 'Botones')
@section('page-title', 'Botones')

@section('content')
<div class="max-w-3xl space-y-6">
    <p class="text-sm text-gray-400">Configura el ícono, el texto y qué pasa al hacer clic en estos botones del sitio. El resto de los botones (Portada, CTA, Planes) se editan en su propia sección.</p>

    <form method="POST" action="{{ route('admin.settings.buttons.update') }}" class="space-y-6">
        @csrf

        @foreach($slots as $key => $title)
        <div class="card space-y-4">
            <h2 class="font-semibold text-base" style="color:var(--color-brand-dark);">{{ $title }}</h2>

            @if($key !== 'whatsapp_float')
            <div>
                <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">Texto del botón</label>
                <input type="text" name="{{ $key }}_label" value="{{ old($key.'_label', $values[$key]['label'] ?? '') }}" class="input-field">
            </div>
            @endif

            @include('admin.partials.button-fields', [
                'uid' => 'global-' . $key,
                'fields' => [
                    'icon' => "{$key}_icon", 'action_type' => "{$key}_action_type",
                    'url' => "{$key}_url", 'url_target' => "{$key}_url_target",
                    'email_to' => "{$key}_email_to", 'email_subject' => "{$key}_email_subject", 'email_body' => "{$key}_email_body",
                    'whatsapp_message' => "{$key}_whatsapp_message",
                ],
                'cfg' => $values[$key],
            ])
        </div>
        @endforeach

        <div class="flex gap-4 pb-8">
            <button type="submit" class="btn-primary">Guardar cambios</button>
            <a href="{{ route('home') }}" target="_blank" class="btn-outline">Ver en el sitio</a>
        </div>
    </form>
</div>
@endsection
