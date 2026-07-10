@extends('layouts.public')

@section('content')

{{-- ════════════════════════════════════════════════════════
     HERO
════════════════════════════════════════════════════════ --}}
@php
    $hero      = $sections['hero'] ?? null;
    $heroExtra = json_decode($hero?->extra ?? '{}', true) ?: [];
    $heroBadgeEnabled  = $heroExtra['cert_badge_enabled'] ?? true;
    $heroBadgeTitle    = $heroExtra['cert_badge_title']    ?? 'Certificado';
    $heroBadgeSubtitle = $heroExtra['cert_badge_subtitle'] ?? 'Psicólogo Clínico';
@endphp
<section id="inicio" class="hero">
    <img src="{{ $hero?->image_path ? asset('storage/'.$hero->image_path) : asset('images/enrique-hero-nobg.png') }}"
         alt="{{ $hero?->image_alt ?? 'Enrique Delgado, El Psicólogo del Cambio' }}"
         class="hero-person">
    <div class="hero-bottom-fade"></div>

    @if($heroBadgeEnabled)
    <div class="hero-cert-badge">
        <div class="hero-cert-badge-icon">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22,4 12,14.01 9,11.01"/></svg>
        </div>
        <div>
            <strong>{{ $heroBadgeTitle }}</strong>
            <span>{{ $heroBadgeSubtitle }}</span>
        </div>
    </div>
    @endif

    <div class="hero-content">
        <div class="hero-badge">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
            {{ $hero?->subtitle ?? 'PSICÓLOGO CLÍNICO · PARAGUAY' }}
        </div>

        <h1>
            {!! $hero ? nl2br(e($hero->title)) : 'El Psicólogo del Cambio' !!}
        </h1>

        <p class="hero-desc">
            {{ $hero?->body ?? 'Acompaño a personas que quieren transformar su vida emocional y construir una versión más plena, libre y auténtica de sí mismas.' }}
        </p>

        <div class="hero-actions">
            <a href="{{ $hero?->cta_url ?? '#contacto' }}" class="btn-primary">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/></svg>
                {{ $hero?->cta_text ?? 'Quiero solicitar una consulta' }}
            </a>
            <a href="{{ $heroExtra['btn2_url'] ?? $settings['whatsappUrl'] }}" target="_blank" rel="noopener" class="btn-outline">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                {{ $heroExtra['btn2_text'] ?? 'Escribir por WhatsApp' }}
            </a>
        </div>
    </div>
</section>


{{-- ════════════════════════════════════════════════════════
     PROCESO
════════════════════════════════════════════════════════ --}}
@php
    $proceso      = $sections['proceso'] ?? null;
    $procesoExtra = json_decode($proceso?->extra ?? '{}', true) ?: [];
    $procesoLabel = $procesoExtra['label'] ?? 'Cómo trabajamos';
    $procesoIconPaths = [
        'message'  => 'M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z',
        'calendar' => 'M9 3H5a2 2 0 0 0-2 2v4m6-6h10a2 2 0 0 1 2 2v4M9 3v18m0 0h10a2 2 0 0 0 2-2V9M9 21H5a2 2 0 0 1-2-2V9m0 0h18',
        'check'    => 'M22 11.08V12a10 10 0 1 1-5.93-9.14M22 4L12 14.01l-3-3',
        'bolt'     => 'M13 2L3 14h9l-1 8 10-12h-9l1-8z',
        'heart'    => 'M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z',
        'users'    => 'M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2M9 7a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75',
        'star'     => 'M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z',
        'shield'   => 'M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z',
        'activity' => 'M22 12h-4l-3 9L9 3l-3 9H2',
        'trending' => 'M23 6l-9.5 9.5-5-5L1 18',
        'sun'      => 'M12 2v2M12 20v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M2 12h2M20 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42M12 6a6 6 0 1 0 0 12A6 6 0 0 0 12 6z',
        'eye'      => 'M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8zM12 9a3 3 0 1 0 0 6 3 3 0 0 0 0-6z',
    ];
    $defaultIconPaths = [
        'M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z',
        'M9 3H5a2 2 0 0 0-2 2v4m6-6h10a2 2 0 0 1 2 2v4M9 3v18m0 0h10a2 2 0 0 0 2-2V9M9 21H5a2 2 0 0 1-2-2V9m0 0h18',
        'M22 11.08V12a10 10 0 1 1-5.93-9.14M22 4L12 14.01l-3-3',
        'M13 2L3 14h9l-1 8 10-12h-9l1-8z',
    ];
