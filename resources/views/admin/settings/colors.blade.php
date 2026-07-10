@extends('layouts.admin')
@section('title', 'Colores')
@section('page-title', 'Colores del sitio')

@section('content')
<div class="max-w-2xl">
    <p class="text-sm text-gray-400 mb-6">
        Estos colores controlan toda la apariencia del sitio público (botones, títulos, fondos de sección) y del panel admin.
        El blanco no está acá porque se usa como color fijo en varias partes y no se puede reemplazar.
    </p>

    <form method="POST" action="{{ route('admin.settings.colors.update') }}" class="space-y-4">
        @csrf

        <div class="card space-y-5">
            @foreach($roles as $key => $role)
            <div class="flex items-center gap-4 {{ !$loop->last ? 'pb-5 border-b border-gray-100' : '' }}">
                <label class="relative shrink-0 cursor-pointer block overflow-hidden rounded-xl" style="width:3rem;height:3rem;">
                    <input type="color" name="{{ $key }}_picker"
                           value="{{ old($key, $values[$key]) }}"
                           class="absolute inset-0 opacity-0 cursor-pointer"
                           style="width:3rem;height:3rem;"
                           onchange="document.getElementById('{{ $key }}_text').value = this.value.toUpperCase()">
                    <span class="block w-full h-full rounded-xl border border-gray-200" style="background: {{ old($key, $values[$key]) }};"></span>
                </label>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold" style="color: var(--color-brand-dark);">{{ $role['label'] }}</p>
                    <p class="text-xs text-gray-400">{{ $role['description'] }}</p>
                </div>
                <input id="{{ $key }}_text" type="text" name="{{ $key }}"
                       value="{{ old($key, $values[$key]) }}"
                       maxlength="7"
                       pattern="^#[0-9A-Fa-f]{6}$"
                       class="input-field font-mono text-sm text-center shrink-0"
                       style="width:7rem;"
                       oninput="
                           if (/^#[0-9A-Fa-f]{6}$/.test(this.value)) {
                               this.closest('.flex').querySelector('input[type=color]').value = this.value;
                               this.closest('.flex').querySelector('span').style.background = this.value;
                           }
                       ">
                @error($key)<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
            @endforeach
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="btn-primary">Guardar colores</button>
        </div>
    </form>

    <form method="POST" action="{{ route('admin.settings.colors.reset') }}"
          onsubmit="return confirm('¿Restaurar la paleta original? Se perderán los colores personalizados.')"
          class="mt-4">
        @csrf
        <button type="submit" class="btn-outline text-sm">Restaurar paleta por defecto</button>
    </form>
</div>
@endsection
