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

        <button type="submit" class="btn-primary">Guardar configuración</button>
    </form>
</div>
@endsection
