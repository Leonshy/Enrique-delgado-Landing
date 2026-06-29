<nav id="navbar" class="transparent">
    <div class="nav-inner">

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="nav-logo" aria-label="Enrique Delgado - El Psicólogo del Cambio">
            <img id="logo-white" src="{{ asset('images/logo-white-h.png') }}"
                 alt="Enrique Delgado" style="height:84px;width:auto;">
            <img id="logo-color" src="{{ asset('images/logo.png') }}"
                 alt="Enrique Delgado" style="height:56px;width:auto;display:none;">
        </a>

        {{-- Desktop links --}}
        <ul class="nav-links">
            <li><a href="#enfoque">Enfoque</a></li>
            <li><a href="#areas">Áreas</a></li>
            <li><a href="#sobre-mi">Sobre mí</a></li>
            <li><a href="#proceso">Proceso</a></li>
            <li><a href="#planes">Planes</a></li>
            <li><a href="#faq">FAQ</a></li>
        </ul>

        <div class="nav-cta-wrap">
            <a href="#contacto" class="btn-primary" style="padding:0.7rem 1.5rem;font-size:0.875rem;">
                Agendar sesión
            </a>
            {{-- Hamburger --}}
            <button id="nav-hamburger" aria-label="Abrir menú" style="background:none;border:none;cursor:pointer;padding:4px;display:flex;flex-direction:column;gap:5px;">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div id="nav-mobile" class="nav-mobile">
        <a href="#enfoque">Enfoque</a>
        <a href="#areas">Áreas de ayuda</a>
        <a href="#sobre-mi">Sobre mí</a>
        <a href="#proceso">Proceso</a>
        <a href="#planes">Planes</a>
        <a href="#faq">Preguntas frecuentes</a>
        <a href="#contacto" style="color:var(--color-primary);font-weight:600;border-bottom:none;margin-top:0.5rem;">→ Agendar sesión</a>
    </div>
</nav>

{{-- Flash messages --}}
@if(session('success'))
<div class="flash-message flash-success">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22,4 12,14.01 9,11.01"/></svg>
    {{ session('success') }}
</div>
@endif
@if(session('error'))
<div class="flash-message flash-error">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
    {{ session('error') }}
</div>
@endif
