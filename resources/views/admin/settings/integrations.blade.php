@extends('layouts.admin')
@section('title', 'Integraciones')
@section('page-title', 'Integraciones externas')

@section('content')
<div class="max-w-2xl">
    <form method="POST" action="{{ route('admin.settings.integrations.update') }}" class="space-y-6">
        @csrf

        {{-- hCaptcha --}}
        <div class="card space-y-4">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: var(--color-brand-muted);">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--color-primary);"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                </div>
                <h2 class="font-semibold" style="color: var(--color-brand-dark);">hCaptcha</h2>
            </div>
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="hcaptcha_enabled" value="1" {{ ($settings['hcaptcha_enabled']->value ?? '0') === '1' ? 'checked' : '' }}
                       class="w-4 h-4" style="accent-color: var(--color-primary);">
                <span class="text-sm font-medium" style="color: var(--color-brand-dark);">Activar hCaptcha en el formulario</span>
            </label>
            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Site Key</label>
                <input type="text" name="hcaptcha_site_key" value="{{ old('hcaptcha_site_key', $settings['hcaptcha_site_key']->value ?? '') }}" class="input-field font-mono text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Secret Key</label>
                <input type="text" name="hcaptcha_secret_key" value="{{ old('hcaptcha_secret_key', $settings['hcaptcha_secret_key']->value ?? '') }}" class="input-field font-mono text-sm">
            </div>
        </div>

        {{-- Google Analytics --}}
        <div class="card space-y-4">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: var(--color-brand-muted);">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--color-primary);"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                </div>
                <h2 class="font-semibold" style="color: var(--color-brand-dark);">Google Analytics 4</h2>
            </div>
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="ga_enabled" value="1" {{ ($settings['ga_enabled']->value ?? '0') === '1' ? 'checked' : '' }}
                       class="w-4 h-4" style="accent-color: var(--color-primary);">
                <span class="text-sm font-medium" style="color: var(--color-brand-dark);">Activar Google Analytics</span>
            </label>
            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Measurement ID (G-XXXXXXXXXX)</label>
                <input type="text" name="ga_measurement_id" value="{{ old('ga_measurement_id', $settings['ga_measurement_id']->value ?? '') }}" class="input-field font-mono text-sm" placeholder="G-XXXXXXXXXX">
            </div>
        </div>

        {{-- Meta Pixel --}}
        <div class="card space-y-4">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: var(--color-brand-muted);">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--color-primary);"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
                </div>
                <h2 class="font-semibold" style="color: var(--color-brand-dark);">Meta Pixel (Facebook)</h2>
            </div>
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="pixel_enabled" value="1" {{ ($settings['pixel_enabled']->value ?? '0') === '1' ? 'checked' : '' }}
                       class="w-4 h-4" style="accent-color: var(--color-primary);">
                <span class="text-sm font-medium" style="color: var(--color-brand-dark);">Activar Meta Pixel</span>
            </label>
            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Pixel ID</label>
                <input type="text" name="pixel_id" value="{{ old('pixel_id', $settings['pixel_id']->value ?? '') }}" class="input-field font-mono text-sm" placeholder="1234567890">
            </div>
        </div>

        {{-- Scripts personalizados --}}
        <div class="card space-y-4">
            <h2 class="font-semibold" style="color: var(--color-brand-dark);">Scripts personalizados</h2>
            <div class="p-3 rounded-xl text-sm bg-amber-50 text-amber-700 border border-amber-200">
                ⚠️ Usa esta opción con responsabilidad. Scripts mal configurados pueden afectar la seguridad y el rendimiento del sitio.
            </div>
            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Scripts en &lt;head&gt;</label>
                <textarea name="custom_head_scripts" rows="5" class="input-field font-mono text-xs">{{ old('custom_head_scripts', $settings['custom_head_scripts']->value ?? '') }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Scripts antes de &lt;/body&gt;</label>
                <textarea name="custom_body_scripts" rows="5" class="input-field font-mono text-xs">{{ old('custom_body_scripts', $settings['custom_body_scripts']->value ?? '') }}</textarea>
            </div>
        </div>

        <button type="submit" class="btn-primary">Guardar integraciones</button>
    </form>
</div>
@endsection
