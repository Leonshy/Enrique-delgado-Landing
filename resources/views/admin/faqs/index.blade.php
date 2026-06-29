@extends('layouts.admin')
@section('title', 'FAQs')
@section('page-title', 'Preguntas Frecuentes')

@section('content')
<div class="flex justify-end mb-4">
    <a href="{{ route('admin.faqs.create') }}" class="btn-primary text-sm py-2.5 px-5">+ Nueva pregunta</a>
</div>
<div class="card overflow-hidden p-0">
    <table class="w-full">
        <thead>
            <tr class="border-b border-gray-100">
                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-400 uppercase">Orden</th>
                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-400 uppercase">Pregunta</th>
                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-400 uppercase">Estado</th>
                <th class="px-6 py-4"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($faqs as $faq)
            <tr class="border-b border-gray-50 hover:bg-gray-50">
                <td class="px-6 py-4 text-sm text-gray-400">{{ $faq->order }}</td>
                <td class="px-6 py-4 text-sm font-medium max-w-sm" style="color: var(--color-brand-dark);">{{ Str::limit($faq->question, 70) }}</td>
                <td class="px-6 py-4">
                    <span class="text-xs px-2 py-1 rounded-full {{ $faq->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $faq->is_active ? 'Activa' : 'Inactiva' }}
                    </span>
                </td>
                <td class="px-6 py-4 flex items-center gap-3">
                    <a href="{{ route('admin.faqs.edit', $faq) }}" class="text-sm font-medium" style="color: var(--color-primary);">Editar</a>
                    <form method="POST" action="{{ route('admin.faqs.destroy', $faq) }}" onsubmit="return confirm('¿Eliminar?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-sm text-red-500 hover:text-red-700">Eliminar</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="px-6 py-10 text-center text-gray-400">No hay preguntas.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
