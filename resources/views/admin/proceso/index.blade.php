@extends('layouts.admin')
@section('title', 'Proceso')
@section('page-title', 'Pasos del proceso')

@section('content')
<div class="flex justify-end mb-4">
    <a href="{{ route('admin.proceso.create') }}" class="btn-primary text-sm py-2.5 px-5">+ Nuevo paso</a>
</div>
<div class="card overflow-hidden p-0">
    <table class="w-full">
        <thead>
            <tr class="border-b border-gray-100">
                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-400 uppercase">Paso</th>
                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-400 uppercase">Título</th>
                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-400 uppercase">Estado</th>
                <th class="px-6 py-4"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($steps as $step)
            <tr class="border-b border-gray-50 hover:bg-gray-50">
                <td class="px-6 py-4">
                    <span class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold text-white" style="background: var(--color-primary);">{{ $step->step_number }}</span>
                </td>
                <td class="px-6 py-4 font-medium text-sm" style="color: var(--color-brand-dark);">{{ $step->title }}</td>
                <td class="px-6 py-4">
                    <span class="text-xs px-2 py-1 rounded-full {{ $step->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $step->is_active ? 'Activo' : 'Inactivo' }}
                    </span>
                </td>
                <td class="px-6 py-4 flex items-center gap-3">
                    <a href="{{ route('admin.proceso.edit', $step) }}" class="text-sm font-medium" style="color: var(--color-primary);">Editar</a>
                    <form method="POST" action="{{ route('admin.proceso.destroy', $step) }}" onsubmit="return confirm('¿Eliminar?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-sm text-red-500">Eliminar</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="px-6 py-10 text-center text-gray-400">No hay pasos.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
