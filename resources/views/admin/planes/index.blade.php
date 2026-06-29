@extends('layouts.admin')
@section('title', 'Planes')
@section('page-title', 'Planes de sesiones')

@section('content')
<div class="flex justify-end mb-4">
    <a href="{{ route('admin.planes.create') }}" class="btn-primary text-sm py-2.5 px-5">+ Nuevo plan</a>
</div>
<div class="grid md:grid-cols-3 gap-4">
    @forelse($plans as $plan)
    <div class="card {{ $plan->is_featured ? 'ring-2' : '' }}" style="{{ $plan->is_featured ? 'outline-color: var(--color-primary);' : '' }}">
        @if($plan->is_featured)
        <span class="text-xs font-bold px-3 py-1 rounded-full text-white mb-3 inline-block" style="background-color: var(--color-primary);">Destacado</span>
        @endif
        <h3 class="font-serif font-semibold text-lg mb-1" style="color: var(--color-brand-dark);">{{ $plan->name }}</h3>
        @if($plan->subtitle)<p class="text-xs font-medium mb-2" style="color: var(--color-primary);">{{ $plan->subtitle }}</p>@endif
        <p class="text-sm text-gray-600 leading-relaxed mb-4">{{ $plan->description }}</p>
        <div class="flex gap-2">
            <a href="{{ route('admin.planes.edit', $plan) }}" class="text-sm font-medium" style="color: var(--color-primary);">Editar</a>
            <span class="text-gray-300">|</span>
            <form method="POST" action="{{ route('admin.planes.destroy', $plan) }}" onsubmit="return confirm('¿Eliminar?')">
                @csrf @method('DELETE')
                <button type="submit" class="text-sm text-red-500">Eliminar</button>
            </form>
        </div>
    </div>
    @empty
    <div class="col-span-3 text-center py-10 text-gray-400">No hay planes.</div>
    @endforelse
</div>
@endsection
