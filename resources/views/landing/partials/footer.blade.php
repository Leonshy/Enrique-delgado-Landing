<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">

            {{-- Brand --}}
            <div>
                <img src="{{ asset('images/logo-white-h.png') }}" alt="Enrique Delgado" class="footer-logo">
                <p class="footer-desc">
                    Acompaño a personas que quieren transformar su vida emocional y construir una versión más plena de sí mismas. El cambio es posible.
                </p>
                {{-- Social --}}
                @if($socials->isNotEmpty())
                <div class="social-row" style="margin-top:1.5rem;">
                    @foreach($socials as $social)
                    <a href="{{ $social->url }}" target="_blank" rel="noopener noreferrer"
                       class="social-btn" aria-label="{{ $social->label }}">
                        @include('landing.partials.social-icon', ['platform' => $social->platform])
                    </a>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- Nav --}}
            <div class="footer-col">
                <h4>Navegación</h4>
                <ul class="footer-links">
                    <li><a href="#inicio">Inicio</a></li>
                    <li><a href="#enfoque">Enfoque</a></li>
                    <li><a href="#areas">Áreas de ayuda</a></li>
                    <li><a href="#sobre-mi">Sobre mí</a></li>
                    <li><a href="#proceso">El proceso</a></li>
                    <li><a href="#planes">Planes</a></li>
                    <li><a href="#faq">Preguntas frecuentes</a></li>
                </ul>
            </div>

            {{-- Contact --}}
            <div class="footer-col">
                <h4>Contacto</h4>
                <ul class="footer-links">
                    @if($settings['email'])
                    <li>
                        <a href="mailto:{{ $settings['email'] }}">{{ $settings['email'] }}</a>
                    </li>
                    @endif
                    @if($settings['whatsapp'])
                    <li>
                        <a href="{{ $settings['whatsappUrl'] }}" target="_blank" rel="noopener">
                            WhatsApp {{ $settings['whatsapp'] }}
                        </a>
                    </li>
                    @endif
                    @if($settings['location'])
                    <li><span style="color:rgba(255,255,255,0.4);">{{ $settings['location'] }}</span></li>
                    @endif
                    @if($settings['schedule'])
                    <li><span style="color:rgba(255,255,255,0.4);">{{ $settings['schedule'] }}</span></li>
                    @endif
                </ul>
                <div style="margin-top:1.75rem;">
                    <a href="#contacto" class="btn-white" style="font-size:0.875rem;padding:0.65rem 1.5rem;">
                        Solicitar consulta
                    </a>
                </div>
            </div>

        </div>

        {{-- Bottom --}}
        <div class="footer-bottom">
            <p class="footer-copyright">
                © {{ date('Y') }} Enrique Delgado. Todos los derechos reservados.
            </p>
            <div class="footer-legal">
                @foreach($legals as $legal)
                <a href="{{ url($legal->slug) }}">{{ $legal->title }}</a>
                @endforeach
                <a href="/admin" style="color:rgba(255,255,255,0.2);">Admin</a>
            </div>
        </div>
    </div>
</footer>
