@extends('layouts.public')

@section('content')

{{-- ════════════════════════════════════════════════════════
     HERO
════════════════════════════════════════════════════════ --}}
@php $hero = $sections['hero'] ?? null; @endphp
<section id="inicio" class="hero">
    {{-- Enrique PNG sin fondo — flota sobre el gradiente oscuro --}}
    <img src="{{ asset('images/enrique-hero-nobg.png') }}"
         alt="Enrique Delgado, El Psicólogo del Cambio"
         class="hero-person">
    <div class="hero-fade"></div>
    <div class="hero-bottom-fade"></div>

    <div class="hero-content">
        <div class="hero-badge">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
            Psicólogo Clínico · Paraguay
        </div>

        <h1>
            {!! $hero ? nl2br(e($hero->title)) : 'El cambio que<br><em>buscas</em> comienza aquí' !!}
        </h1>

        <p class="hero-desc">
            {{ $hero?->subtitle ?? 'Acompaño a personas que quieren transformar su vida emocional y construir una versión más plena, libre y auténtica de sí mismas.' }}
        </p>

        <div class="hero-actions">
            <a href="{{ $hero?->cta_url ?? '#contacto' }}" class="btn-primary">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/></svg>
                {{ $hero?->cta_text ?? 'Agenda tu primera sesión' }}
            </a>
            <a href="{{ $settings['whatsappUrl'] }}" target="_blank" rel="noopener" class="btn-outline-light">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                Escribir por WhatsApp
            </a>
        </div>

        <div class="hero-stats">
            <div class="hero-stat-item">
                <span class="hero-stat-num">10+</span>
                <span class="hero-stat-label">Años de experiencia</span>
            </div>
            <div class="hero-stat-item">
                <span class="hero-stat-num">500+</span>
                <span class="hero-stat-label">Pacientes acompañados</span>
            </div>
            <div class="hero-stat-item">
                <span class="hero-stat-num">3</span>
                <span class="hero-stat-label">Países de formación</span>
            </div>
        </div>
    </div>
</section>


{{-- ════════════════════════════════════════════════════════
     3 FEATURES (Calmind-style, full width, no gap)
════════════════════════════════════════════════════════ --}}
<div class="features-row">
    <div class="feature-box feature-box-dark reveal">
        <div class="feature-box-icon" style="background:rgba(167,216,216,0.12);">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="var(--color-accent)" stroke-width="1.8"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
        </div>
        <h3>Consulta inicial gratuita</h3>
        <p>Conversamos sobre lo que estás viviendo sin compromisos. Juntos evaluamos si podemos trabajar en lo que necesitas.</p>
    </div>

    <div class="feature-box feature-box-light reveal delay-2">
        <div class="feature-box-icon" style="background:var(--color-primary);opacity:0.9;">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.8"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        </div>
        <h3>Enfoque personalizado</h3>
        <p>Cada proceso es único. Diseño un plan adaptado a tus necesidades, ritmo y objetivos específicos de cambio.</p>
    </div>

    <div class="feature-box feature-box-teal reveal delay-4">
        <div class="feature-box-icon" style="background:rgba(255,255,255,0.15);">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.8"><path d="M9 3H5a2 2 0 0 0-2 2v4m6-6h10a2 2 0 0 1 2 2v4M9 3v18m0 0h10a2 2 0 0 0 2-2V9M9 21H5a2 2 0 0 1-2-2V9m0 0h18"/></svg>
        </div>
        <h3>Métodos basados en evidencia</h3>
        <p>Trabajo con técnicas científicamente validadas: TCC, ACT, mindfulness y neurociencia aplicada al cambio real.</p>
    </div>
</div>


