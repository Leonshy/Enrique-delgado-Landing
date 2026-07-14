<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel Admin') — Enrique Delgado</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('partials.theme-vars')
</head>
<body style="background-color: var(--color-brand-light);" class="min-h-screen">

<div class="flex min-h-screen">
    {{-- Sidebar --}}
    <aside class="w-64 bg-white shadow-sm flex flex-col" style="min-height:100vh;">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background-color: var(--color-primary);">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                        <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                        <polyline points="9 22 9 12 15 12 15 22"/>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-sm" style="color: var(--color-brand-dark);">Panel Admin</p>
                    <p class="text-xs text-gray-400">Enrique Delgado</p>
                </div>
            </div>
        </div>

        <nav class="flex-1 p-4 space-y-1">
            <a href="{{ route('admin.dashboard') }}"
               class="admin-sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                Dashboard
            </a>

            <a href="{{ route('admin.media.index') }}"
               class="admin-sidebar-link {{ request()->routeIs('admin.media.*') ? 'active' : '' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                Multimedia
            </a>

            <a href="{{ route('admin.messages.index') }}"
               class="admin-sidebar-link {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                Consultas
                @php $unread = \App\Models\ContactMessage::unread()->count(); @endphp
                @if($unread > 0)
                <span class="ml-auto text-xs font-bold px-2 py-0.5 rounded-full text-white" style="background-color: var(--color-primary);">{{ $unread }}</span>
                @endif
            </a>

            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-4 pt-4 pb-1">Contenido</p>

            <a href="{{ route('admin.portada.edit') }}"
               class="admin-sidebar-link {{ request()->routeIs('admin.portada.*') ? 'active' : '' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
                Portada
            </a>
            <a href="{{ route('admin.proceso.index') }}"
               class="admin-sidebar-link {{ request()->routeIs('admin.proceso.*') ? 'active' : '' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                Proceso
            </a>
            <a href="{{ route('admin.video.edit') }}"
               class="admin-sidebar-link {{ request()->routeIs('admin.video.*') ? 'active' : '' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M10 9l5 3-5 3z" fill="currentColor" stroke="none"/></svg>
                Video
            </a>
            <a href="{{ route('admin.enfoque.edit') }}"
               class="admin-sidebar-link {{ request()->routeIs('admin.enfoque.*') ? 'active' : '' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>
                Mi enfoque
            </a>
            <a href="{{ route('admin.areas.index') }}"
               class="admin-sidebar-link {{ request()->routeIs('admin.areas.*') ? 'active' : '' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
                Áreas de ayuda
            </a>
            <a href="{{ route('admin.sobre-mi.edit') }}"
               class="admin-sidebar-link {{ request()->routeIs('admin.sobre-mi.*') ? 'active' : '' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                Sobre mí
            </a>
            <a href="{{ route('admin.testimonios.index') }}"
               class="admin-sidebar-link {{ request()->routeIs('admin.testimonios.*') ? 'active' : '' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                Testimonios
            </a>
            <a href="{{ route('admin.planes.index') }}"
               class="admin-sidebar-link {{ request()->routeIs('admin.planes.*') ? 'active' : '' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/></svg>
                Planes
            </a>
            <a href="{{ route('admin.faqs.index') }}"
               class="admin-sidebar-link {{ request()->routeIs('admin.faqs.*') ? 'active' : '' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 015.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                Preguntas frecuentes
            </a>
            <a href="{{ route('admin.cta-banner.edit') }}"
               class="admin-sidebar-link {{ request()->routeIs('admin.cta-banner.*') ? 'active' : '' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                CTA
            </a>
            <a href="{{ route('admin.contacto.edit') }}"
               class="admin-sidebar-link {{ request()->routeIs('admin.contacto.*') ? 'active' : '' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                Contacto
            </a>
            <a href="{{ route('admin.legales.index') }}"
               class="admin-sidebar-link {{ request()->routeIs('admin.legales.*') ? 'active' : '' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                Legales
            </a>

            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-4 pt-4 pb-1">Configuración</p>

            <a href="{{ route('admin.settings.general') }}"
               class="admin-sidebar-link {{ request()->routeIs('admin.settings.general') ? 'active' : '' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/></svg>
                Configuración
            </a>
            <a href="{{ route('admin.settings.integrations') }}"
               class="admin-sidebar-link {{ request()->routeIs('admin.settings.integrations') ? 'active' : '' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
                Integraciones
            </a>
            <a href="{{ route('admin.settings.mail') }}"
               class="admin-sidebar-link {{ request()->routeIs('admin.settings.mail') ? 'active' : '' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                Email
            </a>
            <a href="{{ route('admin.settings.colors') }}"
               class="admin-sidebar-link {{ request()->routeIs('admin.settings.colors') ? 'active' : '' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="13.5" cy="6.5" r=".5"/><circle cx="17.5" cy="10.5" r=".5"/><circle cx="8.5" cy="7.5" r=".5"/><circle cx="6.5" cy="12.5" r=".5"/><path d="M12 2a10 10 0 100 20 2 2 0 001.8-2.9 1.7 1.7 0 01.4-2 1.7 1.7 0 011.2-.5H17a3 3 0 003-3 8 8 0 00-8-9z"/></svg>
                Colores
            </a>
            <a href="{{ route('admin.settings.typography') }}"
               class="admin-sidebar-link {{ request()->routeIs('admin.settings.typography') ? 'active' : '' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="4 7 4 4 20 4 20 7"/><line x1="9" y1="20" x2="15" y2="20"/><line x1="12" y1="4" x2="12" y2="20"/></svg>
                Tipografía
            </a>
            <a href="{{ route('admin.seo.index') }}"
               class="admin-sidebar-link {{ request()->routeIs('admin.seo.*') ? 'active' : '' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                SEO
            </a>
            <a href="{{ route('admin.usuarios.index') }}"
               class="admin-sidebar-link {{ request()->routeIs('admin.usuarios.*') ? 'active' : '' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                Usuarios
            </a>
        </nav>

        <div class="p-4 border-t border-gray-100">
            <a href="{{ route('home') }}" target="_blank" class="admin-sidebar-link text-xs mb-2">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                Ver sitio web
            </a>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="admin-sidebar-link w-full text-red-500 hover:bg-red-50 hover:text-red-600">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    Cerrar sesión
                </button>
            </form>
        </div>
    </aside>

    {{-- Main --}}
    <main class="flex-1 flex flex-col">
        <header class="bg-white border-b border-gray-100 px-8 py-4 flex items-center justify-between">
            <h1 class="text-xl font-semibold" style="color: var(--color-brand-dark); font-family: var(--font-serif);">
                @yield('page-title', 'Dashboard')
            </h1>
            <div class="flex items-center gap-3">
                <span class="text-sm text-gray-500">{{ auth()->user()->name }}</span>
            </div>
        </header>

        <div class="flex-1 p-8">
            {{-- Flash messages --}}
            @if(session('success'))
            <div data-flash class="mb-6 px-5 py-4 rounded-xl text-sm font-medium text-white flex items-center gap-2" style="background-color: var(--color-primary);">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div data-flash class="mb-6 px-5 py-4 rounded-xl text-sm font-medium text-white flex items-center gap-2 bg-red-500">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                {{ session('error') }}
            </div>
            @endif

            @yield('content')
        </div>
    </main>
