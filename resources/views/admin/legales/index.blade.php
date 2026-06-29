@extends('layouts.admin')
@section('title', 'Páginas legales')
@section('page-title', 'Páginas legales')

@section('content')
<div class="card overflow-hidden p-0">
    <table class="w-full">
        <thead>
            <tr class="border-b border-gray-100">
                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-400 uppercase">Slug</th>
                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-400 uppercase">Título</th>
                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-400 uppercase">Footer</th>
                <th class="px-6 py-4"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($pages as $page)
            <tr class="border-b border-gray-50 hover:bg-gray-50">
                <td class="px-6 py-4">
                    <code class="text-xs font-mono px-2 py-1 rounded" style="background: var(--color-brand-muted); color: var(--color-primary);">/{{ $page->slug }}</code>
                </td>
                <td class="px-6 py-4 font-medium text-sm" style="color: var(--color-brand-dark);">{{ $page->title }}</td>
                <td class="px-6 py-4">
                    <span class="text-xs px-2 py-1 rounded-full {{ $page->show_in_footer ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $page->show_in_footer ? 'Sí' : 'No' }}
                    </span>
                </td>
                <td class="px-6 py-4 flex items-center gap-3">
                    <a href="{{ route('admin.legales.edit', $page) }}" class="text-sm font-medium" style="color: var(--color-primary);">Editar</a>
                    <a href="{{ url($page->slug) }}" target="_blank" class="text-sm text-gray-400 hover:text-gray-600">Ver</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