{{-- ════════════════════════════════════════════════════════
     ENFOQUE
════════════════════════════════════════════════════════ --}}
@php $enfoque = $sections['enfoque'] ?? null; @endphp
<section id="enfoque" class="section" style="background:#fff;">
    <div class="container">
        <div class="enfoque-grid">

            {{-- Imagen NYC lifestyle --}}
            <div class="enfoque-img-wrap reveal-left">
                <img src="{{ $enfoque && $enfoque->image_path ? asset('storage/'.$enfoque->image_path) : asset('images/enrique-vessel.jpg') }}"
                     alt="Enrique Delgado — psicólogo del cambio">
                <div class="enfoque-img-deco"></div>
            </div>

            {{-- Texto --}}
            <div class="reveal-right">
                <span class="section-label">Mi enfoque</span>
                <h2 class="section-title" style="margin-bottom:1.25rem;">
                    {!! $enfoque ? nl2br(e($enfoque->title)) : 'Psicología que transforma,<br>no solo que escucha' !!}
                </h2>
                <p class="section-subtitle" style="margin-bottom:1.75rem;">
                    {{ $enfoque?->subtitle ?? 'Creo profundamente en la capacidad de cambio de cada persona. Mi trabajo es acompañarte con herramientas reales para que ese cambio ocurra de manera sostenida.' }}
                </p>

                @if($enfoque?->body)
                <p style="color:#4a6868;line-height:1.75;margin-bottom:1.75rem;font-size:0.9375rem;">{{ $enfoque->body }}</p>
                @endif

                <ul class="pillar-list">
                    <li class="pillar-item">
                        <div class="pillar-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22,4 12,14.01 9,11.01"/></svg>
                        </div>
                        <div class="pillar-text">
                            <strong>Alianza terapéutica sólida</strong>
                            <span>Un espacio seguro y confidencial donde puedes ser completamente honesto/a.</span>
                        </div>
                    </li>
                    <li class="pillar-item">
                        <div class="pillar-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22,4 12,14.01 9,11.01"/></svg>
                        </div>
                        <div class="pillar-text">
                            <strong>Objetivos claros desde el principio</strong>
                            <span>Definimos juntos hacia dónde vamos y cómo mediremos el progreso.</span>
                        </div>
                    </li>
                    <li class="pillar-item">
                        <div class="pillar-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22,4 12,14.01 9,11.01"/></svg>
                        </div>
                        <div class="pillar-text">
                            <strong>Herramientas para la vida diaria</strong>
                            <span>Técnicas concretas que puedes aplicar fuera de la sesión, desde el primer día.</span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>


{{-- ════════════════════════════════════════════════════════
     ÁREAS DE AYUDA
════════════════════════════════════════════════════════ --}}
<section id="areas" class="section" style="background:var(--color-brand-muted);">
    <div class="container">
        <div style="text-align:center;margin-bottom:3.5rem;" class="reveal">
            <span class="section-label">¿En qué puedo ayudarte?</span>
            <h2 class="section-title" style="margin-bottom:1rem;">Áreas de acompañamiento</h2>
            <p class="section-subtitle" style="margin:0 auto;">
                Trabajo con personas que enfrentan distintos desafíos. Si tu situación no aparece aquí, escríbeme: seguramente podemos trabajarla.
            </p>
        </div>

        <div class="areas-grid">
            @forelse($areas as $area)
            <div class="area-card reveal delay-{{ ($loop->index % 3) + 1 }}">
                <div class="area-card-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        @php
                        $icons = [
                            'M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z',
                            'M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z',
                            'M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2M9 7a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75',
                            'M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z',
                            'M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z',
                            'M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20zm0 18a8 8 0 1 1 0-16 8 8 0 0 1 0 16zm0-14a2 2 0 0 0-2 2v4l3 3',
                            'M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z',
                            'M22 11.08V12a10 10 0 1 1-5.93-9.14',
                            'M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z',
                        ];
                        $path = $icons[$loop->index % count($icons)];
                        @endphp
                        <path d="{{ $path }}"/>
                    </svg>
                </div>
                <h3>{{ $area->title }}</h3>
                @if($area->body)
                <p>{{ Str::limit($area->body, 90) }}</p>
                @endif
            </div>
            @empty
            @foreach([
                ['Ansiedad y estrés', 'Estrategias para gestionar la ansiedad y el estrés crónico del día a día.', 'M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z'],
                ['Depresión y ánimo bajo', 'Acompañamiento en momentos de tristeza profunda, desmotivación o vacío emocional.', 'M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z'],
                ['Relaciones y vínculos', 'Trabajo en patrones relacionales que se repiten y generan sufrimiento.', 'M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2M9 7a4 4 0 1 0 0-8 4 4 0 0 0 0 8z'],
                ['Autoestima e identidad', 'Construcción de una autoimagen más sana, sólida y compasiva.', 'M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z'],
                ['Duelo y pérdidas', 'Acompañamiento en procesos de pérdida: personas, proyectos, etapas de vida.', 'M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z'],
                ['Trauma y PTSD', 'Procesamiento de experiencias traumáticas con técnicas especializadas y seguras.', 'M9 3H5a2 2 0 0 0-2 2v4m6-6h10a2 2 0 0 1 2 2v4M9 3v18'],
                ['Desarrollo personal', 'Para quienes no atraviesan una crisis, pero quieren crecer y mejorar.', 'M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8'],
                ['Manejo de emociones', 'Regulación emocional: aprender a sentir sin que las emociones te desborden.', 'M22 11.08V12a10 10 0 1 1-5.93-9.14'],
                ['Miedos y fobias', 'Tratamiento de miedos específicos que limitan tu calidad de vida y tus decisiones.', 'M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z'],
            ] as $i => $a)
            <div class="area-card reveal delay-{{ ($i % 3) + 1 }}">
                <div class="area-card-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="{{ $a[2] }}"/>
                    </svg>
                </div>
                <h3>{{ $a[0] }}</h3>
                <p>{{ $a[1] }}</p>
            </div>
            @endforeach
            @endforelse
        </div>
    </div>
