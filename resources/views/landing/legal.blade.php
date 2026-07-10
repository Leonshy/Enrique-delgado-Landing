@extends('layouts.public')

@section('content')
<section class="legal-page">
    <div class="container" style="max-width:900px;">
        <a href="{{ route('home') }}" class="legal-back">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="15 18 9 12 15 6"/>
            </svg>
            Volver al inicio
        </a>

        <div class="legal-header">
            <span class="legal-label">Información legal</span>
            <h1 class="legal-title">{{ $page->title }}</h1>
            <span class="legal-updated">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/><polyline points="12,6 12,12 16,14"/>
                </svg>
                Última actualización: {{ $page->updated_at->format('d/m/Y') }}
            </span>
        </div>

        <div class="legal-card">
            <div class="legal-content">
                {!! $page->content !!}
            </div>
        </div>

        <p class="legal-footer-note">
            ¿Tienes dudas sobre este documento? <a href="{{ route('home') }}#contacto">Escríbeme por acá</a>.
        </p>
    </div>
</section>
@endsection