@endphp
@if($proceso?->is_active ?? true)
<section id="proceso" class="proceso-section">
    <div class="proceso-deco"></div>
    <div class="proceso-deco-2"></div>
    <div class="container">
        <div style="text-align:center;margin-bottom:4rem;" class="reveal">
            <span class="section-label light">{{ $procesoLabel }}</span>
            <h2 class="section-title light" style="margin-bottom:1rem;">
                {{ $proceso?->title ?? 'El proceso de cambio' }}
            </h2>
            @if($proceso?->subtitle)
            <p style="color:rgba(255,255,255,0.55);font-size:1.0625rem;max-width:520px;margin:0 auto;line-height:1.75;">
                {{ $proceso->subtitle }}
            </p>
            @else
            <p style="color:rgba(255,255,255,0.55);font-size:1.0625rem;max-width:520px;margin:0 auto;line-height:1.75;">
                Un camino claro, paso a paso, para que sepas exactamente qué esperar desde el primer día.
            </p>
            @endif
        </div>

        @php
        $defaultSteps = [
            ['Completa el formulario inicial',  'Cuéntanos brevemente tu situación para que podamos preparar la primera consulta.',                              'M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z'],
            ['Primer contacto por WhatsApp',    'Nos ponemos en contacto para resolver dudas y confirmar disponibilidad.',                                        'M9 3H5a2 2 0 0 0-2 2v4m6-6h10a2 2 0 0 1 2 2v4M9 3v18m0 0h10a2 2 0 0 0 2-2V9M9 21H5a2 2 0 0 1-2-2V9m0 0h18'],
            ['Reserva de turno',                'Elegís el horario que mejor se adapta a tu agenda y reservas tu primera sesión.',                                'M22 11.08V12a10 10 0 1 1-5.93-9.14M22 4L12 14.01l-3-3'],
            ['Primera sesión',                  'Nos conocemos, exploramos tu situación y definimos juntos el camino a seguir.',                                  'M13 2L3 14h9l-1 8 10-12h-9l1-8z'],
        ];
        @endphp

        <div class="timeline">
            <div class="timeline-track">
                @forelse($steps as $step)
                @php
                    $iconPath = ($step->icon && isset($procesoIconPaths[$step->icon]))
                        ? $procesoIconPaths[$step->icon]
                        : $defaultIconPaths[$loop->index % 4];
                @endphp
                <div class="timeline-item reveal delay-{{ $loop->index + 1 }}">
                    <div class="timeline-node">
                        <span class="timeline-node-num">{{ str_pad($step->step_number, 2, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <div class="timeline-connector"></div>
                    <div class="timeline-card">
                        <div class="timeline-card-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="{{ $iconPath }}"/>
                            </svg>
                        </div>
                        <h3>{{ $step->title }}</h3>
                        @if($step->description)
                        <p>{{ Str::limit($step->description, 120) }}</p>
                        @endif
                    </div>
                </div>
                @empty
                @foreach($defaultSteps as $i => $s)
                <div class="timeline-item reveal delay-{{ $i + 1 }}">
                    <div class="timeline-node">
                        <span class="timeline-node-num">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <div class="timeline-connector"></div>
                    <div class="timeline-card">
                        <div class="timeline-card-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="{{ $s[2] }}"/>
                            </svg>
                        </div>
                        <h3>{{ $s[0] }}</h3>
                        <p>{{ $s[1] }}</p>
                    </div>
                </div>
                @endforeach
                @endforelse
            </div>
        </div>
    </div>
</section>
@endif


{{-- ════════════════════════════════════════════════════════
     VIDEO
════════════════════════════════════════════════════════ --}}
@php
    $video      = $sections['video'] ?? null;
    $videoExtra = json_decode($video?->extra ?? '{}', true) ?: [];
    $videoId    = \App\Helpers\YoutubeHelper::extractId($videoExtra['video_url'] ?? null);
    $videoLabel = $videoExtra['label'] ?? 'Video';
@endphp
@if(($video?->is_active ?? false) && $videoId)
<section id="video" class="section" style="background:#fff;">
    <div class="container">
        <div style="text-align:center;margin-bottom:3rem;" class="reveal">
            <span class="section-label">{{ $videoLabel }}</span>
            <h2 class="section-title" style="margin-bottom:1rem;">
                {{ $video->title ?? 'Mirá cómo trabajo' }}
            </h2>
            @if($video->subtitle)
            <p class="section-subtitle" style="margin:0 auto;">
                {{ $video->subtitle }}
            </p>
            @endif
        </div>

        <div class="video-embed-wrap reveal">
            <iframe
                src="https://www.youtube-nocookie.com/embed/{{ $videoId }}"
                title="{{ $video->title ?? 'Video' }}"
                loading="lazy"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                allowfullscreen></iframe>
        </div>
    </div>
</section>
@endif


{{-- ════════════════════════════════════════════════════════
     ENFOQUE
════════════════════════════════════════════════════════ --}}
@php
    $enfoque        = $sections['enfoque'] ?? null;
    $enfoqueExtra   = json_decode($enfoque?->extra ?? '{}', true) ?: [];
    $enfoqueLabel   = $enfoqueExtra['label']   ?? 'Mi enfoque';
    $enfoquePillars = $enfoqueExtra['pillars'] ?? [
        ['title' => 'Alianza terapéutica sólida',          'desc' => 'Un espacio seguro y confidencial donde puedes ser completamente honesto/a.'],
        ['title' => 'Objetivos claros desde el principio', 'desc' => 'Definimos juntos hacia dónde vamos y cómo mediremos el progreso.'],
        ['title' => 'Herramientas para la vida diaria',    'desc' => 'Técnicas concretas que puedes aplicar fuera de la sesión, desde el primer día.'],
    ];
@endphp
@if($enfoque?->is_active ?? true)
<section id="enfoque" class="section" style="background:#fff;">
    <div class="container">
        <div class="enfoque-grid">

            <div class="enfoque-img-wrap reveal-left">
                <img src="{{ $enfoque?->image_path ? asset('storage/'.$enfoque->image_path) : asset('images/enrique-vessel.jpg') }}"
                     alt="{{ $enfoque?->image_alt ?? 'Enrique Delgado — psicólogo del cambio' }}">
                <div class="enfoque-img-deco"></div>
            </div>

            <div class="reveal-right">
                <span class="section-label">{{ $enfoqueLabel }}</span>
                <h2 class="section-title" style="margin-bottom:1.25rem;">
                    {!! $enfoque ? nl2br(e($enfoque->title)) : 'Mi Enfoque' !!}
                </h2>
                @php
                    $enfoqueDescHtml = $enfoque?->subtitle ?: '<p>Las acciones por sobre las palabras.</p><p>Trabajo desde una perspectiva sistémica e integradora. Esto significa que no observo únicamente el problema que te trae a consulta, sino también el contexto en el que ocurre.</p><p>El bienestar emocional no depende solamente de cómo pensamos. También depende de cómo actuamos, cómo nos relacionamos y qué hábitos construimos día a día.</p><p>Por eso la terapia no se limita a comprender los problemas. También busca generar cambios concretos y observables en tu vida cotidiana.</p>';
                @endphp
                <div class="rich-text" style="margin-bottom:1.25rem;">
                    {!! $enfoqueDescHtml !!}
                </div>

                <ul class="pillar-list">
                    @foreach($enfoquePillars as $pillar)
                    <li class="pillar-item">
                        <div class="pillar-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22,4 12,14.01 9,11.01"/></svg>
                        </div>
                        <div class="pillar-text">
                            <strong>{{ $pillar['title'] }}</strong>
                            <span>{{ $pillar['desc'] }}</span>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>
@endif


{{-- ════════════════════════════════════════════════════════
     ÁREAS DE AYUDA
════════════════════════════════════════════════════════ --}}
@php
    $areasSection = $sections['areas'] ?? null;
    $areasExtra   = json_decode($areasSection?->extra ?? '{}', true) ?: [];
    $areasLabel   = $areasExtra['label'] ?? '¿En qué puedo ayudarte?';
    $areasIconPaths = [
        'shield'   => 'M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z',
        'heart'    => 'M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z',
        'users'    => 'M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2M9 7a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75',
        'star'     => 'M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z',
        'home'     => 'M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z',
        'activity' => 'M22 12h-4l-3 9L9 3l-3 9H2',
        'box'      => 'M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z',
        'check'    => 'M22 11.08V12a10 10 0 1 1-5.93-9.14M22 4L12 14.01l-3-3',
        'eye'      => 'M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8zM12 9a3 3 0 1 0 0 6 3 3 0 0 0 0-6z',
        'bolt'     => 'M13 2L3 14h9l-1 8 10-12h-9l1-8z',
        'trending' => 'M23 6l-9.5 9.5-5-5L1 18',
        'sun'      => 'M12 2v2M12 20v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M2 12h2M20 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42M12 6a6 6 0 1 0 0 12A6 6 0 0 0 12 6z',
        'default'  => 'M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z',
    ];
    $defaultAreas = [
        ['title'=>'Ansiedad y estrés',     'description'=>'Estrategias para gestionar la ansiedad y el estrés crónico del día a día.',                      'icon'=>'shield'],
        ['title'=>'Depresión y ánimo bajo', 'description'=>'Acompañamiento en momentos de tristeza profunda, desmotivación o vacío emocional.',              'icon'=>'heart'],
        ['title'=>'Relaciones y vínculos',  'description'=>'Trabajo en patrones relacionales que se repiten y generan sufrimiento.',                          'icon'=>'users'],
        ['title'=>'Autoestima e identidad', 'description'=>'Construcción de una autoimagen más sana, sólida y compasiva.',                                   'icon'=>'star'],
        ['title'=>'Duelo y pérdidas',       'description'=>'Acompañamiento en procesos de pérdida: personas, proyectos, etapas de vida.',                    'icon'=>'home'],
        ['title'=>'Trauma y PTSD',          'description'=>'Procesamiento de experiencias traumáticas con técnicas especializadas y seguras.',                'icon'=>'activity'],
        ['title'=>'Desarrollo personal',    'description'=>'Para quienes no atraviesan una crisis, pero quieren crecer y mejorar.',                          'icon'=>'trending'],
        ['title'=>'Manejo de emociones',    'description'=>'Regulación emocional: aprender a sentir sin que las emociones te desborden.',                    'icon'=>'check'],
        ['title'=>'Miedos y fobias',        'description'=>'Tratamiento de miedos específicos que limitan tu calidad de vida y tus decisiones.',             'icon'=>'eye'],
    ];
@endphp
@if($areasSection?->is_active ?? true)
<section id="areas" class="section" style="background:var(--color-brand-muted);">
    <div class="container">
        <div style="text-align:center;margin-bottom:3.5rem;" class="reveal">
            <span class="section-label">{{ $areasLabel }}</span>
            <h2 class="section-title" style="margin-bottom:1rem;">
                {{ $areasSection?->title ?? 'Áreas de acompañamiento' }}
            </h2>
            <p class="section-subtitle" style="margin:0 auto;">
                {{ $areasSection?->subtitle ?? 'Trabajo con personas que enfrentan distintos desafíos. Si tu situación no aparece aquí, escríbeme: seguramente podemos trabajarla.' }}
            </p>
        </div>

        <div class="areas-grid">
            @forelse($areas as $area)
            <div class="area-card reveal delay-{{ ($loop->index % 3) + 1 }}">
                <div class="area-card-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="{{ $areasIconPaths[$area->icon ?? 'default'] ?? $areasIconPaths['default'] }}"/>
                    </svg>
                </div>
                <h3>{{ $area->title }}</h3>
                @if($area->description)
                <p>{{ Str::limit($area->description, 100) }}</p>
                @endif
            </div>
            @empty
            @foreach($defaultAreas as $i => $a)
            <div class="area-card reveal delay-{{ ($i % 3) + 1 }}">
                <div class="area-card-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="{{ $areasIconPaths[$a['icon']] }}"/>
                    </svg>
                </div>
                <h3>{{ $a['title'] }}</h3>
                <p>{{ $a['description'] }}</p>
            </div>
            @endforeach
            @endforelse
        </div>
    </div>
</section>
@endif


{{-- ════════════════════════════════════════════════════════
     SOBRE MÍ
════════════════════════════════════════════════════════ --}}
@php
    $sobremi       = $sections['sobre-mi'] ?? null;
    $sobremiExtra  = json_decode($sobremi?->extra ?? '{}', true) ?: [];
    $sobremiLabel  = $sobremiExtra['label']          ?? 'Sobre mí';
    $sobremiStats  = $sobremiExtra['stats']          ?? [
        ['value' => '10+',  'label' => 'Años de práctica'],
        ['value' => '500+', 'label' => 'Pacientes'],
        ['value' => '3',    'label' => 'Países de formación'],
    ];
@endphp
@if($sobremi?->is_active ?? true)
<section id="sobre-mi" class="section" style="background:#fff;overflow:hidden;">
    <div class="container">
        <div class="sobre-mi-grid">

            {{-- Texto --}}
            <div class="reveal-left">
                <span class="section-label">{{ $sobremiLabel }}</span>
                <h2 class="section-title" style="margin-bottom:1.25rem;">
                    {!! $sobremi ? nl2br(e($sobremi->title)) : 'Enrique Delgado,<br>el psicólogo del cambio' !!}
                </h2>
                <p class="section-subtitle" style="margin-bottom:1.25rem;">
                    {{ $sobremi?->subtitle ?? 'Soy psicólogo clínico especializado en psicoterapia cognitivo-conductual y procesos de cambio personal.' }}
                </p>

                <div class="rich-text" style="margin-bottom:1rem;">
                    @if($sobremi?->body)
                        {!! $sobremi->body !!}
                    @else
                    <p>Me formé en Paraguay, Argentina y España, y durante más de 10 años he acompañado a personas de distintas culturas y contextos a transformar aspectos de su vida que sentían estancados o dolorosos.</p>
                    <p>Mi trabajo está basado en la evidencia científica, pero siempre adaptado a la persona que tengo enfrente. Porque no hay dos procesos iguales.</p>
                    @endif
                </div>

                {{-- Stats --}}
                <div class="stats-row">
                    @foreach($sobremiStats as $stat)
                    @php
                        preg_match('/^(\d+)(.*)$/', $stat['value'] ?? '0', $m);
                        $statNum    = $m[1] ?? 0;
                        $statSuffix = $m[2] ?? '';
                    @endphp
                    <div class="stat-item">
                        <span class="stat-num"
                              data-counter="{{ $statNum }}"
                              @if($statSuffix) data-suffix="{{ $statSuffix }}" @endif>
                            {{ $stat['value'] ?? '0' }}
                        </span>
                        <span class="stat-label">{{ $stat['label'] ?? '' }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Foto PNG sin fondo --}}
            <div class="sobre-mi-photo sobre-mi-photo-col reveal-right" style="position:relative;">
                <div class="sobre-mi-photo-deco"></div>
                <div class="sobre-mi-photo-frame">
                    <img src="{{ $sobremi && $sobremi->image_path ? asset('storage/'.$sobremi->image_path) : asset('images/enrique-pro-nobg.png') }}"
                         alt="{{ $sobremi?->image_alt ?? 'Enrique Delgado — Psicólogo Clínico' }}">
                </div>
            </div>

        </div>
    </div>
</section>
@endif


{{-- ════════════════════════════════════════════════════════
     TESTIMONIOS / QUOTE (dark, Calmind-style)
════════════════════════════════════════════════════════ --}}
@php
$defaultTestimonials = [
    ['quote' => 'Llegué sin esperanza de que algo pudiera cambiar. Hoy tengo herramientas reales y una perspectiva completamente diferente de mi vida. El proceso fue duro pero absolutamente transformador.', 'author' => 'Paciente anónimo — proceso de 6 meses'],
    ['quote' => 'Enrique me ayudó a entender patrones que repetía desde hace años sin darme cuenta. Fue como encender una luz en una habitación oscura. Lo recomiendo sin dudar.', 'author' => 'Paciente anónimo — ansiedad y autoestima'],
    ['quote' => 'Nunca pensé que la psicología pudiera ser tan práctica. Salí de cada sesión con algo concreto para aplicar. Eso marcó una diferencia enorme en mi día a día.', 'author' => 'Paciente anónimo — estrés laboral'],
];
$activeTestimonials = $testimonials->count() ? $testimonials : collect($defaultTestimonials)->map(fn($t) => (object)$t);
@endphp
@if($sections['cambio']->is_active ?? true)
<section class="quote-section">

    <div class="container">
        <div class="quote-content reveal-left">
            <div class="quote-icon">
                <svg width="52" height="52" viewBox="0 0 24 24" fill="currentColor"><path d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1 0 1 1v1c0 1-1 2-2 2s-1 .008-1 1.031V20c0 1 0 1 1 1z"/><path d="M15 21c3 0 7-1 7-8V5c0-1.25-.757-2.017-2-2h-4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2h.75c0 2.25.25 4-2.75 4v3c0 1 0 1 1 1z"/></svg>
            </div>

            @foreach($activeTestimonials as $i => $t)
            <div class="testimonial-item" style="{{ $i > 0 ? 'display:none;' : '' }}transition:opacity 0.5s;">
                <p class="quote-text">"{{ $t->quote }}"</p>
                @if($t->author)
                <div class="quote-author">
                    <div class="quote-author-line"></div>
                    <span class="quote-author-name">{{ $t->author }}</span>
                </div>
                @endif
            </div>
            @endforeach

            @if($activeTestimonials->count() > 1)
            <div class="quote-dots">
                @foreach($activeTestimonials as $i => $t)
                <button class="quote-dot {{ $i === 0 ? 'active' : '' }}" aria-label="Testimonio {{ $i + 1 }}"></button>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</section>
@endif


{{-- ════════════════════════════════════════════════════════
     PLANES
════════════════════════════════════════════════════════ --}}
@php
    $planesSection = $sections['planes'] ?? null;
    $planesExtra   = json_decode($planesSection?->extra ?? '{}', true) ?: [];
    $planesLabel   = $planesExtra['label']       ?? 'Inversión en ti';
    $planesFooter  = $planesExtra['footer_note'] ?? 'Los precios se informan en la consulta inicial. Primera sesión gratuita y sin compromiso.';
    $whatsappBase  = 'https://wa.me/' . preg_replace('/[^0-9]/', '', $settings['whatsapp'] ?? '595981000000');
@endphp
@if($planesSection?->is_active ?? true)
<section id="planes" class="section" style="background:#fff;">
    <div class="container">
        <div style="text-align:center;margin-bottom:3.5rem;" class="reveal">
            <span class="section-label">{{ $planesLabel }}</span>
            <h2 class="section-title" style="margin-bottom:1rem;">
                {{ $planesSection?->title ?? 'Planes de acompañamiento' }}
            </h2>
            <p class="section-subtitle" style="margin:0 auto;">
                {{ $planesSection?->subtitle ?? 'Cada plan está pensado para distintos momentos y necesidades. Si tienes dudas, podemos conversarlas en la consulta inicial gratuita.' }}
            </p>
        </div>

        <div class="planes-grid">
            @forelse($plans as $plan)
            @php
                $planWaUrl = $plan->whatsapp_text
                    ? $whatsappBase . '?text=' . urlencode($plan->whatsapp_text)
                    : $settings['whatsappUrl'];
            @endphp
            <div class="plan-card {{ $plan->is_featured ? 'featured' : '' }} reveal delay-{{ $loop->iteration }}">
                @if($plan->is_featured)
                <div class="plan-badge">Más elegido</div>
                @endif
                <div class="plan-name">{{ $plan->name }}</div>
                @if($plan->subtitle)
                <p class="plan-subtitle-tag">{{ $plan->subtitle }}</p>
                @endif
                @if($plan->price)
                <div class="plan-price-row">
                    <span class="plan-price-amount">{{ $plan->price }}</span>
                    @if($plan->period)
                    <span class="plan-price-period">/ {{ $plan->period }}</span>
                    @endif
                </div>
                @endif
                @if($plan->description)
                <div class="plan-description rich-text">{!! $plan->description !!}</div>
                @endif
                <a href="{{ $planWaUrl }}" target="_blank" rel="noopener" class="plan-cta">
                    {{ $plan->cta_label ?? 'Comenzar ahora' }}
                </a>
            </div>
            @empty
            @foreach([
                ['1 sesión',   false, 'Para explorar tu situación o resolver una duda puntual.',     null],
                ['5 sesiones', true,  'Para quienes quieren iniciar un proceso de cambio real.',      'Hola, me interesa el plan de 5 sesiones. ¿Podemos hablar?'],
                ['10 sesiones',false, 'Para un acompañamiento sostenido a lo largo del tiempo.',      null],
            ] as $i => $p)
            @php
                $defWaUrl = $p[3]
                    ? $whatsappBase . '?text=' . urlencode($p[3])
                    : $settings['whatsappUrl'];
            @endphp
            <div class="plan-card {{ $p[1] ? 'featured' : '' }} reveal delay-{{ $i + 1 }}">
                @if($p[1])<div class="plan-badge">Más elegido</div>@endif
                <div class="plan-name">{{ $p[0] }}</div>
                <p class="plan-description">{{ $p[2] }}</p>
                <a href="{{ $defWaUrl }}" target="_blank" rel="noopener" class="plan-cta">Comenzar ahora</a>
            </div>
            @endforeach
            @endforelse
        </div>

        @if($planesFooter)
        <p style="text-align:center;margin-top:2.5rem;font-size:0.875rem;color:color-mix(in srgb, var(--color-brand-dark) 44%, white);" class="reveal">
            {{ $planesFooter }}
        </p>
        @endif
    </div>
</section>
@endif


{{-- ════════════════════════════════════════════════════════
     FAQ
════════════════════════════════════════════════════════ --}}
@php
    $faqSection = $sections['faq'] ?? null;
    $faqExtra   = json_decode($faqSection?->extra ?? '{}', true) ?: [];
    $faqLabel   = $faqExtra['label'] ?? 'Respuestas';
@endphp
@if($faqSection?->is_active ?? true)
<section id="faq" class="section" style="background:var(--color-brand-muted);">
    <div class="container">
        <div style="text-align:center;margin-bottom:3.5rem;" class="reveal">
            <span class="section-label">{{ $faqLabel }}</span>
            <h2 class="section-title" style="margin-bottom:1rem;">
                {{ $faqSection?->title ?? 'Preguntas frecuentes' }}
            </h2>
            <p class="section-subtitle" style="margin:0 auto;">
                {{ $faqSection?->subtitle ?? 'Si tu pregunta no está aquí, puedes escribirme directamente. Siempre respondo.' }}
            </p>
        </div>

        <div class="faq-grid">
            {{-- Columna izquierda --}}
            <div>
                @php $faqLeft = $faqs->take(ceil($faqs->count() / 2)); @endphp
                @forelse($faqLeft as $faq)
                <div class="faq-item reveal" style="margin-bottom:0.875rem;">
                    <div class="faq-question">
                        <span>{{ $faq->question }}</span>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-inner rich-text">{!! $faq->answer !!}</div>
                    </div>
                </div>
                @empty
                @foreach([
                    ['¿Cómo sé si necesito ir a un psicólogo?', 'Si algo en tu vida te genera malestar sostenido — sea emocional, relacional, conductual o existencial — probablemente te beneficiaría hablar con un profesional. No hace falta estar en crisis para iniciar un proceso.'],
                    ['¿Cuánto dura una sesión?', 'Las sesiones individuales tienen una duración de 50 a 60 minutos. Este tiempo está pensado para que haya espacio de exploración real sin que resulte agotador.'],
                    ['¿Trabajas de forma online?', 'Sí. Trabajo tanto de manera presencial como online a través de videollamada. El formato online no compromete la calidad del proceso terapéutico.'],
                    ['¿Cuántas sesiones voy a necesitar?', 'Depende del motivo de consulta y de los objetivos. Algunos procesos duran 8-12 sesiones; otros son más largos. Lo definimos juntos de forma honesta al inicio.'],
                ] as $q)
                <div class="faq-item reveal" style="margin-bottom:0.875rem;">
                    <div class="faq-question">
                        <span>{{ $q[0] }}</span>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">{{ $q[1] }}</div>
                    </div>
                </div>
                @endforeach
                @endforelse
            </div>

            {{-- Columna derecha --}}
            <div>
                @php $faqRight = $faqs->skip(ceil($faqs->count() / 2)); @endphp
                @forelse($faqRight as $faq)
                <div class="faq-item reveal delay-2" style="margin-bottom:0.875rem;">
                    <div class="faq-question">
                        <span>{{ $faq->question }}</span>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-inner rich-text">{!! $faq->answer !!}</div>
                    </div>
                </div>
                @empty
                @foreach([
                    ['¿La información que comparto es confidencial?', 'Absolutamente. Todo lo que conversemos está protegido por el secreto profesional. Solo hay excepciones muy específicas contempladas en la ley (riesgo de vida).'],
                    ['¿Cuál es el costo de las sesiones?', 'Los honorarios se informan en la primera consulta, que es gratuita. El valor varía según el plan elegido y la modalidad de trabajo.'],
                    ['¿Con qué enfoque trabajas?', 'Mi base es la Terapia Cognitivo-Conductual (TCC), complementada con ACT, mindfulness, técnicas narrativas y herramientas de neurociencia aplicada.'],
                    ['¿Cómo puedo empezar?', 'Simplemente escríbeme por WhatsApp o completa el formulario de contacto. Coordinamos una primera sesión gratuita para conocernos y evaluar cómo puedo ayudarte.'],
                ] as $q)
                <div class="faq-item reveal delay-2" style="margin-bottom:0.875rem;">
                    <div class="faq-question">
                        <span>{{ $q[0] }}</span>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">{{ $q[1] }}</div>
                    </div>
                </div>
                @endforeach
                @endforelse
            </div>
        </div>
    </div>
</section>
@endif


{{-- ════════════════════════════════════════════════════════
     CTA BANNER
════════════════════════════════════════════════════════ --}}
@php
    $ctaSection = $sections['primer-paso'] ?? null;
    $ctaExtra   = json_decode($ctaSection?->extra ?? '{}', true) ?: [];
    $ctaLabel   = $ctaExtra['label']     ?? 'El primer paso';
    $ctaBtn1    = $ctaExtra['btn1_text'] ?? 'Solicitar sesión gratuita';
    $ctaBtn1Url = $ctaExtra['btn1_url']  ?? '#contacto';
    $ctaBtn2    = $ctaExtra['btn2_text'] ?? 'Escribir por WhatsApp';
@endphp
@if($ctaSection?->is_active ?? true)
<section class="cta-banner">
    <div class="container" style="position:relative;z-index:1;text-align:center;">
        <div class="reveal">
            <span class="section-label light" style="margin-bottom:1.25rem;">{{ $ctaLabel }}</span>
            <h2 class="section-title light" style="margin-bottom:1.25rem;">
                {!! $ctaSection ? nl2br(e($ctaSection->title)) : '¿Listo para comenzar<br>tu proceso de cambio?' !!}
            </h2>
            <p style="color:rgba(255,255,255,0.7);font-size:1.0625rem;max-width:480px;margin:0 auto 2.5rem;line-height:1.75;">
                {{ $ctaSection?->subtitle ?? 'La primera sesión es gratuita. Sin compromisos. Solo una conversación para ver si podemos trabajar juntos.' }}
            </p>
            <div style="display:flex;flex-wrap:wrap;gap:1rem;justify-content:center;">
                <a href="{{ $ctaBtn1Url }}" class="btn-white">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/></svg>
                    {{ $ctaBtn1 }}
                </a>
                <a href="{{ $settings['whatsappUrl'] }}" target="_blank" rel="noopener" class="btn-outline-light">
                    {{ $ctaBtn2 }}
                </a>
            </div>
        </div>
    </div>
</section>
@endif


{{-- ════════════════════════════════════════════════════════
     CONTACTO
════════════════════════════════════════════════════════ --}}
@php
    $contacto      = $sections['contacto'] ?? null;
    $contactoExtra = json_decode($contacto?->extra ?? '{}', true) ?: [];
    $contactoLabel = $contactoExtra['label']     ?? 'Hablemos';
    $contactoBoxTitle = $contactoExtra['box_title'] ?? 'Primera sesión';
    $contactoBoxBody  = $contactoExtra['box_body']  ?? 'La primera sesión es **gratuita y sin compromiso**. Es el espacio para conocernos, contarme lo que estás viviendo y evaluar si puedo ayudarte.';
    $contactoBoxHtml  = preg_replace('/\*\*(.+?)\*\*/u', '<strong style="color:var(--color-brand-dark);">$1</strong>', e($contactoBoxBody));
@endphp
<section id="contacto" class="section" style="background:#fff;">
    <div class="container">
        <div style="text-align:center;margin-bottom:3.5rem;" class="reveal">
            <span class="section-label">{{ $contactoLabel }}</span>
            <h2 class="section-title" style="margin-bottom:1rem;">
                {{ $contacto?->title ?? 'Formulario de Contacto' }}
            </h2>
            <p class="section-subtitle" style="margin:0 auto;">
                {{ $contacto?->subtitle ?? 'Completa el siguiente formulario y me pondré en contacto contigo a la brevedad para conocer mejor tu situación.' }}
            </p>
        </div>

        <div class="contact-grid">

            {{-- Formulario --}}
            <div class="reveal-left">
                <form action="{{ route('contact.send') }}" method="POST" novalidate>
                    @csrf
                    <div class="contact-form-group">
                        <div class="contact-form-row">
                            <div>
                                <label class="form-label" for="name">Nombre completo *</label>
                                <input class="form-input @error('name') border-red-400 @enderror"
                                       type="text" id="name" name="name" value="{{ old('name') }}"
                                       placeholder="Tu nombre" required autocomplete="name">
                                @error('name')<p style="color:#dc2626;font-size:0.8125rem;margin-top:0.375rem;">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="form-label" for="phone">Teléfono / WhatsApp</label>
                                <input class="form-input"
                                       type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                                       placeholder="+595 9xx xxx xxx" autocomplete="tel">
                            </div>
                        </div>

                        <div>
                            <label class="form-label" for="email">Correo electrónico *</label>
                            <input class="form-input @error('email') border-red-400 @enderror"
                                   type="email" id="email" name="email" value="{{ old('email') }}"
                                   placeholder="tu@email.com" required autocomplete="email">
                            @error('email')<p style="color:#dc2626;font-size:0.8125rem;margin-top:0.375rem;">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="form-label" for="message">¿En qué puedo ayudarte? *</label>
                            <textarea class="form-input form-textarea @error('message') border-red-400 @enderror"
                                      id="message" name="message" required
                                      placeholder="Cuéntame brevemente lo que estás viviendo o lo que te trajo aquí...">{{ old('message') }}</textarea>
                            @error('message')<p style="color:#dc2626;font-size:0.8125rem;margin-top:0.375rem;">{{ $message }}</p>@enderror
                        </div>

                        {{-- hCaptcha --}}
                        @if($integrations['hcaptcha_enabled'] && $integrations['hcaptcha_site_key'])
                        <div>
                            <div class="h-captcha" data-sitekey="{{ $integrations['hcaptcha_site_key'] }}"></div>
                            @error('h-captcha-response')<p style="color:#dc2626;font-size:0.8125rem;margin-top:0.375rem;">{{ $message }}</p>@enderror
                        </div>
                        @endif

                        <label class="form-check">
                            <input type="checkbox" name="privacy_accepted" value="1"
                                   {{ old('privacy_accepted') ? 'checked' : '' }} required>
                            <span>
                                He leído y acepto la
                                <a href="{{ url('politica-de-privacidad') }}" target="_blank">política de privacidad</a>
                                y el <a href="{{ url('consentimiento-tratamiento-datos') }}" target="_blank">consentimiento de tratamiento de datos</a>.
                            </span>
                        </label>
                        @error('privacy_accepted')<p style="color:#dc2626;font-size:0.8125rem;margin-top:-0.5rem;">Debes aceptar la política de privacidad.</p>@enderror

                        <button type="submit" class="btn-primary" style="width:100%;justify-content:center;padding:1rem;">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22,2 15,22 11,13 2,9"/></svg>
                            Enviar consulta
                        </button>
                    </div>
                </form>
            </div>

            {{-- Info de contacto --}}
            <div class="reveal-right">
                <ul class="contact-info-list">
                    @if($settings['email'])
                    <li class="contact-info-item">
                        <div class="contact-info-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        </div>
                        <div class="contact-info-text">
                            <strong>Email</strong>
                            <a href="mailto:{{ $settings['email'] }}">{{ $settings['email'] }}</a>
                        </div>
                    </li>
                    @endif

                    @if($settings['whatsapp'])
                    <li class="contact-info-item">
                        <div class="contact-info-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        </div>
                        <div class="contact-info-text">
                            <strong>WhatsApp</strong>
                            <a href="{{ $settings['whatsappUrl'] }}" target="_blank" rel="noopener">{{ $settings['whatsapp'] }}</a>
                        </div>
                    </li>
                    @endif

                    @if($settings['location'])
                    <li class="contact-info-item">
                        <div class="contact-info-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        </div>
                        <div class="contact-info-text">
                            <strong>Ubicación</strong>
                            <span>{{ $settings['location'] }}</span>
                        </div>
                    </li>
                    @endif

                    @if($settings['schedule'])
                    <li class="contact-info-item">
                        <div class="contact-info-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="10"/><polyline points="12,6 12,12 16,14"/></svg>
                        </div>
                        <div class="contact-info-text">
                            <strong>Horarios</strong>
                            <span>{{ $settings['schedule'] }}</span>
                        </div>
                    </li>
                    @endif
                </ul>

                {{-- Redes sociales --}}
                @if($socials->isNotEmpty())
                <div class="social-row">
                    @foreach($socials as $social)
                    <a href="{{ $social->url }}" target="_blank" rel="noopener noreferrer"
                       class="social-btn" aria-label="{{ $social->label }}">
                        @include('landing.partials.social-icon', ['platform' => $social->platform])
                    </a>
                    @endforeach
                </div>
                @endif

                {{-- Box destacado --}}
                @if($contactoBoxTitle || $contactoBoxBody)
                <div style="margin-top:2.5rem;background:var(--color-brand-muted);border-radius:1.25rem;padding:1.75rem;border-left:4px solid var(--color-primary);">
                    @if($contactoBoxTitle)
                    <p style="font-size:0.875rem;font-weight:700;color:var(--color-primary);text-transform:uppercase;letter-spacing:0.08em;margin-bottom:0.5rem;">{{ $contactoBoxTitle }}</p>
                    @endif
                    @if($contactoBoxBody)
                    <p style="font-size:0.9375rem;color:color-mix(in srgb, var(--color-brand-dark) 75%, white);line-height:1.7;">{!! $contactoBoxHtml !!}</p>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- hCaptcha script --}}
@if($integrations['hcaptcha_enabled'] && $integrations['hcaptcha_site_key'])
<script src="https://js.hcaptcha.com/1/api.js" async defer></script>
@endif

{{-- Back to top --}}
<button id="back-to-top" aria-label="Volver arriba">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="18,15 12,9 6,15"/></svg>
</button>

{{-- WhatsApp float --}}
<a href="{{ $settings['whatsappUrl'] }}" target="_blank" rel="noopener noreferrer"
   class="whatsapp-float" aria-label="Contáctanos por WhatsApp">
    <svg width="28" height="28" viewBox="0 0 24 24" fill="white"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
</a>

@endsection
