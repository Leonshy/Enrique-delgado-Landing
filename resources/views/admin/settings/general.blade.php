@extends('layouts.admin')
@section('title', 'Configuración')
@section('page-title', 'Configuración general')

@section('content')
<div class="max-w-2xl">
    <form method="POST" action="{{ route('admin.settings.general.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="card space-y-5">
            <h2 class="font-serif font-semibold text-lg" style="color: var(--color-brand-dark);">Identidad</h2>

            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Nombre del sitio</label>
                <input type="text" name="site_name" value="{{ old('site_name', $settings['site_name']->value ?? '') }}" class="input-field">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Eslogan</label>
                <input type="text" name="site_tagline" value="{{ old('site_tagline', $settings['site_tagline']->value ?? '') }}" class="input-field">
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                @foreach(['logo_color' => 'Logo a color', 'logo_white' => 'Logo blanco', 'isotipo' => 'Isotipo', 'favicon' => 'Favicon'] as $key => $label)
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">{{ $label }}</label>
                    @if(!empty($settings[$key]->value))
                    <div class="mb-2 h-12 w-24 flex items-center justify-center rounded-lg border border-gray-100" style="background: #eee;">
                        <img src="{{ asset('storage/'.$settings[$key]->value) }}" class="h-full object-contain p-1" alt="">
                    </div>
                    @endif
                    <input type="file" name="{{ $key }}" accept="image/*" class="input-field py-2 text-xs">
                </div>
                @endforeach
            </div>
        </div>

        <div class="card space-y-5">
            <h2 class="font-serif font-semibold text-lg" style="color: var(--color-brand-dark);">Contacto</h2>

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Email público</label>
                    <input type="email" name="contact_email" value="{{ old('contact_email', $settings['contact_email']->value ?? '') }}" class="input-field">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Email admin (recibe consultas)</label>
                    <input type="email" name="admin_email" value="{{ old('admin_email', $settings['admin_email']->value ?? '') }}" class="input-field">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">WhatsApp</label>
                    <input type="text" name="whatsapp" value="{{ old('whatsapp', $settings['whatsapp']->value ?? '') }}" class="input-field" placeholder="+595981000000">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Ubicación</label>
                    <input type="text" name="location" value="{{ old('location', $settings['location']->value ?? '') }}" class="input-field">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Mensaje WhatsApp predeterminado</label>
                <input type="text" name="whatsapp_msg" value="{{ old('whatsapp_msg', $settings['whatsapp_msg']->value ?? '') }}" class="input-field">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Horario</label>
                <input type="text" name="schedule" value="{{ old('schedule', $settings['schedule']->value ?? '') }}" class="input-field">
            </div>
        </div>

        {{-- ── Redes sociales ── --}}
        <div class="card space-y-5">
            <div>
                <h2 class="font-serif font-semibold text-lg" style="color: var(--color-brand-dark);">Redes sociales</h2>
                <p class="text-sm text-gray-400 mt-1">Si el campo tiene URL, el ícono aparece en el pie de página. Si está vacío, no se muestra.</p>
            </div>

            @foreach([
                'facebook'  => ['label' => 'Facebook', 'placeholder' => 'https://facebook.com/tu-perfil'],
                'x'         => ['label' => 'X (Twitter)', 'placeholder' => 'https://x.com/tu-usuario'],
                'instagram' => ['label' => 'Instagram', 'placeholder' => 'https://instagram.com/tu-perfil'],
                'linkedin'  => ['label' => 'LinkedIn', 'placeholder' => 'https://linkedin.com/in/tu-perfil'],
                'youtube'   => ['label' => 'YouTube', 'placeholder' => 'https://youtube.com/@tu-canal'],
                'tiktok'    => ['label' => 'TikTok', 'placeholder' => 'https://tiktok.com/@tu-usuario'],
            ] as $platform => $meta)
            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">{{ $meta['label'] }}</label>
                <input type="url" name="social_{{ $platform }}"
                       value="{{ old('social_'.$platform, $socials[$platform]) }}"
                       class="input-field"
                       placeholder="{{ $meta['placeholder'] }}">
            </div>
            @endforeach
        </div>

        {{-- ── Modo mantenimiento ── --}}
        <div class="card space-y-4">
            <div>
                <h2 class="font-serif font-semibold text-lg" style="color: var(--color-brand-dark);">Modo mantenimiento</h2>
                <p class="text-sm text-gray-400 mt-1">Cuando está activo, los visitantes ven una página de mantenimiento. El panel admin sigue accesible.</p>
            </div>

            <label class="flex items-center gap-3 cursor-pointer select-none">
                <input type="hidden" name="maintenance_mode" value="0">
                <input type="checkbox" name="maintenance_mode" value="1"
                       {{ old('maintenance_mode', $maintenance) === '1' ? 'checked' : '' }}
                       class="w-5 h-5 rounded accent-green-600">
                <span class="text-sm font-medium" style="color: var(--color-brand-dark);">Activar modo mantenimiento</span>
                @if($maintenance === '1')
                <span class="text-xs font-semibold px-2 py-0.5 rounded-full text-white bg-amber-500">ACTIVO</span>
                @endif
            </label>
        </div>

        {{-- ── Footer ── --}}
        <div class="card space-y-4">
            <div>
                <h2 class="font-serif font-semibold text-lg" style="color: var(--color-brand-dark);">Pie de página</h2>
                <p class="text-sm text-gray-400 mt-1">Texto de copyright que aparece al final del sitio.</p>
            </div>
            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Texto del footer</label>
                <input type="text" name="footer_text"
                       value="{{ old('footer_text', $footerText) }}"
                       class="input-field"
                       placeholder="© {{ date('Y') }} Enrique Delgado. Todos los derechos reservados.">
            </div>
        </div>

        <button type="submit" class="btn-primary">Guardar configuración</button>
    </form>
</div>
@endsection
