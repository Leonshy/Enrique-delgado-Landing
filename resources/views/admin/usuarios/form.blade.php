@extends('layouts.admin')
@section('title', $user->exists ? 'Editar usuario' : 'Nuevo usuario')
@section('page-title', $user->exists ? 'Editar usuario' : 'Nuevo usuario')

@section('content')
<form method="POST"
      action="{{ $user->exists ? route('admin.usuarios.update', $user) : route('admin.usuarios.store') }}"
      class="space-y-6 max-w-xl">
    @csrf
    @if($user->exists) @method('PUT') @endif

    <div class="card space-y-5">
        <div>
            <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">Nombre</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="input-field">
            @error('name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="input-field">
            @error('email')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="pt-5 border-t border-gray-100">
            <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">
                {{ $user->exists ? 'Nueva contraseña' : 'Contraseña' }}
            </label>
            <p class="text-xs text-gray-400 mb-2">
                @if($user->exists)
                    Dejá vacío si no querés cambiarla.
                @endif
                Mínimo 10 caracteres, con mayúsculas, minúsculas, números y símbolos. No puede ser una contraseña filtrada/conocida.
            </p>
            <input type="password" name="password" autocomplete="new-password" class="input-field" {{ $user->exists ? '' : 'required' }}>
            @error('password')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1" style="color:var(--color-brand-dark);">Confirmar contraseña</label>
            <input type="password" name="password_confirmation" autocomplete="new-password" class="input-field" {{ $user->exists ? '' : 'required' }}>
        </div>
    </div>

    <div class="flex gap-4">
        <button type="submit" class="btn-primary">Guardar</button>
        <a href="{{ route('admin.usuarios.index') }}" class="btn-outline">Cancelar</a>
    </div>
</form>
@endsection