</section>


{{-- ════════════════════════════════════════════════════════
     SOBRE MÍ
════════════════════════════════════════════════════════ --}}
@php $sobremi = $sections['sobre-mi'] ?? null; @endphp
<section id="sobre-mi" class="section" style="background:var(--color-brand-muted);overflow:hidden;">
    <div class="container">
        <div class="sobre-mi-grid">

            {{-- Texto --}}
            <div class="reveal-left">
                <span class="section-label">Sobre mí</span>
                <h2 class="section-title" style="margin-bottom:1.25rem;">
                    {!! $sobremi ? nl2br(e($sobremi->title)) : 'Enrique Delgado,<br>el psicólogo del cambio' !!}
                </h2>
                <p class="section-subtitle" style="margin-bottom:1.25rem;">
                    {{ $sobremi?->subtitle ?? 'Soy psicólogo clínico especializado en psicoterapia cognitivo-conductual y procesos de cambio personal.' }}
                </p>

                @if($sobremi?->body)
                @foreach(explode("\n\n", $sobremi->body) as $para)
                <p style="color:#4a6868;line-height:1.75;margin-bottom:1rem;font-size:0.9375rem;">{{ $para }}</p>
                @endforeach
                @else
                <p style="color:#4a6868;line-height:1.75;margin-bottom:1rem;font-size:0.9375rem;">
                    Me formé en Paraguay, Argentina y España, y durante más de 10 años he acompañado a personas de distintas culturas y contextos a transformar aspectos de su vida que sentían estancados o dolorosos.
                </p>
                <p style="color:#4a6868;line-height:1.75;margin-bottom:1rem;font-size:0.9375rem;">
                    Mi trabajo está basado en la evidencia científica, pero siempre adaptado a la persona que tengo enfrente. Porque no hay dos procesos iguales.
                </p>
                @endif

                {{-- Stats --}}
                <div class="stats-row">
                    <div class="stat-item">
                        <span class="stat-num" data-counter="10" data-suffix="+">0+</span>
                        <span class="stat-label">Años de práctica</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-num" data-counter="500" data-suffix="+">0+</span>
                        <span class="stat-label">Pacientes</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-num" data-counter="3">0</span>
                        <span class="stat-label">Países de formación</span>
                    </div>
                </div>
            </div>

            {{-- Foto PNG sin fondo --}}
            <div class="sobre-mi-photo sobre-mi-photo-col reveal-right" style="position:relative;">
                <div class="sobre-mi-photo-deco"></div>
                <img src="{{ $sobremi && $sobremi->image_path ? asset('storage/'.$sobremi->image_path) : asset('images/enrique-pro-nobg.png') }}"
                     alt="Enrique Delgado — Psicólogo Clínico"
                     style="background: transparent;">
                <div class="sobre-mi-badge">
                    <div class="sobre-mi-badge-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22,4 12,14.01 9,11.01"/></svg>
                    </div>
                    <div>
                        <strong>Certificado</strong>
                        <span>Psicólogo Clínico</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


