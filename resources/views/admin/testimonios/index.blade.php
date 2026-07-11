@extends('layouts.admin')
@section('title', 'Testimonios')
@section('page-title', 'Testimonios')

@section('content')
@include('admin.partials.section-url', ['anchor' => 'cambio'])

@if(session('success'))
<div class="p-4 rounded-xl text-sm font-medium mb-4" style="background:#d1fae5;color:#065f46;">
    {{ session('success') }}
</div>
@endif

{{-- ── Visibilidad de la sección ── --}}
<div class="card flex items-center justify-between mb-6">
    <div>
        <h2 class="font-semibold text-base" style="color:var(--color-brand-dark);">Visibilidad de la sección</h2>
        <p class="text-sm text-gray-400 mt-1">Si la desactivas, el bloque de testimonios desaparece completamente de la página.</p>
    </div>
    <form method="POST" action="{{ route('admin.testimonios.section.update') }}">
        @csrf @method('PUT')
        <label class="flex items-center gap-2 cursor-pointer shrink-0">
            <input type="checkbox" name="is_active" value="1" onchange="this.form.submit()"
                   {{ ($section?->is_active ?? true) ? 'checked' : '' }}
                   class="w-4 h-4" style="accent-color: var(--color-primary);">
            <span class="text-sm font-medium" style="color: var(--color-brand-dark);">Sección activa</span>
        </label>
    </form>
</div>

<div class="flex items-center justify-between mb-4">
    <p class="text-sm text-gray-400">{{ $testimonials->count() }} testimonio(s) — se muestran como slider en el sitio</p>
    <a href="{{ route('admin.testimonios.create') }}" class="btn-primary text-sm py-2.5 px-5">+ Nuevo testimonio</a>
</div>

<div class="space-y-3">
    @forelse($testimonials as $t)
    <div class="card flex items-start gap-5">
        {{-- Número de orden --}}
        <div class="shrink-0 w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold text-white mt-0.5"
             style="background:var(--color-primary);">
            {{ $loop->iteration }}
        </div>

        {{-- Contenido --}}
        <div class="flex-1 min-w-0">
            <p class="text-sm leading-relaxed mb-1" style="color:var(--color-brand-dark);">
                "{{ Str::limit($t->quote, 160) }}"
            </p>
            @if($t->author)
            <p class="text-xs text-gray-400 font-medium">— {{ $t->author }}</p>
            @endif
        </div>

        {{-- Estado + acciones --}}
        <div class="shrink-0 flex flex-col items-end gap-2">
            <span class="text-xs px-2 py-1 rounded-full {{ $t->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                {{ $t->is_active ? 'Activo' : 'Inactivo' }}
            </span>
            <div class="flex items-center gap-3 mt-1">
                <a href="{{ route('admin.testimonios.edit', $t) }}"
                   class="text-sm font-medium" style="color:var(--color-primary);">Editar</a>
                <form method="POST" action="{{ route('admin.testimonios.destroy', $t) }}"
                      onsubmit="return confirm('¿Eliminar este testimonio?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-sm text-red-500">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="card text-center py-10 text-gray-400">
        <svg class="mx-auto mb-3" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
        <p>No hay testimonios. Crea el primero.</p>
        <a href="{{ route('admin.testimonios.create') }}" class="btn-primary text-sm mt-4 inline-block">+ Agregar testimonio</a>
    </div>
    @endforelse
</div>

<p class="text-xs text-gray-400 mt-4">
    El orden de aparición en el slider corresponde al campo "Orden" de cada testimonio.
</p>
@endsection
