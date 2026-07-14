@extends('layouts.admin')
@section('title', 'Usuarios')
@section('page-title', 'Usuarios del panel')

@section('content')

@if(session('success'))
<div class="p-4 rounded-xl text-sm font-medium mb-4" style="background:#d1fae5;color:#065f46;">
    {{ session('success') }}
</div>
@endif
@if(session('error'))
<div class="p-4 rounded-xl text-sm font-medium mb-4" style="background:#fee2e2;color:#991b1b;">
    {{ session('error') }}
</div>
@endif

<p class="text-sm text-gray-400 mb-6">
    Todos los usuarios tienen acceso completo al panel admin (no hay roles ni permisos diferenciados).
    Creá una cuenta por persona en vez de compartir credenciales, así podés eliminar el acceso de alguien sin afectar al resto.
</p>

<div class="flex items-center justify-between mb-4">
    <h2 class="font-semibold text-base" style="color:var(--color-brand-dark);">Usuarios ({{ $users->count() }})</h2>
    <a href="{{ route('admin.usuarios.create') }}" class="btn-primary text-sm py-2.5 px-5">+ Nuevo usuario</a>
</div>

<div class="card overflow-hidden p-0">
    <table class="w-full">
        <thead>
            <tr class="border-b border-gray-100">
                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-400 uppercase">Nombre</th>
                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-400 uppercase">Email</th>
                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-400 uppercase">Alta</th>
                <th class="px-6 py-4"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr class="border-b border-gray-50 hover:bg-gray-50">
                <td class="px-6 py-4 text-sm font-medium" style="color:var(--color-brand-dark);">
                    {{ $user->name }}
                    @if($user->id === auth()->id())
                    <span class="text-xs px-2 py-0.5 rounded-full ml-1" style="background:var(--color-brand-muted);color:var(--color-brand-dark);">vos</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $user->email }}</td>
                <td class="px-6 py-4 text-sm text-gray-400">{{ $user->created_at->format('d/m/Y') }}</td>
                <td class="px-6 py-4 flex items-center gap-3 justify-end">
                    <a href="{{ route('admin.usuarios.edit', $user) }}" class="text-sm font-medium" style="color:var(--color-primary);">Editar</a>
                    @if($user->id !== auth()->id())
                    <form method="POST" action="{{ route('admin.usuarios.destroy', $user) }}" onsubmit="return confirm('¿Eliminar a {{ $user->name }}?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-sm text-red-500">Eliminar</button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="px-6 py-10 text-center text-gray-400">No hay usuarios.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