{{-- ════════════════════════════════════════════════════════
     PROCESO
════════════════════════════════════════════════════════ --}}
<section id="proceso" class="proceso-section">
    <div class="proceso-deco"></div>
    <div class="proceso-deco-2"></div>
    <div class="container">
        <div style="text-align:center;margin-bottom:4rem;" class="reveal">
            <span class="section-label light">Cómo trabajamos</span>
            <h2 class="section-title light" style="margin-bottom:1rem;">El proceso de cambio</h2>
            <p style="color:rgba(255,255,255,0.55);font-size:1.0625rem;max-width:520px;margin:0 auto;line-height:1.75;">
                Un camino claro, paso a paso, para que sepas exactamente qué esperar desde el primer día.
            </p>
        </div>

        @php
        $defaultSteps = [
            ['Primera sesión',       'Conversamos sobre tu situación, tus objetivos y evaluamos si somos un buen match para trabajar juntos.',                     'M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z'],
            ['Evaluación y plan',    'Realizo una evaluación completa y diseño un plan de trabajo personalizado con objetivos claros y medibles.',                   'M9 3H5a2 2 0 0 0-2 2v4m6-6h10a2 2 0 0 1 2 2v4M9 3v18m0 0h10a2 2 0 0 0 2-2V9M9 21H5a2 2 0 0 1-2-2V9m0 0h18'],
            ['Trabajo terapéutico',  'Sesiones regulares donde aplicamos técnicas, exploramos patrones y desarrollamos habilidades concretas de cambio.',            'M22 11.08V12a10 10 0 1 1-5.93-9.14M22 4L12 14.01l-3-3'],
            ['Cierre y autonomía',   'Consolidamos los aprendizajes y te preparas para mantener el cambio de forma autónoma a largo plazo.',                         'M13 2L3 14h9l-1 8 10-12h-9l1-8z'],
        ];
        @endphp

        <div class="timeline">
            <div class="timeline-track">
                @forelse($steps as $step)
                @php
                $icons = ['M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z','M9 3H5a2 2 0 0 0-2 2v4m6-6h10a2 2 0 0 1 2 2v4M9 3v18m0 0h10a2 2 0 0 0 2-2V9M9 21H5a2 2 0 0 1-2-2V9m0 0h18','M22 11.08V12a10 10 0 1 1-5.93-9.14M22 4L12 14.01l-3-3','M13 2L3 14h9l-1 8 10-12h-9l1-8z'];
                @endphp
                <div class="timeline-item reveal delay-{{ $loop->index + 1 }}">
                    <div class="timeline-node">
                        <span class="timeline-node-num">0{{ $loop->iteration }}</span>
                    </div>
                    <div class="timeline-connector"></div>
                    <div class="timeline-card">
                        <div class="timeline-card-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="{{ $icons[$loop->index % 4] }}"/>
                            </svg>
                        </div>
                        <h3>{{ $step->title }}</h3>
                        @if($step->body)<p>{{ Str::limit($step->body, 110) }}</p>@endif
                    </div>
                </div>
                @empty
                @foreach($defaultSteps as $i => $s)
                <div class="timeline-item reveal delay-{{ $i + 1 }}">
                    <div class="timeline-node">
                        <span class="timeline-node-num">0{{ $i + 1 }}</span>
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


