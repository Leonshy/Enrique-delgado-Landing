@extends('layouts.admin')
@section('title', 'Consulta de ' . $message->name)
@section('page-title', 'Detalle de consulta')

@section('content')
<div class="max-w-2xl">
    <div class="mb-4">
        <a href="{{ route('admin.messages.index') }}" class="text-sm flex items-center gap-2" style="color: var(--color-primary);">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
            Volver a consultas
        </a>
    </div>

    <div class="card mb-4">
        <div class="grid md:grid-cols-2 gap-4 mb-6">
            <div>
                <p class="text-xs text-gray-400 uppercase font-semibold mb-1">Nombre</p>
                <p class="font-medium" style="color: var(--color-brand-dark);">{{ $message->name }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase font-semibold mb-1">Fecha</p>
                <p class="font-medium" style="color: var(--color-brand-dark);">{{ $message->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase font-semibold mb-1">Email</p>
                <a href="mailto:{{ $message->email }}" class="font-medium" style="color: var(--color-primary);">{{ $message->email }}</a>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase font-semibold mb-1">Teléfono</p>
                <a href="tel:{{ $message->phone }}" class="font-medium" style="color: var(--color-primary);">{{ $message->phone }}</a>
            </div>
        </div>
        <div>
            <p class="text-xs text-gray-400 uppercase font-semibold mb-2">Mensaje</p>
            <div class="p-4 rounded-xl leading-relaxed" style="background-color: var(--color-brand-light);">
                {{ $message->message }}
            </div>
        </div>
    </div>

    <div class="flex flex-wrap gap-3">
        @if(!$message->responded_at)
        <form method="POST" action="{{ route('admin.messages.responded', $message) }}">
            @csrf @method('PATCH')
            <button type="submit" class="btn-primary text-sm py-2.5 px-5">
                Marcar como respondida
            </button>
        </form>
        @endif

        <a href="mailto:{{ $message->email }}" class="btn-outline text-sm py-2.5 px-5">
            Responder por email
        </a>

        @php
        $waNumber = preg_replace('/[^0-9]/', '', $message->phone);
        $waMsg    = urlencode("Hola {$message->name}, recibí tu consulta y me gustaría comunicarme contigo.");
        @endphp
        <a href="https://wa.me/{{ $waNumber }}?text={{ $waMsg }}" target="_blank" rel="noopener"
           class="btn-outline text-sm py-2.5 px-5">
            Responder por WhatsApp
        </a>

        <form method="POST" action="{{ route('admin.messages.destroy', $message) }}"
              onsubmit="return confirm('¿Eliminar esta consulta? Esta acción no se puede deshacer.')">
            @csrf @method('DELETE')
            <button type="submit" class="text-sm py-2.5 px-5 rounded-full border-2 border-red-300 text-red-500 hover:bg-red-50 transition-colors">
                Eliminar
            </button>
        </form>
    </div>

    @if($message->responded_at)
    <p class="mt-4 text-xs text-green-600 font-medium">
        ✓ Respondida el {{ $message->responded_at->format('d/m/Y H:i') }}
    </p>
    @endif
</div>
@endsection
