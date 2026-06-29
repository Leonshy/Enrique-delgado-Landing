@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

{{-- Stats --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="card text-center">
        <p class="text-3xl font-bold mb-1" style="color: var(--color-primary);">{{ $totalMessages }}</p>
        <p class="text-sm text-gray-500">Consultas totales</p>
    </div>
    <div class="card text-center">
        <p class="text-3xl font-bold mb-1 text-amber-500">{{ $unreadMessages }}</p>
        <p class="text-sm text-gray-500">Sin leer</p>
    </div>
    <div class="card text-center">
        <p class="text-3xl font-bold mb-1" style="color: var(--color-primary);">{{ $totalFaqs }}</p>
        <p class="text-sm text-gray-500">Preguntas FAQ</p>
    </div>
    <div class="card text-center">
        <p class="text-3xl font-bold mb-1" style="color: var(--color-primary);">{{ $totalAreas }}</p>
        <p class="text-sm text-gray-500">Áreas de ayuda</p>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-6">

    {{-- Últimas consultas --}}
    <div class="lg:col-span-2 card">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-serif font-semibold text-lg" style="color: var(--color-brand-dark);">Últimas consultas</h2>
            <a href="{{ route('admin.messages.index') }}" class="text-sm" style="color: var(--color-primary);">Ver todas</a>
        </div>
        @forelse($recentMessages as $msg)
        <div class="flex items-start gap-3 py-3 border-b border-gray-50 last:border-0">
            <div class="flex-shrink-0 w-2 h-2 mt-2 rounded-full {{ $msg->is_read ? 'bg-gray-300' : '' }}"
                 style="{{ !$msg->is_read ? 'background-color: var(--color-primary);' : '' }}"></div>
            <div class="flex-1 min-w-0">
                <p class="font-medium text-sm truncate" style="color: var(--color-brand-dark);">{{ $msg->name }}</p>
                <p class="text-xs text-gray-400 truncate">{{ $msg->email }}</p>
                <p class="text-xs text-gray-500 mt-1 line-clamp-1">{{ Str::limit($msg->message, 60) }}</p>
            </div>
            <div class="text-right flex-shrink-0">
                <p class="text-xs text-gray-400">{{ $msg->created_at->diffForHumans() }}</p>
                <a href="{{ route('admin.messages.show', $msg) }}" class="text-xs font-medium" style="color: var(--color-primary);">Ver</a>
            </div>
        </div>
        @empty
        <p class="text-sm text-gray-400 text-center py-6">Aún no hay consultas.</p>
        @endforelse
    </div>

    {{-- Quick links --}}
    <div class="card">
        <h2 class="font-serif font-semibold text-lg mb-4" style="color: var(--color-brand-dark);">Accesos rápidos</h2>
        <div class="space-y-2">
            <a href="{{ route('admin.landing.index') }}" class="admin-sidebar-link">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                Editar secciones
            </a>
            <a href="{{ route('admin.faqs.create') }}" class="admin-sidebar-link">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
                Nueva FAQ
            </a>
            <a href="{{ route('admin.areas.create') }}" class="admin-sidebar-link">
                Nueva área de ayuda
            </a>
            <a href="{{ route('admin.settings.general') }}" class="admin-sidebar-link">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/></svg>
                Configuración
            </a>
            <a href="{{ route('admin.settings.integrations') }}" class="admin-sidebar-link">
                Integraciones
            </a>
            <a href="{{ route('admin.media.index') }}" class="admin-sidebar-link">
                Multimedia
            </a>
        </div>
    </div>
</div>

@endsection