{{-- ════════════════════════════════════════════════════════
     PLANES
════════════════════════════════════════════════════════ --}}
<section id="planes" class="section" style="background:#fff;">
    <div class="container">
        <div style="text-align:center;margin-bottom:3.5rem;" class="reveal">
            <span class="section-label">Inversión en ti</span>
            <h2 class="section-title" style="margin-bottom:1rem;">Planes de acompañamiento</h2>
            <p class="section-subtitle" style="margin:0 auto;">
                Cada plan está pensado para distintos momentos y necesidades. Si tienes dudas, podemos conversarlas en la consulta inicial gratuita.
            </p>
        </div>

        <div class="planes-grid">
            @forelse($plans as $plan)
            <div class="plan-card {{ $plan->is_featured ? 'featured' : '' }} reveal delay-{{ $loop->iteration }}">
                @if($plan->is_featured)
                <div class="plan-badge">Más elegido</div>
                @endif
                <div class="plan-name">{{ $plan->title }}</div>
                @if($plan->extra)
                @php $extra = json_decode($plan->extra, true); @endphp
                @if(!empty($extra['price']))
                <div class="plan-price">
                    <span class="plan-price-currency">₲</span>
                    <span class="plan-price-amount">{{ number_format($extra['price'], 0, ',', '.') }}</span>
                </div>
                <div class="plan-price-period">/ {{ $extra['period'] ?? 'sesión' }}</div>
                @endif
                @endif
                @if($plan->subtitle)
                <p class="plan-description">{{ $plan->subtitle }}</p>
                @endif
                @if($plan->body)
                <ul class="plan-features">
                    @foreach(explode("\n", $plan->body) as $feature)
                    @if(trim($feature))
                    <li>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="{{ $plan->is_featured ? '#A7D8D8' : 'var(--color-primary)' }}" stroke-width="2.5"><polyline points="20,6 9,17 4,12"/></svg>
                        {{ ltrim(trim($feature), '-•') }}
                    </li>
                    @endif
                    @endforeach
                </ul>
                @endif
                <a href="#contacto" class="plan-cta">Comenzar ahora</a>
            </div>
            @empty
            @foreach([
                ['Sesión única', false, 'Para explorar, resolver una duda puntual o tener una perspectiva externa sobre algo concreto.', ['Sesión de 60 minutos', 'Sin compromiso de continuidad', 'Resumen y recursos al finalizar']],
                ['Proceso inicial', true, 'Para quienes quieren hacer un cambio real con acompañamiento sostenido desde el principio.', ['8 sesiones individuales', 'Evaluación y plan personalizado', 'Materiales y ejercicios entre sesiones', 'Canal de contacto entre sesiones', 'Informe de progreso']],
                ['Proceso continuo', false, 'Para quienes ya iniciaron y quieren mantener el trabajo terapéutico a lo largo del tiempo.', ['Sesiones mensuales ilimitadas', 'Revisión mensual de objetivos', 'Acceso a recursos exclusivos']],
            ] as $i => $p)
            <div class="plan-card {{ $p[1] ? 'featured' : '' }} reveal delay-{{ $i + 1 }}">
                @if($p[1])<div class="plan-badge">Más elegido</div>@endif
                <div class="plan-name">{{ $p[0] }}</div>
                <p class="plan-description">{{ $p[2] }}</p>
                <ul class="plan-features">
                    @foreach($p[3] as $f)
                    <li>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="{{ $p[1] ? '#A7D8D8' : 'var(--color-primary)' }}" stroke-width="2.5"><polyline points="20,6 9,17 4,12"/></svg>
                        {{ $f }}
                    </li>
                    @endforeach
                </ul>
                <a href="#contacto" class="plan-cta">Consultar precio</a>
            </div>
            @endforeach
            @endforelse
        </div>

        <p style="text-align:center;margin-top:2.5rem;font-size:0.875rem;color:#8aabab;" class="reveal">
            Los precios se informan en la consulta inicial. Primera sesión gratuita y sin compromiso.
        </p>
    </div>
</section>


{{-- ════════════════════════════════════════════════════════
     TESTIMONIOS / QUOTE (dark, Calmind-style)
════════════════════════════════════════════════════════ --}}
<section class="quote-section">
    <img src="{{ asset('images/enrique-nyc.jpg') }}" alt="" class="quote-bg">
    <div class="quote-bg-grad"></div>

    <div class="container">
        <div class="quote-content reveal-left">
            <div class="quote-icon">
                <svg width="52" height="52" viewBox="0 0 24 24" fill="currentColor"><path d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1 0 1 1v1c0 1-1 2-2 2s-1 .008-1 1.031V20c0 1 0 1 1 1z"/><path d="M15 21c3 0 7-1 7-8V5c0-1.25-.757-2.017-2-2h-4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2h.75c0 2.25.25 4-2.75 4v3c0 1 0 1 1 1z"/></svg>
            </div>

            <div class="testimonial-item" style="transition:opacity 0.5s;">
                <p class="quote-text">
                    "Llegué sin esperanza de que algo pudiera cambiar. Hoy tengo herramientas reales y una perspectiva completamente diferente de mi vida. El proceso fue duro pero absolutamente transformador."
                </p>
                <div class="quote-author">
                    <div class="quote-author-line"></div>
                    <span class="quote-author-name">Paciente anónimo — proceso de 6 meses</span>
                </div>
            </div>

            <div class="testimonial-item" style="display:none;transition:opacity 0.5s;">
                <p class="quote-text">
                    "Enrique me ayudó a entender patrones que repetía desde hace años sin darme cuenta. Fue como encender una luz en una habitación oscura. Lo recomiendo sin dudar."
                </p>
                <div class="quote-author">
                    <div class="quote-author-line"></div>
                    <span class="quote-author-name">Paciente anónimo — ansiedad y autoestima</span>
                </div>
            </div>

            <div class="testimonial-item" style="display:none;transition:opacity 0.5s;">
                <p class="quote-text">
                    "Nunca pensé que la psicología pudiera ser tan práctica. Salí de cada sesión con algo concreto para aplicar. Eso marcó una diferencia enorme en mi día a día."
                </p>
                <div class="quote-author">
                    <div class="quote-author-line"></div>
                    <span class="quote-author-name">Paciente anónimo — estrés laboral</span>
                </div>
            </div>

            <div class="quote-dots">
                <button class="quote-dot active" aria-label="Testimonio 1"></button>
                <button class="quote-dot" aria-label="Testimonio 2"></button>
                <button class="quote-dot" aria-label="Testimonio 3"></button>
            </div>
        </div>
    </div>
