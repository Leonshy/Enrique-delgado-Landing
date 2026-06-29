@extends('layouts.public')

@section('content')
<section class="min-h-screen pt-28 pb-20" style="background-color: var(--color-brand-light);">
    <div class="max-w-3xl mx-auto px-6">
        <div class="mb-6">
            <a href="{{ route('home') }}" class="text-sm flex items-center gap-2" style="color: var(--color-primary);">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="15 18 9 12 15 6"/>
                </svg>
                Volver al inicio
            </a>
        </div>
        <div class="card">
            <h1 class="section-title mb-2">{{ $page->title }}</h1>
            <p class="text-xs text-gray-400 mb-8">Última actualización: {{ $page->updated_at->format('d/m/Y') }}</p>
            <div class="prose prose-slate max-w-none leading-relaxed">
                {!! $page->content !!}
            </div>
        </div>
    </div>
</section>
@endsection
