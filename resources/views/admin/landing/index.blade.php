@extends('layouts.admin')
@section('title', 'Secciones de la Landing')
@section('page-title', 'Secciones de la Landing')

@section('content')
<div class="card overflow-hidden p-0">
    <table class="w-full">
        <thead>
            <tr class="border-b border-gray-100">
                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-400 uppercase">#</th>
                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-400 uppercase">Sección</th>
                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-400 uppercase">Título</th>
                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-400 uppercase">Estado</th>
                <th class="px-6 py-4"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($sections as $section)
            <tr class="border-b border-gray-50 hover:bg-gray-50 transition-colors">
                <td class="px-6 py-4 text-sm text-gray-400">{{ $section->order }}</td>
                <td class="px-6 py-4">
                    <code class="text-xs font-mono px-2 py-1 rounded" style="background: var(--color-brand-muted); color: var(--color-primary);">{{ $section->slug }}</code>
                </td>
                <td class="px-6 py-4 font-medium text-sm" style="color: var(--color-brand-dark);">{{ $section->title }}</td>
                <td class="px-6 py-4">
                    <span class="text-xs px-2 py-1 rounded-full font-medium {{ $section->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $section->is_active ? 'Activa' : 'Inactiva' }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <a href="{{ route('admin.landing.edit', $section) }}" class="text-sm font-medium" style="color: var(--color-primary);">Editar</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