</div>

@php $tinymceApiKey = \App\Helpers\SettingsHelper::get('tinymce_api_key', '') ?: 'no-api-key'; @endphp
<script src="https://cdn.tiny.cloud/1/{{ $tinymceApiKey }}/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    window.initRichEditor = function (selector, options = {}) {
        if (!window.tinymce) return;
        tinymce.init(Object.assign({
            selector,
            height: 300,
            menubar: false,
            branding: false,
            plugins: 'lists link autolink',
            toolbar: 'bold italic underline | bullist numlist | link | removeformat | undo redo',
            content_style: "body { font-family: {{ \App\Helpers\FontHelper::cssVars()['--font-sans'] }}; font-size: 15px; color: {{ \App\Helpers\ThemeHelper::resolvedColors()['--color-brand-dark'] }}; line-height: 1.6; }",
        }, options));
    };

    window.copySectionUrl = function (anchor, btn) {
        const input = document.getElementById('section-url-' + anchor);
        if (!input) return;
        const restore = btn.textContent;
        const done = () => { btn.textContent = 'Copiado ✓'; setTimeout(() => { btn.textContent = restore; }, 1500); };
        if (navigator.clipboard) {
            navigator.clipboard.writeText(input.value).then(done).catch(() => {
                input.select();
                document.execCommand('copy');
                done();
            });
        } else {
            input.select();
            document.execCommand('copy');
            done();
        }
    };
</script>
@stack('scripts')

</body>
</html>