</section>


{{-- ════════════════════════════════════════════════════════
     FAQ
════════════════════════════════════════════════════════ --}}
<section id="faq" class="section" style="background:var(--color-brand-muted);">
    <div class="container">
        <div style="text-align:center;margin-bottom:3.5rem;" class="reveal">
            <span class="section-label">Respuestas</span>
            <h2 class="section-title" style="margin-bottom:1rem;">Preguntas frecuentes</h2>
            <p class="section-subtitle" style="margin:0 auto;">
                Si tu pregunta no está aquí, puedes escribirme directamente. Siempre respondo.
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
                        <div class="faq-answer-inner">{{ $faq->answer }}</div>
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
                        <div class="faq-answer-inner">{{ $faq->answer }}</div>
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


{{-- ════════════════════════════════════════════════════════
     CTA BANNER
════════════════════════════════════════════════════════ --}}
<section class="cta-banner">
    <div class="container" style="position:relative;z-index:1;text-align:center;">
        <div class="reveal">
            <span class="section-label light" style="margin-bottom:1.25rem;">El primer paso</span>
            <h2 class="section-title light" style="margin-bottom:1.25rem;">¿Listo para comenzar<br>tu proceso de cambio?</h2>
            <p style="color:rgba(255,255,255,0.7);font-size:1.0625rem;max-width:480px;margin:0 auto 2.5rem;line-height:1.75;">
                La primera sesión es gratuita. Sin compromisos. Solo una conversación para ver si podemos trabajar juntos.
            </p>
            <div style="display:flex;flex-wrap:wrap;gap:1rem;justify-content:center;">
                <a href="#contacto" class="btn-white">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/></svg>
                    Solicitar sesión gratuita
                </a>
                <a href="{{ $settings['whatsappUrl'] }}" target="_blank" rel="noopener" class="btn-outline-light">
                    Escribir por WhatsApp
                </a>
            </div>
        </div>
    </div>
</section>


{{-- ════════════════════════════════════════════════════════
     CONTACTO
════════════════════════════════════════════════════════ --}}
@php $contacto = $sections['contacto'] ?? null; @endphp
<section id="contacto" class="section" style="background:#fff;">
    <div class="container">
        <div style="text-align:center;margin-bottom:3.5rem;" class="reveal">
            <span class="section-label">Hablemos</span>
            <h2 class="section-title" style="margin-bottom:1rem;">
                {{ $contacto?->title ?? 'Da el primer paso hoy' }}
            </h2>
            <p class="section-subtitle" style="margin:0 auto;">
                {{ $contacto?->subtitle ?? 'Completa el formulario o escríbeme directamente. Respondo todas las consultas en menos de 24 horas.' }}
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
                <div style="margin-top:2.5rem;background:var(--color-brand-muted);border-radius:1.25rem;padding:1.75rem;border-left:4px solid var(--color-primary);">
                    <p style="font-size:0.875rem;font-weight:700;color:var(--color-primary);text-transform:uppercase;letter-spacing:0.08em;margin-bottom:0.5rem;">Primera sesión</p>
                    <p style="font-size:0.9375rem;color:#4a6868;line-height:1.7;">
                        La primera sesión es <strong style="color:#0D2424;">gratuita y sin compromiso</strong>. Es el espacio para conocernos, contarme lo que estás viviendo y evaluar si puedo ayudarte.
                    </p>
                </div>
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
