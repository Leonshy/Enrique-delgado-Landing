@extends('layouts.admin')
@section('title', 'SEO')
@section('page-title', 'Configuración SEO')

@section('content')
<div class="card overflow-hidden p-0">
    <table class="w-full">
        <thead>
            <tr class="border-b border-gray-100">
                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-400 uppercase">Página</th>
                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-400 uppercase">Meta título</th>
                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-400 uppercase">Index</th>
                <th class="px-6 py-4"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($seoSettings as $seo)
            <tr class="border-b border-gray-50 hover:bg-gray-50">
                <td class="px-6 py-4">
                    <code class="text-xs font-mono px-2 py-1 rounded" style="background: var(--color-brand-muted); color: var(--color-primary);">{{ $seo->page }}</code>
                </td>
                <td class="px-6 py-4 text-sm text-gray-600 max-w-xs truncate">{{ $seo->meta_title ?? '—' }}</td>
                <td class="px-6 py-4">
                    <span class="text-xs px-2 py-1 rounded-full {{ !$seo->noindex ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ !$seo->noindex ? 'Indexado' : 'Noindex' }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <a href="{{ route('admin.seo.edit', $seo) }}" class="text-sm font-medium" style="color: var(--color-primary);">Editar</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
